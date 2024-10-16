<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Exam;

class ExamController extends Controller
{
    public function create(Request $req) {
        try {
            $fields = $req->only(['user_id', 'category_id']);
            $validated = Validator::make($fields, [
                'user_id' => 'required|numeric|exists:users,id',
                'category_id' => 'required|numeric|exists:categories,id',
            ]);

            if ($validated->fails()) {
                return $this->sendError(message: $validated->messages(), statusCode: 400);
            }

            $createdNew = new Exam();
            $createdNew->fill($fields);
            $createdNew->save();

            return $this->sendResponse(message: 'Create new Exam success', statusCode: 201);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function destroy(Request $req, $id) {
        try {
            $foundItem = Exam::find($id);

            if (!$foundItem) {
                return $this->sendError(message: "Cannot find Exam!", statusCode: 404);
            }

            $foundItem->delete();

            return $this->sendResponse(message: "Remove Exam with ID::${id} success");
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

}