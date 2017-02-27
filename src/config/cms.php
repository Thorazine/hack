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
		 	'namespace' => 'Thorazine\Hack\Models\Builders\Text',
		 	'label' => 'Text',
	 	],
		'image' => [
		 	'namespace' => 'Thorazine\Hack\Models\Builders\Image',
		 	'label' => 'Image',
		 	'builder' => 'Thorazine\Hack\Classes\Builders\Image',
	 	],
		'wysiwyg' => [
		 	'namespace' => 'Thorazine\Hack\Models\Builders\Wysiwyg',
		 	'label' => 'Wysiwyg',
		 	'values' => [
		 		'plain',
		 		'full',
		 	],
	 	],
		'menu' => [
		 	'namespace' => 'Thorazine\Hack\Models\Builders\Menu',
		 	'label' => 'Menu',
	 	],
		'form' => [
		 	'namespace' => 'Thorazine\Hack\Models\Builders\Form',
		 	'label' => 'Form',
		 	'builder' => 'Thorazine\Hack\Classes\Builders\Form',
	 	],
	],
	

	/** 
	 * All the loaded modules
	 */
	'forms' => [
		'on_complete_functions' => [
			// 'Thorazine\Hack\Classes\Email@mailChimp' => 'Add to MailChimp',
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