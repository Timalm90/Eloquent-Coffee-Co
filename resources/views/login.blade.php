<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Eloquent Coffee Co</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <x-header />

    <div class="w-full max-w-sm mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>

        <x-form action="/login">
            <x-input name="username" label="Username" />
            <x-input name="password" label="Password" type="password" />
            <x-button type="submit">
                Login
            </x-button>
        </x-form>

        @include('components/errors')
    </div>
</body>

</html>