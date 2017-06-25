<?php

namespace Thorazine\Hack\Models;

use Thorazine\Hack\Scopes\SiteScope;
use Thorazine\Hack\Models\Template;
use Request;
use Cms;

class Page extends CmsModel
{
    protected $table = 'pages';


    /**
     * All the morph relation placeholder
     */
    protected $morphs = [];


    /**
     * Append to the output
     */
    protected $appends = [
        'url',
    ];


    /**
     * Constructor
     */
    public function __construct()
    {
        // we need to force the parent construct
        parent::__construct($this);

        $this->types = $this->types();

        // add all the modules tot the array so they can be 
        // caught by the realtional builder
        if(config('cms.modules')) {
            foreach(config('cms.modules') as $key => $values) {
                $this->morphs[str_plural($key)] = $values;
            }
        }
    }


    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SiteScope);
    }


    /**
     * Return all the types for this module
     */
    public function types()
    {
        return [
            'id' => [
                'type' => 'number',
                'label' => 'Id',
                'regex' => '',
                'overview' => false,
                'create' => false,
                'edit' => false,
            ],
            'template_id' => [
                'type' => 'value-label',
                'label' => trans('modules.pages.template_id'),
                'regex' => 'required',
                'values' => 'getTemplates',
                // 'edit' => false,
            ],
            'language' => [
                'type' => 'select',
                'label' => trans('modules.pages.language'),
                'regex' => 'required',
                'values' => config('cms.languages'),
            ],
            'prepend_slug' => [
                'type' => 'text',
                'label' => trans('modules.pages.prepend_slug'),
                'regex' => '',
                'overview' => true,
                'create' => false,
                'edit' => false,
            ],
            'slug' => [
                'type' => 'text',
                'label' => trans('modules.pages.slug'),
                'regex' => 'slug',
            ],
            'title' => [
                'type' => 'text',
                'label' => trans('modules.pages.title'),
                'regex' => '',
                'overview' => false,
            ],
            'body' => [
                'type' => 'wysiwyg',
                'label' => trans('modules.pages.body'),
                'regex' => '',
                'configuration' => 'full',
                'overview' => false,
            ],
            'publish_at' => [
                'type' => 'timestamp',
                'label' => trans('modules.pages.publish_at'),
                'regex' => '',
                'default' => date('Y-m-d H:i:s'),
                'position' => 'sidebar',
            ],
            'depublish_at' => [
                'type' => 'timestamp',
                'label' => trans('modules.pages.depublish_at'),
                'regex' => '',
                'position' => 'sidebar',
            ],
        ];
    }


    /**
     * Return the url
     */
    public function __toString()
    {
        return $this->toUrl();
    }


    public function toUrl()
    {
        $url = rtrim(Cms::site('protocol').Cms::site('domain').$this->prepend_slug, '/');
        return $url.'/'.$this->slug;
    }


    /*
     * Catch all the methods for this model. Filter out the 
     * relational requests so we can automatically make
     * a relational query for it based on the array
     * This is only for eager loading. Send the
     * rest to the model function in extend
     */
    public function __call($method, $arguments)
    {
        if(in_array($method, array_keys($this->morphs))) {
            return $this->morphedByMany($this->morphs[$method]['namespace'], 'pageable')->withPivot('id', 'drag_order');
        }

        return parent::__call($method, $arguments);
    }


    /*
     * Catch all the lazy loaded requests to this class
     * and overwrite a model class function with an
     * other of our own. We added a OR function
     */
    public function getRelationValue($key)
    {
        // If the key already exists in the relationships array, it just means the
        // relationship has already been loaded, so we'll just return it out of
        // here because there is no need to query within the relations twice.
        if ($this->relationLoaded($key)) {
            return $this->relations[$key];
        }

        // If the "attribute" exists as a method on the model, we will just assume
        // it is a relationship and will load and return results from the query
        // and hydrate the relationship's value on the "relationships" array.
        if (method_exists($this, $key) || in_array($key, array_keys($this->morphs))) {
            return $this->getRelationshipFromMethod($key);
        }
    }


    /**
     * Check if the page may be visible
     */
    public function scopePublished($query)
    {
        $query->where('pages.publish_at', '<', date('Y-m-d H:i:s'))
            ->where(function($query) {
                $query->where('pages.depublish_at', '>', date('Y-m-d H:i:s'))
                    ->orWhereNull('pages.depublish_at');
            });
    }


    /**
     * Get the comments for the blog post.
     */
    public function slugs()
    {
        return $this->hasMany('Thorazine\Hack\Models\Slug')->orderBy('created_at', 'desc');
    }


    /**
     * Get the comments for the blog post.
     */
    public function template()
    {
        return $this->belongsTo('Thorazine\Hack\Models\Template');
    }


    /**
     * Set the prepend_slug.
     *
     * @param  string  $value
     * @return void
     */
    public function setPrependSlugAttribute($value)
    {
        $this->attributes['prepend_slug'] = trim(trim($value, '/'));
    }


    /**
     * Set the prepend_slug.
     *
     * @param  string  $value
     * @return void
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = trim(trim($value, '/'));
    }


    /**
     * Set the prepend_slug.
     *
     * @param  string  $value
     * @return void
     */
    public function getUrlAttribute()
    {
        return Cms::site('protocol').Cms::site('domain').(($this->attributes['prepend_slug']) ? '/' : '').$this->attributes['prepend_slug'].'/'.$this->attributes['slug'];
    }


    /**
     * Get all of the module owners.
     */
    public function getTemplates($data = [], $key = '')
    {        
        // check if there is request cache.
        if(@$this->templates) {
            return $this->templates;
        }



        $this->templates = Template::select('id', 'refrence')
            ->orderBy('refrence', 'asc')
            ->pluck('refrence', 'id');

        return $this->templates;
    }

    /**
     *
     */
    public function prependSlugLabel($data, $key)
    {
        // dd($data);
        if(Request::has('template_id')) {
            $template = Template::where('id', Request::get('template_id'))->first();
            return Cms::site('protocol').Cms::site('domain').'/'.$template->prepend_slug.(($template->prepend_slug) ? '/' : '');
        }

        $page = $this->where('id', $data['id'])->with('template')->first();
        return Cms::site('protocol').Cms::site('domain').'/'.$page->template->prepend_slug.(($page->template->slug) ? '/' : '');   
    }


    /**
     * Do something before saving this value
     */
    public function beforeSlugSave($value)
    {
        return trim(trim($value, '/'));
    }
}
