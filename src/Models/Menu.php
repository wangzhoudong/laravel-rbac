<?php


namespace Wangzd\Rbac\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * Class Menu
 * @package Wangzd\Rbac\Models
 * @property $id
 * @property $pid
 * @property $url
 * @property $name
 * @property $path
 * @property $sort
 * @property $deep
 * @property $root_id
 * @property $ico
 * @property $show
 * @property $remark
 * @property $created_at
 * @property $updated_at
 * @property-read Collection $apis 该菜单所绑定的API集合
 */
class Menu extends Model
{
    protected $table = 'rbac_menus';

    protected $primaryKey = 'id';

    protected $guarded = [

    ];

    /**
     * @return BelongsToMany
     */
    public function apis()
    {
        return $this->belongsToMany('Wangzd\Rbac\Models\Api', 'rbac_menu_api', 'menu_id', 'api_id');
    }
}
