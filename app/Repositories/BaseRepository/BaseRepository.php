<?php

namespace App\Repositories\BaseRepository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface{
    protected Model $model;

    public function __construct(Model $model){
        $this->model = $model;
    }

    public function all(): Collection{
        return $this->model->orderBy("created_at", "desc")->get();
    }

    public function allPaginated(int $pageCount): LengthAwarePaginator{
        return $this->model->orderBy("created_at", "desc")->paginate($pageCount);
    }

    public function getById(int $id): Model|null{
        return $this->model->find($id);
    }

    public function create(array $createModelObject): Model{
        return $this->model->create($createModelObject);
    }

    public function upsert(array $pipelineStageIdentifierObject, array $pipelineStageUpdateObject){
        return $this->model->updateOrCreate($pipelineStageIdentifierObject, $pipelineStageUpdateObject);
    }

    public function firstOrCreate(array $equalityObject, array $createObject): Model{
        return $this->model->firstOrCreate($equalityObject, $createObject);
    }

    public function update(int $id, array $updateModelObject): bool|null{
        return $this->model->where('id', $id)->update($updateModelObject);
    }

    public function updateFields(int $id, array $updateModelFieldsObject): bool|null{
        $model = $this->model->find($id);
        if($model === null){
            return null;
        }

        foreach($updateModelFieldsObject as $fieldName => $value){
            $model[$fieldName] = $value;
        }

        return $model->save();
    }

    public function delete(int $id): bool{
        return $this->model->destroy($id);
    }

    public function exists(int $id): bool{
        return $this->model->where("id", $id)->exists();
    }
}
