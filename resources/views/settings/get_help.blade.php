<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> tulong ni Manong Sorbetero</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body>

 <!--background-->
    <div class="min-h-screen m-0 p-0 bg-no-repeat bg-cover bg-center" style="background-image: url({{asset('img/settings_sales_ordererzxs.png')}});">


    <header class="flex items-start flex-col px-4 pt-4">

        
            
            <div class=" container flex-wrap flex items-center justify-between">
                <div class="text-3xl font-medium p-6">Settings </div>
                <div class="flex">
                <img src="{{asset('img/pic ni admin.jpg')}}" alt="user" class="rounded-full md:block w-17 ">

                </div>
            </div>

            <div class="flex  ">
                <nav>
                    <ul class="font-medium text-xl p-6">
                        <li class="mb-7 pe-20"><a href="{{route('menu.index')}}">Menu</a></li>
                        <li class="mb-7" ><a href="{{route('settings.account')}}">Account detail</a></li>
                        <li class="mb-7 border-1  px-2 rounded-2xl"><a href="{{route('settings.get_help')}}">Get help</a></li>
                    </ul>
                </nav>
                
                <div class="bg-pink-100/60 flex flex-wrap flex-col gap-10 rounded-2xl  shadow-2xl p-6 pe-10">
                    
                    <div class="flex flex-wrap">
                        <h1 class="font-semibold mb-7 text-2xl">Get Help</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem beatae cum ipsum sint eveniet odio perspiciatis quia iste ad eaque est error amet animi itaque magnam nesciunt qui, repellendus molestiae. </p></div>
                </div>
            </div>
        
        

       
    </header>


    <footer class="absolute bottom-0 right-0 p-6">
        <a href="login.html" class="bg-white hover:bg-blue-700 text-black hover:text-white font-medium py-2 px-4 rounded-xl shadow">
            Log Out 
        </a>
    </footer>

</div>
</body>
</html>
