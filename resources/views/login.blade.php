<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="/favicon-light.ico" media="(prefers-color-scheme: light)">
    <link rel="icon" href="/favicon-dark.ico" media="(prefers-color-scheme: dark)">

    <title>Login - Eloquent Coffee Co</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">

    <x-header />

    <main id="main-content">
        <div class="w-full max-w-sm mx-auto p-6">

            <h1 id="login-heading" class="text-2xl font-bold mb-6 text-center">
                Login
            </h1>

            {{-- FORM --}}
            <form
                method="POST"
                action="/login"
                aria-labelledby="login-heading"
                class="max-w-sm">
                @csrf

                {{-- USERNAME INPUT --}}
                <div class="mb-4">
                    <label for="username" class="block mb-1 font-medium">
                        Username
                    </label>

                    <input
                        id="username"
                        name="username"
                        type="text"
                        value="{{ old('username') }}"
                        autocomplete="username"
                        required
                        class="border border-gray-300 p-2 rounded w-full
                           focus:outline-none
                           focus:ring
                           focus:ring-blue-200" />
                </div>

                {{-- PASSWORD INPUT --}}
                <div class="mb-4">
                    <label for="password" class="block mb-1 font-medium">
                        Password
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        class="border border-gray-300 p-2 rounded w-full
                           focus:outline-none
                           focus:ring
                           focus:ring-blue-200" />
                </div>

                {{-- BUTTON  --}}
                <button
                    type="submit"
                    class="border border-gray-300 rounded-lg bg-gray-100 py-2 px-4
                       hover:bg-gray-200
                       focus:outline-none
                       focus:ring
                       focus:ring-blue-300">
                    Login
                </button>

            </form>

            {{-- GLOBAL ERRORS --}}
            @include('components/errors')

        </div>
    </main>

</body>

</html>