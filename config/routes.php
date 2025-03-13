<?php

return [
    'GET' => [
        '/' => ['action' => 'HomeController@index'],
        '/posts' => ['action' => 'PostController@index'],
        '/posts/create' => [
            'action' => 'PostController@create',
            'middleware' => [
                'AuthMiddleware' => ['admin']
            ]
        ],
        '/posts/{id}' => ['action' => 'PostController@show'],
        '/posts/{id}/edit' => [
            'action' => 'PostController@edit',
            'middleware' => [
                'AuthMiddleware' => ['admin']
            ]
        ],
        '/admin/login' => [
            'action' => 'Admin\Auth\LoginController@showLoginForm',
            'middleware' => ['RedirectIfAuthenticate']
        ],
    ],
    'POST' => [
        '/admin/login' => [
            'action' => 'Admin\Auth\LoginController@login',
            'middleware' => ['RedirectIfAuthenticate']
        ],
        '/admin/logout' => [
            'action' => 'Admin\Auth\LoginController@logout',
            'middleware' => ['GuestMiddleware']
        ],
        '/posts' => ['action' => 'PostController@store'],
    ],
    'PUT' => [
        '/posts/{id}' => [
            'action' => 'PostController@update',
            'middleware' => [
                'AuthMiddleware' => ['admin']
            ]
        ],
    ],
    'DELETE' => [
        '/posts/{id}/delete' => [
            'action' => 'PostController@destroy',
            'middleware' => [
                'AuthMiddleware' => ['admin']
            ]
        ]
    ]
];
