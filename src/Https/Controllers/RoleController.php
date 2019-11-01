<?php

namespace Wangzd\Rbac\Https\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Wangzd\Rbac\Https\Traits\Response;
use Wangzd\Rbac\Services\RoleServiceImpl;

class RoleController extends Controller
{
    use Response;

    /**
     * Single page application catch-all route.
     * @param Request $request
     * @param RoleServiceImpl $roleService
     * @return LengthAwarePaginator
     */
    public function index(Request $request, RoleServiceImpl $roleService)
    {
        return $roleService->paginate($request->except(['page', 'limit']), $request->input('page', 1), $request->input('limit', 10));
    }

    /**
     * @param $id
     * @param RoleServiceImpl $roleServiceImpl
     * @return JsonResponse
     */
    public function show($id, RoleServiceImpl $roleServiceImpl)
    {
        return $this->success($roleServiceImpl->find($id));
    }

    /**
     * @param Request $request
     * @param RoleServiceImpl $roleService
     * @return JsonResponse
     */
    public function store(Request $request, RoleServiceImpl $roleService)
    {
        return $this->success($roleService->create($request->all()));
    }

    /**
     * @param $id
     * @param Request $request
     * @param RoleServiceImpl $roleService
     * @return JsonResponse
     */
    public function update($id, Request $request, RoleServiceImpl $roleService)
    {
        return $this->success($roleService->update($id, $request->except('id')));
    }

    /**
     * @param $id
     * @param RoleServiceImpl $roleService
     * @return JsonResponse
     */
    public function destroy($id, RoleServiceImpl $roleService)
    {
        return $this->success($roleService->destroy($id));
    }

    /**
     * @param $id
     * @param Request $request
     * @param RoleServiceImpl $roleService
     * @return JsonResponse
     */
    public function bindMenu($id, Request $request, RoleServiceImpl $roleService)
    {
        $roleService->bindMenu($id, $request->input('menuIds'));

        return $this->success('绑定成功');
    }

    public function getBindMenus($id, RoleServiceImpl $roleService)
    {
        return $this->success($roleService->getBindMenus($id)->pluck('id'));
    }

    public function getBindApis($id, RoleServiceImpl $roleService)
    {
        return $this->success($roleService->getBindApis($id));
    }
}
