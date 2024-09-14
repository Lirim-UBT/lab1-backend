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

    public function searchCaseInsensitive(array $filterParameters): Collection{
        return $this->searchScaffolding(15, $filterParameters, "ILIKE", false);
    }

    public function searchCaseSensitive(array $filterParameters): Collection{
        return $this->searchScaffolding(15, $filterParameters, "LIKE", false);
    }

    public function searchCaseInsensitivePaginated(int $perPage, array $filterParameters): LengthAwarePaginator{
        return $this->searchScaffolding($perPage, $filterParameters, "ILIKE", true);
    }

    public function searchCaseSensitivePaginated(int $perPage, array $filterParameters): LengthAwarePaginator{
        return $this->searchScaffolding($perPage, $filterParameters, "LIKE", true);
    }

    protected function searchScaffolding(
        int $perPage, array $filterParameters, string $operator, bool $paginated, int $count = -1
    ){
        $query = $this->model->query();
        foreach($filterParameters as $field => $value){
            $query->where("{$field}", $operator, "%{$value}%");
        }
        $query = $query->orderBy("created_at", "desc");

        if($count !== -1){
            $query = $query->take($count);
        }

        if($paginated){
            $query = $query->paginate($perPage);
        }else{
            $query = $query->get();
        }

        return $query;
    }
}
