<?php

return [
	// module entry fields
	'sites' => [
		'title' => 'Title',
		'robots' => 'Robots',
		'protocol' => 'Protocol',
		'domain' => 'Default domain',
		'domains' => 'Alternative domains',
		'language' => 'Default language',
		'languages' => 'Languages',
		'description' => 'Description',
		'favicon' => 'Favicon',
		'og_title' => 'og:title',
		'og_description' => 'og:description',
		'og_type' => 'og:type',
		'og_image' => 'og:image',
		'browser_cache_time' => 'Browser cache time',
		'keywords' => 'Keywords',
		'publish_at' => 'Publish date',
		'depublish_at' => 'Depublish date',
	],
	'templates' => [
		'refrence' => 'Name',
		'prepend_slug' => 'Slug prefix',
		'view' => 'View',
		'module' => 'Module',
		'template' => 'Template',
		'pages' => 'Pages',
	],
	'field' => [
		'key' => 'Refrence',
		'label' => 'Label',
		'value' => 'Value',
		'default_value' => 'Default value',
		'create_regex' => 'Create regex',
		'edit_regex' => 'Edit Regex',
		'configuration' => 'Configuration',
		'width' => 'Width',
		'height' => 'Height',
		'aspect-ratio' => 'Aspect Ratio',
	],
	'pages' => [
		'template_id' => 'Template',
		'view' => 'View',
		'module' => 'Module',
		'prepend_slug' => 'Root path',
		'slug' => 'Slug',
		'language' => 'Language',
		'title' => 'Title',
		'publish_at' => 'Publish date',
		'depublish_at' => 'Depublish date',
	],
	'menu' => [
		'title' => 'Title',
		'max_levels' => 'Menu depth',
	],
	'menu_items' => [
		'page_id' => 'Connected page',
		'external_url' => 'Url',
		'title' => 'Title',
		'description' => 'Description',
		'active' => 'Active',
	],
	'not_found' => [
		'requests' => 'Requests',
		'slug' => 'Url',
		'redirect' => 'Redirect to',
		'referrer' => 'Referred by',
	],
	'slugs' => [
		'slug' => 'Url',
		'page_id' => 'Current slug',
	],
	'users' => [
		'roles' => 'Roles',
		'first_name' => 'First name',
		'last_name' => 'Last name', 
		'email' => 'Email',
		'permissions' => 'Extra permissions',
	],
	'roles' => [
		'name' => 'Name',
		'permissions' => 'Permissions',
	],
	'forms' => [
		'fields' => 'Fields',
		'title' => 'Title',
		'button_text' => 'Button text',
		'on_complete_function' => 'On complete function',
		'email_new' => 'Email on new request',
		'email_template' => 'Email template',
		'email_from' => 'Sender of email',
		'email' => 'Entries',
		'email_to' => 'Email recipient(s)',
		'email_reply_to' => 'Reply address',
		'email_reply_to_name' => 'Reply name',
		'email_subject' => 'Subject of email',
		'email_body' => 'Email body',
		'thank_message' => 'Thank message',
		'on_complete_function_placeholder' => 'No function',
		'download' => 'Download',
		'entries' => 'Entries',
		'download_as' => 'Download as',
	],
	'form_fields' => [
		'field_type' => 'Type of field',
		'label' => 'Label',
		'placeholder' => 'Placeholder',
		'key' => 'Key name',
		'default_value' => 'Default value',
		'regex' => 'Regex',
		'width' => 'Width',
		'values' => 'Values',
	],
	'gallery' => [
		'filetype' => 'File type',
		'title' => 'Title',
		'width' => 'Width',
		'height' => 'Height',
		'image' => 'Image',
	]
];