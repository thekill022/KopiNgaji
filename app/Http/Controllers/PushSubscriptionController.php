<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PushSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'endpoint' => 'required|string|max:500',
            'keys' => 'required|array',
            'keys.p256dh' => 'required|string|max:255',
            'keys.auth' => 'required|string|max:255',
        ]);

        PushSubscription::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'endpoint' => $validated['endpoint'],
            ],
            [
                'public_key' => $validated['keys']['p256dh'],
                'auth_token' => $validated['keys']['auth'],
                'content_encoding' => 'aesgcm',
            ]
        );

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $request->validate(['endpoint' => 'required|string|max:500']);

        PushSubscription::where('user_id', Auth::id())
            ->where('endpoint', $request->endpoint)
            ->delete();

        return response()->json(['success' => true]);
    }
}
