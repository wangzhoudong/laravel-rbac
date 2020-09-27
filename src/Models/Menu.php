<?php


namespace Lwj\Rbac\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class Menu
 * @package Lwj\Rbac\Models
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
    use SoftDeletes;
    protected $table = 'rbac_menus';

    protected $primaryKey = 'id';

    protected $guarded = [

    ];

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * 可以被集体附值的表的字段
     */
    protected $fillable = [
        'pid',
        'url',
        'name',
        'path',
        'sort',
        'deep',
        'root_id',
        'ico',
        'show',
        'remark'
    ];

    /**
     * @return BelongsToMany
     */
    public function apis()
    {
        return $this->belongsToMany('Lwj\Rbac\Models\Api', 'rbac_menu_api', 'menu_id', 'api_id');
    }
}
