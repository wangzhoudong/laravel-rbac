<?php


namespace Wangzd\Rbac\Services;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Wangzd\Rbac\Models\Role;

class RoleServiceImpl
{
    use BindData;

    /**
     * @param array $search
     * @param int $page
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function paginate(array $search = [], int $page = 1, int $limit = 10)
    {
        return Role::search($search)->paginate($limit, ['*'], 'page', $page);
    }

    public function get(array $search = [])
    {
        return Role::search($search)->cursor();
    }

    /**
     * @param $id
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function find($id)
    {
        return Role::query()->findOrFail($id);
    }

    public function create(array $data)
    {
        return Role::query()->create($data);
    }

    public function update($id, array $data)
    {
        return Role::query()->where('id', $id)->update($data);
    }

    public function destroy($id)
    {
        return Role::destroy($id);
    }

    public function bindMenu($id, array $menuIds)
    {
        /** @var Role $role */
        $role = $this->find($id);

        $role->menus()->sync($menuIds);
    }

    /**
     * @param $id
     * @return Collection
     */
    public function getBindMenus($id)
    {
        $role = $this->find($id);
        $role->load('menus');

        return $role->menus;
    }
}
