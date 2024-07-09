<?php
namespace App\Core\CommentResponse\Actions;

use App\Models\CommentResponse;

final class UpdateCommentResponseAction
{
    public function __construct(
        private CommentResponse $commentResponse,
        private mixed $request
    )
    {}

    public function run()
    {
        $this->commentResponse->update([
            'response' => $this->request->response
        ]);
    }
}
