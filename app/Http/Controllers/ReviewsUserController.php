<?php

namespace App\Http\Controllers;

use App\Models\ReviewUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReviewsUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Get paginated reviews by user.
     */
    public function getPaginatedReviewsByUser($userId)
    {
        try {
            $reviews = ReviewUser::where('user_id', $userId)->paginate(10);
            return response()->json($reviews, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching paginated reviews for user ' . $userId . ': ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching paginated reviews'], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ReviewUser $reviewUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReviewUser $reviewUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReviewUser $reviewUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReviewUser $reviewUser)
    {
        //
    }
}
