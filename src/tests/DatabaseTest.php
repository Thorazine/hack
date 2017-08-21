<?php

namespace Thorazine\Hack\Tests\Feature;

use Tests\TestCase;
use Exception;
use DB;

class DatabaseTest extends TestCase
{
    /** 
     * @test
     */
    public function strict_mode_test() 
    {
    	if(config('database.default') == 'mysql') {
        	$this->assertTrue(! config('database.connections.mysql.strict'), 'Your database has to have strict mode set to false.');
        }
    }

    /** 
     * @test
     */
    public function database_connection_test() 
    {
    	try {
		    DB::connection()->getPdo();
		    $this->assertTrue(true);
		} catch (Exception $e) {
			$this->assertTrue(false, 'Could not connect to the database. Please check your configuration.');
		}
    }
}