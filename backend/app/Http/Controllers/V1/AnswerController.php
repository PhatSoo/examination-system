<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

use App\Models\Answer;

class AnswerController extends Controller
{

    public function detail(Request $req, $id) {
        try {
            return $this->sendResponse(message: "Retrieve Answer with ID::${id} success", data: Answer::find($id));
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function update(Request $req, $id) {
        try {
            $foundItem = Answer::find($id);

            if (!$foundItem) {
                return $this->sendError(message: "Cannot find Answer!", statusCode: 404);
            }
            if (!Gate::check('manage', $foundItem->question)) {
                return $this->sendError(message: "You have no permission to update this Answer", statusCode: 403);
            }

            $fields = $req->only(['title', 'is_correct', 'type']);

            $validated = Validator::make($fields, [
                'title' => 'string',
                'is_correct' => 'boolean',
                'type' => 'string|in:text,image'
            ]);

            if ($fields['is_correct'] && $foundItem->checkValid()) {
                return $this->sendError(message: 'This Question has correct Answer already!!', statusCode: 400);
            }

            $foundItem->update($fields);

            return $this->sendResponse(message: "Update Answer with ID::${id} success");
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

}