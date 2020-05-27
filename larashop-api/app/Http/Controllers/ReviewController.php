<?php

namespace App\Http\Controllers;

use App\Review;
use App\OrderMerchandise;
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
        $order_merchandise = OrderMerchandise::where('merchandise_id', '=', "$id")->get();
        $reviews = [];
        foreach($order_merchandise as $temp){
            $review = Review::where('order_merchandise_id', '=', $temp->id)->first();
            $reviews[] = new ReviewResource($review);
        }
        return response()->json(['review' => $reviews], 200);
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
