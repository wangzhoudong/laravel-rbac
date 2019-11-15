<?php

namespace Lwj\Rbac\Https\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    /**
     * Single page application catch-all route.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        return view('laravel-rbac::home'  , [
            'abc' =>'这是一个模板变量',
        ]);
    }
}
