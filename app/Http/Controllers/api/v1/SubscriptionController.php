<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['user', 'producer'])->get();
        return response()->json($subscriptions, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'producer_id' => 'required|exists:producers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $subscription = Subscription::create($validatedData);
        return response()->json($subscription, 201);
    }

    public function show(Subscription $subscription)
    {
        $subscription->load(['user', 'producer']);
        return response()->json($subscription, 200);
    }

    public function update(Request $request, Subscription $subscription)
    {
        $validatedData = $request->validate([
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_date',
        ]);

        $subscription->update($validatedData);
        return response()->json($subscription, 200);
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return response()->json(null, 204);
    }
}

