<!DOCTYPE html>
<html lang="en" ">
<head>
    <meta charset=" UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vanilla Cone</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-no-repeat bg-cover bg-center h-screen p-5 font-PP" x-data="{
                flavors: {
                    'White Chocolate': { quantity: 0, extra:0 },
                    'Ube': { quantity: 0, extra:0 },
                    'Strawberry': { quantity: 0,  extra:0 },
                    'Chocolate': { quantity: 0,  extra:0 },
                    'Caramel': { quantity: 0,  extra:0 }

                },

                showPopup: false,
                popupMessage: '',

                addToCart() {
                    const basePrice = 15;
                    const extraPrice = 5;
                    let anyAdded = false;

                    for (const [flavorName, data] of Object.entries(this.flavors)) {

                        if (data.quantity > 0) {

                            const totalPrice = (basePrice * data.quantity) + 
                                            (extraPrice * data.extra);

                            const item = {
                                name: 'Vanilla Cone',
                                flavor: flavorName,
                                quantity: data.quantity,
                                dipped: data.extra,
                                price: totalPrice
                            };

                            let cart = JSON.parse(localStorage.getItem('cart')) || [];
                            cart.push(item);
                            localStorage.setItem('cart', JSON.stringify(cart));

                            data.quantity = 0;
                            data.extra = 0;

                            anyAdded = true;
                        }
                    }

                    if (anyAdded) {
                        this.popupMessage = 'Vanilla Cone added to cart!';
                        this.showPopup = true;
                    } else {
                        this.popupMessage = 'Please select quantity!';
                        this.showPopup = true;
                    }
                    }

                }">


    <h1 class="text-xl max-[780px]:text-sm mb-4 max-[780px]:mb-0">Vanilla Cone Flavors</h1>

    <div class="flex flex-1  space-x-5 overflow-x-auto  items-center px-2 py-3 no-scrollbar ">

        <!-- White Chocolate -->
        <div class="rounded-2xl" @click="selectedFlavor='White Chocolate'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/whiteChocolateVaillaCone.png') }}" alt="White Chocolate" class="-mt-15 ml-7 w-[126px] h-[126px]">

                    <h1 class="text-center text-lg px-1 max-[780px]:text-sm">
                        White Chocolate
                    </h1>
                </div>


                <!-- Extra Dipped -->
                <div class="flex justify-center mb-20 mt-2 px-3">

                    <button @click.stop="flavors['White Chocolate'].extra = 
                            flavors['White Chocolate'].extra === 1 ? 0 : 1" :class="flavors['White Chocolate'].extra === 1 
                        ? 'bg-blue-200 text-black' 
                        : 'bg-white text-black'" class="p-2 px-5 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">

                        <div class="text-xs flex items-center space-x-5">
                            <p>+5</p>
                            <p>For Dipped <br>Cone Flavors</p>
                        </div>
                    </button>

                </div>



                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['White Chocolate'].quantity > 0) flavors['White Chocolate'].quantity--; 
                    else flavors['White Chocolate'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['White Chocolate'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['White Chocolate'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">+</button>
                </div>
            </div>
        </div>

        <!-- Ube -->
        <div class="rounded-2xl" @click="selectedFlavor='Ube'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/ubeVaillaCone.png') }}" alt="Ube" class="-mt-15 ml-7 w-[126px] h-[126px]">

                    <h1 class="text-center text-lg px-1 max-[780px]:text-sm">
                        Ube
                    </h1>
                </div>


                <!-- Extra Dipped -->
                <div class="flex justify-center mb-20 mt-2 px-3">

                    <button @click.stop="flavors['Ube'].extra = 
                            flavors['Ube'].extra === 1 ? 0 : 1" :class="flavors['Ube'].extra === 1 
                        ? 'bg-blue-200 text-black' 
                        : 'bg-white text-black'" class="p-2 px-5 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">

                        <div class="text-xs flex items-center space-x-5">
                            <p>+5</p>
                            <p>For Dipped <br>Cone Flavors</p>
                        </div>
                    </button>

                </div>



                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Ube'].quantity > 0) flavors['Ube'].quantity--; 
                    else flavors['Ube'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Ube'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Ube'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">+</button>
                </div>
            </div>
        </div>

        <!-- Strawberry -->
        <div class="rounded-2xl" @click="selectedFlavor='Strawberry'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/strawberryVaillaCone.png') }}" alt="Strawberry" class="-mt-15 ml-7 w-[126px] h-[126px]">

                    <h1 class="text-center text-lg px-1 max-[780px]:text-sm">
                        Strawberry
                    </h1>
                </div>


                <!-- Extra Dipped -->
                <div class="flex justify-center mb-20 mt-2 px-3">

                    <button @click.stop="flavors['Strawberry'].extra = 
                            flavors['Strawberry'].extra === 1 ? 0 : 1" :class="flavors['Strawberry'].extra === 1 
                        ? 'bg-blue-200 text-black' 
                        : 'bg-white text-black'" class="p-2 px-5 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">

                        <div class="text-xs flex items-center space-x-5">
                            <p>+5</p>
                            <p>For Dipped <br>Cone Flavors</p>
                        </div>
                    </button>

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

        <!-- Chocolate -->
        <div class="rounded-2xl" @click="selectedFlavor='Chocolate'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/chocolateVaillaCone.png') }}" alt="Chocolate" class="-mt-15 ml-7 w-[126px] h-[126px]">

                    <h1 class="text-center text-lg px-1 max-[780px]:text-sm">
                        Chocolate
                    </h1>
                </div>


                <!-- Extra Dipped -->
                <div class="flex justify-center mb-20 mt-2 px-3">

                    <button @click.stop="flavors['Chocolate'].extra = 
                            flavors['Chocolate'].extra === 1 ? 0 : 1" :class="flavors['Chocolate'].extra === 1 
                        ? 'bg-blue-200 text-black' 
                        : 'bg-white text-black'" class="p-2 px-5 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">

                        <div class="text-xs flex items-center space-x-5">
                            <p>+5</p>
                            <p>For Dipped <br>Cone Flavors</p>
                        </div>
                    </button>

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

        <!-- Caramel -->
        <div class="rounded-2xl" @click="selectedFlavor='Caramel'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/caramelVaillaCone.png') }}" alt="Caramel" class="-mt-15 ml-7 w-[126px] h-[126px]">

                    <h1 class="text-center text-lg px-1 max-[780px]:text-sm">
                        Caramel
                    </h1>
                </div>


                <!-- Extra Dipped -->
                <div class="flex justify-center mb-20 mt-2 px-3">

                    <button @click.stop="flavors['Caramel'].extra = 
                            flavors['Caramel'].extra === 1 ? 0 : 1" :class="flavors['Caramel'].extra === 1 
                        ? 'bg-blue-200 text-black' 
                        : 'bg-white text-black'" class="p-2 px-5 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">

                        <div class="text-xs flex items-center space-x-5">
                            <p>+5</p>
                            <p>For Dipped <br>Cone Flavors</p>
                        </div>
                    </button>

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
