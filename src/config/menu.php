<?php

return [
	// Dashboard
	[
		'route' => 'cms.panel.index',
		'label' => 'menu.dashboard',
		'icon' => 'fa-dashboard',
	],

	// Content
	[
		'label' => 'menu.content',
		'icon' => 'fa-cloud',
		'children' => [
			[
				'route' => 'cms.sites.index',
				'label' => 'cms.module.sites',
			],
			[
				'route' => 'cms.pages.index',
				'label' => 'cms.module.pages',
			],
			[
				'route' => 'cms.restaurant_menus.index',
				'label' => 'cms.module.restaurant_menus',
			],
			[
				'route' => 'cms.menus.index',
				'label' => 'cms.module.menus',
			],
			[
				'route' => 'cms.templates.index',
				'label' => 'cms.module.templates',
			],
			[
				'route' => 'cms.not_found.index',
				'label' => 'cms.module.not_found',
			],
		]
	],

	// Forms
	[
		'label' => 'menu.forms',
		'icon' => 'fa-wpforms',
		'children' => [
			[
				'route' => 'cms.forms.index',
				'label' => 'cms.module.forms',
			],
			[
				'route' => 'cms.form_validations.index',
				'label' => 'cms.module.form_validations',
			],
		]
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

];