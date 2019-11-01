<?php


namespace Wangzd\Rbac\Https\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Throwable;
use Wangzd\Rbac\Https\Traits\Response;
use Wangzd\Rbac\Services\MenuServiceImpl;

/**
 * 菜单相关接口的控制器
 *
 * Class MenuController
 * @package Wangzd\Rbac\Https\Controllers
 */
class MenuController extends Controller
{
    use Response;

    public function index(MenuServiceImpl $menuService)
    {
        return $menuService->getByUser();
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
        return $menuService->create($request->all());
    }

    public function destroy($id, MenuServiceImpl $menuService)
    {
        return $menuService->destroy($id);
    }

    public function bindApi($id, Request $request, MenuServiceImpl $menuService)
    {
        $menuService->bindApi($id, $request->input('apiIds'));

        return $this->success('绑定成功');
    }

    public function getBindApis($id, MenuServiceImpl $menuService)
    {
        $apis = $menuService->getBindApis($id);

        return $this->success($apis->pluck('id'));
    }
}
