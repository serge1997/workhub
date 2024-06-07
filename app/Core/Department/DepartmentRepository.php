<?php
namespace App\Core\Department;

use App\Models\Departments;
class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function create($request){}

    public function listAll()
    {
        return Departments::all();
    }
    public function delete($id){}
}
