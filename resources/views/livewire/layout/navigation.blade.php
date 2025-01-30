<?php
use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<nav class="bg-white border-b border-gray-200" x-data="{ mobileMenuOpen: false, settingsOpen: false }">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo & Primary Navigation -->
            <div class="flex">
                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                        class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                        <span class="sr-only">Deschide meniul principal</span>
                        <svg class="w-6 h-6" :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="w-6 h-6" :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

          <div class="flex items-center flex-shrink-0 ml-4 sm:ml-0">
    <img src="assets/logo.webp" alt="BonScan Logo" class="w-8 h-8 mr-2">
    <span class="text-xl font-bold text-indigo-600">BonScan</span>
</div>
                <!-- Desktop Navigation -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="/dashboard" wire:navigate @class([
                        'inline-flex items-center px-1 pt-1 text-sm font-medium border-b-2',
                        'border-indigo-500 text-gray-900' => request()->routeIs('dashboard'),
                        'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' => !request()->routeIs(
                            'dashboard'),
                    ])>
                        Dashboard
                    </a>
                    <a href="/situatie-centralizatoare" wire:navigate @class([
                        'inline-flex items-center px-1 pt-1 text-sm font-medium border-b-2',
                        'border-indigo-500 text-gray-900' => request()->routeIs(
                            'situatie-centralizatoare*'),
                        'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' => !request()->routeIs(
                            'situatie-centralizatoare*'),
                    ])>
                        Situații
                    </a>
                    <a href="/bonuri" wire:navigate @class([
                        'inline-flex items-center px-1 pt-1 text-sm font-medium border-b-2',
                        'border-indigo-500 text-gray-900' => request()->routeIs('bonuri*'),
                        'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' => !request()->routeIs(
                            'bonuri*'),
                    ])>
                        Bonuri
                    </a>
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                                x-on:profile-updated.window="name = $event.detail.name">
                            </div>
                            <div class="ms-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Deconectare') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="/dashboard" wire:navigate @class([
                'block py-2 pl-3 pr-4 text-base font-medium border-l-4',
                'border-indigo-500 text-indigo-700 bg-indigo-50' => request()->routeIs(
                    'dashboard'),
                'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' => !request()->routeIs(
                    'dashboard'),
            ])>
                Dashboard
            </a>
            <a href="/situatie-centralizatoare" wire:navigate @class([
                'block py-2 pl-3 pr-4 text-base font-medium border-l-4',
                'border-indigo-500 text-indigo-700 bg-indigo-50' => request()->routeIs(
                    'situatie-centralizatoare*'),
                'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' => !request()->routeIs(
                    'situatie-centralizatoare*'),
            ])>
                Situații
            </a>
            <a href="/bonuri" wire:navigate @class([
                'block py-2 pl-3 pr-4 text-base font-medium border-l-4',
                'border-indigo-500 text-indigo-700 bg-indigo-50' => request()->routeIs(
                    'bonuri*'),
                'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' => !request()->routeIs(
                    'bonuri*'),
            ])>
                Bonuri
            </a>

            <!-- Mobile Profile Info -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="text-base font-medium text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                        x-on:profile-updated.window="name = $event.detail.name">
                    </div>
                    <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile')" wire:navigate>
                        {{ __('Profil') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <button wire:click="logout" class="w-full text-start">
                        <x-responsive-nav-link>
                            {{ __('Deconectare') }}
                        </x-responsive-nav-link>
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>
