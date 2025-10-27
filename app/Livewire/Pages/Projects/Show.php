<?php

namespace App\Livewire\Pages\Projects;

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\ProjectReview;
use App\Models\ProjectVote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Show extends Component
{
    public Project $project;

    public int $rating = 0;

    public string $comment = '';

    public bool $showReviewForm = false;

    public function mount(Project $project): void
    {
        // Only allow approved projects to be viewed
        if ($project->status !== ProjectStatus::Approved) {
            abort(404, 'Project not found or not yet approved.');
        }

        $this->project = $project;

        // Record unique view for this project
        views($project)->record();
    }

    public function toggleVote(): void
    {
        if (! Auth::check()) {
            Toaster::warning('Please log in to vote for this project.');
            $this->redirect(route('login'));

            return;
        }

        $userId = Auth::id();
        $existingVote = ProjectVote::where('user_id', $userId)
            ->where('project_id', $this->project->id)
            ->first();

        if ($existingVote) {
            // Remove vote
            $existingVote->delete();
            $this->project->decrement('votes_count');
            Toaster::info('Vote removed.');
        } else {
            // Add vote
            ProjectVote::create([
                'user_id' => $userId,
                'project_id' => $this->project->id,
            ]);
            $this->project->increment('votes_count');
            Toaster::success('Thanks for your vote!');
        }

        $this->project->refresh();
    }

    public function submitReview(): void
    {
        if (! Auth::check()) {
            Toaster::warning('Please log in to leave a review.');
            $this->redirect(route('login'));

            return;
        }

        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        try {
            ProjectReview::create([
                'user_id' => Auth::id(),
                'project_id' => $this->project->id,
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]);

            // Update average rating
            $this->updateAverageRating();

            Toaster::success('Thank you for your review!');

            // Reset form
            $this->rating = 0;
            $this->comment = '';
            $this->showReviewForm = false;

            $this->project->refresh();
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            Toaster::error('You have already reviewed this project.');
        }
    }

    public function deleteReview(int $reviewId): void
    {
        $review = ProjectReview::findOrFail($reviewId);

        if ($review->user_id !== Auth::id()) {
            Toaster::error('You can only delete your own reviews.');

            return;
        }

        $review->delete();
        $this->updateAverageRating();

        Toaster::info('Your review has been deleted.');
        $this->project->refresh();
    }

    private function updateAverageRating(): void
    {
        $averageRating = ProjectReview::where('project_id', $this->project->id)
            ->avg('rating');

        $this->project->update([
            'average_rating' => round($averageRating ?? 0, 2),
        ]);
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        $reviews = $this->project->reviews()
            ->with('user')
            ->latest()
            ->get();

        $hasVoted = Auth::check() && $this->project->hasVotedBy(Auth::user());
        $hasReviewed = Auth::check() && $this->project->hasReviewedBy(Auth::user());

        return view('livewire.pages.projects.show', [
            'reviews' => $reviews,
            'hasVoted' => $hasVoted,
            'hasReviewed' => $hasReviewed,
        ])->title($this->project->title.' - Community Projects');
    }
}
