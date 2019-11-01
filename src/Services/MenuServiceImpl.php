<?php


namespace Wangzd\Rbac\Services;


use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\LazyCollection;
use Throwable;
use Wangzd\Rbac\Models\Menu;
use DB;

class MenuServiceImpl
{
    /**
     * @param array $search
     * @return LazyCollection
     */
    public function get(array $search = [])
    {
        return Menu::query()->cursor();
    }

    public function getByUser($userId = '')
    {
        return Menu::query()->cursor();
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|Menu
     */
    public function find($id)
    {
        return Menu::query()->findOrFail($id);
    }

    /**
     * @param $id
     * @param array $data
     * @return array|int
     */
    public function update($id, array $data)
    {
        $data = Menu::query()->where('id', $id)->update($data);

        return $data;
    }

    /**
     * @param array $data
     * @return Model
     * @throws Throwable
     */
    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $data = Menu::query()->create($data);

            // 处理数据
            $data->path = $data->pid . ',' . $data->id;
            $data->deep = $data->pid == 0 ? 0 : 1;
            $data->root_id = $data->pid == 0 ? $data->id : $data->pid;

            $bool = $data->save();

            if (!$bool) {
                throw new Exception('保存菜单失败');
            }

            return $data;
        });

    }

    /**
     * @param $id
     * @return int
     */
    public function destroy($id)
    {
        return Menu::destroy($id);
    }

    public function bindApi($id, array $apiIds)
    {
        /** @var Menu $menu */
        $menu = $this->find($id);

        $menu->apis()->sync($apiIds);
    }

    public function getBindApis($id)
    {
        /** @var Menu $menu */
        $menu = $this->find($id);
        $menu->load('apis');

        return $menu->apis;
    }
}
