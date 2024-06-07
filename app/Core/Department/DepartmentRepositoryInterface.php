<?php
namespace App\Core\Department;

interface DepartmentRepositoryInterface
{
    public function create($request);
    public function listAll();
    public function delete($id);
}
