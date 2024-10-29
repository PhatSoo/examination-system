<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

use App\Models\Category;
use App\Models\Question;

class QuestionController extends Controller
{

    public function create(Request $req) {
        /* Example Data
            {
                "title": "Question 1",
                "image_url": "",
                "difficulty": "hard",
                "category_id": 1,
                "answer": [ // default === empty array
                    {
                        "title": "answer 1",
                        "is_correct": false,
                        "type": "text"
                    },
                    {
                        "title": "answer 2 image url",
                        "is_correct": true,
                        "type": "image"
                    },...
                ]
            }
        */
        try {
            DB::beginTransaction();

            if (!Gate::check('create', Question::class)) {
                DB::rollBack();
                return $this->sendError(message: 'You have no permission to create Question.!', statusCode: 403);
            }

            $fields = $req->only(['title', 'image_url', 'difficulty', 'category_id']);

            $validated = Validator::make($fields, [
                'title' => 'required|string|unique:questions,title',
                'image_url' => 'string',
                'difficulty' => 'required|in:easy,medium,hard',
                'category_id' => 'required|numeric|exists:categories,id'
            ]);

            if ($validated->fails()) {
                DB::rollBack();
                return $this->sendError(message: $validated->messages(), statusCode: 400);
            }

            // Check permission of current user with the Category
            $category = Category::find($fields['category_id']);
            $checked = Gate::inspect('manage', $category);
            if (!$checked->allowed()) {
                return $this->sendError(message: 'You have no permissions to add Questions for this Category!', statusCode: $checked->status());
            }

            if ($category->status === 'pending') {
                DB::rollBack();
                return $this->sendError(message: "You can't add questions for ~Pending~ Category...", statusCode: 400);
            }

            if ($category->checkEnoughQuestions()) {
                DB::rollBack();
                return $this->sendError(message: "This Category has enough questions", statusCode: 400);
            }

            // Check number of Answer === 4 ?
            $answer_fields = $req->answers;

            if (count($answer_fields) <> 4) {
                DB::rollBack();
                return $this->sendError(message: 'The quantity of Answers must equal 4', statusCode: 400);
            }

            $fields['user_id'] = auth()->user()->id;

            $question = new Question();
            $question->fill($fields);
            $question->save();

            // after create question
            // --- add answer ---

            foreach ($answer_fields as $field) {
                $validated = Validator::make($field, [
                    'title' => 'required|string',
                    'is_correct' => 'required|boolean',
                    'type' => 'required|in:image,text',
                ]);

                if ($validated->fails()) {
                    DB::rollBack();
                    return $this->sendError(message: $validated->messages(), statusCode: 400);
                }

                $question->answers()->create($field);
            }

            DB::commit();
            return $this->sendResponse(message: 'Create new Question success', statusCode: 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage() . " ...at line::" . $th->getLine());
            return $this->sendError();
        }
    }

    public function update(Request $req, $id) {
        try {
            $foundItem = Question::find($id);
            if (!$foundItem) {
                return $this->sendError(message: "Question with ID::$id not found!", statusCode: 404);
            }

            $checked = Gate::inspect('manage', $foundItem);
            if (!$checked->allowed()) {
                return $this->sendError(message: $checked->message(), statusCode: $checked->status());
            }

            $fields = $req->only(['title', 'image_url', 'difficulty', 'category_id']);

            $validated = Validator::make($fields, [
                'title' => 'string|unique:questions,title',
                'image_url' => 'string',
                'difficulty' => 'in:easy,medium,hard',
                'category_id' => 'numeric|exists:categories,id'
            ]);

            if ($validated->fails()) {
                return $this->sendError(message: $validated->messages(), statusCode: 400);
            }

            // Check permission of current user with the Category
            $category = Category::find($fields['category_id']);
            $checked = Gate::inspect('manage', $category);
            if (!$checked->allowed()) {
                return $this->sendError(message: 'You have no permissions to edit Question for this Category!', statusCode: $checked->status());
            }

            $foundItem->update($fields);

            return $this->sendResponse(message: "Update Question with ID::$id success.", statusCode: 204);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . " ...at line::" . $th->getLine());
            return $this->sendError();
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

            $checked = Gate::inspect('manage', $data);
            if (!$checked->allowed()) {
                return $this->sendError(message: 'You have no permissions to view detail this Question', statusCode: $checked->status());
            }

            return $this->sendResponse(message: "Retrieve Question with ID::${id} success", data: $data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . " ...at line::" . $th->getLine());
            return $this->sendError();
        }
    }

    public function destroy(Request $req, $id) {
        try {
            $foundItem = Question::find($id);

            if (!$foundItem) {
                return $this->sendError(message: "Cannot find Question!", statusCode: 404);
            }

            $checked = Gate::inspect('manage', $foundItem);
            if (!$checked->allowed()) {
                return $this->sendError(message: $checked->message(), statusCode: $checked->status());
            }

            $foundItem->delete();

            return $this->sendResponse(message: "Remove Question with ID::${id} success");
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . " ...at line::" . $th->getLine());
            return $this->sendError();
        }
    }
}
