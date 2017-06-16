<?php

return [
	// Dashboard
	[
		'route' => 'cms.panel.index',
		'label' => 'menu.dashboard',
		'icon' => 'fa-dashboard',
		'verified' => true, // always in menu
	],

	// General
	[
		'route' => 'cms.sites.index',
		'label' => 'cms.module.sites',
		'icon' => 'fa-th-list',
	],

	// Content
	[
		'label' => 'menu.content',
		'icon' => 'fa-cloud',
		'children' => [
			[
				'route' => 'cms.pages.index',
				'label' => 'cms.module.pages',
			],
			[
				'route' => 'cms.templates.index',
				'label' => 'cms.module.templates',
				'route-matches' => [
					'/cms/builder',
				],
			],
			[
				'route' => 'cms.menus.index',
				'label' => 'cms.module.menus',
				'route-matches' => [
					'/cms/menu_items',
				],
			],
			[
				'route' => 'cms.not_found.index',
				'label' => 'cms.module.not_found',
			],
		],
	],

	// Forms
	[
		'label' => 'menu.forms',
		'icon' => 'fa-wpforms',
		'children' => [
			[
				'route' => 'cms.forms.index',
				'label' => 'cms.module.forms',
				'route-matches' => [
					'/cms/form_fields',
					'/cms/form_entries',
				],
			],
			[
				'route' => 'cms.form_validations.index',
				'label' => 'cms.module.form_validations',
			],
		]
	],

	// Gallery
	[
		'route' => 'cms.gallery.index',
		'label' => 'cms.module.gallery',
		'icon' => 'fa-picture-o',
	],

	// Settings
	[
		'label' => 'menu.settings',
		'icon' => 'fa-gear',
		'children' => [
			[
				'route' => 'cms.users.index',
				'label' => 'cms.module.users',
			],
			[
				'route' => 'cms.roles.index',
				'label' => 'cms.module.roles',
			],
		]
	],

	// Information
	[
		'label' => 'menu.information',
		'icon' => 'fa-info-circle',
		'children' => [
			[
				'route' => 'cms.db_logs.index',
				'label' => 'cms.module.db_logs',
			],
			[
				'route' => 'cms.information.index',
				'label' => 'cms.module.information',
			],
		]
	],

];