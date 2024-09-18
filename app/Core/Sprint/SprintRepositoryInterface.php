<?php
namespace App\Core\Sprint;


interface SprintRepositoryInterface
{
    public function create($request);
    public function listAll();
}
