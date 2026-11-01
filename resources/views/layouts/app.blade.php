<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'KRL Station Review & Notes')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 antialiased">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">

        <div class="max-w-7xl mx-auto px-5 py-4
                    flex justify-between items-center">

            <a href="{{ route('home') }}"
               class="text-xl font-extrabold text-red-600">

                KRL<span class="text-gray-900">Review.</span>

            </a>

            <div class="flex items-center gap-5 text-sm font-medium">

                <a href="{{ route('home') }}"
                   class="hover:text-red-600">
                    Home
                </a>

                @auth

                    <a href="{{ route('reviews.my-notes') }}"
                       class="hover:text-red-600">
                        🔒 My Notes
                    </a>

                    <span class="hidden md:block text-gray-500">
                        {{ auth()->user()->name }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit"
                                class="text-red-600 font-bold">
                            Logout
                        </button>
                    </form>

                @else

                    <a href="{{ route('login') }}"
                       class="hover:text-red-600">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="bg-red-600 text-white
                              px-4 py-2 rounded-lg
                              hover:bg-red-700">
                        Register
                    </a>

                @endauth

            </div>

        </div>

    </nav>


    <!-- Main -->
    <main class="min-h-screen">

        @yield('content')

    </main>


    <!-- Footer -->
    <footer class="bg-gray-950 text-gray-400 mt-16">

        <div class="max-w-7xl mx-auto px-5 py-10 text-center">

            <h3 class="text-white font-bold text-xl">
                KRL Station Review & Notes
            </h3>

            <p class="text-sm mt-2">
                Share your experience. Help other commuters.
            </p>

            <p class="text-xs mt-6">
                &copy; {{ date('Y') }} KRL Review.
            </p>

        </div>

    </footer>

</body>
</html>