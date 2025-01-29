<!-- Navigation Component -->
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
                        <!-- Icon when menu is closed -->
                        <svg class="w-6 h-6" :class="{'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" 
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Icon when menu is open -->
                        <svg class="w-6 h-6" :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" 
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex items-center flex-shrink-0 ml-4 sm:ml-0">
                    <!-- Logo -->
                    <span class="text-xl font-bold text-indigo-600">BonScan</span>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="/" wire:navigate 
                        @class([
                            'inline-flex items-center px-1 pt-1 text-sm font-medium border-b-2',
                            'border-indigo-500 text-gray-900' => request()->routeIs('dashboard') || request()->is('/'),
                            'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' => !request()->routeIs('dashboard')
                        ])>
                        Dashboard
                    </a>
                    <a href="/situatie-centralizatoare" wire:navigate 
                        @class([
                            'inline-flex items-center px-1 pt-1 text-sm font-medium border-b-2',
                            'border-indigo-500 text-gray-900' => request()->routeIs('situatie-centralizatoare*'),
                            'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' => !request()->routeIs('situatie-centralizatoare*')
                        ])>
                        Situații
                    </a>
                    <a href="/bonuri" wire:navigate 
                        @class([
                            'inline-flex items-center px-1 pt-1 text-sm font-medium border-b-2',
                            'border-indigo-500 text-gray-900' => request()->routeIs('bonuri*'),
                            'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' => !request()->routeIs('bonuri*')
                        ])>
                        Bonuri
                    </a>
                </div>
            </div>

            <!-- Secondary Navigation -->
            <div class="flex items-center">
                <!-- Settings Dropdown -->
                <div class="relative ml-3" x-data="{ open: false }">
                    <button @click="settingsOpen = !settingsOpen" type="button" 
                        class="p-1 text-gray-400 bg-white rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <span class="sr-only">Setări</span>
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>

                    <!-- Settings Dropdown Panel -->
                    <div x-show="settingsOpen" @click.away="settingsOpen = false" 
                        class="absolute right-0 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Setări cont</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Preferințe</a>
                        <hr class="my-1">
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                Deconectare
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" class="sm:hidden"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95">
        <div class="pt-2 pb-3 space-y-1">
            <a href="/" wire:navigate 
                @class([
                    'block py-2 pl-3 pr-4 text-base font-medium border-l-4',
                    'border-indigo-500 text-indigo-700 bg-indigo-50' => request()->routeIs('dashboard'),
                    'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' => !request()->routeIs('dashboard')
                ])>
                Dashboard
            </a>
            <a href="/situatie-centralizatoare" wire:navigate 
                @class([
                    'block py-2 pl-3 pr-4 text-base font-medium border-l-4',
                    'border-indigo-500 text-indigo-700 bg-indigo-50' => request()->routeIs('situatie-centralizatoare*'),
                    'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' => !request()->routeIs('situatie-centralizatoare*')
                ])>
                Situații
            </a>
            <a href="/bonuri" wire:navigate 
                @class([
                    'block py-2 pl-3 pr-4 text-base font-medium border-l-4',
                    'border-indigo-500 text-indigo-700 bg-indigo-50' => request()->routeIs('bonuri*'),
                    'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' => !request()->routeIs('bonuri*')
                ])>
                Bonuri
            </a>
        </div>
    </div>
</nav>