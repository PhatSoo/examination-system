<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Exam;
use App\Models\User;
use App\Models\Category;
use App\Models\Question;

class ExamController extends Controller
{
    public function join(Request $req) {
        try {
            $fields = $req->only(['category_id']);
            $validated = Validator::make($fields, [
                'category_id' => 'required|numeric|exists:categories,id',
            ]);

            if ($validated->fails()) {
                return $this->sendError(message: $validated->messages(), statusCode: 400);
            }

            $fields['user_id'] = auth()->user()->id;
            $createdNew = new Exam();
            $createdNew->fill($fields);
            $createdNew->save();

            $data = [];
            $questions = Question::where('category_id', $createdNew->category_id)->get();
            $data['questions'] = $questions;

            return $this->sendResponse(message: 'Create new Exam success', data: $data, statusCode: 201);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function userResult(Request $req) {
        try {
            $user_id = auth()->user()->id;

            $data = Exam::where('user_id', $user_id)
                        ->when($req->query('category'), function($query, $category) {
                            return $query->where('category_id', $category);
                        })
                        ->get();

            return $this->sendResponse(message: "Retrieve all results of User ID::$user_id success.", data: $data, statusCode: 200);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function listByUser(Request $req, $id) {
        try {
            $foundItem = User::find($id);

            if (!$foundItem) {
                return $this->sendError(message: "User with ID::$id not found.", statusCode: 404);
            }

            $data = Exam::where('user_id', $id)
                        ->when($req->query('category'), function($query, $category) {
                            return $query->where('category_id', $category);
                        })
                        ->get();

            return $this->sendResponse(message: "Retrieve all results of User ID::$id success.", data: $data, statusCode: 200);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function listByCategory(Request $req, $id) {
        try {
            $foundItem = Category::find($id);

            if (!$foundItem) {
                return $this->sendError(message: "Category with ID::$id not found.", statusCode: 404);
            }

            $checked = Gate::inspect('manage', $foundItem);
            if (!$checked->allowed()) {
                return $this->sendError(message: "You have no permission to view results of other people's Category", statusCode: $checked->status());
            }

            $data = Exam::where('category_id', $id)->get();

            return $this->sendResponse(message: "Retrieve all results by Category ID::$id success.", data: $data, statusCode: 200);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function submit(Request $req) {
        /* Example data
        {
            "exam_id": 1,
            "data": [
                {
                    "question_id": 1,
                    "user_choice": 1 // answer_id that selected
                },
                {
                    "question_id": 2,
                    "user_choice": 2
                },...
            ]
        }
        */
        try {
            $foundItem = Exam::find($req->exam_id);

            if (!$foundItem) {
                return $this->sendError(message: "Exam with ID::$id not found.", statusCode: 404);
            }
            $data = [];
            $total_question = $foundItem->category->num_question;
            $num_correct = 0;
            $answers = $req->data;

            foreach($answers as &$item) {
                $question = Question::find($item['question_id']);

                $correct_answer_id = 0;

                if ($question) {
                    $correct_answer_id = $question->getCorrectAnswerId();
                }

                $user_choice = $item['user_choice'];
                $item['status'] = false;

                if ($question && $correct_answer_id === $user_choice) {
                    $num_correct++;
                    $item['status'] = true;
                }
            }

            $score = $num_correct / $total_question * 10;

            $foundItem->score = $score;
            $foundItem->update();

            $data['score'] = $score;
            $data['detail'] = $answers;
            return $this->sendResponse(message: "Calculate the Exam score success.", data: $data, statusCode: 200);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

}
