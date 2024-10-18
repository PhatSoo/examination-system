<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class UserController extends Controller
{
    public function register(Request $req) {
        try {
            $fields = $req->only(['name', 'email', 'password', 'password_confirmation']);

            $validated = Validator::make($fields, [
                'name' => 'required|string|min:3',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if ($validated->fails()) {
                return $this->sendError(message: $validated->messages(), statusCode: 400);
            }

            $createdNew = new User();
            $createdNew->fill($fields);
            $createdNew->save();

            return $this->sendResponse(message: 'Create new Account success', statusCode: 201);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function login(Request $req) {
        try {
            $validated = Validator::make($req->all(), [
                'email' => 'required|email',
                'password' => 'required|string'
            ]);

            if ($validated->fails()) {
                return $this->sendError(message: $validated->messages(), statusCode: 400);
            }

            if (!auth()->attempt($req->all())) {
                return $this->sendError(message: 'Login Failed', statusCode: 401);
            }

            return $this->sendResponse(message: 'Login success!', data: [
                'token' => auth()->user()->createToken('Password Token')->accessToken
            ]);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function profile(Request $req) {
        try {
            return $this->sendResponse(message: 'Get Profile success!', data: auth()->user()->load('role'));
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function logout(Request $req) {
        try {
            $req->user()->token()->delete();
            return $this->sendResponse(message: 'Logout success!');
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function destroy(Request $req, $id) {
        try {
            $foundItem = User::find($id);

            if (!$foundItem) {
                return $this->sendError(message: "Cannot find User!", statusCode: 404);
            }

            $foundItem->delete();

            return $this->sendResponse(message: "Remove User with ID::${id} success");
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function createUserByAdmin(Request $req) {}

}