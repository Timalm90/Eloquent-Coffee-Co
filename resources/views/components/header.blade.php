<nav class="navbar bg-gray-50 shadow-md flex justify-between">
    <div class=" flex items-center">
        <a href="/" class="flex items-center justify-center">
            <img src="/images/logos/WhiteLogoOnSun.png" alt="Logo" class="h-28 w-auto hover:scale-105" />

        </a>
    </div>

    <div class="navLinks">
        <a href="/dashboard" class="text-black text-3xl font-bold hover:underline font-[family-name:var(--font-afacad)]">DASHBOARD</a>
        @guest
        <a href="{{ route('login') }}" class="text-black text-3xl font-bold hover:underline font-[family-name:var(--font-afacad)]">LOGIN</a>
        @endguest
        @auth
        <a href="/logout" class="text-black text-3xl font-bold hover:underline font-[family-name:var(--font-afacad)]">LOGOUT</a>
        @endauth
    </div>
</nav>