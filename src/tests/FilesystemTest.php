<?php

namespace Thorazine\Hack\Tests\Feature;

use Tests\TestCase;
use Storage;

class FilesystemTest extends TestCase
{
    /** 
     * @test
     */
    public function put_storage_test() 
    {
    	$this->assertTrue(Storage::disk(config('filesystems.default'))->put('test.txt', 'This is a test file. You can remove this anytime.'), 'The filesystem is not writeable. Please check configuration.');
    }

    /** 
     * @test
     */
    public function has_storage_test() 
    {
    	$this->assertTrue(Storage::disk(config('filesystems.default'))->has('test.txt'), 'The filesystem has no test file. Please check configuration.');
    }

    /** 
     * @test
     */
    public function url_storage_test() 
    {
    	$response = $this->get(Storage::disk(config('filesystems.default'))->url('test.txt'));
        $response->assertStatus(200);
    }

    /** 
     * @test
     */
    public function delete_storage_test() 
    {
    	$this->assertTrue(Storage::disk(config('filesystems.default'))->delete('test.txt'), 'The filesystem doesn\'t have proper rights to for delete. Please check configuration.');
    }
}