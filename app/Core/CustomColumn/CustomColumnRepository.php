<?php
namespace App\Core\CustomColumn;

use App\Core\CustomColumn\Actions\CreateCustomColumnAction;
use App\Core\CustomColumn\Actions\ListAllCustomColumnAction;
use App\Core\CustomColumn\Actions\ListCustomColumnByTaskAction;
use App\Http\Resources\CustomColumnResource;

class CustomColumnRepository implements CustomColumnRepositoryInterface
{
    public function create($request)
    {
        return CreateCustomColumnAction::run($request);
    }
    public function listAll()
    {
       return CustomColumnResource::collection(
            app()->make(ListAllCustomColumnAction::class)->handle()
       );
    }
    public function update($request){}
    public function delete($request){}

    public function listByTaskId($request)
    {
        return CustomColumnResource::collection(
            app()->make(ListCustomColumnByTaskAction::class)->handle($request)
        );
    }
}
