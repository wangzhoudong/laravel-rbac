<?php


namespace Wangzd\Rbac\Https\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Wangzd\Rbac\Https\Traits\Response;
use Wangzd\Rbac\Services\ApiServiceImpl;

/**
 * 菜单相关接口的控制器
 *
 * Class MenuController
 * @package Wangzd\Rbac\Https\Controllers
 */
class ApiController extends Controller
{
    use Response;

    /**
     * @param Request $request
     * @param ApiServiceImpl $apiService
     * @return JsonResponse
     */
    public function index(Request $request, ApiServiceImpl $apiService)
    {
        return $this->success(
            $apiService->paginate($request->all(),
                $request->input('page', 1),
                $request->input('limit', 10)
            ));
    }

    public function getList(Request $request, ApiServiceImpl $apiService)
    {
        return $this->success($apiService->get());
    }

    public function show($id, ApiServiceImpl $apiService)
    {
        return $this->success($apiService->find($id));
    }

    public function update($id, Request $request, ApiServiceImpl $apiService)
    {
        return $this->success($apiService->update($id, $request->all()));
    }

    public function store(Request $request, ApiServiceImpl $apiService)
    {
        return $this->success($apiService->create($request->all()));
    }

    public function destroy($id, ApiServiceImpl $apiService)
    {
        return $this->success($apiService->destroy($id));
    }

    public function getModules(ApiServiceImpl $apiService)
    {
        return $this->success($apiService->getModules());
    }
}
