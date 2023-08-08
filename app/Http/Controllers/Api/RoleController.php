<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return response()->json(
                ["message" => "you don't have permission to create users"],
                403
            );
        }

        $roles = Role::paginate(10);

        return response()->json($roles);
    }

    /**
     * Store a newly created roles in database.
     */
    public function store(Request $request)
    {
        if (!Gate::allows('isAdmin')) {
            return response()->json(
                ["message" => "you don't have permission to create users"],
                403
            );
        }

        try {
            $validated = $request->validate([
                'name' => 'required|string'
            ]);

            $role = Role::create($validated);

            $role->save();

            return response()->json($role);

        } catch (ValidationException $e) {
            return response()->json(["message" => $e->getMessage()], 422);
        }
    }

    /**
     * Remove the specified role from database.
     */
    public function destroy(string $id)
    {
        if (!Gate::allows('isAdmin')) {
            return response()->json(
                ["message" => "you don't have permission to create users"],
                403
            );
        }

        $role = Role::find($id);

        if (!$role) {
            return response()->json(["message" => "Role Not Found"], 404);
        }

        $role->delete();

        return response()->json($role);
    }
}
