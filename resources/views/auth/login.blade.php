
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swirls Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
   

<body >
    <div class="min-h-screen bg-no-repeat bg-cover bg-center flex justify-center "
style="background-image: url('{{asset('img/Login_dashboard.png')}}');">

     <div class="grid  md:grid-cols-2  min-h-screen  flex-wrap flex-col items-center justify-center  ">

        <div class="flex items-center p-8 justify-end">
        <img src="{{asset('img/swirls-logo.webp')}}" alt="Swirls Logo" class="w-50 md:w-65  mr-6 mt-[30%]  ">

        </div>

        <div class="flex flex-col items-start justify-center w-full px-2">
            
            <div class="flex flex-col flex-wrap items-center justify-center ps-8 mb-6">
            <img src="{{asset('img/logo-1.png')}}" alt="mini logo" class="hidden md:block w-16 ">

            <h2 class="text-2xl font-semibold text-center ps-6 mr-13 ">Welcome to Swirls!</h2>
            </div>

            @if ($errors->any())
            <div class="mb-4 p-2 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route ('login')}}" method="POST" class="w-full max-w-xs space-y-4" class="w-full max-w-xs space-y-4">
                @csrf
                <div class="flex flex-col">
                <label for="username" class="mb-1 font-medium">Username:</label>
                <input type="text" id="username" required name="username"
                    class="bg-white border-2 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter your username">
                </div>

                <div class="flex flex-col">
                <label for="password" class="mb-1 font-medium">Password:</label>
                <input type="password" id="password" required name="password"
                    class="bg-white border-2 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Enter your password">
                </div>

                <button type="submit"
                class="w-full bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition mt-4 font-semibold tracking-wide">Log In</button><a href="index.html"></a>
            </form>
        </div>
  </div>
    </div>
</body>
</html>