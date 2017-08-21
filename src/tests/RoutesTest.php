<?php

namespace Thorazine\Hack\Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoutesTest extends TestCase
{

	/** 
	 * @test
	 */
	public function cms_has_redirect() 
	{
		$response = $this->get('/cms');
        $response->assertStatus(302);
	}

	/** 
	 * @test
	 */
	public function panel_has_redirect() 
	{
		$response = $this->get('/cms/panel');
        $response->assertStatus(302);
	}

	/** 
	 * @test
	 */
	public function auth_login_availible() 
	{
		$response = $this->get('/auth/login');
        $response->assertStatus(200);
	}
}