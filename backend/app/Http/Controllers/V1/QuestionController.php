<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Question;
use App\Models\Answer;

class QuestionController extends Controller
{

    public function create(Request $req) {
        /* Example Data
            {
                "title": "Question 1",
                "image_url": "",
                "difficulty": "hard",
                "category_id": 1,
                "answer": [
                    {
                        "title": "answer 1",
                        "is_correct": false,
                        "type": "text"
                    },
                    {
                        "title": "answer 2 image url",
                        "is_correct": true,
                        "type": "image"
                    }
                ]
            }
        */
        try {
            DB::beginTransaction();
            $question_fields = $req->only(['title', 'image_url', 'difficulty', 'category_id']);

            $validated = Validator::make($question_fields, [
                'title' => 'required|string|unique:questions,title',
                'image_url' => 'string',
                'difficulty' => 'required|in:easy,medium,hard',
                'category_id' => 'required|numeric|exists:categories,id'
            ]);

            if ($validated->fails()) {
                DB::rollBack();
                return $this->sendError(message: $validated->messages(), statusCode: 400);
            }

            $createdNew = new Question();
            $createdNew->fill($question_fields);
            $createdNew->save();

            // after create question
            // --- add answer ---
            $question_id = $createdNew->id;
            if (is_null($question_id)) {
                DB::rollBack();
                return $this->sendError(message: 'Something went wrong went creating Question', statusCode: 400);
            }

            $answer_fields = $req->only(['answers'])['answers'];

            foreach ($answer_fields as &$field) {
                $field['question_id'] = $question_id;

                $validated = Validator::make($field, [
                    'title' => 'required|string',
                    'is_correct' => 'required|boolean',
                    'type' => 'required|in:image,text',
                    'question_id' => 'required|numeric|exists:questions,id'
                ]);

                if ($validated->fails()) {
                    DB::rollBack();
                    return $this->sendError(message: $validated->messages(), statusCode: 400);
                }
            }

            Answer::insert($answer_fields);

            DB::commit();
            return $this->sendResponse(message: 'Create new Question success', statusCode: 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function list(Request $req) {
        try {
            $withCategory = $req->query('category') === 'true';
            $data = $withCategory ? Question::with('category')->get() : Question::all();

            return $this->sendResponse(message: 'Retrieve all Question success', data: $data);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function detail(Request $req, $id) {
        try {
            $withCategory = $req->query('category') === 'true';
            $withAnswers = $req->query('answers') === 'true';

            $query = Question::query();

            if ($withCategory) {
                $query->with('category');
            }

            if ($withAnswers) {
                $query->with('answers');
            }

            $data = $query->find($id);

            if (!$data) {
                return $this->sendError(message: "Question with ID::${id} not found", statusCode: 404);
            }

            return $this->sendResponse(message: "Retrieve Question with ID::${id} success", data: $data);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

}