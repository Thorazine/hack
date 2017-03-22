<?php

namespace Thorazine\Hack\Classes\Facades;

use Illuminate\Support\Facades\Storage;
use Thorazine\Hack\Models\Templateable;
use Thorazine\Hack\Models\Template;
use Thorazine\Hack\Models\Pageable;
use Thorazine\Hack\Models\Gallery;
use Thorazine\Hack\Models\Page;
use Thorazine\Hack\Models\Menu;
use Thorazine\Hack\Models\Form;
use Log;

class Builder {

	// translate an array for the builder
	public function trans($array)
	{
		foreach($array as &$text) {
			$text = trans('builder.'.$text);
		}
		return $array;
	}


    public function image($id)
    {
        $gallery = new Gallery;

        $file = $gallery->select('filename', 'extension')->where('id', $id)->first();

        if($file) {
            return asset(Storage::disk($gallery->disk)->url('cropped/thumbnail/'.$file->fullname)).'?cache='.crc32($file->updated_at);
        }
        
    }


    public function asset($fullname)
    {
        $gallery = new Gallery;

        if($fullname) {
            return asset(Storage::disk($gallery->disk)->url('cropped/original/'.$fullname));
        }
        
    }


	public function moduleValues()
	{
		$values = [];
		foreach(config('cms.modules') as $key => $value) {
			$values[$key] = config('cms.modules.'.$key.'.label');
		}
		return $values;
	}


	public function templates()
	{
		// keep it lean
		$this->template = new Template;

		$templates = $this->template
			->select('id', 'refrence')
            ->orderBy('refrence', 'asc')
			->pluck('refrence', 'id')
			->toArray();

		return $templates;
	}


	public function getTemplateBuilders($templateId, $model, $asArray = false)
	{
		// keep it lean
		$this->templateable = new Templateable;
		$this->template = new Template;

		// Get the morphs that we need to request. We don't want to run joins that have no data
        // It is worth one query to find out if we can spare a few joins
        $morphs = $this->templateable
            ->select('templateable_type')
            ->where('template_id', $templateId)
            ->groupBy('templateable_type')
            ->pluck('templateable_type')
            ->toArray();

        // start the relational query
        $template = $this->template->where('id', $templateId);
            // ->join('templateables', 'templateables.template_id', '=', 'templates.id')
            // ->where('templateables.template_id', $templateId);

        // add all relations that exist in the morph if they exist
        foreach(array_keys(config('cms.modules')) as $relation) {

            // check if function exists. 
            // Spoiler alert, it doesn't. 
            // We magicaly create it with the __call function
            if(in_array(config('cms.modules.'.$relation.'.namespace'), $morphs)) {
                $template = $template->with(str_plural($relation));
            }
            else {
                // show user that he needs to add his relation
                Log::info('Skipped relation '.config('cms.modules.'.$relation.'.namespace').' because it wasn\'t defined');
            }
        }
        
        // pick up the first
        $template = $template->first();

        if($template) {

            // join all the module relations together if they exist and check is in morphs, else it will eager load. We don't want that
            $collection = []; //  default to nothing
            foreach(array_keys(config('cms.modules')) as $relation) {
                if(! $collection) {
                    $collection = collect($template->{str_plural($relation)});
                }
                elseif(in_array(config('cms.modules.'.$relation.'.namespace'), $morphs)) {
                    $collection = $collection->merge($template->{str_plural($relation)});
                }
            }

            // drop the collection in the modules object
            $builders = $collection->sortBy('pivot.drag_order')->values()->all();

            if($asArray) {
            	return json_decode(json_encode($builders), true);
            }
            return $builders;
        }

	    return [];
	}


	/*
	 *
	 */
	public function getPageBuilders($pageId, $model, $asArray = false)
	{
		// keep it lean
		$this->pageable = new Pageable;
		$this->page = new Page;

		// Get the morphs that we need to request. We don't want to run joins that have no data
        // It is worth one query to find out if we can spare a few joins
        $morphs = $this->pageable
            ->select('pageable_type')
            ->where('page_id', $pageId)
            ->groupBy('pageable_type')
            ->pluck('pageable_type')
            ->toArray();

        // start the relational query
        $page = $this->page
            ->where('id', $pageId);

        // add all relations that exist in the morph if they exist
        foreach(array_keys(config('cms.modules')) as $relation) {
            if(method_exists($model, str_plural($relation)) && in_array(config('cms.modules.'.$relation.'.namespace'), $morphs)) {
                $page = $page->with(str_plural($relation));
            }
            elseif(in_array(config('cms.modules.'.$relation.'.namespace'), $morphs)) {
                // show user that he needs to add his relation
                Log::info('Skipped relation '.config('cms.modules.'.$relation.'.namespace').' because it wasn\'t defined');
            }
        }
        
        // pick up the first
        $page = $page->first();

        if($page) {

            // join all the module relations together if they exist and check is in morphs, else it will eager load. We don't want that
            $collection = []; //  default to nothing
            foreach(array_keys(config('cms.modules')) as $relation) {
                if(! $collection) {
                    $collection = collect($page->{str_plural($relation)});
                }
                elseif(in_array(config('cms.modules.'.$relation.'.namespace'), $morphs)) {
                    $collection = $collection->merge($page->{str_plural($relation)});
                }
            }

            // drop the collection in the modules object
            $builders = $collection->sortBy('pivot.drag_order')->values()->all();

            if($asArray) {
            	return json_decode(json_encode($builders), true);
            }
            return $builders;
        }

        return [];
	}


	public function makeBuilder($type)
	{
		$namespace = config('cms.modules.'.$type.'.namespace');
        return new $namespace;
	}


    public function createValue($model, $type, $data, $key, $action, $returnArray = false)
    {
        if(array_key_exists($key, $data)) {
            if($returnArray) {
                if(array_key_exists('alternateValue', $type)) {
                    if(array_key_exists($action, $type['alternateValue'])) { 
                        return $this->getArrayValue($model, $type, $type['alternateValue'][$action], $data, $key);
                    }
                }
                return $this->getArrayValue($model, $type, $data[$key], $data, $key);
            }

            if(array_key_exists('alternateValue', $type)) {
                if(array_key_exists($action, $type['alternateValue'])) {
                    return $this->getPlainValue($model, $type['alternateValue'][$action], $data, $key);
                }
            }
            return $this->getPlainValue($model, $data[$key], $data, $key);
        }
        dd($data);

        dd('Key "'.$key.'" doesn\'t exist. (Builder->createValue())');
    }


    public function getPlainValue($model, $value, $data, $key)
    {
        if(is_string($value) || is_integer($value)) {
            return $value;
        }
        elseif(is_callable($value)) {
            return $value($data, $key);
        }
        return '';
    }


    public function getArrayValue($model, $type, $value, $data, $key)
    {
        if(is_string($type['values'])) {
            return $model->{$type['values']}($data, $key);
        }
        elseif(is_callable($value)) {
            return $value($data, $key);
        }
        elseif(is_array($value)) {
            return $value;
        }
        return [];
    }


    public function getBooleanByKeyFromCollectionArray($collection, $key, $value) 
    {

        foreach($collection as $values) {
            if($values[$key] == $value) {
                return true;
            }
        }
        return false;
    }


    public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' kB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }


    public function getLanguageAsArray($key = 'name') 
    {
        $languages = [];

        foreach(collect(config('languages'))->sortBy($key)->values()->all() as $countryCode => $settings) {
            $languages[$settings['countryCode']] = $settings[$key];
        }

        return $languages;
    }


    private function getGallery()
    {
        if(! $this->gallery) {
            $this->gallery = new Gallery;
        }
        return $this->gallery;
    }


    public function getMenus()
    {
        $menu = new Menu;
        return $menu->getMenus();
    }


    public function getForms()
    {
        $form = new Form;
        return $form->getForms();
    }
}