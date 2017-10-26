<?php

return [
	'tab' => [
		1 => [
			'title' => 'Welcome',
			'introduction' => 'Welcome, and thanks for trying Hack!<br>
				You are now entering the setup fase for Hack. These steps will
				help you setup the basics for Hack.',
			'next' => 'Lets get going',
		],
		2 => [
			'title' => 'Language',
			'introduction' => 'Please select the main language for Hack.',
			'previous' => 'Previous',
			'next' => 'Next',
			'languages' => [
				'en' => 'English',
				'nl' => 'Nederlands',
			],
		],
		3 => [
			'title' => 'Website data',
			'introduction' => 'Check if your domain is correct',

			'previous' => 'Previous',
			'next' => 'Next',
		],
		4 => [
			'title' => 'User',
			'introduction' => 'Create your administrator account here',
			'previous' => 'Previous',
			'next' => 'Next',
			'email' => 'Email',
			'password' => 'Password',
			'password_confirmation' => 'Confirm your password',
		],
		5 => [
			'title' => 'Done',
			'introduction' => 'That\'s it, your done. No really. Have fun!',
			'next' => 'Go to Hack!',
		],
	],
];
