<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Travel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class TravelController extends Controller
{
    /**
     * Display a listing of the travels.
     */
    public function index()
    {
        $travels = Travel::where('is_public', true)
                        ->paginate(10);

        return response()->json($travels);
    }

    /**
     * Store a newly created travel in database.
     */
    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'is_public' => 'required|boolean',
                'slug' => 'required|string',
                'name' => 'required|string',
                'description' => 'required|string',
                'number_of_days' => 'required|integer'
            ]);

            $travel = Travel::create($validated);

            return response()->json($travel);

        } catch (ValidationException $e) {
            return response()->json(["message" => $e->getMessage()], 422);
        }

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $travel = Travel::find($id);

            if (!$travel) {
                return response()->json(
                    [
                        "message" => "Travel not found"
                    ],
                    404
                );
            }

            $validated = $request->validate([
                'is_public' => 'required|boolean',
                'slug' => 'required|string',
                'name' => 'required|string',
                'description' => 'required|string',
                'number_of_days' => 'required|integer'
            ]);


            $travel->is_public = $validated['is_public'];
            $travel->slug = $validated['slug'];
            $travel->name = $validated['name'];
            $travel->description = $validated['description'];
            $travel->number_of_days = $validated['number_of_days'];

            $travel->save();

            return response()->json($travel);

        } catch (ValidationException $e) {
            return response()->json(["message" => $e->getMessage()], 422);
        }
    }

}
