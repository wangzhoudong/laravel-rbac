<?php

namespace Lwj\Rbac\Https\Controllers;


use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException as ValidationExceptionAlias;
use Lwj\Rbac\Https\Traits\Response;
use Lwj\Rbac\Services\UserServiceImpl;

class UserController extends Controller
{
    use Response;

    /**
     * Single page application catch-all route.
     * @param Request $request
     * @param UserServiceImpl $userService
     * @return LengthAwarePaginator
     */
    public function index(Request $request, UserServiceImpl $userService)
    {
        return $userService->paginate($request->except(['start', 'limit']), $request->input('start', 1), $request->input('limit', 10));
    }

    /**
     * @param $id
     * @param UserServiceImpl $userService
     * @return JsonResponse
     */
    public function show($id, UserServiceImpl $userService)
    {
        return $this->success($userService->find($id));
    }

    /**
     * @param Request $request
     * @param UserServiceImpl $userService
     * @return JsonResponse
     */
    public function store(Request $request, UserServiceImpl $userService)
    {
        return $this->success($userService->create($request->all()));
    }

    /**
     * @param $id
     * @param Request $request
     * @param UserServiceImpl $userService
     * @return JsonResponse
     * @throws Exception
     */
    public function update($id, Request $request, UserServiceImpl $userService)
    {
        return $this->success($userService->update($id, $request->except('id')));
    }

    /**
     * @param $id
     * @param Request $request
     * @param UserServiceImpl $userService
     * @return JsonResponse
     * @throws ValidationExceptionAlias
     */
    public function updatePassword($id, Request $request, UserServiceImpl $userService)
    {
        $this->validate($request, [
            'password' => 'required'
        ]);

        return $this->success($userService->updatePassword($id, $request->input('password')));
    }

    /**
     * @param $id
     * @param UserServiceImpl $userService
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id, UserServiceImpl $userService)
    {
        return $this->success($userService->destroy($id));
    }

    /**
     * @param $id
     * @param Request $request
     * @param UserServiceImpl $userService
     * @return JsonResponse
     */
    public function bindRole($id, Request $request, UserServiceImpl $userService)
    {
        $userService->bindRole($id, $request->input('roleIds'));

        return $this->success('绑定成功');
    }

    public function getBindRoles($id, UserServiceImpl $userService)
    {
        return $this->success($userService->getBindRoles($id)->pluck('id'));
    }

    public function getBindMenus($id, UserServiceImpl $userService)
    {
        return $this->success($userService->getBindMenus($id)->pluck('id'));
    }

    public function getBindApis($id, UserServiceImpl $userService)
    {
        return $this->success($userService->getBindApis($id)->pluck('id'));
    }
}
