<?php
namespace App\Core\Position;

use App\Models\Position;
class PositionRepository implements PositionRepositoryInterface
{
    public function create($request){}
    public function listAll()
    {
        return Position::all();
    }
    public function delete($id){}
}
