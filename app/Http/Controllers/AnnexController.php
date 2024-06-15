<?php

namespace App\Http\Controllers;

use App\core\Annex\AnnexRepositoryInterface;
use Illuminate\Http\Request;

class AnnexController extends Controller
{
    public function __construct(
        private AnnexRepositoryInterface $annexRepositoryInterface
    )
    {}
}
