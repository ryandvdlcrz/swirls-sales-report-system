<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account ni Manong Sorbetero</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body>

    <!--background-->
    <div class="min-h-screen m-0 p-0 bg-no-repeat bg-cover bg-center relative" style="background-image: url({{asset('img/settings_sales_ordererzxs.png')}});">


        <header class="flex items-start flex-col px-4 pt-4">

            <div class="container flex items-center justify-between">
                <div class="text-2xl md:text-3xl font-medium p-4 md:p-6">Settings</div>
            </div>

            <div class="flex flex-col lg:flex-row gap-5 w-full px-2 md:px-4">
                <nav class="lg:min-w-[200px]">
                    <ul class="font-medium text-lg md:text-xl p-4 md:p-6">
                        <li class="mb-5 md:mb-7"><a href="{{route('index')}}" class="hover:underline">Menu</a></li>
                        <li class="mb-5 md:mb-7 border-1 px-2 rounded-2xl inline-block"><a href="{{route('settings.account')}}">Account detail</a></li>
                        <li class="mb-5 md:mb-7"><a href="{{route('settings.get_help')}}" class="hover:underline">Get help</a></li>
                    </ul>
                </nav>

                <div class="bg-pink-100/60 flex flex-col rounded-2xl font-[550] shadow-2xl p-4 md:p-5 w-full max-w-2xl mb-20 md:mb-24">
                    <h1 class="text-xl md:text-2xl font-semibold mb-4 md:mb-5">Account Information</h1>

                    {{-- MERCHANT NAME --}}
                    <div class="flex flex-col mb-3">
                        <label for="merchant" class="mb-1 font-medium text-sm md:text-base">MERCHANT NAME:</label>
                        <input type="text" id="merchant" readonly class="bg-pink-100 border-2 rounded-full p-2 md:p-2.5 w-full focus:outline-none focus:ring-2 focus:ring-blue-400 cursor-not-allowed text-sm md:text-base" value="{{ $user->branch ? $user->branch->name : 'No branch assigned' }}">
                    </div>

                    {{-- BRANCH LOCATION --}}
                    <div class="flex flex-col mb-3">
                        <label for="branch_location" class="mb-1 font-medium text-sm md:text-base">BRANCH LOCATION:</label>
                        <input type="text" id="branch_location" readonly class="bg-pink-100 border-2 rounded-full p-2 md:p-2.5 w-full focus:outline-none focus:ring-2 focus:ring-blue-400 cursor-not-allowed text-sm md:text-base" value="{{ $user->branch ? $user->branch->location : 'N/A' }}">
                    </div>

                    {{-- USERNAME --}}
                    <div class="flex flex-col mb-3">
                        <label for="username" class="mb-1 font-medium text-sm md:text-base">USERNAME:</label>
                        <input type="text" id="username" readonly class="bg-pink-100 border-2 rounded-full p-2 md:p-2.5 w-full focus:outline-none focus:ring-2 focus:ring-blue-400 cursor-not-allowed text-sm md:text-base" value="{{ $user->username }}">
                    </div>

                    {{-- ROLE --}}
                    <div class="flex flex-col mb-3">
                        <label for="role" class="mb-1 font-medium text-sm md:text-base">ROLE:</label>
                        <input type="text" id="role" readonly class="bg-pink-100 border-2 rounded-full p-2 md:p-2.5 w-full focus:outline-none focus:ring-2 focus:ring-blue-400 cursor-not-allowed text-sm md:text-base" value="{{ ucfirst($user->role) }}">
                    </div>

                    {{-- ACCOUNT STATUS --}}
                    <div class="flex flex-col">
                        <label for="status" class="mb-1 font-medium text-sm md:text-base">ACCOUNT STATUS:</label>
                        <input type="text" id="status" readonly class="bg-pink-100 border-2 rounded-full p-2 md:p-2.5 w-full focus:outline-none focus:ring-2 focus:ring-blue-400 cursor-not-allowed text-sm md:text-base" value="{{ $user->branch && $user->branch->is_active ? 'Active' : 'Inactive' }}">
                    </div>

                </div>
            </div>
        </header>


        <footer class="fixed bottom-0 right-0 p-4 md:p-6">
            <a href="login.html" class="bg-white hover:bg-blue-700 text-black hover:text-white font-medium py-2 px-4 md:py-2.5 md:px-6 rounded-xl shadow text-sm md:text-base inline-block">
                Log Out
            </a>
        </footer>

    </div>
</body>
</html>
