<?php


namespace Lwj\Rbac\Https\Controllers;


use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lwj\Rbac\Https\Traits\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthController extends Controller
{
    use Response;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['password']);
        if ($request->has('email')) {
            $credentials['email'] = $request->input('email');
        } else if ($request->has('mobile')) {
            $credentials['mobile'] = $request->input('mobile');
        } else {
            throw new UnauthorizedHttpException('jwt-auth', '请填写邮箱或手机');
        }

        if (! $token = auth('rbac')->attempt($credentials)) {
            throw new UnauthorizedHttpException('jwt-auth', '用户名或密码不正确');
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return $this->success(auth('rbac')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth('rbac')->logout();

        return $this->success(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('rbac')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('rbac')->factory()->getTTL() * 60
        ]);
    }
}
