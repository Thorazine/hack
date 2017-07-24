<?php

return [
	/**
	 * The languages pages can be made in
	 * You can add add any language here from the languages config.
	 */
	'languages' => [
		'nl' => 'Dutch',
		'en' => 'English',
	],

	/**
	 * The languages the user can choose from for the cms
	 * You can add add any language here from the languages config.
	 */
	'cms-languages' => [
		'en' => 'English',
		'nl' => 'Dutch',
	],
	

	/** 
	 * All the builders we use
	 */
	'builders' => [
		'text' => [
		 	'namespace' => 'Thorazine\Hack\Models\Builders\Text',
		 	'label' => 'Text',
	 	],
		'image' => [
		 	'namespace' => 'Thorazine\Hack\Models\Builders\Image',
		 	'label' => 'Image',
		 	'builder' => 'Thorazine\Hack\Classes\Builders\Image',
	 	],
		'carousel' => [
		 	'namespace' => 'Thorazine\Hack\Models\Builders\Carousel',
		 	'label' => 'Carousel',
	 	],
		'wysiwyg' => [
		 	'namespace' => 'Thorazine\Hack\Models\Builders\Wysiwyg',
		 	'label' => 'Wysiwyg',
		 	'builder' => 'Thorazine\Hack\Classes\Builders\Wysiwyg',
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
	 * All the availible form elements
	 */
	'forms' => [
		'on_complete_functions' => [
			// 'Thorazine\Hack\Classes\Email@mailChimp' => 'Add to MailChimp',
		],

		'types' => [
			'text' => [
				'label' => 'Text',
				'type' => 'text',
			],
			'select' => [
				'label' => 'Select',
				'type' => 'value-label',
			],
			'checkbox' => [
				'label' => 'Checkbox',
				'type' => 'text',
			],
			'radio' => [
				'label' => 'Radio',
				'type' => 'value-label',
			],
			'date' => [
				'label' => 'Date',
				'type' => 'text',
			],
			'time' => [
				'label' => 'Time',
				'type' => 'text',
			],
		],
	],


	/**
	 * The distance in km from a previous session to the current.
	 * To be valid the user has to be at least this close to
	 * continue without the user having to confirm.
	 */
	'validation_distance' => 10,


	/**
	 * The routes that do not need to be in the 
	 * sentinel rights configuration to pass 
	 * through the middleware check. 
	 * These routes alway work.
	 */
	'rights' => [
	
		'excluded' => [
			'cms.panel.index',
			'cms.api.gallery.upload',
			'cms.api.gallery.destroy',
			'cms.api.gallery.api',
			'cms.api.gallery.crop',
			'cms.user.show',
			'cms.user.edit',
			'cms.user.update',
			'cms.user.destroy',
		],
	],


	/**
	 * All the settings for searching
	 */
	'search' => [

		/**
		 * The model query searches through these types
		 * of inputs for a possible match unless
		 * overwritten in the class.
		 */
		'cms_search_types' => [
			'text',
			'wysiwyg',
			'number',
			'timestamp',
		],

		/**
		 * The frontens searches through these types
		 * of inputs for a possible match
		 */
		'frontend_search_types' => [
			'text',
			'wysiwyg',
		],

		/**
		 * The search results are indexed to make searching the pages 
		 * more efficient. When you are low on pages it makes 
		 * sense to only update the results on a page change. 
		 * However, when the amount of pages grows you are going to want
		 * to run the indexer in the background by running the hack:search
		 * artisan command on a crontab every few minutes.
		 */
		'index_on_update' => true,

		/**
		 * Run the search engine on these views 
		 */
		'view_bind' => [
			'search',
			'example.search',
		],
	],

];
