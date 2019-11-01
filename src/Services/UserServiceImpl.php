<?php


namespace Wangzd\Rbac\Services;


use Exception;
use Illuminate\Database\Eloquent\Collection;
use Wangzd\Rbac\Models\User;

class UserServiceImpl
{
    use BindData;

    public function create(array $data)
    {
        return User::query()->create($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return bool|int
     * @throws Exception
     */
    public function update($id, array $data)
    {
        $user = $this->find($id);

        return $user->update($data);
    }

    public function updatePassword($id, $newPassword)
    {
        $user = $this->find($id);
        $user->password = $newPassword;

        return $user->save();
    }

    public function updateOrCreateByMobile($mobile, array $data)
    {
        return User::query()->updateOrCreate(['mobile' => $mobile], $data);
    }

    public function updateOrCreateByEmail($email, array $data)
    {
        return User::query()->updateOrCreate(['email' => $email], $data);
    }

    public function paginate(array $search = [], int $page = 1, int $limit = 10)
    {
        return User::search($search)->paginate($limit, ['*'], 'page', $page);
    }

    public function find($id)
    {
        return User::query()->findOrFail($id);
    }

    public function findByMobile($mobile)
    {
        return User::query()->where('mobile', $mobile)->firstOrFail();
    }

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


}
