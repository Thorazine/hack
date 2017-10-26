<?php

namespace Thorazine\Hack\Models;

use Illuminate\Support\Facades\Storage;
use Thorazine\Hack\Scopes\SiteScope;

class Gallery extends HackModel
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
    public $disk = 'replace with config(\'filesystems.default\')';

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

        $this->types = $this->types();
    }


    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SiteScope);
    }


    /**
     * Return all the types for this module
     */
    public function types()
    {
        return [
            'id' => [
                'type' => 'number',
                'label' => 'Id',
                'regex' => '',
                'overview' => false,
                'create' => false,
                'edit' => false,
            ],
            'preview' => [
                'type' => 'gallery-image',
                'label' => trans('hack::modules.gallery.preview'),
                'regex' => '',
                'overview' => true,
                'create' => false,
                'edit' => false,
            ],
            'filetype' => [
                'type' => 'select',
                'label' => trans('hack::modules.gallery.filetype'),
                'regex' => 'required',
                'values' => [
                    'image' => 'Image',
                    // 'document' => 'Document',
                ],
            ],
            'title' => [
                'type' => 'text',
                'label' => trans('hack::modules.gallery.title'),
                'regex' => 'required',
            ],
            'width' => [
                'type' => 'number',
                'label' => trans('hack::modules.gallery.width'),
                'regex' => '',
                'overview' => true,
                'create' => false,
                'edit' => false,
            ],
            'height' => [
                'type' => 'number',
                'label' => trans('hack::modules.gallery.height'),
                'regex' => '',
                'overview' => true,
                'create' => false,
                'edit' => false,
            ],
        ];
    }


    /**
     * Return the url with browser cache buster
     */
    public function __toString()
    {
        if($this->filename && $this->extension) {
            return Storage::disk(config('filesystems.default'))->url('cropped/original/'.$this->filename.'.'.$this->extension).'?cache='.crc32($this->updated_at);
        }
        return '';
    }


    /**
     * Return the url with browser cache buster
     */
    public function getThumbnailAttribute()
    {
        if($this->filename && $this->extension) {
            return Storage::disk(config('filesystems.default'))->url('cropped/thumbnail/'.$this->filename.'.'.$this->extension).'?cache='.crc32($this->updated_at);
        }
        return '';
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
            return Storage::disk(config('filesystems.default'))->url('cropped/original/'.$this->filename.'.'.$this->extension).'?cache='.crc32($this->updated_at);
        }
        return '';
    }


    /**
     * See if there is a conflict
     */
    public function conflictFilename($filename, $path = '', $counter = false)
    {
    	$file = pathinfo($filename);

    	// dd($path.$file['filename'].(($counter) ? $this->conflictPrefix.$counter : '').'.'.$file['extension']);

    	if(Storage::disk(config('filesystems.default'))->exists($path.$file['filename'].(($counter) ? $this->conflictPrefix.$counter : '').'.'.$file['extension'])) {
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

    	if(Storage::disk(config('filesystems.default'))->has($hash.'.'.$file['extension'])) {
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
     * Get the filetype
     */
    public function has()
    {
        return Storage::disk(config('filesystems.default'))->exists('cropped/original/'.$this->filename.'.'.$this->extension);
    }


    /**
     * Quick html output
     */
    public function html($class = null)
    {
        return '<img '.(($class) ? 'class="'.$class.'"' : '').'src="'.$this.'" title="'.$this->title.'">';
    }


    /**
     * Get the filetype
     */
    public function key()
    {
        return crc32($this->updated_at);
    }


    /**
     * Get the filesize
     */
    public function filesize($metric = 'B', $precision = 2)
    {
        $size = $this->filesize;

        switch ($metric) {
            case 'KB':
                $size = $this->filesize / 1024;
                break;

            case 'MB':
                $size = $this->filesize / 1024 / 1024;
                break;

            case 'GB':
                $size = $this->filesize / 1024 / 1024 / 1024;
                break;
        }
        return round($size, $precision);
    }


    /**
     * Get the path of the storage
     */
    public function diskPath($filename)
    {
    	//  get the disks storage path
        return Storage::disk(config('filesystems.default'))->getDriver()->getAdapter()->getPathPrefix().$filename;
    }


    /**
     * Delete from disc
     */
    public function removeObsoleteItem($id)
    {
        $file = $this->where('id', $id)->first();

        if($file) {
            Storage::disk(config('filesystems.default'))->delete('cropper/original/'.$file->fullname);
            Storage::disk(config('filesystems.default'))->delete('cropper/thumbnail/'.$file->fullname);
            $this->where('id', $id)->delete();
        }
    }


    /**
     * Clean temp folder
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
            Storage::disk(config('filesystems.default'))->delete($delete);
            $this->whereIn('id', $ids)->delete();
        }
    }


    public function remove($original = false)
    {
        if($this->id) {
            if($original) {
                Storage::disk(config('filesystems.default'))->delete('original/'.$this->fullname);
                Storage::disk(config('filesystems.default'))->delete('thumbnail/'.$this->fullname);
            }
            else {
                Storage::disk(config('filesystems.default'))->delete('cropped/original/'.$this->fullname);
                Storage::disk(config('filesystems.default'))->delete('cropped/thumbnail/'.$this->fullname);
            }
            $this->where('id', $this->id)->delete();
        }
    }
}
