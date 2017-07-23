<?php

namespace Thorazine\Hack\Tests\Feature;

use Tests\TestCase;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateFirstSiteTest extends TestCase
{

    /** 
     * @test
     *
     * See if you get redirected properly while requesting
     * the cms panel without login
     */
    public function no_auth_cms_route() 
    {
        $response = $this->get('/cms');
        $response->assertStatus(302);
        $response = $this->get('/cms/panel');
        $response->assertStatus(302);
        $response = $this->get('/auth/login');
        $response->assertStatus(200);
    }

    /** @test */
    public function name_of_test() 
    {
        
    }
}