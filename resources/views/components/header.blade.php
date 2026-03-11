<nav class="navbar bg-gray-50 border-b border-gray-200 flex justify-between items-center overflow-hidden">
    <div class="flex items-center shrink-0">
        <a href="/" class="flex items-center justify-center hover:scale-105 transition-transform duration-300">
            <img src="/images/logos/WhiteLogoOnSun.png" alt="Logo" class="h-12 sm:h-20 w-auto" />
        </a>
    </div>

    <div class="navLinks min-w-0">
        <a href="/dashboard" class="nav-link font-[family-name:var(--font-afacad)]">DASHBOARD</a>
        @guest
        <a href="{{ route('login') }}" class="nav-link font-[family-name:var(--font-afacad)]">LOGIN</a>
        @endguest
        @auth
        <a href="/logout" class="nav-link font-[family-name:var(--font-afacad)]">LOGOUT</a>
        @endauth
    </div>
</nav>