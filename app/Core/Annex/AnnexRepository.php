<?php
namespace App\Core\Annex;

use App\core\Annex\AnnexRepositoryInterface;
use App\Models\Annex;
use App\Models\Task;
use Exception;

class AnnexRepository implements AnnexRepositoryInterface
{
    public function create($request, ?Task $task = null)
    {
        if ($request->hasFile('annex')) {
            $files = $request->annex;
            foreach($files as $annex){
                $model = new Annex();
                $extension = $annex->extension();
                $annexName = md5($annex->getClientOriginalName() . strtotime('now')) . "." . $extension;
                $annex->move(public_path('task-annex/'), $annexName);
                $model->annex = $annexName;
                $model->task_id = $task !== null ? $task->id : $request->task_id;
                $model->save();
                if (!Annex::find($model->id)->exists()) {
                    throw new Exception("Não foi possivel criar o annex");
                }
            }
        }
    }

    public function find($request)
    {

    }

    public function update($request)
    {

    }

    public function delete($request)
    {

    }
}
