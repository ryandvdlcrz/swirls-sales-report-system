<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting ni Manong Sorbetero</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body>

    <!--background-->
    <div class="min-h-screen m-0 p-0 bg-no-repeat bg-cover bg-center" style="background-image: url('img/settings_sales_ordererzxs.png');">

        <header class="flex items-start justify-between px-4 pt-4">

            <div>
                <div class="text-3xl font-medium p-6">Settings</div>
                <nav>
                    <ul class="font-medium text-xl p-6">
                        <li class="mb-7"><a href="{{route('menu.index')}}">Menu</a></li>
                        <li class="mb-7"><a href="{{route('settings.account')}}">Account detail</a></li>
                        <li class="mb-7"><a href="{{route('settings.get_help')}}">Get help</a></li>
                    </ul>
                </nav>
            </div>

            <div class="p-4">
                <img src="img/pic ni admin.jpg" alt="user" class="rounded-full md:block w-17">
            </div>
        </header>


        <footer class="absolute bottom-0 right-0 p-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-white hover:bg-blue-700 text-black hover:text-white font-medium py-2 px-4 rounded-xl shadow">
                    Log Out
                </button>
            </form>
        </footer>

    </div>
</body>
</html>
