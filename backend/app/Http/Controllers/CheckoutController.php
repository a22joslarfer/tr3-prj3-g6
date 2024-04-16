<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;
use App\Models\Seat;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    //

    public function index()
    {
        return Checkout::all();
    }



    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            foreach ($request->all() as $seatData) {
                $seat = Seat::find($seatData['seat_id']);

                if (!$seat) {
                    return response()->json(['error' => 'Seat not found'], 404);
                }

                $seat->status = 'booked';
                $seat->save();

                Checkout::create([
                    'movie_id' => (int)$seatData['movie_id'],
                    'user_id' => $seatData['user_id'],
                    'seat_id' => $seatData['seat_id'],
                    'date' => $seatData['date'],
                    'total' => $seatData['total'],
                    'unit_seat_price' => $seatData['unit_seat_price'],
                ]);
            }



            DB::commit();

            return response()->json(['message' => 'Purchase successful'], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            // Log the error for investigation
            Log::error('Database error occurred while storing the checkout: ' . $e->getMessage());

            return response()->json(['error' => 'Database error occurred while storing the checkout.'], 500);
        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error for investigation
            Log::error('An unexpected error occurred while storing the checkout: ' . $e->getMessage());

            return response()->json(['error' => 'An unexpected error occurred while storing the checkout.'], 500);
        }
    }

    public function destroy($id)
    {
        $checkout = Checkout::find($id);

        if (!$checkout) {
            return response()->json(['error' => 'Checkout not found'], 404);
        }

        $seat = Seat::find($checkout->seat_id);
        $seat->status = 'available';
        $seat->save();

        $checkout->delete();

        return response()->json(['message' => 'Checkout deleted'], 200);
    }

    public function showBasedOnUserId($id)
    {
        $checkouts = Checkout::where('user_id', $id)->get();
        if (!$checkouts) {
            return response()->json(['error' => 'Checkout not found'], 404);
        }
        return $checkouts;
    }

    public function show($id)
    {
        $checkout = Checkout::find($id);
        if (!$checkout) {
            return response()->json(['error' => 'Checkout not found'], 404);
        }
        return $checkout;
    }

    public function update($id)
    {
        $checkout = Checkout::find($id);
        if (!$checkout) {
            return response()->json(['error' => 'Checkout not found'], 404);
        }
        $checkout->status = 'paid';
        $checkout->save();
        return response()->json(['message' => 'Checkout updated'], 200);
    }

    // find unique user_id based on movie_id to get the number of users who have booked the movie

    public function getMovieWatchers($id)
    {
        if(!is_numeric($id)){
            return response()->json(['error' => 'Invalid movie id'], 400);
        }else if(!Checkout::where('movie_id', $id)->exists()){
            return response()->json(['error' => 'Movie not found'], 404);
        }
        $uniqueUserIds = Checkout::where('movie_id', $id)->distinct()->get(['user_id']);

        return response()->json(['watchers' => count($uniqueUserIds)], 200);
    }
}
