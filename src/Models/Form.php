<?php

namespace Thorazine\Hack\Models;

use Thorazine\Hack\Classes\Builders\FormBuilder;
use Thorazine\Hack\Scopes\SiteScope;
use View;
use Hack;

class Form extends HackModel
{
    protected $table = 'forms';

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
                'label' => trans('hack::modules.forms.title'),
                'regex' => 'required',
            ],
            'button_text' => [
                'type' => 'text',
                'label' => trans('hack::modules.forms.button_text'),
                'default' => 'Send',
                'regex' => 'required',
                'overview' => false,
            ],
            'on_complete_function' => [
                'type' => 'select',
                'label' => trans('hack::modules.forms.on_complete_function'),
                'regex' => '',
                'overview' => false,
                'placeholder' => trans('hack::modules.forms.on_complete_function_placeholder'),
                'values' => config('cms.forms.on_complete_functions'),
            ],
            'email_new' => [
                'type' => 'checkbox',
                'label' => trans('hack::modules.forms.email_new'),
                'regex' => '',
            ],
            'email_template' => [
                'type' => 'text',
                'label' => trans('hack::modules.forms.email_template'),
                'regex' => 'required_if:email_new,1',
                'default' => 'cms.emails.form-builder',
                'overview' => false,
            ],
            'email_from' => [
                'type' => 'text',
                'label' => trans('hack::modules.forms.email_from'),
                'regex' => 'required_if:email_new,1',
                'overview' => false,
            ],
            'email_from_name' => [
                'type' => 'text',
                'label' => trans('hack::modules.forms.email_from_name'),
                'regex' => '',
                'overview' => false,
            ],
            'email_to' => [
                'type' => 'text',
                'label' => trans('hack::modules.forms.email_to'),
                'regex' => 'required_if:email_new,1',
                'overview' => false,
            ],
            'email_reply_to' => [
                'type' => 'text',
                'label' => trans('hack::modules.forms.email_reply_to'),
                'regex' => '',
                'overview' => false,
            ],
            'email_reply_to_name' => [
                'type' => 'text',
                'label' => trans('hack::modules.forms.email_reply_to_name'),
                'regex' => '',
                'overview' => false,
            ],
            'email_subject' => [
                'type' => 'text',
                'label' => trans('hack::modules.forms.email_subject'),
                'regex' => 'required_if:email_new,1',
                'overview' => false,
            ],
            'email_body' => [
                'type' => 'wysiwyg',
                'label' => trans('hack::modules.forms.email_body'),
                'regex' => '',
                'configuration' => 'email',
                'overview' => false,
            ],
            'thank_message' => [
                'type' => 'wysiwyg',
                'label' => trans('hack::modules.forms.thank_message'),
                'regex' => '',
                'configuration' => 'html',
                'overview' => false,
            ],
            'download_as' => [
                'type' => 'select',
                'label' => trans('hack::modules.forms.download_as'),
                'regex' => 'in:,xls,csv,xlsx',
                'overview' => false,
                'default' => 'xls',
                'values' => [
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
        return $this->hasMany('Thorazine\Hack\Models\FormField')
            ->orderBy('drag_order', 'asc')
            ->orderBy('id', 'asc');
    }


    /**
     * Get all the forms
     */
    public function getForms()
    {
        return ['' => 'None']+$this->select('id', 'title')->orderBy('title', 'asc')->pluck('title', 'id')->toArray();
    }


    /**
     * Output the html
     */
    public function html()
    {
        $page = Hack::page();

        if(view()->exists(Hack::site('id').'.form.form')) {
            return view(Hack::site('id').'.form.form')
            ->with('page', $page)
            ->with('form', $this)
            ->render();
        }

        return view('hack::frontend.form.form')
            ->with('page', $page)
            ->with('form', $this)
            ->render();
    }

}
