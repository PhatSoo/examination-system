<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Answer;

class AnswerController extends Controller
{

    public function create(Request $req) {
        try {
            $validated = Validator::make($req->all(), [
                'title' => 'required|string',
                'is_correct' => 'required|boolean',
                'type' => 'required|in:image,text',
                'question_id' => 'required|numeric|exists:questions,id'
            ]);

            if ($validated->fails()) {
                return $this->sendError(message: $validated->messages(), statusCode: 400);
            }

            $createdNew = new Answer();
            $createdNew->fill($req->all());
            $createdNew->save();

            return $this->sendResponse(message: 'Create new Answer success', statusCode: 201);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function list(Request $req) {
        try {
            return $this->sendResponse(message: 'Retrieve all Answer success', data: Answer::all());
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function detail(Request $req, $id) {
        try {
            return $this->sendResponse(message: "Retrieve Answer with ID::${id} success", data: Answer::find($id));
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

}