<?php

namespace App\Livewire\Pages;

use App\Enums\SubscriberStatus;
use App\Models\NewsletterSubscription;
use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\Schema;

class WelcomePage extends Component
{
    #[Validate('required|email|max:255|unique:newsletter_subscriptions,email')]
    public $email;

    public function subscribe()
    {
        $this->validate();

        $existingSubscription = NewsletterSubscription::where('email', $this->email)
            ->first();

        if ($existingSubscription) {
            Toaster::error(__('this email is already subscribed to our newsletter'));

            return;
        }

        NewsletterSubscription::create(
            [
                'email' => $this->email,
                'status' => SubscriberStatus::Subscribed,
                'subscribed_at' => now(),
            ],
        );

        Toaster::success(__('thank you for subscribing to our newsletter'));

        $this->reset('email');

    }

    #[Layout('layouts.guest')]
    public function render()
    {
        // Protect against environments where the votes table may not exist
        // (e.g., fresh sqlite testing environment). If the table is missing
        // fall back to ordering by approval date only.
        $query = Project::approved()->with('category');

        if (Schema::hasTable('project_votes')) {
            $query = $query->withCount('votes')
                ->orderBy('votes_count', 'desc')
                ->orderBy('approved_at', 'desc');
        } else {
            $query = $query->orderBy('approved_at', 'desc');
        }

        $featuredProjects = $query->limit(4)->get();

        return view('livewire.pages.welcome-page', [
            'featuredProjects' => $featuredProjects,
        ]);
    }
}
