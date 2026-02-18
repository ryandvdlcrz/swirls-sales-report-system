<!DOCTYPE html>
<html lang="en" ">
<head>
    <meta charset=" UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Milkshake</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-no-repeat bg-cover bg-center h-screen p-5 font-PP" x-data="{
                flavors: {
                  'Choco Brownie Fudge': { quantity: 0, selectedSize: '' },
                  'Coffee Banana': { quantity: 0, selectedSize: '' },
                  'Mango Graham': { quantity: 0, selectedSize: '' },
                  'Oreo Chocolate': { quantity: 0, selectedSize: '' },
                  'Oreo Strawberry': { quantity: 0, selectedSize: '' },
                  'Oreo Vanilla': { quantity: 0, selectedSize: '' },
                },

                showPopup: false,
                popupMessage: '',

                displaySizes: { Small: '8oz',  Large: '16oz'},

                addToCart() {
                  const prices = { Small: 65.00,  Large: 80.00 };
                  let anyAdded = false;

                  for (const [flavorName, data] of Object.entries(this.flavors)) {
                    if (data.selectedSize && data.quantity > 0) {
                      const price = prices[data.selectedSize];

                      const item = {
                        name: 'Milkshake',
                        flavor: flavorName,
                        size: data.selectedSize,
                        quantity: data.quantity,
                        price: price
                      };

                      let cart = JSON.parse(localStorage.getItem('cart')) || [];
                      cart.push(item);
                      localStorage.setItem('cart', JSON.stringify(cart));

                      data.quantity = 0;
                      data.selectedSize = '';
                      anyAdded = true;
                    }
                  }

                  if (anyAdded) {
                    this.popupMessage = ' Milkshake Items added to cart!';
                    this.showPopup = true;
                  } else {
                    this.popupMessage = 'Please select size and quantity!';
                    this.showPopup = true;
                  }
                }
              }">

    <h1 class="text-xl max-[780px]:text-sm mb-4 max-[780px]:mb-0">Milkshake Flavors</h1>

    <div class="flex flex-1 space-x-5 overflow-x-auto items-start px-2 py-3 no-scrollbar">

        <!-- Choco Brownie Fudge -->
        <div class="rounded-2xl" @click="selectedFlavor='Choco Brownie Fudge'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/chocoBrownieFudgeMilkshake.png') }}" alt="Choco Brownie Fudge" class="-mt-15 ml-7 w-[126px] h-[126px]">
                    <h1 class="text-center text-lg px-3  max-[780px]:-mt-0 -mt-4 max-[780px]:text-sm">
                        Choco Brownie <br> Fudge
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="space-y-3 max-[780px]:space-y-2 mb-11">
                    <template x-for="size in ['Small','Large']" :key="size">
                        <div>
                            <div @click.stop="
                      flavors['Choco Brownie Fudge'].selectedSize === size
                          ? flavors['Choco Brownie Fudge'].selectedSize = ''
                          : flavors['Choco Brownie Fudge'].selectedSize = size" :class="flavors['Choco Brownie Fudge'].selectedSize === size ? 'bg-blue-200' : ''" class="p-2 px-10 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">
                                <div class="flex items-center">
                                    <h1 class="max-[780px]:text-sm pr-2 text-center" x-text="size + ':'"></h1>
                                    <p class="pr-0.5">₱</p>
                                    <p class="text-xs mt-0.5" x-text="size==='Small'?65:80"></p>
                                </div>
                            </div>
                        </div>
                    </template>
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

                    <button @click.stop="flavors['Choco Brownie Fudge'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        +
                    </button>
                </div>
            </div>
        </div>

        <!-- Coffee Banana -->
        <div class="rounded-2xl" @click="selectedFlavor='Coffee Banana'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/coffeeBananaMilkshake.png') }}" alt="Coffee Banana" class="-mt-15 ml-7 w-[126px] h-[126px]">
                    <h1 class="text-center text-lg px-3  max-[780px]:-mt-0 -mt-4 max-[780px]:text-sm">
                        Choco Brownie <br> Fudge
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="space-y-3 max-[780px]:space-y-2 mb-11">
                    <template x-for="size in ['Small','Large']" :key="size">
                        <div>
                            <div @click.stop="
                      flavors['Coffee Banana'].selectedSize === size
                          ? flavors['Coffee Banana'].selectedSize = ''
                          : flavors['Coffee Banana'].selectedSize = size" :class="flavors['Coffee Banana'].selectedSize === size ? 'bg-blue-200' : ''" class="p-2 px-10 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">
                                <div class="flex items-center">
                                    <h1 class="max-[780px]:text-sm pr-2 text-center" x-text="size + ':'"></h1>
                                    <p class="pr-0.5">₱</p>
                                    <p class="text-xs mt-0.5" x-text="size==='Small'?65:80"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Coffee Banana'].quantity > 0) flavors['Coffee Banana'].quantity--; 
                  else flavors['Coffee Banana'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Coffee Banana'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Coffee Banana'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        +
                    </button>
                </div>
            </div>
        </div>

        <!-- Mango Graham -->
        <div class="rounded-2xl" @click="selectedFlavor='Mango Graham'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/mangoGrahamMilkshake.png') }}" alt="Mango Graham" class="-mt-15 ml-7 w-[126px] h-[126px]">
                    <h1 class="text-center text-lg px-3  max-[780px]:-mt-0 -mt-4 max-[780px]:text-sm">
                        Mango <br>Graham
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="space-y-3 max-[780px]:space-y-2 mb-11">
                    <template x-for="size in ['Small','Large']" :key="size">
                        <div>
                            <div @click.stop="
                      flavors['Mango Graham'].selectedSize === size
                          ? flavors['Mango Graham'].selectedSize = ''
                          : flavors['Mango Graham'].selectedSize = size" :class="flavors['Mango Graham'].selectedSize === size ? 'bg-blue-200' : ''" class="p-2 px-10 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">
                                <div class="flex items-center">
                                    <h1 class="max-[780px]:text-sm pr-2 text-center" x-text="size + ':'"></h1>
                                    <p class="pr-0.5">₱</p>
                                    <p class="text-xs mt-0.5" x-text="size==='Small'?65:80"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Mango Graham'].quantity > 0) flavors['Mango Graham'].quantity--; 
                  else flavors['Mango Graham'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Mango Graham'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Mango Graham'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        +
                    </button>
                </div>
            </div>
        </div>

        <!-- Oreo Chocolate -->
        <div class="rounded-2xl" @click="selectedFlavor='Oreo Chocolate'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/oreoChocolateMilkshake.png') }}" alt="Oreo Chocolate" class="-mt-15 ml-7 w-[126px] h-[126px]">
                    <h1 class="text-center text-lg px-3  max-[780px]:-mt-0 -mt-4 max-[780px]:text-sm">
                        Oreo <br> Chocolate
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="space-y-3 max-[780px]:space-y-2 mb-11">
                    <template x-for="size in ['Small','Large']" :key="size">
                        <div>
                            <div @click.stop="
                      flavors['Oreo Chocolate'].selectedSize === size
                          ? flavors['Oreo Chocolate'].selectedSize = ''
                          : flavors['Oreo Chocolate'].selectedSize = size" :class="flavors['Oreo Chocolate'].selectedSize === size ? 'bg-blue-200' : ''" class="p-2 px-10 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">
                                <div class="flex items-center">
                                    <h1 class="max-[780px]:text-sm pr-2 text-center" x-text="size + ':'"></h1>
                                    <p class="pr-0.5">₱</p>
                                    <p class="text-xs mt-0.5" x-text="size==='Small'?65:80"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Oreo Chocolate'].quantity > 0) flavors['Oreo Chocolate'].quantity--; 
                  else flavors['Oreo Chocolate'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Oreo Chocolate'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Oreo Chocolate'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        +
                    </button>
                </div>
            </div>
        </div>

        <!-- Oreo Strawberry -->
        <div class="rounded-2xl" @click="selectedFlavor='Oreo Strawberry'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/oreoStrawberryMilkshake.png') }}" alt="Oreo Strawberry" class="-mt-15 ml-7 w-[126px] h-[126px]">
                    <h1 class="text-center text-lg px-3  max-[780px]:-mt-0 -mt-4 max-[780px]:text-sm">
                        Oreo <br> Strawberry
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="space-y-3 max-[780px]:space-y-2 mb-11">
                    <template x-for="size in ['Small','Large']" :key="size">
                        <div>
                            <div @click.stop="
                      flavors['Oreo Strawberry'].selectedSize === size
                          ? flavors['Oreo Strawberry'].selectedSize = ''
                          : flavors['Oreo Strawberry'].selectedSize = size" :class="flavors['Oreo Strawberry'].selectedSize === size ? 'bg-blue-200' : ''" class="p-2 px-10 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">
                                <div class="flex items-center">
                                    <h1 class="max-[780px]:text-sm pr-2 text-center" x-text="size + ':'"></h1>
                                    <p class="pr-0.5">₱</p>
                                    <p class="text-xs mt-0.5" x-text="size==='Small'?65:80"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Oreo Strawberry'].quantity > 0) flavors['Oreo Strawberry'].quantity--; 
                  else flavors['Oreo Strawberry'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Oreo Strawberry'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Oreo Strawberry'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        +
                    </button>
                </div>
            </div>
        </div>

        <!-- Oreo Vanilla -->
        <div class="rounded-2xl" @click="selectedFlavor='Oreo Vanilla'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/oreoVanillaMilkshake.png') }}" alt="Oreo Vanilla" class="-mt-15 ml-7 w-[126px] h-[126px]">
                    <h1 class="text-center text-lg px-3  max-[780px]:-mt-0 -mt-4 max-[780px]:text-sm">
                        Oreo <br> Strawberry
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="space-y-3 max-[780px]:space-y-2 mb-11">
                    <template x-for="size in ['Small','Large']" :key="size">
                        <div>
                            <div @click.stop="
                      flavors['Oreo Vanilla'].selectedSize === size
                          ? flavors['Oreo Vanilla'].selectedSize = ''
                          : flavors['Oreo Vanilla'].selectedSize = size" :class="flavors['Oreo Vanilla'].selectedSize === size ? 'bg-blue-200' : ''" class="p-2 px-10 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">
                                <div class="flex items-center">
                                    <h1 class="max-[780px]:text-sm pr-2 text-center" x-text="size + ':'"></h1>
                                    <p class="pr-0.5">₱</p>
                                    <p class="text-xs mt-0.5" x-text="size==='Small'?65:80"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Oreo Vanilla'].quantity > 0) flavors['Oreo Vanilla'].quantity--; 
                  else flavors['Oreo Vanilla'].quantity=0" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Oreo Vanilla'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Oreo Vanilla'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        +
                    </button>
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
