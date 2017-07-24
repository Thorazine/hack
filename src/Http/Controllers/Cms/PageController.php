<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Thorazine\Hack\Http\Requests\ModuleUpdate;
use Thorazine\Hack\Http\Requests\ModuleStore;
use Illuminate\Http\Request;
use Thorazine\Hack\Traits\ModuleHelper;
use Thorazine\Hack\Models\Templateable;
use Thorazine\Hack\Models\Template;
use Thorazine\Hack\Models\Pageable;
use Thorazine\Hack\Classes\Search;
use Thorazine\Hack\Http\Requests;
use Thorazine\Hack\Models\DbLog;
use Thorazine\Hack\Models\Page;
use Thorazine\Hack\Models\Slug;
use Exception;
use Builder;
use Artisan;
use Cms;
use Log;
use DB;

class PageController extends CmsController
{

    public function __construct(Page $model, Template $template, Templateable $templateable, Pageable $pageable, Slug $slug, Search $search)
    {

        $this->model = $model;
        $this->slug = 'pages';
        $this->template = $template;
        $this->templateable = $templateable;
        $this->pageable = $pageable;
        $this->notFound = $slug;
        $this->search = $search;
        // $this->paginateAmount = 1;

        parent::__construct($this);

        view()->share([
            'createRoute' => 'cms.'.$this->slug.'.module',
            'filters' => [
                'template_id' => [
                    'type' => 'select',
                    'values' => function() {
                        return ['' => '-- '.trans('hack::modules.pages.template_id').' --']+$this->model->getTemplates();
                    },
                ],
                'prepend_slug' => [
                    'type' => 'select',
                    'values' => function() {
                        return ['' => '-- '.trans('hack::modules.pages.prepend_slug').' --']+$this->model
                            ->groupBy('prepend_slug')
                            ->pluck('prepend_slug', 'prepend_slug')
                            ->toArray();
                    },
                ]
            ],
        ]);
    }


    /**
     * Add the default order to the model. If "hasOrder" 
     * That will take default
     *
     * @param  string  $query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function defaultOrder($query)
    {
        return $query->orderBy('template_id')->orderBy('language');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function module(Request $request)
    {
        $this->viewInitialiser();
         
        return view('hack::page.module');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->viewInitialiser();

        if(session('_old_input')) {
            $data = session('_old_input');
        }
        else {
            $data = [
                'template_id' => $request->template_id,
            ];
        }

        // add the builders to the output
        $data['builders'] = Builder::getTemplateBuilders($request->template_id, $this->model, true);

        return view('hack::page.create')
            ->with('data', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModuleStore $request)
    {
        // Start insert
        try {
            DB::beginTransaction();

            $template = $this->template->where('id', $request->template_id)->firstOrFail();

            $id = $this->model->insertGetId($this->prepareValues($request->only([
                'slug',
                'title',
                'body', 
                'search_priority', 
                'template_id', 
                'language',
                'publish_at',
                'depublish_at',
            ]), false, [
                'site_id' => Cms::siteId(), 
                'prepend_slug' => $template->prepend_slug,
                'view' => $template->view,
                'hash' => str_random(40),
            ]));

            $builders = Builder::getTemplateBuilders($request->template_id, $this->model, true);

            foreach($builders as $builder) {

                $builderClass = Builder::makeBuilder($builder['type']);

                if(method_exists($builderClass, 'beforeStore')) {
                    $request = $builderClass->beforeStore($request, $builder, $id);
                }

                $builderId = $builderClass->insertGetId(
                    $this->prepareValues(array_only($builder, array_keys($builderClass->types)), false, [
                        'value' => $request->{$builder['key']},
                        'template_sibling' => $builder['id'],
                    ]));

                $this->pageable->insert([
                    'page_id' => $id,
                    'pageable_id' => $builderId,
                    'pageable_type' => config('cms.builders.'.$builder['type'].'.namespace'),
                    'drag_order' => $builder['pivot']['drag_order'],
                ]);
            }

            DB::commit();

            DbLog::add(__CLASS__, 'store', json_encode($request->all()));

            Cms::destroyCache([$this->slug]);

            // call the search if needed
            if(config('cms.search.index_on_update')) {
                $this->search->pageIndexEntry();
            }
        }
        catch(Exception $e) {
            return $this->rollback($e, $request);
        }

        return redirect()->route('cms.'.$this->slug.'.edit', $id)
            ->with('alert-success', trans('hack::cms.info.created'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $this->viewInitialiser();
        
        if(session('_old_input')) {
            $page = $this->model
                ->where('id', $id)
                ->first();

            $data = session('_old_input');
            $data['template_id'] = $page->template_id;
        }
        else {
            $data = $this->queryParameters($this->model, $request)
                ->where('id', $id)
                ->first()
                ->toArray();
        }

        // add the builders to the output
        $data['builders'] = Builder::getPageBuilders($id, $this->model, true);

        return view('hack::page.edit')
            ->with('data', $data)
            ->with('id', $id)
            ->with('types', $this->types);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModuleUpdate $request, $id)
    {
        // Start insert
        try {
            DB::beginTransaction();

            // get the current page
            $this->record = $this->queryParameters($this->model, $request)->where('id', $id)->first();

            // prepare the page variables
            $values = $this->prepareValues($request->only([
                'slug', 
                'title',
                'body', 
                'search_priority', 
                'language',
                'publish_at',
                'depublish_at',
            ]), $id);

            // save the page
            $this->model->where('id', $id)->update($values);

            // check if the slug changed. If so, add record to slugs
            if($this->record->slug != $values['slug']) {
                $this->notFound->insert($this->prepareValues([
                    'site_id' => Cms::siteId(),
                    'page_id' => $id,
                    'slug' => $this->record->prepend_slug.'/'.$this->record->slug,
                ], false));
            }

            // get al the page builders and loop them for save
            $builders = Builder::getPageBuilders($id, $this->model, true);

            foreach($builders as $builder) {

                $builderClass = Builder::makeBuilder($builder['type']);

                if(method_exists($builderClass, 'beforeUpdate')) {
                    $request = $builderClass->beforeUpdate($request, $builder, $id);
                }

                // save the page builder data
                $builderClass->where('id', $builder['id'])->update(
                    $this->prepareValues(
                        array_only(
                            $builder, 
                            array_keys($builderClass->types)
                        ), 
                        $builder['id'], 
                        [
                            'value' => $request->{$builder['key']},
                        ]
                    )
                );
            }

            DB::commit();

            DbLog::add(__CLASS__, 'update', json_encode($request->all()));

            Cms::destroyCache([$this->slug]);

            // call the search if needed
            if(config('cms.search.index_on_update')) {
                $this->search->pageIndexEntry();
            }
        
        }
        catch(Exception $e) {
            return $this->rollback($e, $request, 'update');
        }

        return redirect()->route('cms.'.$this->slug.'.edit', $id)
            ->with('alert-success', trans('hack::cms.info.updated'));
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // et all the builders
            $builders = Builder::getPageBuilders($id, $this->model, true);

            //  delete all the slugs this page had
            $this->slug->where('page_id', $id)->delete();

            foreach($builders as $builder) {
                // remove the pivot that binds it
                $this->pageable->find($builder['pivot']['id'])->delete();

                // Get the builder class
                $builderClass = Builder::makeBuilder($builder['type']);

                // call the delete function for the builder
                $builderClass->remove($builder['id']);
            }

            // delete the page itself
            $this->model->where('id', $id)->delete();

            DB::commit();

            DbLog::add(__CLASS__, 'destroy', $id);

            Cms::destroyCache([$this->slug]);

            // call the search if needed
            if(config('cms.search.index_on_update')) {
                $this->search->pageIndexEntry();
            }

            return response()->json([
                'message' => trans('hack::cms.deleted'),
            ]);
        
        }
        catch(Exception $e) {

            DB::rollBack();

            Log::error('Rollback after deletion attempt', [
                'action' => 'destroy',
                'data' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Possibly add query parameters to the model
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function queryParameters($query, $request)
    {
        if($request->fid) {
            return $query->where('fid', $request->fid);
        }
        return $query;
    }
}
