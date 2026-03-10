<nav class="navbar">
    <div class="flex items-center">
        <a href="/" class="flex items-center justify-center">
            <img src="/images/logos/WhiteLogoOnSun.png" alt="Logo" style="height: 150px; width: auto;" />

        </a>
    </div>

    <div class="navLinks">
        <a href="/dashboard" class="text-blue-500 hover:underline">Dashboard</a>
        @guest
        <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
        @endguest
        @auth
        <a href="/logout" class="text-blue-500 hover:underline">Logout</a>
        @endauth
    </div>
</nav>