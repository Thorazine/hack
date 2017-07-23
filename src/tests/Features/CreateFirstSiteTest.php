<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateFirstSiteTest extends TestCase
{

    /** @test */
    public function is_create_site_availible() 
    {
        \URL::forceRootUrl('http://localhost/hack/public');

        $response = $this->get('/');

        // dd($response;

        $response->assertStatus(302);
    }
}