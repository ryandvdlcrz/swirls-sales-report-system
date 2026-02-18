<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-no-repeat bg-cover bg-center flex flex-col items-center justify-center bg-pink-200" style="background-image: url('{{ asset('img/settings_sales_ordererzxs.png') }}');">

    <!-- Header -->
    <header class="w-full flex flex-col items-center max-w-2xl mt-3">

        <!-- Logo & Name -->
        <div class="flex items-center space-x-3 mb-8">
            <a href="{{ route('index') }}">
                <img src="{{ asset('img/swirls-logo.webp') }}" alt="Swirls Logo" class="w-12 h-12" />
            </a>
            <h1 class="text-2xl font-semibold text-gray-800">Swirls</h1>
        </div>

        <!-- Success Message -->
        <div class="text-center space-y-4">
            <h1 class="text-xl text-gray-700">
                We Serve Happiness!
            </h1>

            <img src="{{ asset('img/ep_success-filled.png') }}" alt="Success Icon" class="w-20 mx-auto" />

            <h1 class="text-2xl font-bold text-green-600">
                Order success, thank you!
            </h1>

            <p class="text-gray-600">
                Your order has been recorded successfully.
            </p>
        </div>
    </header>

    <!-- Action Buttons -->
    <div class="flex flex-col items-center gap-4 mt-8">

        <!-- Back to Menu -->
        <a href="{{ route('menu.index') }}">
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-8 rounded-xl active:scale-95 transition">
                Browse Menu
            </button>
        </a>

        <!-- Home Button -->
        <a href="{{ route('index') }}">
            <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-8 rounded-xl active:scale-95 transition">
                Go to Home
            </button>
        </a>

    </div>

</body>
</html>
