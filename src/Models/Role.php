<?php


namespace Wangzd\Rbac\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

/**
 * Class Role
 * @package Wangzd\Rbac\Models
 * @property $name
 * @property $level
 * @property $mark
 * @property $created_at
 * @property $updated_at
 * @property-read Collection $menus 该角色所绑定的Menu集合
 */
class Role extends Model
{
    protected $table = 'rbac_roles';

    protected $primaryKey = 'id';

    protected $guarded = [

    ];

    /**
     * @param Builder $query
     * @param array $search
     * @return mixed
     */
    public function scopeSearch($query, array $search = [])
    {
        if (Arr::exists($search, 'name')) {
            $query = $query->where($this->getTable() . '.name', $search['name']);
        }

        return $query;
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'rbac_role_menu', 'role_id', 'menu_id');
    }
}
