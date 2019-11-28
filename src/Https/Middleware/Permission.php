<?php

namespace Lwj\Rbac\Https\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Lwj\Rbac\Exceptions\PermissionException;
use Lwj\Rbac\Services\UserServiceImpl;

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
        $user = auth('rbac')->user();

        if ($this->userService->checkSuperAdmin()) {
            return $next($request);
        }

        // 获取所有API
        $apis = $this->userService->getBindApis($user->id);

        // 获取当前访问的api
        $apis = $apis->filter(function ($api) use ($request) {
            return $request->is($api->path);
        });

        // 判断请求方式
        $bool = $apis->search(function ($api) use ($request) {
            if ($api->method === 'ANYWAY') { // 如果类型是ANYWAY的话，那么直接放行
                return true;
            }
            return $request->isMethod($api->method);
        });

        if ($bool !== false) {
            return $next($request);
        }

        throw new PermissionException('不被允许访问此接口');
    }
}
