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

        <div class="bg-no-repeat bg-cover bg-center h-screen font-PP" style="background-image: url('img/settings_sales_ordererzxs.png');">


            <!-- ================= Cart ================= -->
            <aside class="float-end w-[25%] max-[780px]:w-[36%] bg-white h-screen shadow flex flex-col">

                <div class="py-5 shadow-sm shrink-0">
                    <h1 class="text-center text-2xl max-[780px]:text-xl">
                        Current Order
                    </h1>
                </div>

                <div class="flex justify-end text-sm mr-8 space-x-4 mt-3">
                    <p class="pr-2">Size</p>
                    <p>Qty</p>
                    <p>Amount</p>
                </div>

                <div class="flex-1 overflow-y-auto px-2 space-y-2">

                    <template x-for="(item, index) in cart" :key="index">
                        <div class="flex space-x-1">

                            <div class="flex flex-col p-2 rounded-xl border border-black/20 w-85 text-sm">
                                <div class="flex justify-between">
                                    <div>
                                        <p class="font-semibold" x-text="item.name"></p>
                                        <p x-text="item.flavor"></p>
                                        <p class="text-xs" x-show="item.dipped == 1">
                                            Dipped (+₱5.00)
                                        </p>
                                    </div>

                                    <div class="flex flex-col">
                                        <div class="flex space-x-7">
                                            <p x-text="item.size ? sizeLabels[item.size] : ''"></p>
                                            <p x-text="item.quantity"></p>
                                            <p x-text="'₱' + Number(item.price).toFixed(2)"></p>
                                        </div>

                                        <div class="font-bold text-right" x-text="'₱' + (Number(item.price) * Number(item.quantity)).toFixed(2)">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button @click="removeItem(index)" class="active:scale-95">
                                <img src="{{ asset('img/delete.png') }}" class="w-5 h-4">
                            </button>

                        </div>
                    </template>
                </div>

                <div class="text-right p-2 mr-5">
                    <button @click="clearCart()" class="text-red-500 underline">
                        Clear All
                    </button>
                </div>

                <div class="p-4 border-t border-black/20 shadow">
                    <div class="text-sm mb-3 pr-4 flex justify-between">
                        <h1>Total:</h1>
                        <h1 x-text="'₱ ' + cart.reduce((sum, i) =>
                    sum + Number(i.price) * Number(i.quantity), 0).toFixed(2)">
                        </h1>
                    </div>

                    <a href="{{ route('order.checkout') }}">
                        <button class="active:scale-95">
                            <img src="{{ asset('img/checkOutButton.png') }}">
                        </button>
                    </a>
                </div>
            </aside>


            <!-- ================= Items ================= -->
            <section>

                <header>
                    <div class="flex items-center p-5 space-x-5">

                        <a href="{{ route('index') }}">
                            <img src="{{ asset('img/swirls-logo.webp') }}" class="w-21.25 h-21.25">
                        </a>

                        <h1 class="text-2xl">Menu</h1>
                    </div>
                </header>

                <main>
                    <div class="flex flex-wrap items-center justify-center">

                        <!-- Products -->
                        <img src="{{ asset('img/dayDreamClassic.png') }}" class="active:scale-95 w-44.5 h-44.75" @click="src='{{ route('menu.daydreamclassic') }}'; open = true">

                        <img src="{{ asset('img/bigCone.png') }}" class="active:scale-95 w-44.5 h-44.75" @click="src='{{ route('menu.bigcone') }}'; open = true">

                        <img src="{{ asset('img/sundaeCup.png') }}" class="active:scale-95 w-44.5 h-44.75" @click="src='{{ route('menu.sundaecup') }}'; open = true">

                        <img src="{{ asset('img/sundaeCone.png') }}" class="active:scale-95 w-44.5 h-44.75" @click="src='{{ route('menu.sundaecone') }}'; open = true">

                        <img src="{{ asset('img/dayDreamPremium.png') }}" class="active:scale-95 w-44.5 h-44.75" @click="src='{{ route('menu.daydreampremium') }}'; open = true">

                        <img src="{{ asset('img/swirlsDelight.png') }}" class="active:scale-95 w-44.5 h-44.75" @click="src='{{ route('menu.swirldelight') }}'; open = true">

                        <img src="{{ asset('img/vanillaCone.png') }}" class="active:scale-95 w-44.5 h-44.75" @click="src='{{ route('menu.vanillacone') }}'; open = true">

                        <img src="{{ asset('img/sodaFloat.png') }}" class="active:scale-95 w-44.5 h-44.75" @click="src='{{ route('menu.sodafloat') }}'; open = true">

                        <img src="{{ asset('img/carfait.png') }}" class="active:scale-95 w-44.5 h-44.75" @click="src='{{ route('menu.carfait') }}'; open = true">

                        <img src="{{ asset('img/milkShake.png') }}" class="active:scale-95 w-44.5 h-44.75" @click="src='{{ route('menu.milkshake') }}'; open = true">

                        <img src="{{ asset('img/iceCoffeeFloat.png') }}" class="active:scale-95 w-44.5 h-44.75" @click="src='{{ route('menu.icedcoffeefloat') }}'; open = true">
                    </div>

                    <div class="p-5 w-fit">
                        <a href="{{ route('index') }}">
                            <img src="{{ asset('img/backButton.png') }}" class="active:scale-95 w-27.5 h-8.75">
                        </a>
                    </div>
                </main>
            </section>


            <!-- ================= MODAL ================= -->
            <div x-show="open" x-transition.opacity x-cloak @keydown.escape.window="open = false" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" @click.self="open = false">

                <div x-transition.scale class="bg-[#FFF6F6] rounded-2xl shadow-2xl relative overflow-hidden
                    w-full max-w-5xl h-[70vh]">

                    <button @click="open = false" class="absolute top-2 right-3 text-2xl m-4">
                        ✕
                    </button>

                    <iframe :src="src" class="w-full h-full border-none"></iframe>

                </div>
            </div>

        </div>
    </div>
</body>
</html>
