<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Newsletter\Facades\Newsletter;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('newsletter_subscriptions')->where(function ($query) {
                    return $query->where('status', 'subscribed');
                }),
            ],
            'list_name' => 'nullable|string|max:255',
        ]);

        $listName = $request->input('list_name', 'subscribers');

        try {
            $existingSubscription = NewsletterSubscription::where('email', $request->email)
                ->where('list_name', $listName)
                ->first();

            if ($existingSubscription && $existingSubscription->isSubscribed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cette adresse email est déjà abonnée à notre newsletter.',
                ], 409);
            }

            $subscription = NewsletterSubscription::updateOrCreate(
                [
                    'email' => $request->email,
                    'list_name' => $listName,
                ],
                [
                    'status' => 'subscribed',
                    'subscribed_at' => now(),
                    'unsubscribed_at' => null,
                ]
            );

            Newsletter::subscribeOrUpdate($request->email, [], $listName);

            return response()->json([
                'success' => true,
                'message' => 'Merci pour votre abonnement ! Vous recevrez bientôt nos dernières actualités.',
                'data' => $subscription,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function unsubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'list_name' => 'nullable|string|max:255',
        ]);

        $listName = $request->input('list_name', 'subscribers');

        try {
            $subscription = NewsletterSubscription::where('email', $request->email)
                ->where('list_name', $listName)
                ->first();

            if (!$subscription) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cette adresse email n\'est pas trouvée dans notre liste.',
                ], 404);
            }

            $subscription->unsubscribe();

            Newsletter::unsubscribe($request->email, $listName);

            return response()->json([
                'success' => true,
                'message' => 'Vous avez été désabonné(e) de notre newsletter avec succès.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la désinscription. Veuillez réessayer.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function status(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'list_name' => 'nullable|string|max:255',
        ]);

        $listName = $request->input('list_name', 'subscribers');

        $subscription = NewsletterSubscription::where('email', $request->email)
            ->where('list_name', $listName)
            ->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'subscribed' => false,
                'message' => 'Cette adresse email n\'est pas dans notre liste.',
            ]);
        }

        return response()->json([
            'success' => true,
            'subscribed' => $subscription->isSubscribed(),
            'subscription' => $subscription,
        ]);
    }

    public function showForm()
    {
        return view('newsletter.form');
    }
}
