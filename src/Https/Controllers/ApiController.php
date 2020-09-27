<?php


namespace Lwj\Rbac\Https\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lwj\Rbac\Https\Traits\Response;
use Lwj\Rbac\Services\ApiServiceImpl;

/**
 * 菜单相关接口的控制器
 *
 * Class MenuController
 * @package Lwj\Rbac\Https\Controllers
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

    public function getAll(Request $request, ApiServiceImpl $apiService)
    {
        return $this->success($apiService->get());
    }

    public function show($id, ApiServiceImpl $apiService)
    {
        return $this->success($apiService->find($id));
    }

    public function update($id, Request $request, ApiServiceImpl $apiService)
    {
        if (config('app.env') !== 'local') {
            throw new \Exception('只允许开发环境执行');
        }
        return $this->success($apiService->update($id, $request->all()));
    }

    public function store(Request $request, ApiServiceImpl $apiService)
    {
        if (config('app.env') !== 'local') {
            throw new \Exception('只允许开发环境执行');
        }
        return $this->success($apiService->create($request->all()));
    }

    public function destroy($id, ApiServiceImpl $apiService)
    {
        if (config('app.env') !== 'local') {
            throw new \Exception('只允许开发环境执行');
        }
        return $this->success($apiService->destroy($id));
    }

    public function getModules(ApiServiceImpl $apiService)
    {
        return $this->success($apiService->getModules());
    }
}
