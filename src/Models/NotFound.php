<?php

namespace Thorazine\Hack\Models;

use Thorazine\Hack\Scopes\SiteScope;
use Request;
use Cms;

class NotFound extends CmsModel
{
    protected $table = 'not_found';


    protected $fillable = [
        'site_id',
        'slug',
        'referrer',
        'requests',
    ];


    /**
     * Constructor
     */
    public function __construct()
    {
        // we need to force the parent construct
        parent::__construct($this);

        $this->types = $this->types();
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
            'requests' => [
                'type' => 'number',
                'label' => trans('hack::modules.not_found.requests'),
                'regex' => '',
                'create' => false,
                'edit' => false,
            ],
            'slug' => [
                'type' => 'text',
                'label' => trans('hack::modules.not_found.slug'),
                'regex' => '',
            ],
            'redirect' => [
                'type' => 'text',
                'label' => trans('hack::modules.not_found.redirect'),
                'regex' => 'required',
            ],
            'referer' => [
                'type' => 'text',
                'label' => trans('hack::modules.not_found.referer'),
                'regex' => '',
                'create' => false,
                'edit' => false,
            ],
        ];
    } 


    public static function add($slug)
    {
        $notFound = NotFound::where('slug', $slug)
            ->first();

        if($notFound) {

        	// redirect if specified
        	if($notFound->redirect) {
        		header("HTTP/1.1 302 Moved Temporarily");
	            header('Location: '.$notFound->redirect);
	            die();
        	}

            NotFound::where('referer', Request::header('referer'))
                ->where('slug', $slug)
                ->increment('requests');
        }
        else {
            NotFound::insert([
                'site_id' => Cms::siteId(),
                'slug' => $slug,
                'referer' => Request::header('referer'),
                'requests' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
