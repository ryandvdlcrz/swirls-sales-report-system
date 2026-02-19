<!DOCTYPE html>
<html lang="en"">
<head>
    <meta charset=" UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Soda Float</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-no-repeat bg-cover bg-center h-screen p-5 font-PP" x-data="{
                flavors: {
                    'Coke / Pepsi': { quantity: 0, },
                    'Mountain Dew / Royal': { quantity: 0, },
                    'Rootbeer / Sarsi': { quantity: 0, },


                },

                showPopup: false,
                popupMessage: '',

                addToCart() {
                    const price = 35; // fixed price
                    let anyAdded = false;

                    for (const [flavorName, data] of Object.entries(this.flavors)) {

                        if (data.quantity > 0) {

                        const item = {
                            name: 'Soda Float',
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
                        this.popupMessage = 'Soda Float added to cart!';
                        this.showPopup = true;
                    } else {
                        this.popupMessage = 'Please select quantity!';
                        this.showPopup = true;
                    }
                    }

                }">


    <h1 class="text-xl max-[780px]:text-sm mb-4 max-[780px]:mb-0">Soda Float Flavors</h1>

    <div class="flex flex-1 space-x-5 overflow-x-auto max-[780px]:justify-start  justify-center  px-2 py-3 no-scrollbar ">

        <!-- Coke / Pepsi -->
        <div class="rounded-2xl" @click="selectedFlavor='Coke / Pepsi'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/cokePepsiSodaFloat.png') }}" alt="Coke / Pepsi" class="-mt-15 ml-7 w-[126px] h-[126px]">

                    <h1 class="text-center -mt-4 max-[780px]:-mt-0 text-lg px-1 max-[780px]:text-sm">
                        Coke / Pepsi
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="">
                    <div class="  p-2 pb-20   ">
                        <div class="flex text-center  items-center border-b-2 border-black/20">

                            <p class=" max-[780px]:text-sm  text-center pr-0.5">₱</p>
                            <p class="max-[780px]:text-sm pr-2 text-center mt-0.5">35</p>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Coke / Pepsi'].quantity > 0) flavors['Coke / Pepsi'].quantity--; 
                    else flavors['Coke / Pepsi'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Coke / Pepsi'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Coke / Pepsi'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">+</button>
                </div>
            </div>
        </div>

        <!-- Mountain Dew / Royal -->
        <div class="rounded-2xl" @click="selectedFlavor='Mountain Dew / Royal'">
            <div class="bg-white w-55 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/mountainDewRoyalSodaFloat.png') }}" alt="Mountain Dew / Royal" class="-mt-15 ml-7 w-[126px] h-[126px]">

                    <h1 class="text-center text-lg -mt-4 max-[780px]:-mt-0 px-1 max-[780px]:text-sm">
                        Mountain Dew / Royal
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="">
                    <div class="  p-2 pb-20   ">
                        <div class="flex text-center  items-center border-b-2 border-black/20">

                            <p class=" max-[780px]:text-sm  text-center pr-0.5">₱</p>
                            <p class="max-[780px]:text-sm pr-2 text-center mt-0.5">35</p>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Mountain Dew / Royal'].quantity > 0) flavors['Mountain Dew / Royal'].quantity--; 
                    else flavors['Mountain Dew / Royal'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Mountain Dew / Royal'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Mountain Dew / Royal'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">+</button>
                </div>
            </div>
        </div>

        <!-- Rootbear / Sarsi -->
        <div class="rounded-2xl" @click="selectedFlavor='Rootbeer / Sarsi'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/rootbearSarsiSodaFloat.png') }}" alt="Rootbeer / Sarsi" class="-mt-15 ml-7 w-[126px] h-[126px]">

                    <h1 class="text-center -mt-4 max-[780px]:-mt-0 text-lg px-1 max-[780px]:text-sm">
                        Rootbeerr / Sarsi
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="">
                    <div class="  p-2 pb-20   ">
                        <div class="flex text-center  items-center border-b-2 border-black/20">

                            <p class=" max-[780px]:text-sm  text-center pr-0.5">₱</p>
                            <p class="max-[780px]:text-sm pr-2 text-center mt-0.5">35</p>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Rootbeer / Sarsi'].quantity > 0) flavors['Rootbeer / Sarsi'].quantity--; 
                    else flavors['Rootbeer / Sarsi'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Rootbeer / Sarsi'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Rootbeer / Sarsi'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">+</button>
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
