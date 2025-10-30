<?php

namespace App\Http\Responses;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse
    {
        $intendedUrl = session()->pull('url.intended', route('dashboard'));
        $projectId = session()->pull('pending_vote_project_id');

        if ($projectId && $request->user()) {
            $project = Project::find($projectId);

            if ($project && ! $request->user()->hasVotedFor($project)) {
                $request->user()->votedProjects()->attach($project);
            }
        }

        return redirect()->to($intendedUrl);
    }
}
