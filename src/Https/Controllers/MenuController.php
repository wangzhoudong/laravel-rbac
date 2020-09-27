<?php


namespace Lwj\Rbac\Https\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Throwable;
use Lwj\Rbac\Https\Traits\Response;
use Lwj\Rbac\Services\MenuServiceImpl;
use Lwj\Rbac\Services\UserServiceImpl;

/**
 * 菜单相关接口的控制器
 *
 * Class MenuController
 * @package Lwj\Rbac\Https\Controllers
 */
class MenuController extends Controller
{
    use Response;

    public function index(UserServiceImpl $userService, MenuServiceImpl $menuService)
    {
        $userId = auth('rbac')->id();

        if ($userService->checkSuperAdmin()) {
            return $menuService->get();
        }

        $menus = $userService->getBindMenus($userId);

        return $menuService->findParentByMenus($menus);
    }

    public function getAll(MenuServiceImpl $menuService)
    {
        return $menuService->get();
    }

    public function show($id, MenuServiceImpl $menuService)
    {
        return $menuService->find($id);
    }

    public function update($id, Request $request, MenuServiceImpl $menuService)
    {
        if (config('app.env') !== 'local') {
            throw new \Exception('只允许开发环境执行');
        }
        return $menuService->update($id, $request->all());
    }

    /**
     * @param Request $request
     * @param MenuServiceImpl $menuService
     * @return Model
     * @throws Throwable
     */
    public function store(Request $request, MenuServiceImpl $menuService)
    {
        if (config('app.env') !== 'local') {
            throw new \Exception('只允许开发环境执行');
        }
        return $menuService->create($request->all());
    }

    public function destroy($id, MenuServiceImpl $menuService)
    {
        if (config('app.env') !== 'local') {
            throw new \Exception('只允许开发环境执行');
        }
        return $menuService->destroy($id);
    }

    public function bindApi($id, Request $request, MenuServiceImpl $menuService)
    {
        $menuService->bindApi($id, $request->input('apiIds'));

        return $this->success('绑定成功');
    }

    public function getBindApis($id, Request $request, MenuServiceImpl $menuService)
    {
        $apis = $menuService->getBindApis($id);

        return $this->success($apis->pluck('id'));
    }
}
