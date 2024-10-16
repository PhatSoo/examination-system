<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;

class CategoryController extends Controller
{

    public function create(Request $req) {
        try {
            $fields = $req->only(['name', 'image_url']);
            $validated = Validator::make($fields, [
                'name' => 'required|string|unique:categories,name|min:5',
                'image_url' => 'string'
            ]);

            if ($validated->fails()) {
                return $this->sendError(message: $validated->messages(), statusCode: 400);
            }

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
            return $this->sendResponse(message: 'Retrieve all Category success', data: Category::all());
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function detail(Request $req, $id) {
        try {
            return $this->sendResponse(message: "Retrieve Category with ID::${id} success", data: Category::find($id));
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

            $foundItem->delete();

            return $this->sendResponse(message: "Remove Category with ID::${id} success");
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }


}