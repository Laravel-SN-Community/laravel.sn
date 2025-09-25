<?php

namespace App\Livewire\Pages;

use App\Models\NewsletterSubscription;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Newsletter\Facades\Newsletter;

class WelcomePage extends Component
{
    public $email = '';
    public $list_name = 'subscribers';

    protected function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('newsletter_subscriptions')->where(function ($query) {
                    return $query->where('status', 'subscribed')->where('list_name', $this->list_name);
                }),
            ],
        ];
    }

    protected $messages = [
        'email.required' => 'L\'adresse email est requise.',
        'email.email' => 'Veuillez entrer une adresse email valide.',
        'email.max' => 'L\'adresse email ne peut pas dépasser 255 caractères.',
        'email.unique' => 'Cette adresse email est déjà abonnée à notre newsletter.',
    ];

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.pages.welcome-page');
    }

    public function subscribe()
    {
        try {
            $this->validate();

            $existingSubscription = NewsletterSubscription::where('email', $this->email)
                ->where('list_name', $this->list_name)
                ->first();

            if ($existingSubscription && $existingSubscription->isSubscribed()) {
                Toaster::error('Cette adresse email est déjà abonnée à notre newsletter.');
                return;
            }

            $subscription = NewsletterSubscription::updateOrCreate(
                [
                    'email' => $this->email,
                    'list_name' => $this->list_name,
                ],
                [
                    'status' => 'subscribed',
                    'subscribed_at' => now(),
                    'unsubscribed_at' => null,
                ]
            );

            Newsletter::subscribeOrUpdate($this->email, [], $this->list_name);

            Toaster::success('Merci pour votre abonnement ! Vous recevrez bientôt nos dernières actualités.');

            $this->reset('email');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Toaster::error('Une erreur est survenue lors de l\'inscription. Veuillez réessayer.');

            if (config('app.debug')) {
                logger()->error('Newsletter subscription error: ' . $e->getMessage());
            }
        }
    }
}
