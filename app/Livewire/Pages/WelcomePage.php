<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use App\Enums\SubscriberStatus;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use App\Models\NewsletterSubscription;
use Spatie\Newsletter\Facades\Newsletter;

class WelcomePage extends Component
{
    #[Validate('required|email|max:255|unique:newsletter_subscriptions,email,status,subscribed')]
    public $email;

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.pages.welcome-page');
    }

    public function subscribe()
    {
            $this->validate();

            $existingSubscription = NewsletterSubscription::where('email', $this->email)
                ->where('status', SubscriberStatus::Subscribed)
                ->first();

            if ($existingSubscription) {
                Toaster::error(__('this email is already subscribed to our newsletter'));
                return;
            }

            $subscription = NewsletterSubscription::create(
                [
                    'email' => $this->email,
                    'status' => SubscriberStatus::Subscribed,
                    'subscribed_at' => now()
                ],
            );

            Toaster::success(__('thank you for subscribing to our newsletter'));

            $this->reset('email');

    }
}
