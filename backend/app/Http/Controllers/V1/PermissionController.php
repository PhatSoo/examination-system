<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Permission;

class PermissionController extends Controller
{
    public function create(Request $req) {
        try {
            $validated = Validator::make($req->all(), [
                'name' => 'required|string|unique:permissions,name',
            ]);

            if ($validated->fails()) {
                return $this->sendError(message: $validated->messages(), statusCode: 400);
            }

            $createdNew = new Permission();
            $createdNew->fill($req->all());
            $createdNew->save();

            return $this->sendResponse(message: 'Create new Permission success', statusCode: 201);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function list(Request $req) {
        try {
            $withPermission = $req->query('role') === 'true';
            $data = $withPermission ? Permission::with('roles')->get() : Permission::all();

            return $this->sendResponse(message: 'Retrieve all Permission success', data: $data);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function detail(Request $req, $id) {
        $withPermission = $req->query('role') === 'true';

        $data = $withPermission ? Permission::with('roles')->find($id) : Permission::find($id);

        return $this->sendResponse(message: "Retrieve Permission with ID::${id} success", data: $data);
    }
}