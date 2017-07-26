<?php

namespace Thorazine\Hack\Tests\Feature;

use Tests\TestCase;

class AssetTest extends TestCase
{
    /** 
     * @test
     */
    public function migration_done_test() 
    {
        $this->assertTrue(file_exists(base_path('resources/views/1')), 'No assets found. Please run "php artisan vendor:publish --tag=hack --force"');
    }

    /** 
     * @test
     */
    public function node_modules_installed_test() 
    {
        $this->assertTrue(file_exists(base_path('node_modules')), 'Node_modules have not been created. Please run "npm install"');
    }

    /** 
     * @test
     */
    public function compiled_files_found_test() 
    {
        $this->assertTrue(file_exists(base_path('resources/views/1')), 'Compiled files have not been found. Please run "npm run dev"');
    }
}