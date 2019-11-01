<?php


namespace Wangzd\Rbac\Services;


use Illuminate\Database\Eloquent\Collection;

trait BindData
{
    /**
     * @param $id
     * @return Collection
     */
    abstract public function getBindMenus($id);

    public function getBindApis($id)
    {
        $menus = $this->getBindMenus($id);
        $menus->load('apis');

        $apis = $menus->map(function ($item) {
            return $item->apis;
        });

        return $apis->collapse();
    }
}
