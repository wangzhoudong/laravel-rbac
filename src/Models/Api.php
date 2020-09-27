<?php


namespace Lwj\Rbac\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class Api
 * @package Lwj\Rbac\Models
 * @property $id
 * @property $path
 * @property $name
 * @property $method
 * @property $module
 * @property $mark
 * @property $enable
 * @property $created_at
 * @property $updated_at
 */
class Api extends Model
{
    protected $table = 'rbac_apis';

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

    protected $fillable = [
        'path',
        'name',
        'method',
        'module',
        'mark',
        'enable'
    ];


    /**
     * @param Builder $query
     * @param array $search
     * @return mixed
     */
    public function scopeSearch($query, array $search)
    {
        if (Arr::exists($search, 'path')) {
            $query = $query->where($this->getTable() . '.path', $search['path']);
        }
        if (Arr::exists($search, 'name')) {
            $query = $query->where($this->getTable() . '.name', "%{$search['name']}%");
        }
        if (Arr::exists($search, 'module')) {
            $query = $query->where($this->getTable() . '.module', $search['module']);
        }

        return $query;
    }
}
