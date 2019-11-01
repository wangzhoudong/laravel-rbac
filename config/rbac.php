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
    'auth_middleware' => ['api']

];
