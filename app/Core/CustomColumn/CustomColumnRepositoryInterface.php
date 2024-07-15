<?php
namespace App\Core\CustomColumn;

interface CustomColumnRepositoryInterface
{
    public function create($request);
    public function listAll();
    public function update($request);
    public function delete($request);
}
