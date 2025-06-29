<?php

namespace App\Repositories\BaseRepository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function all(): Collection;

    public function allPaginated(int $pageCount): LengthAwarePaginator;

    public function getById(int $id): Model|null;

    public function create(array $createModelObject): Model;

    public function upsert(array $pipelineStageIdentifierObject, array $pipelineStageUpdateObject);

    public function firstOrCreate(array $equalityObject, array $createObject): Model;

    public function update(int $id, array $updateModelObject): bool|null;

    public function updateFields(int $id, array $updateModelFieldsObject): bool|null;

    public function delete(int $id): bool;

    public function exists(int $id): bool;
}
