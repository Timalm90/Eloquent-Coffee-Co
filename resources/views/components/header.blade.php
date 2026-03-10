<nav class="navbar bg-gray-50 shadow-md flex justify-between items-center overflow-hidden">
    <div class="flex items-center shrink-0">
        <a href="/" class="flex items-center justify-center">
            <img src="/images/logos/WhiteLogoOnSun.png" alt="Logo" class="h-16 sm:h-28 w-auto hover:scale-105" />
        </a>
    </div>

    <div class="navLinks min-w-0">
        <a href="/dashboard" class="text-black text-xl sm:text-3xl font-bold hover:underline font-[family-name:var(--font-afacad)]">DASHBOARD</a>
        @guest
        <a href="{{ route('login') }}" class="text-black text-xl sm:text-3xl font-bold hover:underline font-[family-name:var(--font-afacad)]">LOGIN</a>
        @endguest
        @auth
        <a href="/logout" class="text-black text-xl sm:text-3xl font-bold hover:underline font-[family-name:var(--font-afacad)]">LOGOUT</a>
        @endauth
    </div>
</nav>