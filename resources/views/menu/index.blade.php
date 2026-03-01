<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swirls Menu</title>

    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body>

    <div x-data="{
        open: false,
        src: '',
        cart: [],
        sizeLabels: { Small: '8oz', Medium: '12oz', Large: '16oz' },

        init() {
            this.loadCart()
            window.addEventListener('storage', () => this.loadCart())
        },

        loadCart(){
            this.cart = JSON.parse(localStorage.getItem('cart')) || []
        },

        clearCart(){
            localStorage.removeItem('cart')
            this.cart = []
        },

        removeItem(index){
            this.cart.splice(index, 1)
            localStorage.setItem('cart', JSON.stringify(this.cart))
        }
    }">

        <div class="bg-no-repeat bg-cover bg-center min-h-screen font-PP flex" style="background-image: url('img/settings_sales_ordererzxs.png');">


            <!-- ================= Items ================= -->
            <section class="flex-1 min-w-0 flex flex-col overflow-hidden">

                <header class="shrink-0">
                    <div class="flex items-center p-3 md:p-4 lg:p-5 space-x-3 md:space-x-4 lg:space-x-5">

                        <a href="{{ route('index') }}">
                            <img src="{{ asset('img/swirls-logo.webp') }}" class="w-14 h-14 md:w-16 md:h-16 lg:w-[85px] lg:h-[85px]">
                        </a>

                        <h1 class="text-xl md:text-2xl lg:text-3xl">Menu</h1>
                    </div>
                </header>

                <main class="flex-1 overflow-y-auto">
                    {{-- 2 cols on small tablets, 3 on medium, 4 on large --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2 md:gap-3 p-2 md:p-3 justify-items-center">

                        <img src="{{ asset('img/dayDreamClassic.png') }}" class="active:scale-95 cursor-pointer w-full max-w-[160px] md:max-w-[175px] lg:max-w-[190px] aspect-square object-contain" @click="src='{{ route('menu.daydreamclassic') }}'; open = true">

                        <img src="{{ asset('img/bigCone.png') }}" class="active:scale-95 cursor-pointer w-full max-w-[160px] md:max-w-[175px] lg:max-w-[190px] aspect-square object-contain" @click="src='{{ route('menu.bigcone') }}'; open = true">

                        <img src="{{ asset('img/sundaeCup.png') }}" class="active:scale-95 cursor-pointer w-full max-w-[160px] md:max-w-[175px] lg:max-w-[190px] aspect-square object-contain" @click="src='{{ route('menu.sundaecup') }}'; open = true">

                        <img src="{{ asset('img/sundaeCone.png') }}" class="active:scale-95 cursor-pointer w-full max-w-[160px] md:max-w-[175px] lg:max-w-[190px] aspect-square object-contain" @click="src='{{ route('menu.sundaecone') }}'; open = true">

                        <img src="{{ asset('img/dayDreamPremium.png') }}" class="active:scale-95 cursor-pointer w-full max-w-[160px] md:max-w-[175px] lg:max-w-[190px] aspect-square object-contain" @click="src='{{ route('menu.daydreampremium') }}'; open = true">

                        <img src="{{ asset('img/swirlsDelight.png') }}" class="active:scale-95 cursor-pointer w-full max-w-[160px] md:max-w-[175px] lg:max-w-[190px] aspect-square object-contain" @click="src='{{ route('menu.swirldelight') }}'; open = true">

                        <img src="{{ asset('img/vanillaCone.png') }}" class="active:scale-95 cursor-pointer w-full max-w-[160px] md:max-w-[175px] lg:max-w-[190px] aspect-square object-contain" @click="src='{{ route('menu.vanillacone') }}'; open = true">

                        <img src="{{ asset('img/sodaFloat.png') }}" class="active:scale-95 cursor-pointer w-full max-w-[160px] md:max-w-[175px] lg:max-w-[190px] aspect-square object-contain" @click="src='{{ route('menu.sodafloat') }}'; open = true">

                        <img src="{{ asset('img/carfait.png') }}" class="active:scale-95 cursor-pointer w-full max-w-[160px] md:max-w-[175px] lg:max-w-[190px] aspect-square object-contain" @click="src='{{ route('menu.carfait') }}'; open = true">

                        <img src="{{ asset('img/milkShake.png') }}" class="active:scale-95 cursor-pointer w-full max-w-[160px] md:max-w-[175px] lg:max-w-[190px] aspect-square object-contain" @click="src='{{ route('menu.milkshake') }}'; open = true">

                        <img src="{{ asset('img/iceCoffeeFloat.png') }}" class="active:scale-95 cursor-pointer w-full max-w-[160px] md:max-w-[175px] lg:max-w-[190px] aspect-square object-contain" @click="src='{{ route('menu.icedcoffeefloat') }}'; open = true">

                    </div>

                    <div class="p-3 md:p-4 lg:p-5 w-fit">
                        <a href="{{ route('index') }}">
                            <img src="{{ asset('img/backButton.png') }}" class="active:scale-95 w-24 md:w-28 lg:w-[110px] h-auto">
                        </a>
                    </div>
                </main>
            </section>


            <!-- ================= Cart ================= -->
            <aside class="w-[38%] md:w-[32%] lg:w-[28%] xl:w-[25%] shrink-0 bg-white h-screen shadow flex flex-col sticky top-0">

                <div class="py-4 md:py-5 shadow-sm shrink-0">
                    <h1 class="text-center text-lg md:text-xl lg:text-2xl">
                        Current Order
                    </h1>
                </div>

                <div class="flex justify-end text-xs md:text-sm mr-4 md:mr-6 lg:mr-8 space-x-3 md:space-x-4 mt-2 md:mt-3">
                    <p class="pr-1 md:pr-2">Size</p>
                    <p>Qty</p>
                    <p>Amount</p>
                </div>

                <div class="flex-1 overflow-y-auto px-2 space-y-2 py-1">

                    <template x-for="(item, index) in cart" :key="index">
                        <div class="flex space-x-1">

                            <div class="flex flex-col p-1.5 md:p-2 rounded-xl border border-black/20 flex-1 text-xs md:text-sm">
                                <div class="flex justify-between gap-1">
                                    <div class="min-w-0">
                                        <p class="font-semibold truncate" x-text="item.name"></p>
                                        <p class="truncate" x-text="item.flavor"></p>
                                        <p class="text-xs" x-show="item.dipped == 1">
                                            Dipped (+₱5.00)
                                        </p>
                                    </div>

                                    <div class="flex flex-col shrink-0">
                                        <div class="flex space-x-3 md:space-x-5 lg:space-x-7">
                                            <p x-text="item.size ? sizeLabels[item.size] : ''"></p>
                                            <p x-text="item.quantity"></p>
                                            <p x-text="'₱' + Number(item.price).toFixed(2)"></p>
                                        </div>

                                        <div class="font-bold text-right text-xs md:text-sm" x-text="'₱' + (Number(item.price) * Number(item.quantity)).toFixed(2)">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button @click="removeItem(index)" class="active:scale-95 shrink-0 self-center">
                                <img src="{{ asset('img/delete.png') }}" class="w-4 h-3 md:w-5 md:h-4">
                            </button>

                        </div>
                    </template>
                </div>

                <div class="text-right p-1.5 md:p-2 mr-3 md:mr-5">
                    <button @click="clearCart()" class="text-red-500 underline text-xs md:text-sm">
                        Clear All
                    </button>
                </div>

                <div class="p-3 md:p-4 border-t border-black/20 shadow">
                    <div class="text-xs md:text-sm mb-2 md:mb-3 pr-2 md:pr-4 flex justify-between">
                        <h1>Total:</h1>
                        <h1 x-text="'₱ ' + cart.reduce((sum, i) =>
                            sum + Number(i.price) * Number(i.quantity), 0).toFixed(2)">
                        </h1>
                    </div>

                    <a href="{{ route('order.checkout') }}">
                        <button class="active:scale-95 w-full">
                            <img src="{{ asset('img/checkOutButton.png') }}" class="w-full h-auto">
                        </button>
                    </a>
                </div>
            </aside>


            <!-- ================= MODAL ================= -->
            <div x-show="open" x-transition.opacity x-cloak @keydown.escape.window="open = false" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 md:p-6" @click.self="open = false">

                <div x-transition.scale class="bg-[#FFF6F6] rounded-2xl shadow-2xl relative overflow-hidden
                    w-full max-w-[90vw] md:max-w-3xl lg:max-w-5xl h-[75vh] md:h-[70vh]">

                    <button @click="open = false" class="absolute top-2 right-3 text-xl md:text-2xl m-3 md:m-4 z-10">
                        ✕
                    </button>

                    <iframe :src="src" class="w-full h-full border-none"></iframe>

                </div>
            </div>

        </div>
    </div>
</body>
</html>
