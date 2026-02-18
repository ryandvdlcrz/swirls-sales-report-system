<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carfait</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-no-repeat bg-cover bg-center h-screen p-5 font-PP" x-data="{
                flavors: {
                    'Blueberry Cheesecake': { quantity: 0, },
                    'Choco Brownie Fudge': { quantity: 0, },
                    'Mango Passion': { quantity: 0, },
                    'Strawberry Stripes': { quantity: 0, },
                    'Ultimate Chocolate': { quantity: 0, }

                },

                showPopup: false,
                popupMessage: '',

                addToCart() {
                    const price = 99; // fixed price
                    let anyAdded = false;

                    for (const [flavorName, data] of Object.entries(this.flavors)) {

                        if (data.quantity > 0) {

                        const item = {
                            name: 'Carfait',
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
                        this.popupMessage = 'Carfait added to cart!';
                        this.showPopup = true;
                    } else {
                        this.popupMessage = 'Please select quantity!';
                        this.showPopup = true;
                    }
                    }

                }">


    <h1 class="text-xl max-[780px]:text-sm mb-4 max-[780px]:mb-0">Carfait Flavors</h1>

    <div class="flex flex-1 space-x-5 overflow-x-auto  items-center px-2 py-3 no-scrollbar ">

        <!-- Blueberry Cheesecake -->
        <div class="rounded-2xl" @click="selectedFlavor='Blueberry Cheesecake'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[145px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/blueberryCheesecakeCarfait.png') }}" alt="Blueberry Cheesecake" class="-mt-15 max-[780px]:-mt-15 ml-7 w-[126px] h-[126px]">

                    <h1 class="text-center text-lg px-1  max-[780px]:-mt-0 -mt-3 max-[780px]:text-sm">
                        Blueberry <br> Cheesecake
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="">
                    <div class="  p-2 pb-20   ">
                        <div class="flex text-center  items-center border-b-2 border-black/20">

                            <p class=" max-[780px]:text-sm  text-center pr-0.5">₱</p>
                            <p class="max-[780px]:text-sm pr-2 text-center mt-0.5">99</p>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Blueberry Cheesecake'].quantity > 0) flavors['Blueberry Cheesecake'].quantity--; 
                    else flavors['Blueberry Cheesecake'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Blueberry Cheesecake'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Blueberry Cheesecake'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">+</button>
                </div>
            </div>
        </div>

        <!-- Choco Brownie Fudge -->
        <div class="rounded-2xl" @click="selectedFlavor='Choco Brownie Fudge'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[145px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/chocoBrownieFudgeCarfait.png') }}" alt="Choco Brownie Fudge" class="-mt-15 max-[780px]:-mt-15 ml-7 w-[126px] h-[126px]">

                    <h1 class="text-center text-lg px-1  max-[780px]:-mt-0 -mt-3 max-[780px]:text-sm">
                        Choco Brownie <br> Fudge
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="">
                    <div class="  p-2 pb-20   ">
                        <div class="flex text-center  items-center border-b-2 border-black/20">

                            <p class=" max-[780px]:text-sm  text-center pr-0.5">₱</p>
                            <p class="max-[780px]:text-sm pr-2 text-center mt-0.5">99</p>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Choco Brownie Fudge'].quantity > 0) flavors['Choco Brownie Fudge'].quantity--; 
                    else flavors['Choco Brownie Fudge'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Choco Brownie Fudge'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Choco Brownie Fudge'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">+</button>
                </div>
            </div>
        </div>

        <!-- Mango Passion -->
        <div class="rounded-2xl" @click="selectedFlavor='Mango Passion'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[145px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/mangoPassionCarfait.png') }}" alt="Mango Passion" class="-mt-15 max-[780px]:-mt-15 ml-7 w-[126px] h-[126px]">

                    <h1 class="text-center text-lg px-1  max-[780px]:-mt-0 -mt-3 max-[780px]:text-sm">
                        Mango <br> Passion
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="">
                    <div class="  p-2 pb-20   ">
                        <div class="flex text-center  items-center border-b-2 border-black/20">

                            <p class=" max-[780px]:text-sm  text-center pr-0.5">₱</p>
                            <p class="max-[780px]:text-sm pr-2 text-center mt-0.5">99</p>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Mango Passion'].quantity > 0) flavors['Mango Passion'].quantity--; 
                    else flavors['Mango Passion'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Mango Passion'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Mango Passion'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">+</button>
                </div>
            </div>
        </div>

        <!-- Strawberry Stripes -->
        <div class="rounded-2xl" @click="selectedFlavor='Strawberry Stripes'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[145px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/straberryStripesCarfait.png') }}" alt="Strawberry Stripes" class="-mt-15 max-[780px]:-mt-15 ml-7 w-[126px] h-[126px]">

                    <h1 class="text-center text-lg px-1  max-[780px]:-mt-0 -mt-3 max-[780px]:text-sm">
                        Strawberry <br> Stripes
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="">
                    <div class="  p-2 pb-20   ">
                        <div class="flex text-center  items-center border-b-2 border-black/20">

                            <p class=" max-[780px]:text-sm  text-center pr-0.5">₱</p>
                            <p class="max-[780px]:text-sm pr-2 text-center mt-0.5">99</p>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Strawberry Stripes'].quantity > 0) flavors['Strawberry Stripes'].quantity--; 
                    else flavors['Strawberry Stripes'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Strawberry Stripes'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Strawberry Stripes'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">+</button>
                </div>
            </div>
        </div>

        <!-- Ultimate Chocolate -->
        <div class="rounded-2xl" @click="selectedFlavor='Ultimate Chocolate'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[145px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/ultimateChocolateCarfait.png') }}" alt="Ultimate Chocolate" class="-mt-15 max-[780px]:-mt-15 ml-7 w-[126px] h-[126px]">

                    <h1 class="text-center text-lg px-1  max-[780px]:-mt-0 -mt-3 max-[780px]:text-sm">
                        Ultimate <br> Chocolate
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="">
                    <div class="  p-2 pb-20   ">
                        <div class="flex text-center  items-center border-b-2 border-black/20">

                            <p class=" max-[780px]:text-sm  text-center pr-0.5">₱</p>
                            <p class="max-[780px]:text-sm pr-2 text-center mt-0.5">99</p>
                        </div>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Ultimate Chocolate'].quantity > 0) flavors['Ultimate Chocolate'].quantity--; 
                    else flavors['Ultimate Chocolate'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Ultimate Chocolate'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Ultimate Chocolate'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">+</button>
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
