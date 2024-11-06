<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Permission;

class PermissionController extends Controller
{
    public function list(Request $req) {
        try {
            $withPermission = $req->query('role') === 'true';
            $data = $withPermission ? Permission::with('roles')->get() : Permission::all();

            return $this->sendResponse(message: 'Retrieve all Permission success', data: $data);
        } catch (\Throwable $th) {
            return $this->handleException($th);
        }
    }

    public function detail(Request $req, $id) {
        $withPermission = $req->query('role') === 'true';

        $data = $withPermission ? Permission::with('roles')->find($id) : Permission::find($id);

        return $this->sendResponse(message: "Retrieve Permission with ID::$id success", data: $data);
    }

}