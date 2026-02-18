<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DayDream Premium</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-no-repeat bg-cover bg-center h-screen p-5 font-PP" x-data="{
                flavors: {
                  'Chocolate Almond Fudge': { quantity: 0, selectedSize: '' },
                  'M&M Brownie Fudge': { quantity: 0, selectedSize: '' },
                  'Mango Banana Twist': { quantity: 0, selectedSize: '' },
                  'Strawberry Banana': { quantity: 0, selectedSize: '' },
                  'Vanilla Almond Fudge': { quantity: 0, selectedSize: '' },
                  'Very Rocky Road': { quantity: 0, selectedSize: '' },
                },

                showPopup: false,
                popupMessage: '',

                displaySizes: { Small: '8oz', Medium: '12oz', Large: '16oz'},

                addToCart() {
                  const prices = { Small: 69.00, Medium: 85.00, Large: 99.00 };
                  let anyAdded = false;

                  for (const [flavorName, data] of Object.entries(this.flavors)) {
                    if (data.selectedSize && data.quantity > 0) {
                      const price = prices[data.selectedSize];

                      const item = {
                        name: 'DayDream Premium',
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
                    this.popupMessage = 'DayDream Premium Items added to cart!';
                    this.showPopup = true;
                  } else {
                    this.popupMessage = 'Please select size and quantity!';
                    this.showPopup = true;
                  }
                }
              }">

    <h1 class="text-xl max-[780px]:text-sm mb-4 max-[780px]:mb-0">DayDream Premium Flavors</h1>

    <div class="flex flex-1 space-x-5 overflow-x-auto items-start px-2 py-2 no-scrollbar">

        <!-- Chocolate Almond Fudge -->
        <div class="rounded-2xl" @click="selectedFlavor='Chocolate Almond Fudge'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/chocolateAlmondFudgeDayDreamPremium.png') }}" alt="Chocolate Almond Fudge" class="-mt-15 ml-9 max-[780px]:ml-5 w-[126px] h-[126px]">
                    <h1 class="text-center text-lg px-2 -mt-3 max-[780px]:-mt-1 max-[780px]:text-sm">
                        Chocolate <br> Almond Fudge
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="space-y-3 max-[780px]:space-y-2">
                    <template x-for="size in ['Small','Medium','Large']" :key="size">
                        <div>
                            <div @click.stop="
                      flavors['Chocolate Almond Fudge'].selectedSize === size
                          ? flavors['Chocolate Almond Fudge'].selectedSize = ''
                          : flavors['Chocolate Almond Fudge'].selectedSize = size" :class="flavors['Chocolate Almond Fudge'].selectedSize === size ? 'bg-blue-200' : ''" class="p-2 px-10 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">
                                <div class="flex items-center">
                                    <h1 class="max-[780px]:text-sm pr-2 text-center" x-text="size + ':'"></h1>
                                    <p class="pr-0.5">₱</p>
                                    <p class="text-xs mt-0.5" x-text="size==='Small'?69:size==='Medium'?85:99"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Chocolate Almond Fudge'].quantity > 1) flavors['Chocolate Almond Fudge'].quantity--; 
                  else flavors['Chocolate Almond Fudge'].quantity=1" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Chocolate Almond Fudge'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Chocolate Almond Fudge'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        +
                    </button>
                </div>
            </div>
        </div>

        <!-- M&M Brownie Fudge -->
        <div class="rounded-2xl" @click="selectedFlavor='M&M Brownie Fudge'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/mmBrownieFudgeDayDreamPremium.png') }}" alt="M&M Brownie Fudge" class="-mt-15 ml-6 max-[780px]:ml-5 w-[126px] h-[126px]">
                    <h1 class="text-center text-lg px-6 -mt-3 max-[780px]:-mt-1 max-[780px]:text-sm">
                        M&M <br> Brownie Fudge
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="space-y-3 max-[780px]:space-y-2">
                    <template x-for="size in ['Small','Medium','Large']" :key="size">
                        <div>
                            <div @click.stop="
                      flavors['M&M Brownie Fudge'].selectedSize === size
                          ? flavors['M&M Brownie Fudge'].selectedSize = ''
                          : flavors['M&M Brownie Fudge'].selectedSize = size" :class="flavors['M&M Brownie Fudge'].selectedSize === size ? 'bg-blue-200' : ''" class="p-2 px-10 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">
                                <div class="flex items-center">
                                    <h1 class="max-[780px]:text-sm pr-2 text-center" x-text="size + ':'"></h1>
                                    <p class="pr-0.5">₱</p>
                                    <p class="text-xs mt-0.5" x-text="size==='Small'?69:size==='Medium'?85:99"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['M&M Brownie Fudge'].quantity > 1) flavors['M&M Brownie Fudge'].quantity--; 
                  else flavors['M&M Brownie Fudge'].quantity=1" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['M&M Brownie Fudge'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['M&M Brownie Fudge'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        +
                    </button>
                </div>
            </div>
        </div>

        <!-- Mango Banana Twist -->
        <div class="rounded-2xl" @click="selectedFlavor='Mango Banana Twist'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/mangoBananaTwistDayDreamPremium.png') }}" alt="Mango Banana Twist" class="-mt-15 ml-7 max-[780px]:ml-5 w-[126px] h-[126px]">
                    <h1 class="text-center text-lg px-5 -mt-3 max-[780px]:-mt-1 max-[780px]:text-sm">
                        Mango Banana <br> Twist
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="space-y-3 max-[780px]:space-y-2">
                    <template x-for="size in ['Small','Medium','Large']" :key="size">
                        <div>
                            <div @click.stop="
                      flavors['Mango Banana Twist'].selectedSize === size
                          ? flavors['Mango Banana Twist'].selectedSize = ''
                          : flavors['Mango Banana Twist'].selectedSize = size" :class="flavors['Mango Banana Twist'].selectedSize === size ? 'bg-blue-200' : ''" class="p-2 px-10 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">
                                <div class="flex items-center">
                                    <h1 class="max-[780px]:text-sm pr-2 text-center" x-text="size + ':'"></h1>
                                    <p class="pr-0.5">₱</p>
                                    <p class="text-xs mt-0.5" x-text="size==='Small'?69:size==='Medium'?85:99"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Mango Banana Twist'].quantity > 1) flavors['Mango Banana Twist'].quantity--; 
                  else flavors['Mango Banana Twist'].quantity=1" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Mango Banana Twist'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Mango Banana Twist'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        +
                    </button>
                </div>
            </div>
        </div>

        <!-- Strawberry Banana -->
        <div class="rounded-2xl" @click="selectedFlavor='Strawberry Banana'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/strawberryBananaDayDreamPremium.png') }}" alt="Strawberry Banana" class="-mt-15 ml-6 max-[780px]:ml-5 w-[126px] h-[126px]">
                    <h1 class="text-center text-lg px-9 -mt-3 max-[780px]:-mt-1 max-[780px]:text-sm">
                        Strawberry <br> Banana
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="space-y-3 max-[780px]:space-y-2">
                    <template x-for="size in ['Small','Medium','Large']" :key="size">
                        <div>
                            <div @click.stop="
                      flavors['Strawberry Banana'].selectedSize === size
                          ? flavors['Strawberry Banana'].selectedSize = ''
                          : flavors['Strawberry Banana'].selectedSize = size" :class="flavors['Strawberry Banana'].selectedSize === size ? 'bg-blue-200' : ''" class="p-2 px-10 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">
                                <div class="flex items-center">
                                    <h1 class="max-[780px]:text-sm pr-2 text-center" x-text="size + ':'"></h1>
                                    <p class="pr-0.5">₱</p>
                                    <p class="text-xs mt-0.5" x-text="size==='Small'?69:size==='Medium'?85:99"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Strawberry Banana'].quantity > 1) flavors['Strawberry Banana'].quantity--; 
                  else flavors['Strawberry Banana'].quantity=1" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Strawberry Banana'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Strawberry Banana'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        +
                    </button>
                </div>
            </div>
        </div>

        <!-- Vanilla Almond Fudge -->
        <div class="rounded-2xl" @click="selectedFlavor='Vanilla Almond Fudge'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/vanillaAlmondFudgeDayDreamPremium.png') }}" alt="Vanilla Almond Fudge" class="-mt-15 ml-6 max-[780px]:ml-7 w-[126px] h-[126px]">
                    <h1 class="text-center text-lg px-5 max-[780px]:px-8 -mt-3 max-[780px]:-mt-1 max-[780px]:text-sm">
                        Vanilla <br> Almond Fudge
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="space-y-3 max-[780px]:space-y-2">
                    <template x-for="size in ['Small','Medium','Large']" :key="size">
                        <div>
                            <div @click.stop="
                      flavors['Vanilla Almond Fudge'].selectedSize === size
                          ? flavors['Vanilla Almond Fudge'].selectedSize = ''
                          : flavors['Vanilla Almond Fudge'].selectedSize = size" :class="flavors['Vanilla Almond Fudge'].selectedSize === size ? 'bg-blue-200' : ''" class="p-2 px-10 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">
                                <div class="flex items-center">
                                    <h1 class="max-[780px]:text-sm pr-2 text-center" x-text="size + ':'"></h1>
                                    <p class="pr-0.5">₱</p>
                                    <p class="text-xs mt-0.5" x-text="size==='Small'?69:size==='Medium'?85:99"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Vanilla Almond Fudge'].quantity > 1) flavors['Vanilla Almond Fudge'].quantity--; 
                  else flavors['Vanilla Almond Fudge'].quantity=1" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Vanilla Almond Fudge'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Vanilla Almond Fudge'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        +
                    </button>
                </div>
            </div>
        </div>

        <!-- Very Rocky Road -->
        <div class="rounded-2xl" @click="selectedFlavor='Very Rocky Road'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/veryRockyRoadDayDreamPremium.png') }}" alt="Very Rocky Road" class="-mt-15 ml-6 max-[780px]:ml-5 w-[126px] h-[126px]">
                    <h1 class="text-center text-lg px-10 -mt-3 max-[780px]:-mt-1 max-[780px]:text-sm">
                        Very Rocky <br> Road
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="space-y-3 max-[780px]:space-y-2">
                    <template x-for="size in ['Small','Medium','Large']" :key="size">
                        <div>
                            <div @click.stop="
                      flavors['Very Rocky Road'].selectedSize === size
                          ? flavors['Very Rocky Road'].selectedSize = ''
                          : flavors['Very Rocky Road'].selectedSize = size" :class="flavors['Very Rocky Road'].selectedSize === size ? 'bg-blue-200' : ''" class="p-2 px-10 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">
                                <div class="flex items-center">
                                    <h1 class="max-[780px]:text-sm pr-2 text-center" x-text="size + ':'"></h1>
                                    <p class="pr-0.5">₱</p>
                                    <p class="text-xs mt-0.5" x-text="size==='Small'?69:size==='Medium'?85:99"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['Very Rocky Road'].quantity > 1) flavors['Very Rocky Road'].quantity--; 
                  else flavors['Very Rocky Road'].quantity=1" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
                        −
                    </button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['Very Rocky Road'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['Very Rocky Road'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">
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
