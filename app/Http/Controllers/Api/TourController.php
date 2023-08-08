<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class TourController extends Controller
{
    /**
     * Display a listing of the tours.
     */
    public function index(Request $request)
    {
        $tours = Tour::query();

        if ($request->has('slug')) {
            $slug = $request->input('slug');
            $tours = $tours->whereHas('travel', function (Builder $query) use ($slug) {
                $query->where('slug', $slug);
            });
        }

        if ($request->has('priceFrom')) {
            $priceFrom = ((int) $request->input('priceFrom')) * 100;
            $tours = $tours->where('price', '>=', $priceFrom);
        }

        if ($request->has('priceTo')) {
            $priceTo = ((int) $request->input('priceTo')) * 100;
            $tours = $tours->where('price', '<', $priceTo);
        }

        if ($request->has('dateFrom')) {
            $dateFrom = $request->input('dateFrom');
            $tours = $tours->where('starting_date', '>=', $dateFrom);
        }

        if ($request->has('dateTo')) {
            $dateTo = $request->input('dateTo');
            $tours = $tours->where('ending_date', '<', $dateTo);
        }

        $tours = $tours
            ->orderBy('starting_date', 'asc')
            ->orderBy('price', 'asc')
            ->paginate(10);

        return response()->json($tours);
    }

    /**
     * Store a newly created tour in database.
     */
    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'travel_id' => 'required|integer',
                'name' => 'required|string',
                'starting_date' => 'required|date',
                'ending_date' => 'required|date',
                'price' => 'required|integer'
            ]);

            $tour = Tour::create($validated);

            return response()->json($tour->toArray());

        } catch (ValidationException $e) {
            return response()->json(["message" => $e->getMessage()], 422);
        }
    }

}
