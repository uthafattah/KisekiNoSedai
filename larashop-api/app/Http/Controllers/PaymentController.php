<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use App\Http\Resources\Payment as PaymentResource;
use App\Http\Resources\PaymentCollection as PaymentResourceCollection;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->per_page ? $request->per_page : 10;
        $sortBy = $request->sort_by ? $request->sort_by : 'id';
        $orderBy = $request->order_by  ? $request->order_by : 'asc';
        return response()->json([
            'payments' => new PaymentResourceCollection(Payment::orderBy($sortBy, $orderBy)->paginate($per_page))
        ], 200);
    }

    public function store(Request $request)
    {
        $payment = new Payment([
            'name' => $request->name,
            'slug' => \Str::slug($request->name, '-'),
        ]);
        $payment->save();
        return response()->json(['payment' => new PaymentResource($payment)], 200);
    }

    public function show($id)
    {
        $payment = Payment::where('name', 'LIKE', "%$id%")->paginate(10);
        return response()->json(['payment' => new PaymentResourceCollection($payment)], 200);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);
        $payment->name = $request->name;
        $payment->slug = \Str::slug($request->name, '-');
        $payment->save();
        return response()->json(['payment' => new PaymentResource($payment)], 200);
    }

    public function destroy($id)
    {
        $payment = Payment::find($id)->delete();
        return response()->json(['payment' => $payment], 200);
    }

    public function verifyPayment(Request $request) 
    {
        $request->validate([
            'name' => 'required|unique:payments'
        ]);

        return response()->json(['message' => 'Valid Payment Name'], 200);
    }
}
