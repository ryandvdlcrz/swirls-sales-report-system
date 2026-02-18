<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daydream Classic</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-no-repeat bg-cover bg-center h-screen p-5 font-PP" x-data="{
                flavors: {
                  'Brownie Avalanche': { quantity: 0, selectedSize: '' },
                  'Oreo Strawberry': { quantity: 0, selectedSize: '' },
                  'Oreo Chocolate': { quantity: 0, selectedSize: '' },
                  'Oreo Vanilla': { quantity: 0, selectedSize: '' },
                  'Strawberry': { quantity: 0, selectedSize: '' },
                  'Blueberry': { quantity: 0, selectedSize: '' },
                  'Snickers': { quantity: 0, selectedSize: '' },
                  'Kitkat': { quantity: 0, selectedSize: '' },
                },

                showPopup: false,
                popupMessage: '',

                displaySizes: { Small: '8oz', Medium: '12oz', Large: '16oz'},

                addToCart() {
                  const prices = { Small: 55.00, Medium: 69.00, Large: 85.00 };
                  let anyAdded = false;

                  for (const [flavorName, data] of Object.entries(this.flavors)) {
                    if (data.selectedSize && data.quantity > 0) {
                      const price = prices[data.selectedSize];

                      const item = {
                        name: 'DayDream Classic',
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
                    this.popupMessage = 'Daydream Classic Items added to cart!';
                    this.showPopup = true;
                  } else {
                    this.popupMessage = 'Please select size and quantity!';
                    this.showPopup = true;
                  }
                }
              }">

    <h1 class="text-xl max-[780px]:text-sm mb-4 max-[780px]:mb-0">DayDream Classic Flavors</h1>

    <div class="flex flex-1 space-x-5 overflow-x-auto items-start px-2 py-3 no-scrollbar">

        @php
        $flavors = [
        ['name'=>'Brownie Avalanche','img'=>'brownieAvalanche.png'],
        ['name'=>'Oreo Strawberry','img'=>'oreoStrawberry.png'],
        ['name'=>'Oreo Chocolate','img'=>'oreoChocolate.png'],
        ['name'=>'Oreo Vanilla','img'=>'oreoVanilla.png'],
        ['name'=>'Strawberry','img'=>'strawberry.png'],
        ['name'=>'Blueberry','img'=>'blueberry.png'],
        ['name'=>'Snickers','img'=>'snickers.png'],
        ['name'=>'Kitkat','img'=>'kitkat.png'],
        ];
        @endphp

        @foreach ($flavors as $flavor)
        <div class="rounded-2xl" @click="selectedFlavor='{{ $flavor['name'] }}'">
            <div class="bg-white w-58 p-5 drop-shadow-sm flex flex-col justify-center items-center space-y-3 rounded-2xl max-[780px]:space-y-2 max-[780px]:p-4">

                <!-- Image -->
                <div class="bg-[#FFFBFB] shadow-sm rounded-2xl py-6 mt-6 px-1 h-[135px] items-center drop-shadow-sm">
                    <img src="{{ asset('img/'.$flavor['img']) }}" alt="{{ $flavor['name'] }}" class="-mt-15 ml-7 w-[126px] h-[126px]">
                    <h1 class="text-center text-lg px-1 max-[780px]:text-sm">
                        {{ $flavor['name'] }}
                    </h1>
                </div>

                <!-- Sizes -->
                <div class="space-y-3 max-[780px]:space-y-2">
                    <template x-for="size in ['Small','Medium','Large']" :key="size">
                        <div>
                            <div @click.stop="
                      flavors['{{ $flavor['name'] }}'].selectedSize === size
                          ? flavors['{{ $flavor['name'] }}'].selectedSize = ''
                          : flavors['{{ $flavor['name'] }}'].selectedSize = size" :class="flavors['{{ $flavor['name'] }}'].selectedSize === size ? 'bg-blue-200' : ''" class="p-2 px-10 rounded-full inset-shadow-sm shadow active:scale-95 cursor-pointer text-center">
                                <div class="flex items-center">
                                    <h1 class="max-[780px]:text-sm pr-2 text-center" x-text="size + ':'"></h1>
                                    <p class="pr-0.5">₱</p>
                                    <p class="text-xs mt-0.5" x-text="size==='Small'?55:size==='Medium'?69:85"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Quantity -->
                <div class="flex justify-between space-x-7 p-1 px-5 rounded-full inset-shadow-sm shadow overflow-hidden">
                    <button @click.stop="if(flavors['{{ $flavor['name'] }}'].quantity > 1) flavors['{{ $flavor['name'] }}'].quantity--; else flavors['{{ $flavor['name'] }}'].quantity=1" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">−</button>

                    <span class="px-4 py-1 bg-white text-gray-800">
                        <span x-text="flavors['{{ $flavor['name'] }}'].quantity"></span>
                    </span>

                    <button @click.stop="flavors['{{ $flavor['name'] }}'].quantity++" class="px-2.5 bg-gray-300 hover:bg-gray-400 font-bold rounded-full">+</button>
                </div>
            </div>
        </div>
        @endforeach

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

