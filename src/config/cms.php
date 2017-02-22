<?php

return [
	/**
	 * The languages pages can be made in
	 */
	'languages' => [
		'nl' => 'Dutch',
		'en' => 'English',
	],
	

	/** 
	 * All the loaded modules
	 */
	'modules' => [
		'text' => [
		 	'namespace' => 'App\Models\Builders\Text',
		 	'label' => 'Text',
	 	],
		'image' => [
		 	'namespace' => 'App\Models\Builders\Image',
		 	'label' => 'Image',
		 	'builder' => 'App\Classes\Builders\Image',
	 	],
		'wysiwyg' => [
		 	'namespace' => 'App\Models\Builders\Wysiwyg',
		 	'label' => 'Wysiwyg',
		 	'values' => [
		 		'plain',
		 		'full',
		 	],
	 	],
		'menu' => [
		 	'namespace' => 'App\Models\Builders\Menu',
		 	'label' => 'Menu',
	 	],
		'form' => [
		 	'namespace' => 'App\Models\Builders\Form',
		 	'label' => 'Form',
		 	'builder' => 'App\Classes\Builders\Form',
	 	],
	],
	

	/** 
	 * All the loaded modules
	 */
	'forms' => [
		'on_complete_functions' => [
			// 'App\Classes\Email@mailChimp' => 'Add to MailChimp',
		],

		'types' => [
			'text' => 'Text',
			'select' => 'Select',
			'checkbox' => 'Checkbox',
			'radio' => 'Radio',
			'date' => 'Date',
			'time' => 'Time',
		],
	],


	/**
	 * The distance in km from a previous session to the current.
	 * To be valid it has to be at least this close to
	 * continue without the user having to confirm
	 */
	'validation_distance' => 10,


	'rights' => [
	
		'excluded' => [
			'cms.panel.index',
			'cms.api.gallery.upload',
			'cms.api.gallery.destroy',
			'cms.api.gallery.api',
			'cms.api.gallery.crop',
		],
	],


	'search' => [
		'defaultSearchTypes' => [
			'text',
			'wysiwyg',
			'number',
		],
	],

];