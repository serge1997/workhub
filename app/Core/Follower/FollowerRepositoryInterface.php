<?php
namespace App\Core\Follower;

interface FollowerRepositoryInterface
{
    public function create($request);
    public function find($request);
    public function update($request);
    public function delete($request);
}
