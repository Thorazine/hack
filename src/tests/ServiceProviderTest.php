<?php

namespace Thorazine\Hack\Tests\Feature;

use Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    /** 
     * @test
     */
    public function html_in_providers() 
    {
        $this->assertTrue(in_array('Collective\Html\HtmlServiceProvider', config('app.providers')), 'Add "Collective\Html\HtmlServiceProvider::class" to config.app.providers');
    }


    /** 
     * @test
     */
    public function debugbar_in_providers() 
    {
        $this->assertTrue(in_array('Barryvdh\Debugbar\ServiceProvider', config('app.providers')), 'Add "Barryvdh\Debugbar\ServiceProvider::class" to config.app.providers');
    }


    /** 
     * @test
     */
    public function hack_in_providers() 
    {
        $this->assertTrue(in_array('Thorazine\Hack\HackServiceProvider', config('app.providers')), 'Add "Thorazine\Hack\HackServiceProvider::class" to config.app.providers');
    }


    /** 
     * @test
     */
    public function builder_in_providers() 
    {
        $this->assertTrue(in_array('Thorazine\Hack\Providers\BuilderServiceProvider', config('app.providers')), 'Add "Thorazine\Hack\Providers\BuilderServiceProvider::class" to config.app.providers');
    }


    /** 
     * @test
     */
    public function cms_in_providers() 
    {
        $this->assertTrue(in_array('Thorazine\Hack\Providers\CmsServiceProvider', config('app.providers')), 'Add "Thorazine\Hack\Providers\CmsServiceProvider::class" to config.app.providers');
    }


    /** 
     * @test
     */
    public function front_in_providers() 
    {
        $this->assertTrue(in_array('Thorazine\Hack\Providers\FrontServiceProvider', config('app.providers')), 'Add "Thorazine\Hack\Providers\FrontServiceProvider::class" to config.app.providers');
    }


    /** 
     * @test
     */
    public function validation_in_providers() 
    {
        $this->assertTrue(in_array('Thorazine\Hack\Providers\ValidationServiceProvider', config('app.providers')), 'Add "Thorazine\Hack\Providers\ValidationServiceProvider::class" to config.app.providers');
    }


    /** 
     * @test
     */
    public function intervention_in_providers() 
    {
        $this->assertTrue(in_array('Intervention\Image\ImageServiceProvider', config('app.providers')), 'Add "Intervention\Image\ImageServiceProvider::class" to config.app.providers');
    }


    /** 
     * @test
     */
    public function cartalyst_in_providers() 
    {
        $this->assertTrue(in_array('Cartalyst\Sentinel\Laravel\SentinelServiceProvider', config('app.providers')), 'Add "Cartalyst\Sentinel\Laravel\SentinelServiceProvider::class" to config.app.providers');
    }


    /** 
     * @test
     */
    public function agent_in_providers() 
    {
        $this->assertTrue(in_array('Jenssegers\Agent\AgentServiceProvider', config('app.providers')), 'Add "Jenssegers\Agent\AgentServiceProvider::class" to config.app.providers');
    }


    /** 
     * @test
     */
    public function excel_in_providers() 
    {
        $this->assertTrue(in_array('Maatwebsite\Excel\ExcelServiceProvider', config('app.providers')), 'Add "Maatwebsite\Excel\ExcelServiceProvider::class" to config.app.providers');
    }


    /** 
     * @test
     */
    public function route_in_providers() 
    {
        $this->assertTrue(in_array('Thorazine\Hack\Providers\RouteServiceProvider', config('app.providers')), 'Add "Thorazine\Hack\Providers\RouteServiceProvider::class" to config.app.providers');
    }


    /** 
     * @test
     */
    public function location_in_providers() 
    {
        $this->assertTrue(in_array('Thorazine\Location\LocationServiceProvider', config('app.providers')), 'Add "Thorazine\Location\LocationServiceProvider::class" to config.app.providers');
    }
}