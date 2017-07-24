<?php

namespace Thorazine\Hack\Tests\Feature;

use Tests\TestCase;

class EnvTest extends TestCase
{
    /** 
     * @test
     */
    public function env_cache_driver_test() 
    {
        $this->assertTrue(env('CACHE_DRIVER') <> 'file', 'Set the cache in .env driver to another driver than "file"');
    }

    /** 
     * @test
     */
    public function env_filesystem_driver() 
    {
        $this->assertTrue(env('FILESYSTEM_DRIVER') <> '', 'Update the .env setting for the FILESYSTEM_DRIVER');
    }

    /** 
     * @test
     */
    public function env_google_key_driver() 
    {
        $this->assertTrue(env('GOOGLE_KEY') <> '', 'Update the .env setting for GOOGLE_KEY');
    }

    /** 
     * @test
     */
    public function env_cache_page_time_driver() 
    {
        $this->assertTrue(env('PAGE_CACHE_TIME') <> '', 'Update the .env setting for PAGE_CACHE_TIME');
    }
}