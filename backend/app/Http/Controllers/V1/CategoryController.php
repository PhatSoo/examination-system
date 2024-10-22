<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

use App\Models\Category;

class CategoryController extends Controller
{

    public function create(Request $req) {
        try {
            if (!Gate::check('create', Category::class)) {
                return $this->sendError(message: 'You have no permission for this action.!', statusCode: 403);
            }

            $fields = $req->only(['name', 'image_url']);
            $validated = Validator::make($fields, [
                'name' => 'required|string|unique:categories,name|min:5',
                'image_url' => 'string'
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
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function list(Request $req) {
        try {
            $withOwner = $req->query('owner') === 'true';

            if ($withOwner) {
                $data = auth()->user()->categories;
                $message = 'Retrieve all Category created by current user success';
            } else {
                $data = Category::all();
                $message = 'Retrieve all Category success';
            }

            return $this->sendResponse(message: $message, data: $data);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function listByAuthor(Request $req, $author_id) {
        try {
            $data = Category::where('user_id', $author_id)->get();

            return $this->sendResponse(message: "Retrieve Category of User ID::$author_id success.", data: $data);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
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
            return $this->sendError(message: $th->getMessage());
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

            $fields = $req->only(['name', 'image_url']);

            $validated = Validator::make($fields, [
                'name' => 'string|unique:categories,name|min:5',
                'image_url' => 'string'
            ]);

            if ($validated->fails()) {
                return $this->sendError(message: $validated->messages(), statusCode: 400);
            }

            $foundItem->update($fields);

            return $this->sendResponse(message: "Update Category with id $id success.", statusCode: 204);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
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
            return $this->sendError(message: $th->getMessage());
        }
    }
}
