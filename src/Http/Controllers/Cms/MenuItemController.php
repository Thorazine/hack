<?php

namespace Thorazine\Hack\Http\Controllers\Cms;

use Thorazine\Hack\Classes\Tools\Nested;
use Illuminate\Http\Request;
use Thorazine\Hack\Models\MenuItem;

class MenuItemController extends CmsController
{

    public function __construct(MenuItem $model, Nested $nested)
    {
        $this->model = $model;
        $this->slug = 'menu_items';

        parent::__construct($this);

        view()->share([
            'nested' => $nested,
            'extraItemButtons' => function($datas) {
                return [
                    [
                        'class' => 'primary',
                        'route' => route('cms.forms.index'),
                        'text' => 'Menus',
                    ],
                ];
            },
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datas = $this->search($this->queryParameters($this->model, $request), $request)
            ->orderBy('drag_order', 'asc')
            ->with('menu')
            ->get();

        if($request->ajax()) {
            return response()->json([
                'dataset' => view('cms.models.ajax.index')
                    ->with('datas', $datas)
                    ->with('fid', $request->fid)
                    ->with('searchFields', $this->searchFields)
                    ->render(),
                'paginate' => view('cms.models.ajax.paginate')
                    ->with('datas', $datas)
                    ->with('fid', $request->fid)
                    ->with('searchFields', $this->searchFields)
                    ->render(),
            ]);
        }

        return view('cms.menu-item.index')
            ->with('datas', $datas)
            ->with('fid', $request->fid);
    }


    /**
     * Get the values for saving. This function
     * makes overwriting it with an array  
     * for the child class easier
     *
     * @param  \Illuminate\Http\Request  $request|array
     * @return \Illuminate\Http\Response|array
     */
    protected function beforeStore($request)
    {
        $this->extraCreateValues = [
            'menu_id' => $request->fid,
        ];
        return $request;
    }


    /**
     * An easy way the break in to
     * the save method with an
     * extra query
     *
     * @param  \Illuminate\Http\Request  $request|array
     * @return \Illuminate\Http\Response|array
     */
    protected function storeExtra($request, $id)
    {
        // set all the other items order + 1
        $this->model->where('menu_id', $request->fid)
            ->where('id', '!=', $id)
            ->increment('drag_order');
    }


    /**
     * Possibly add query parameters to the model
     *
     * @param  string  $query
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function queryParameters($query, $request)
    {
        if($request->fid) {
            return $query->where('menu_id', $request->fid);
        }
        return $query;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request)
    {

        $menuItemsIds = $this->model
            ->where('menu_id', $request->menu_id)
            ->pluck('id')
            ->toArray();

        foreach($request->menu_items as $index => $menuItem) {

            if(@$menuItem['name']) { // update
                $this->model->where('id', $menuItem['name'])->update([
                    'parent_id' => $menuItem['parent_id'],
                    'depth' => $menuItem['depth'],
                    'drag_order' => $index,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                // delete id from delete list

                if(@$menuItem['name'] && ($key = array_search($menuItem['name'], $menuItemsIds)) !== false) {
                    unset($menuItemsIds[$key]);
                }
            }
            else { // create

            }
        }

        Cms::destroyCache([$this->slug]);

        // dd($menuItemsIds);

        return response()->json([
            'success' => true,
        ]);
    }
}
