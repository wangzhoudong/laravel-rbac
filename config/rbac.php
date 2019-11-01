<?php

return [

    /*
    | 单独设置域名指向
    |
    */

    'domain' => null,

    /*
    | 为route设置前缀
    |
    */

    'path' => 'rbac',

    /*
    | 设置独立的Middleware
    |
    */

    'middleware' => [
        'api',
        'jwt.auth'
    ],

    /*
    | 设置Auth的中间件
    |
    */
    'auth_middleware' => ['api'],

    /*
    | 设置超管白名单
    |
    */
    'super_admin' => env('SUPER_ADMIN', 'admin@liweijia.com'),

    /*
    | 设置驱动
    |
    */
    'defaults' => [
        'users' => 'self',
        'roles' => 'self'
    ],

];
