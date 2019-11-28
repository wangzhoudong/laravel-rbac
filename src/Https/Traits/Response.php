<?php


namespace Lwj\Rbac\Https\Traits;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait Response
{
    public function success($data = '')
    {
        return response()->json($data, 200, ['Content-Type' => 'application/json; charset=UTF-8'], JSON_UNESCAPED_UNICODE);
    }
}
