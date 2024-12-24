<?php
namespace App\Core\Annex\Actions;

use App\core\Annex\AnnexRepositoryInterface;

class AnnexDeleteAction
{

    public function __construct(
        private AnnexRepositoryInterface $annexRepository
    ){}

    public function run($id)
    {
        $annex = $this->annexRepository->find($id);
        $this->annexRepository->delete($annex);
    }
}
