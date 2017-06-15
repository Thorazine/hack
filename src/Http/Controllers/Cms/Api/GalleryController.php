<?php

namespace Thorazine\Hack\Http\Controllers\Cms\Api;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Thorazine\Hack\Models\Builders\Image as ImageDB;
use Illuminate\Http\Request;
use Thorazine\Hack\Models\Gallery;
use Thorazine\Hack\Http\Requests;
use Exception;
use Image;
use File;
use Cms;

class GalleryController extends Controller
{

	private $quality;

	private $defaultSizes = [
		'thumbnail' => [
			'width' => 100,
			'height' => 100,
		],
	];


	public function __construct(Gallery $gallery, ImageDB $imageDB)
	{
		$this->gallery = $gallery;
		$this->imageDB = $imageDB;
		$this->quality = (config('image.quality')) ? config('image.quality') : 100;
	}

	/**
     * Catch uploaded images and save them instantly to the gallery and push back the data
     */
    public function upload(Request $request)
    {
    	try {
    		ini_set('memory_limit','250M');

	    	if($request->file('file')->isValid()) {

	    		$file = pathinfo($request->filename);


// dd($file);
	    		// clean the filename
	    		$file['extension'] = strtolower($file['extension']);
	    		$file['filename'] = str_slug($file['filename']);

	    		// sanitize, find conflict, resolve
	    		if($this->gallery->hashed) {
	    			$filename = $this->gallery->conflictHash($file['filename'].'.'.$file['extension'], 'original/');
	    		}
	    		else {
	    			$filename = $this->gallery->conflictFilename($file['filename'].'.'.$file['extension'], 'original/');
	    		}

	    		// get the storage path
	    		// $storagePath = Storage::disk(config('filesystems.default'))->getDriver()->getAdapter()->getPathPrefix();

	    		// store original image to disk
	    		$request->file('file')->storeAs('original', $filename, config('filesystems.default'));

	    		// get an instance of the original
	    		$original = Image::make(Storage::disk(config('filesystems.default'))->get('original/'.$filename))->encode($file['extension'], $this->quality);

	    		foreach($this->defaultSizes as $folder => $specifications) {
	    			$temp = clone $original;

	    			// create the image 
	    			$image = $temp->fit($specifications['width'], $specifications['height'], function ($constraint) {
					    $constraint->aspectRatio();
					})
					->encode($file['extension'], $this->quality);
				
					Storage::disk(config('filesystems.default'))->put('thumbnail/'.$filename, $image->getEncoded());
	    			
	    			$image->destroy();
	    		}	    		

	    		// Prepare for insert
	    		$newFile = pathinfo($filename);
	    		$gallery = [];
	    		$gallery['site_id'] = Cms::siteId();
	    		$gallery['filetype'] = $this->gallery->fileType($newFile['extension']);
	    		$gallery['filename'] = $newFile['filename'];
	    		$gallery['extension'] = $newFile['extension'];
	    		$gallery['title'] = $newFile['filename'];
	    		$gallery['filesize'] = @strlen((string) $original);
		    	$gallery['width'] = $original->width();
		    	$gallery['height'] = $original->height();
		    	$gallery['created_at'] = date('Y-m-d H:i:s');
		    	$gallery['updated_at'] = date('Y-m-d H:i:s');

		    	// save the image to DB
		    	$id = $this->gallery->insertGetId($gallery);

		    	return response()->json([
		    		'id' => $id,
		    		'filename' => $newFile['filename'],
		    		'original' => asset(Storage::disk(config('filesystems.default'))->url('original/'.$filename))
		    	], 200);
		    }
		}
		catch(Exception $e) {
			// no good, log it

			if(env('APP_DEBUG') === true) {
			    return response()->json($e->getMessage(), 500);
		    }
		}

	    // no good
	    return response()->json('Could not upload: File not valid', 500);
    }

    /**
     * Catch uploaded images and push them to the temp folder
     */
    public function crop(Request $request)
    {
    	try {
    		ini_set('memory_limit','250M');

    		// load the gallery image data from the DB
    		$gallery = $this->gallery->where('id', $request->id)->first();

    		// sanitize, find conflict, resolve
    		if($this->gallery->hashed) {
    			$filename = $this->gallery->conflictHash(str_slug($gallery->filename).'.'.$gallery->extension, 'cropped/original/');
    		}
    		else {
    			$filename = $this->gallery->conflictFilename(str_slug($gallery->filename).'.'.$gallery->extension, 'cropped/original/');
    		}

    		// get an instance of the original
    		$original = Image::make(Storage::disk(config('filesystems.default'))->get('original/'.$gallery->fullname));

    		// create instance of the cropped image
    		$cropped = $original->crop(ceil($request->width), ceil($request->height), ceil($request->x), ceil($request->y));

    		// create all the default images
    		foreach($this->defaultSizes as $folder => $specifications) {
    			$temp = clone $cropped;
    			// create the image 
    			$image = $temp->fit($specifications['width'], $specifications['height'], function ($constraint) {
				    $constraint->aspectRatio();
				})
				->encode($gallery->extension, $this->quality);
				
				// save the default image
				Storage::disk(config('filesystems.default'))->put('cropped/thumbnail/'.$filename, $image->getEncoded());

    			
    			// Storage::disk(config('filesystems.default'))->put('cropped/thumbnail/'.$filename, $image);
    		}

    		// create stream of the resized original
    		$image = $cropped->resize($request->resize_width, $request->resize_height)
    			->encode($gallery->extension, $this->quality);
				
			// save the default image
			Storage::disk(config('filesystems.default'))->put('cropped/original/'.$filename, $image->getEncoded());
    			// ->stream($gallery->extension, $this->quality);

    		// save the original image
    		// Storage::disk(config('filesystems.default'))->put('cropped/original/'.$filename, $image);

    		// Prepare for insert
	    	$newFile = pathinfo($filename);
    		$gallery = [];
    		$gallery['site_id'] = Cms::siteId();
    		$gallery['parent_id'] = $request->id;
    		$gallery['filetype'] = $this->gallery->fileType($newFile['extension']);
    		$gallery['filename'] = $newFile['filename'];
    		$gallery['extension'] = $newFile['extension'];
    		$gallery['title'] = $newFile['filename'];
    		$gallery['filesize'] = strlen((string) $image);
	    	$gallery['width'] = $request->resize_width;
	    	$gallery['height'] = $request->resize_height;
	    	$gallery['created_at'] = date('Y-m-d H:i:s');
	    	$gallery['updated_at'] = NULL; // now we know it still has to be activated

	    	// save the image to DB
	    	$id = $this->gallery->insertGetId($gallery);

	    	return response()->json([
	    		'id' => $id,
	    		'thumbnail' => asset(Storage::disk(config('filesystems.default'))->url('cropped/thumbnail/'.$filename)),
	    	], 200);

    	}
		catch(Exception $e) {
	    	// no good
		    return response()->json($e->getMessage(), 500);
    	}
    }

    /**
     * Delete an uploaded image
     */
    public function delete(Request $request)
    {
    	try {
	    	$gallery = $this->gallery->where('id', $request->id)->first();
	    	Storage::disk(config('filesystems.default'))->delete($this->gallery->fullname);
	    	$this->gallery->where('id', $request->id)->delete();

	    	return response()->json([
	    		'success' => $gallery->fullname.trans('cms.removed'),
	    	], 200);
	    }
	    catch(Exception $e) {
	    	// no good, log it
    	    return response()->json(trans('cms.error.remove'), 500);
	    }
	    
    }


    /**
     * Delete an uploaded image
     */
    public function api(Request $request)
    {
    	try {
	    	$datas = $this->gallery
	    		->whereNull('parent_id')
	    		->take(100)
	    		->where('site_id', Cms::siteId())
	    		->orderBy('id', 'desc')
	    		->get();

	    	$return = [];
	    	foreach($datas as $data) {
	    		array_push($return, [
	    			'id' => $data->id,
	    			'title' => $data->filename,
	    			'original' => asset(Storage::disk(config('filesystems.default'))->url('original/'.$data->fullname)),
	    			'thumbnail' => asset(Storage::disk(config('filesystems.default'))->url('thumbnail/'.$data->fullname)),
	    		]);
	    	}

	    	return response()->json([
	    		'success' => true,
	    		'data' => $return,
	    	], 200);
	    }
	    catch(Exception $e) {
	    	// no good, log it
    	    return response()->json(trans('cms.error'), 500);
	    }

	}


}
