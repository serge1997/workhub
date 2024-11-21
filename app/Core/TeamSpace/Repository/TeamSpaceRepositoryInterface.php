<?php
namespace App\Core\TeamSpace\Repository;

use App\Models\TeamSpace;

interface TeamSpaceRepositoryInterface
{
    public function create($request);
    public function find(int $id);
    public function findByName(string $name) : ?TeamSpace;
    public function findAll();
}
