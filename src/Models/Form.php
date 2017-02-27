<?php

namespace Thorazine\Hack\Models;

use Thorazine\Hack\Scopes\SiteScope;
use View;

class Form extends CmsModel
{
    protected $table = 'forms';

    protected $viewPath = 'cms.form.inputs';

    protected $builder;


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
            'title' => [
                'type' => 'text',
                'label' => trans('modules.forms.title'),
                'regex' => 'required',
            ],
            'on_complete_function' => [
                'type' => 'select',
                'label' => trans('modules.forms.on_complete_function'),
                'regex' => '',
                'overview' => false,
                'placeholder' => trans('modules.forms.on_complete_function_placeholder'),
                'values' => config('cms.forms.on_complete_functions'),
            ],
            'email_new' => [
                'type' => 'checkbox',
                'label' => trans('modules.forms.email_new'),
                'regex' => '',
            ],
            'email_from' => [
                'type' => 'text',
                'label' => trans('modules.forms.email_from'),
                'regex' => 'required_with:email_new',
                'overview' => false,
            ],
            'email_to' => [
                'type' => 'text',
                'label' => trans('modules.forms.email_to'),
                'regex' => 'required_with:email_new',
                'overview' => false,
            ],
            'email_reply_to' => [
                'type' => 'text',
                'label' => trans('modules.forms.email_reply_to'),
                'regex' => '',
                'overview' => false,
            ],
            'email_subject' => [
                'type' => 'text',
                'label' => trans('modules.forms.email_subject'),
                'regex' => 'required_with:email_new',
                'overview' => false,
            ],
            'email_body' => [
                'type' => 'wysiwyg',
                'label' => trans('modules.forms.email_body'),
                'regex' => '',
                'configuration' => 'email',
                'overview' => false,
            ],
            'thank_message' => [
                'type' => 'wysiwyg',
                'label' => trans('modules.forms.thank_message'),
                'regex' => '',
                'configuration' => 'html',
                'overview' => false,
            ],
            'download_as' => [
                'type' => 'select',
                'label' => trans('modules.forms.download_as'),
                'regex' => 'in:xls,csv,xlsx',
                'overview' => false,
                'values' => [
                    '' => trans('cms.none'),
                    'xls' => 'Excel (.xls)',
                    'xlsx' => 'Excel (.xlsx)',
                    'csv' => 'Comma seperated (.csv)',
                ],
            ],
        ];
    }


    /**
     * Get the page record associated with the slug.
     */
    public function formFields()
    {
        return $this->hasMany('Thorazine\Hack\Models\FormField');
    }


    /**
     * Get all the forms
     */
    public function getForms()
    {
        return $this->select('id', 'title')->orderBy('title', 'asc')->pluck('title', 'id');
    }


    public function html()
    {
        return 'form_builder';
    }
    
}
