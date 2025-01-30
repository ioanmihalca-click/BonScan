<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'Numele este obligatoriu',
            'email.required' => 'Adresa de email este obligatorie',
            'email.email' => 'Adresa de email nu este validă',
            'email.unique' => 'Această adresă de email este deja înregistrată',
            'password.required' => 'Parola este obligatorie',
            'password.confirmed' => 'Parolele nu coincid'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register" class="space-y-6">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nume și Prenume')" />
            <x-text-input wire:model="name" id="name" class="block w-full mt-1" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresa de Email')" />
            <x-text-input wire:model="email" id="email" class="block w-full mt-1" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Parola')" />
            <x-text-input wire:model="password" id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmă Parola')" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-primary-button class="justify-center w-full">
                Înregistrare
            </x-primary-button>
        </div>

        <div class="text-center">
            <span class="text-sm text-gray-600">Ai deja cont? </span>
            <a class="text-sm font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('login') }}" wire:navigate>
                Autentifică-te
            </a>
        </div>
    </form>
</div>