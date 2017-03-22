<?php

namespace Thorazine\Hack\Models;

use Illuminate\Support\Facades\Storage;

class Gallery extends CmsModel
{
    /**
     * The table name for the model.
     *
     * @var string
     */
    protected $table = 'gallery';

    /**
     * Append to the output
     *
     * @var array
     */
    protected $appends = [
        'fullname',
        'url',
    ];

    /**
     * The disk we use.
     *
     * @var string
     */
    public $disk = 'cms';

    /**
     * If there is a conflict in an image, use this to couple
     *
     * @var string
     */
	private $conflictPrefix = '_';

    /**
     * Do we use original filename or a hash.
     *
     * @var string
     */
	public $hashed = false;
    

    /**
     * These are the allowed extensions and their categories
     *
     * @var string
     */
	private $allowedExtensions = [
		'jpg' => 'image',
		'jpeg' => 'image',
		'png' => 'image',
		'pdf' => 'file',
	];


    /**
     * Constructor
     */
    public function __construct()
    {
        // we need to force the parent construct
        parent::__construct($this);
    }


    /**
     * Add the fullname to the db output
     */
    public function getFullnameAttribute()
    {
        return $this->filename.'.'.$this->extension;
    }


    /**
     * Add the url with  to the db output
     */
    public function getUrlAttribute()
    {
        if($this->filename && $this->extension) {
            $gallery = new Gallery;
            return asset(Storage::disk($gallery->disk)->url('cropped/original/'.$this->filename.'.'.$this->extension)).'?cache='.crc32($this->updated_at);
        }
        return null;
    }


    /**
     * See if there is a conflict
     */
    public function conflictFilename($filename, $path = '', $counter = false)
    {
    	$file = pathinfo($filename);

    	// dd($path.$file['filename'].(($counter) ? $this->conflictPrefix.$counter : '').'.'.$file['extension']);

    	if(Storage::disk($this->disk)->exists($path.$file['filename'].(($counter) ? $this->conflictPrefix.$counter : '').'.'.$file['extension'])) {
    		if($counter) {
    			$counter++;
    		}
    		else {
    			$counter = 1;
    		}

    		return $this->conflictFilename($filename, $path, $counter);
    	}

    	return $file['filename'].(($counter) ? $this->conflictPrefix.$counter : '').'.'.$file['extension'];
    }


    /**
     * See if there is a conflict
     */
    public function conflictHash($filename)
    {
    	$file = pathinfo($filename);

    	$hash = hash('sha256', microtime().rand(0, 9999));

    	if(Storage::disk($this->disk)->has($hash.'.'.$file['extension'])) {
    		return $this->conflictHash($filename);
    	}

    	return $hash.'.'.$file['extension'];
    }


    /**
     * Get the filetype
     */
    public function fileType($extension)
    {
    	return $this->allowedExtensions[$extension];
    }


    /**
     * Get the path of the storage
     */
    public function diskPath($filename)
    {
    	//  get the disks storage path
        return Storage::disk($this->disk)->getDriver()->getAdapter()->getPathPrefix().$filename;
    }


    /**
     * 
     */
    public function removeObsoleteItem($id)
    {
        $file = $this->where('id', $id)->first();

        if($file) {
            Storage::disk($this->disk)->delete('cropper/original/'.$file->fullname);
            Storage::disk($this->disk)->delete('cropper/thumbnail/'.$file->fullname);
            $this->where('id', $id)->delete();
        }
    }


    /**
     * 
     */
    public function removeUnused()
    {
        // lottery to delete old items
        if(rand(1,25) == 1) {

            // get the old files
            $files = $this->whereNull('updated_at')
                ->where('created_at', '<', date('Y-m-d H:i:s', strtotime("-1 days")))
                ->get();

            $delete = [];
            $ids = [];
            foreach($files as $file) {
                array_push($delete, 'cropped/original/'.$file->fullname);
                array_push($delete, 'cropped/thumbnail/'.$file->fullname);
                array_push($ids, $file->id);
            }

            // delete them from disk and db
            Storage::disk($this->disk)->delete($delete);
            $this->whereIn('id', $ids)->delete();
        }
    }
}
