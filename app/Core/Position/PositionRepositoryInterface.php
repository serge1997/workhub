<?php
namespace App\Core\Position;

interface PositionRepositoryInterface
{
    public function create($request);
    public function listAll();
    public function delete($id);
}
