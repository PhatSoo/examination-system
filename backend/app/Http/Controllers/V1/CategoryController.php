<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use App\Models\Category;

class CategoryController extends Controller
{

    public function create(Request $req) {
        try {
            if (!Gate::check('create', Category::class)) {
                return $this->sendError(message: 'You have no permission for this action.!', statusCode: 403);
            }

            $fields = $req->only(['name', 'image_url', 'num_question', 'total_time', 'random']);
            $validated = Validator::make($fields, [
                'name' => 'required|string|unique:categories,name|min:5',
                'image_url' => 'string',
                'num_question' => 'required|numeric|min:10|max:50',
                'total_time' => 'required|numeric|min:10',
                'random' => 'boolean'
            ]);

            if ($validated->fails()) {
                return $this->sendError(message: $validated->messages(), statusCode: 400);
            }

            $fields['user_id'] = auth()->user()->id;

            $createdNew = new Category();
            $createdNew->fill($fields);
            $createdNew->save();

            return $this->sendResponse(message: 'Create new Category success', statusCode: 201);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . " ...at line::" . $th->getLine());
            return $this->sendError();
        }
    }

    public function list(Request $req) {
        try {
            $withOwner = $req->query('owner') === 'true';
            $cacheKey = "cate?owner=$withOwner";

            [$data, $message] = Cache::remember($cacheKey, 60, function () use ($withOwner) {
                if ($withOwner) {
                    $data = auth()->user()->categories;
                    $message = 'Retrieve all Category created by current user success';
                } else {
                    $data = Category::all();
                    $message = 'Retrieve all Category success';
                }

                return [$data, $message];
            });

            return $this->sendResponse(message: $message, data: $data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . " on file::" . $th->getFile() ." ...at line::" . $th->getLine());
            return $this->sendError();
        }
    }

    public function listQuestionsOfCategory(Request $req, $id) {
        try {
            $foundItem = Category::find($id);
            if (!$foundItem) {
                return $this->sendError(message: "Category with ID::$id not found!", statusCode: 404);
            }

            $checked = Gate::inspect('manage', $foundItem);
            if (!$checked->allowed()) {
                return $this->sendError(message: $checked->message(), statusCode: $checked->status());
            }

            $data = $foundItem->questions;

            $withAnswer = $req->query('answer') === 'true';
            if ($withAnswer) {
                $data->load('answers');
            }

            return $this->sendResponse(message: "Retrieve Answers of Category with ID::$id success.", data: $data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . " ...at line::" . $th->getLine());
            return $this->sendError();
        }
    }

    public function listByAuthor(Request $req, $author_id) {
        try {
            $data = Category::where('user_id', $author_id)->get();

            return $this->sendResponse(message: "Retrieve Category of User ID::$author_id success.", data: $data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . " ...at line::" . $th->getLine());
            return $this->sendError();
        }
    }

    public function detail(Request $req, $id) {
        try {
            $withUser = $req->query('userInfo') === 'true';

            $data = Category::find($id);

            if ($withUser) {
                $data = $data->load('user');
            }

            return $this->sendResponse(message: "Retrieve Category with ID::$id success", data: $data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . " ...at line::" . $th->getLine());
            return $this->sendError();
        }
    }

    public function update(Request $req, $id) {
        try {
            $foundItem = Category::find($id);
            if (!$foundItem) {
                return $this->sendError(message: "Category with ID::$id not found!", statusCode: 404);
            }

            $checked = Gate::inspect('manage', $foundItem);
            if (!$checked->allowed()) {
                return $this->sendError(message: $checked->message(), statusCode: $checked->status());
            }

            $fields = $req->only(['name', 'image_url', 'num_question', 'total_time', 'random']);

            $validated = Validator::make($fields, [
                'name' => 'string|unique:categories,name|min:5',
                'image_url' => 'string',
                'num_question' => 'numeric|min:10|max:50',
                'total_time' => 'numeric|min:10',
                'random' => 'boolean'
            ]);

            if ($validated->fails()) {
                return $this->sendError(message: $validated->messages(), statusCode: 400);
            }

            $foundItem->update($fields);

            return $this->sendResponse(message: "Update Category with id $id success.", statusCode: 204);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . " ...at line::" . $th->getLine());
            return $this->sendError();
        }
    }

    public function destroy(Request $req, $id) {
        try {
            $foundItem = Category::find($id);

            if (!$foundItem) {
                return $this->sendError(message: "Cannot find Category!", statusCode: 404);
            }

            $checked = Gate::inspect('manage', $foundItem);
            if (!$checked->allowed()) {
                return $this->sendError(message: $checked->message(), statusCode: $checked->status());
            }

            $foundItem->delete();

            return $this->sendResponse(message: "Remove Category with ID::${id} success");
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . " ...at line::" . $th->getLine());
            return $this->sendError();
        }
    }

    public function changeStatus(Request $req, $id) {
        try {
            $foundItem = Category::find($id);

            if (!$foundItem) {
                return $this->sendError(message: "Cannot find Category!", statusCode: 404);
            }

            if($foundItem->status === 'pending' && !Gate::check('before', Category::class)) {
                return $this->sendError(message: 'You must be waiting for Admin approve your Category', statusCode: 403);
            }

            $checked = Gate::inspect('manage', $foundItem);
            if (!$checked->allowed()) {
                return $this->sendError(message: $checked->message(), statusCode: $checked->status());
            }

            $newStatus = $req->status;

            if (!in_array($newStatus, ['active', 'inactive'])) {
                return $this->sendError(message: "Unsuitable status...", statusCode: 400);
            }

            $foundItem->status = $newStatus;

            $foundItem->save();

            return $this->sendResponse(statusCode: 204);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . " ...at line::" . $th->getLine());
            return $this->sendError();
        }
    }
}
