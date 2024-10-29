<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Models\Permission;

class PermissionController extends Controller
{
    public function list(Request $req) {
        try {
            $withPermission = $req->query('role') === 'true';
            $data = $withPermission ? Permission::with('roles')->get() : Permission::all();

            return $this->sendResponse(message: 'Retrieve all Permission success', data: $data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage() . " ...at line::" . $th->getLine());
            return $this->sendError();
        }
    }

    public function detail(Request $req, $id) {
        $withPermission = $req->query('role') === 'true';

        $data = $withPermission ? Permission::with('roles')->find($id) : Permission::find($id);

        return $this->sendResponse(message: "Retrieve Permission with ID::${id} success", data: $data);
    }

}
