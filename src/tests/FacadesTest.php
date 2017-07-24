<?php

namespace Thorazine\Hack\Tests\Feature;

use Tests\TestCase;


class FacadesTest extends TestCase
{

    /** 
     * @test
     */
    public function form_exists_in_config() 
    {
        $this->assertTrue(class_exists('Form'), 'Add "\'Form\' => Collective\Html\FormFacade::class," to your app.aliases');
    }

    /** 
     * @test
     */
    public function html_exists_in_config() 
    {
        $this->assertTrue(class_exists('Html'), 'Add "\'Html\' => Collective\Html\HtmlFacade::class," to your app.aliases');
    }

    /** 
     * @test
     */
    public function debugbar_exists_in_config() 
    {
        $this->assertTrue(class_exists('Debugbar'), 'Add "\'Debugbar\' => Barryvdh\Debugbar\Facade::class," to your app.aliases');
    }

    /** 
     * @test
     */
    public function image_exists_in_config() 
    {
        $this->assertTrue(class_exists('Image'), 'Add "\'Image\' => Intervention\Image\Facades\Image::class," to your app.aliases');
    }

    /** 
     * @test
     */
    public function activation_exists_in_config() 
    {
        $this->assertTrue(class_exists('Activation'), 'Add "\'Activation\' => Cartalyst\Sentinel\Laravel\Facades\Activation::class," to your app.aliases');
    }

    /** 
     * @test
     */
    public function reminder_exists_in_config() 
    {
        $this->assertTrue(class_exists('Reminder'), 'Add "\'Reminder\' => Cartalyst\Sentinel\Laravel\Facades\Reminder::class," to your app.aliases');
    }

    /** 
     * @test
     */
    public function sentinel_exists_in_config() 
    {
        $this->assertTrue(class_exists('Sentinel'), 'Add "\'Sentinel\' => Cartalyst\Sentinel\Laravel\Facades\Sentinel::class," to your app.aliases');
    }

    /** 
     * @test
     */
    public function excel_exists_in_config() 
    {
        $this->assertTrue(class_exists('Excel'), 'Add "\'Excel\' => Maatwebsite\Excel\Facades\Excel::class," to your app.aliases');
    }

    /** 
     * @test
     */
    public function builder_exists_in_config() 
    {
        $this->assertTrue(class_exists('Builder'), 'Add "\'Builder\' => Thorazine\Hack\Facades\BuilderFacade::class," to your app.aliases');
    }

    /** 
     * @test
     */
    public function cms_exists_in_config() 
    {
        $this->assertTrue(class_exists('Cms'), 'Add "\'Cms\' => Thorazine\Hack\Facades\CmsFacade::class," to your app.aliases');
    }

    /** 
     * @test
     */
    public function front_exists_in_config() 
    {
        $this->assertTrue(class_exists('Front'), 'Add "\'Front\' => Thorazine\Hack\Facades\FrontFacade::class," to your app.aliases');
    }

    /** 
     * @test
     */
    public function location_exists_in_config() 
    {
        $this->assertTrue(class_exists('Location'), 'Add "\'Location\' => Noprotocol\LaravelLocation\Facades\LocationFacade::class," to your app.aliases');
    }
}