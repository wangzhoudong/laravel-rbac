<?php


namespace Lwj\Rbac\Services;


use Illuminate\Database\Eloquent\Builder;
use Lwj\Rbac\Models\Api;

class ApiServiceImpl
{
    public function get()
    {
        return Api::query()->cursor();
    }

    public function paginate(array $search = [], $page = 1, $limit = 10)
    {
        /** @var Builder $query */
        $query = Api::search($search);
        return $query->paginate($limit, ['*'], 'page', $page);
    }

    public function find($id)
    {
        return Api::query()->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $data = Api::query()->where('id', $id)->update($data);

        return $data;
    }

    public function create(array $data)
    {
        return Api::query()->create($data);
    }

    public function destroy($id)
    {
        return Api::destroy($id);
    }

    public function getModules()
    {
        return Api::query()->distinct()->pluck('module')->map(function ($item) {
            return ['label' => $item, 'value' => $item];
        });
    }
}
