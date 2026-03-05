
<nav class="navbar">
    {{-- <div><a href="/"><img src="/images/Frame3.png" alt="Logo" class="logoNav"/></a></div> --}}
    <div><a href="/">Home</a></div>
    <div class="navLinks">
        <a href="/dashboard" class="text-blue-500 hover:underline">Dashboard</a>
        @guest
        <a href=" {{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
        @endguest
        @auth
        <a href="/logout" class="text-blue-500 hover:underline">Logout</a>
        @endauth
    </div>
</nav>

