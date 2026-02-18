<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sundae Cone</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-no-repeat bg-cover bg-center h-screen p-5 font-PP" x-data="{
                flavors: {
                    'Blueberry': { quantity: 0, },
                    'Caramel': { quantity: 0, },
                    'Chocolate': { quantity: 0, },
                    'Mango': { quantity: 0, },
                    'Strawberry': { quantity: 0, }

                },

                showPopup: false,
                popupMessage: '',

                addToCart() {
                    const price = 25; // fixed price
                    let anyAdded = false;

                    for (const [flavorName, data] of Object.entries(this.flavors)) {

                        if (data.quantity > 0) {

                        const item = {
                            name: 'Sundae Cone',
                            flavor: flavorName,
                            quantity: data.quantity,
                            price: price,

                        };

                        let cart = JSON.parse(localStorage.getItem('cart')) || [];
                        cart.push(item);
                        localStorage.setItem('cart', JSON.stringify(cart));

                        data.quantity = 0;
                        anyAdded = true;
                        }
                    }

                    if (anyAdded) {
                        this.popupMessage = 'Sundae Cone added to cart!';
                        this.showPopup = true;
                    } else {
                        this.popupMessage = 'Please select quantity!';
                        this.showPopup = true;
                    }
                    }

                }">


    <h1 class="text-xl max-[780px]:text-sm mb-4 max-[780px]:mb-0">Sundae Cone Flavors</h1>

    <div class="flex flex-1 space-x-5 overflow-x-auto  items-center px-2 py-3 no-scrollbar ">

        <!-- Blueberry -->
        <div class="rounded-2xl" @click="selectedFlavor='Blueberry'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/blueberrySundaeCone.png') }}" alt="Blueberry" class="-mt-15 ml-2 w-[126px] h-[126px]">

                    <h1 class="text-center text-lg px-1 max-[780px]:text-sm">
                        Blueberry
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="">
                    <div class="  p-2 pb-20   ">
                        <div class="flex text-center  items-center border-b-2 border-black/20">

                            <p class=" max-[780px]:text-sm  text-center pr-0.5">₱</p>
                            <p class="max-[780px]:text-sm pr-2 text-center mt-0.5">25</p>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Blueberry'].quantity > 0) flavors['Blueberry'].quantity--; 
                    else flavors['Blueberry'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Blueberry'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Blueberry'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">+</button>
                </div>
            </div>
        </div>

        <!-- Caramel -->
        <div class="rounded-2xl" @click="selectedFlavor='Caramel'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/caramelSundaeCone.png') }}" alt="Caramel" class="-mt-15 ml-2 w-[126px] h-[126px]">

                    <h1 class="text-center text-lg px-1 max-[780px]:text-sm">
                        Caramel
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="">
                    <div class="  p-2 pb-20   ">
                        <div class="flex text-center  items-center border-b-2 border-black/20">

                            <p class=" max-[780px]:text-sm  text-center pr-0.5">₱</p>
                            <p class="max-[780px]:text-sm pr-2 text-center mt-0.5">25</p>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Caramel'].quantity > 0) flavors['Caramel'].quantity--; 
                    else flavors['Caramel'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Caramel'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Caramel'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">+</button>
                </div>
            </div>
        </div>

        <!-- Chocolate -->
        <div class="rounded-2xl" @click="selectedFlavor='Chocolate'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/chocolateSundaeCone.png') }}" alt="Chocolate" class="-mt-15 ml-2 w-[126px] h-[126px]">

                    <h1 class="text-center text-lg px-1 max-[780px]:text-sm">
                        Chocolate
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="">
                    <div class="  p-2 pb-20   ">
                        <div class="flex text-center  items-center border-b-2 border-black/20">

                            <p class=" max-[780px]:text-sm  text-center pr-0.5">₱</p>
                            <p class="max-[780px]:text-sm pr-2 text-center mt-0.5">25</p>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Chocolate'].quantity > 0) flavors['Chocolate'].quantity--; 
                    else flavors['Chocolate'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Chocolate'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Chocolate'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">+</button>
                </div>
            </div>
        </div>

        <!-- Mango -->
        <div class="rounded-2xl" @click="selectedFlavor='Mango'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/mangoSundaeCone.png') }}" alt="Mango" class="-mt-15 ml-2 w-[126px] h-[126px]">

                    <h1 class="text-center text-lg px-1 max-[780px]:text-sm">
                        Mango
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="">
                    <div class="  p-2 pb-20   ">
                        <div class="flex text-center  items-center border-b-2 border-black/20">

                            <p class=" max-[780px]:text-sm  text-center pr-0.5">₱</p>
                            <p class="max-[780px]:text-sm pr-2 text-center mt-0.5">25</p>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Mango'].quantity > 0) flavors['Mango'].quantity--; 
                    else flavors['Mango'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Mango'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Mango'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">+</button>
                </div>
            </div>
        </div>

        <!-- Strawberry -->
        <div class="rounded-2xl" @click="selectedFlavor='Strawberry'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/strawberrySundaeCone.png') }}" alt="Strawberry" class="-mt-15 ml-2 w-[126px] h-[126px]">

                    <h1 class="text-center text-lg px-1 max-[780px]:text-sm">
                        Strawberry
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="">
                    <div class="  p-2 pb-20   ">
                        <div class="flex text-center  items-center border-b-2 border-black/20">

                            <p class=" max-[780px]:text-sm  text-center pr-0.5">₱</p>
                            <p class="max-[780px]:text-sm pr-2 text-center mt-0.5">25</p>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Strawberry'].quantity > 0) flavors['Strawberry'].quantity--; 
                    else flavors['Strawberry'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Strawberry'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Strawberry'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">+</button>
                </div>
            </div>
        </div>

    </div>

    <!-- Add to Cart -->
    <div class="shrink-0 pb-1 flex float-right pt-1 ">
        <button class="active:scale-95" @click="addToCart()">
            <img src="{{ asset('img/addToOrderBtn.png') }}" alt="Add to Button" class="w-[130px] h-[40px]">
        </button>
    </div>

    <!-- Custom Popup Modal -->
    <div x-show="showPopup" x-transition class="fixed inset-0 flex items-center justify-center bg-black/40 z-50" style="display: none;">

        <div class="bg-white rounded-2xl shadow-xl w-[300px] p-6 text-center animate-popup">

            <h2 class="text-lg font-bold mb-3">Notification</h2>

            <p class="text-sm mb-5" x-text="popupMessage"></p>

            <button @click="showPopup = false" class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full active:scale-95 transition">
                OK
            </button>

        </div>
    </div>


</body>
</html>
