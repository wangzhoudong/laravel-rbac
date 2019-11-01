<?php

namespace Wangzd\Rbac\Https\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Wangzd\Rbac\Exceptions\PermissionException;
use Wangzd\Rbac\Services\UserServiceImpl;

class Permission
{
    private $userService;

    public function __construct(UserServiceImpl $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response|null
     */
    public function handle($request, $next)
    {
        // 获取user
        $user = auth()->user();

        // 获取所有API
        $apis = $this->userService->getBindApis($user->id);

        // 获取当前访问的api
        $apis = $apis->filter(function ($api) use ($request) {
            return $request->is($api->path);
        });

        // 判断请求方式
        $method = $request->getMethod();
        $bool = $apis->search(function ($api) use ($method) {
            return $method === $api->method;
        });

        if ($bool !== false) {
            return $next($request);
        }

        throw new PermissionException('不被允许访问此接口');
    }
}
