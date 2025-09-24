<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Layout;
use Livewire\Component;

class WelcomePage extends Component
{
    public $email = '';

    protected $rules = [
        'email' => 'required|email|max:255',
    ];

    protected $messages = [
        'email.required' => 'L\'adresse email est requise.',
        'email.email' => 'Veuillez entrer une adresse email valide.',
        'email.max' => 'L\'adresse email ne peut pas dépasser 255 caractères.',
    ];

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.pages.welcome-page');
    }

    public function subscribe()
    {
        $this->validate();

        // do something with the email
    }
}
