<?php
return [
	'defaults' => [
		'guard' => 'user',
		'passwords' => 'users',
	],
	'guards' => [
		'api' => [
			'driver' => 'token',
			'provider' => 'users',
		],
		'user' => [
			'driver' => 'session',
			'provider' => 'users',
		],
		'admin' => [
			'driver' => 'session',
			'provider' => 'admins',
		],
	],
	'providers' => [
		'users' => [
			'driver' => 'eloquent',
			'model' => App\User::class,
		],
		'admins' => [
			'driver' => 'eloquent',
			'model' => App\Admin::class,
		],
	],
	'passwords' => [
		'users' => [
			'provider' => 'users',
			'table' => 'password_resets',
			'expire' => 30,
		],
		'admins' => [
			'provider' => 'admins',
			'table' => 'password_resets',
			'expire' => 60,
		],
	],
];
