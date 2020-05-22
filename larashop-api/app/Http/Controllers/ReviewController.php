<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use App\Http\Resources\Review as ReviewResource;
use App\Http\Resources\ReviewCollection as ReviewResourceCollection;

class ReviewController extends Controller
{
    public function all()
    {
        return new ReviewResourceCollection(Review::paginate(10));
    }

    public function index()
    {
        return new ReviewResourceCollection(Review::paginate(10));
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function merchandiseReview($id)
    {
        $reviews = Review::where('order_merchandise_id', '=', "$id")->get();
        $review = [];
        foreach($reviews as $temp){
            $review[] = new ReviewResource($temp);
        }
        return response()->json(['review' => $review], 200);
    }

    public function update(Request $request, $id)
    {
        //
    }
    
    public function destroy($id)
    {
        //
    }
}
