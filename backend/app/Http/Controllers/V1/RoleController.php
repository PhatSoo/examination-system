<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{

    public function create(Request $req) {
        try {
            $validated = Validator::make($req->all(), [
                'name' => 'required|string|unique:roles,name',
            ]);

            if ($validated->fails()) {
                return $this->sendError(message: $validated->messages(), statusCode: 400);
            }

            $createdNew = new Role();
            $createdNew->fill($req->all());
            $createdNew->save();

            return $this->sendResponse(message: 'Create new Role success', statusCode: 201);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function list(Request $req) {
        try {
            $withPermission = $req->query('permission') === 'true';
            $data = $withPermission ? Role::with('permissions')->get() : Role::all();

            return $this->sendResponse(message: 'Retrieve all Role success', data: $data);
        } catch (\Throwable $th) {
            return $this->sendError(message: $th->getMessage());
        }
    }

    public function detail(Request $req, $id) {
        $withPermission = $req->query('permission') === 'true';

        $data = $withPermission ? Role::with('permissions')->find($id) : Role::find($id);

        return $this->sendResponse(message: "Retrieve Role with ID::${id} success", data: $data);
    }

    public function addPermission(Request $req, $id /* role_id */) {
        try {
            DB::beginTransaction();
            $found_role = Role::find($id);

            if (!$found_role) {
                DB::rollBack();
                return $this->sendError(message: 'Role not found!', statusCode: 404);
            }

            /*  Sample Data
                permissions : [
                    'per_id_1',
                    'per_id_2'
                ]
            */

            $permission_array = $req->only(['permissions'])['permissions'];

            $existing_permissions = Permission::whereIn('id', $permission_array)->pluck('id')->toArray();

            // Check all permissions in request is not exist in DB;
            $missing_permissions = array_diff($permission_array, $existing_permissions);

            if (!empty($missing_permissions)) { // if found permission_id that not in Permission table
                DB::rollBack();
                return $this->sendError(statusCode: 400, message: 'Permission ID:: ' . implode(',' , $missing_permissions) . ' does not exist');
            }

            $found_role->permissions()->sync($permission_array);

            DB::commit();
            return $this->sendResponse(message: 'Add Permissions to Role success', statusCode: 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError(message: $th->getMessage());
        }
    }
}