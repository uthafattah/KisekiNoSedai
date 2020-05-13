<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use App\Http\Resources\Review as ReviewResource;
use App\Http\Resources\ReviewCollection as ReviewResourceCollection;

class ReviewController extends Controller
{
    public function index()
    {
        //return response()->json(['review' => Review::all()], 200);
        return new ReviewResourceCollection(Review::paginate(5));
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
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
