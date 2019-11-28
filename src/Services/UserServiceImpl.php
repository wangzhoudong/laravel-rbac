<?php


namespace Lwj\Rbac\Services;


use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Lwj\Rbac\Models\User;
use Illuminate\Support\Str;

class UserServiceImpl
{
    use BindData;

    /**
     * @param array $data
     * @return Builder|Model
     */
    public function create(array $data)
    {
        $user = User::query()->create($data);

        return $user;
    }

    /**
     * 更新用户信息
     * 除了密码
     *
     * @param $id
     * @param array $data
     * @return bool|int
     * @throws Exception
     */
    public function update($id, array $data)
    {
        $user = $this->find($id);

        // 如果有密码的话，就把密码去掉。不能在这个方法更新密码。
        if (Arr::exists($data, 'password')) {
            unset($data['password']);
        }

        return $user->update($data);
    }

    /**
     * 更新密码
     *
     * @param $id
     * @param $newPassword
     * @return bool
     */
    public function updatePassword($id, $newPassword)
    {
        $user = $this->find($id);
        $user->password = $newPassword;

        return $user->save();
    }

    /**
     * @param $mobile
     * @param array $data
     * @return Builder|Model
     */
    public function updateOrCreateByMobile($mobile, array $data)
    {
        return User::query()->updateOrCreate(['mobile' => $mobile], $data);
    }

    /**
     * @param $email
     * @param array $data
     * @return Builder|Model
     */
    public function updateOrCreateByEmail($email, array $data)
    {
        return User::query()->updateOrCreate(['email' => $email], $data);
    }

    /**
     * @param array $search
     * @param int $page
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function paginate(array $search = [], int $page = 1, int $limit = 10)
    {
        return User::search($search)->paginate($limit, ['*'], 'page', $page);
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model
     */
    public function find($id)
    {
        return User::query()->findOrFail($id);
    }

    /**
     * @param $mobile
     * @return Builder|Model
     */
    public function findByMobile($mobile)
    {
        return User::query()->where('mobile', $mobile)->firstOrFail();
    }

    /**
     * @param $id
     * @param array $roleIds
     */
    public function bindRole($id, array $roleIds)
    {
        /** @var User $user */
        $user = $this->find($id);

        $user->roles()->sync($roleIds);
    }

    /**
     * 获取这个用户对应的角色
     *
     * @param $id
     * @return Collection
     */
    public function getBindRoles($id)
    {
        $role = $this->find($id);
        $role->load('roles');

        return $role->roles;
    }

    /**
     * 获取这个用户对应的MENUs
     *
     * @param $id
     * @return Collection|\Illuminate\Support\Collection
     */
    public function getBindMenus($id)
    {
        $roles = $this->getBindRoles($id);
        $roles->load('menus');

        $menus = $roles->map(function ($item) {
            return $item->menus;
        });

        return $menus->collapse();
    }

    /**
     * @return bool
     */
    public function checkSuperAdmin()
    {
        $user = auth()->user();
        if (Str::contains(config('rbac.super_admin'), $user->email)) {
            return true;
        }
        return false;
    }
}
