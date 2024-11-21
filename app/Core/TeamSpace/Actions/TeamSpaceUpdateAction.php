<?php
namespace App\Core\TeamSpace\Actions;

use App\Core\TeamSpace\Repository\TeamSpaceRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class TeamSpaceUpdateAction
{
    public function __construct(
        private TeamSpaceRepositoryInterface $teamSpaceRepository
    ){}

    public function run(FormRequest $request)
    {

    }
}
