<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swirls Home</title>

    <link rel="stylesheet" href="{{asset('css/output.css')}}">
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body>

    <!--background-->
    <div class="min-h-screen m-0 p-0 bg-no-repeat bg-cover bg-center flex flex-col items-center justify-center gap-16 flex-wrap font-PP" style="background-image: url('img/home.png');">

        <header>
            <!--Option to-->
            <div class="container flex items-center justify-center flex-wrap gap-2">

                <!--logo-->
                <div class="flex items-center justify-center">
                    <a href="{{ route ('index') }}"><img src="{{ asset('img/swirls-logo.webp') }}" alt="logo" class="w-40 sm:w-32 md:w-20 "></a>
                </div>

                <!--background nung options-->
                <div class="flex items-center justify-between bg-white rounded-xl p-2.5 shadow-md ">

                    <!--eto na talaga mga option ahahaha-->
                    <div class="w-full lg:w-auto flex justify-center items-center">
                        <div class="flex flex-wrap justify-center gap-4  rounded font-[550] ">

                            <button class="bg-red-200 shadow active:scale-95 text-white font-bold px-5 py-2 rounded-full"><a href="{{ route('index') }}">Home</a></button>
                            <button class="hover:bg-red-200 shadow active:scale-95 text-red-300 px-5 py-2 rounded-full"><a href="{{ route('menu.index') }}">Menu</a></button>
                            <button class="hover:bg-red-200 shadow active:scale-95 text-red-300 px-5 py-2 rounded-full"><a href="{{ route('sales.index') }}">Sales</a></button>
                            <button class="hover:bg-red-200 shadow active:scale-95 text-red-300 px-5 py-2 rounded-full"><a href="{{ route('settings.index') }}">Settings</a></button>

                        </div>

                    </div>

                </div>
        </header>

        <main>
            <div class=" flex items-center space-x-10  flex-wrap justify-center pl-8">

                <!--description to ahahaha-->
                <div class="rounded-3xl p-6  shadow-xl text-center  md:w-100 bg-white/60 text-black  mb-6 ">

                    <h1 class="text-2xl font-semibold text-black mb-6">We Serve <br>Happiness!!</h1>

                    <p class="text-center md:text-center">Come swirl with us at Swirls Ice Cream, and let the magic of our soft-served ice cream create moments of happiness, one scoop at a time.</p>
                </div>
                <div class="w-60 md:w-70 pr-4s ">
                    <img src="{{ asset('img/items.png') }}" alt="items">
                </div>
            </div>
        </main>

    </div>

</body>
</html>
