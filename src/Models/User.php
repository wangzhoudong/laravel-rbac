<?php


namespace Lwj\Rbac\Models;


use Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @package Lwj\Rbac\Models
 * @property $id
 * @property $name
 * @property $nickname
 * @property $mobile
 * @property $password
 * @property $avatar
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 * @property-read Collection $roles
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'rbac_user';

    protected $primaryKey = 'id';

    protected $guarded = [
        'password'
    ];

    /**
     * 输出时需要隐藏的字段
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public function setPasswordAttribute($val)
    {
        $this->attributes['password'] = Hash::make($val);
    }

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

        if (Arr::exists($search, 'mobile')) {
            $query = $query->where($this->getTable() . '.mobile', $search['mobile']);
        }

        if (Arr::exists($search, 'email')) {
            $query = $query->where($this->getTable() . '.email', $search['email']);
        }

        return $query;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'rbac_user_role', 'user_id', 'role_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
