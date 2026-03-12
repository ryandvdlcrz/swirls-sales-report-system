<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Out</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body x-data="checkoutData()" class="min-h-screen bg-no-repeat bg-cover bg-center flex flex-col items-center justify-center bg-pink-200" style="background-image: url('{{ asset('img/settings_sales_ordererzxs.png') }}');">

    <!-- Header -->
    <header class="w-full flex items-center justify-between max-w-5xl px-6 mt-3">
        <!-- Logo & Name -->
        <div class="flex items-center space-x-3">
            <a href="{{ route('index') }}">
                <img src="{{ asset('img/swirls-logo.webp') }}" alt="Swirls Logo" class="w-12 h-12" />
            </a>
            <h1 class="text-2xl font-semibold text-gray-800">Swirls</h1>
        </div>

        <div class="text-center">
            <h1 class="text-xl">Review Your Order</h1>
        </div>
    </header>

    <div class="flex flex-col items-center w-full px-6 mt-6">

        <h1 class="w-full max-w-5xl mb-3 px-4 text-lg font-semibold">
            Order Summary
        </h1>

        <!-- Orders Box -->
        <div class="p-4 border-2 backdrop-blur-sm bg-white/80 rounded-2xl shadow-2xl w-full max-w-5xl">

            <!-- Error Message -->
            <div x-show="errorMessage" x-transition class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <p x-text="errorMessage"></p>
            </div>

            <!-- Orders List -->
            <div class="max-h-[45vh] overflow-y-auto">

                <template x-if="cart.length === 0">
                    <p class="text-gray-500 text-center py-10">
                        Your cart is empty. <a href="{{ route('menu.index') }}" class="text-blue-500 underline">Browse menu</a>
                    </p>
                </template>

                <template x-for="(item, index) in cart" :key="index">
                    <div class="flex justify-between items-center border-b border-gray-300 px-3 py-3">

                        <!-- Left side -->
                        <div class="flex justify-between w-full text-sm">
                            <div class="space-y-1">
                                <div class="flex space-x-2">
                                    <p class="font-semibold" x-text="item.name + ' -'"></p>
                                    <p x-text="item.flavor"></p>
                                </div>
                                <div class="flex space-x-4 text-xs text-gray-600">
                                    <p x-text="'₱' + item.price"></p>
                                    <p x-text="item.size ? sizeLabels[item.size] : ''"></p>
                                </div>
                                <!-- Dipped Display -->
                                <p class="text-xs text-gray-600" x-show="item.dipped == 1">
                                    Dipped (+₱5.00)
                                </p>
                            </div>

                            <div class="space-y-1 text-right">
                                <p class="text-sm" x-text="item.quantity + ' pcs'"></p>
                                <p class="font-semibold" x-text="'₱' + (Number(item.price) * Number(item.quantity)).toFixed(2)"></p>
                            </div>
                        </div>

                        {{-- Changed: @click="confirmRemove(index)" --}}
                        <button @click="confirmRemove(index)" class="ml-3 text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </template>

                <!-- Total -->
                <div class="flex justify-between px-3 py-4 font-bold text-xl border-t-2 mt-4">
                    <p>Total</p>
                    <p x-text="'₱' + cart.reduce((sum, i) => sum + Number(i.price) * Number(i.quantity), 0).toFixed(2)"></p>
                </div>

            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between w-full max-w-5xl px-2 mt-4 gap-4">

            <!-- Back to Menu -->
            <a href="{{ route('menu.index') }}" class="flex-1">
                <button class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-xl active:scale-95 transition">
                    ← Back to Menu
                </button>
            </a>

            <!-- Place Order Button -->
            <button @click="submitOrder()" :disabled="cart.length === 0 || isSubmitting" :class="{ 'opacity-50 cursor-not-allowed': cart.length === 0 || isSubmitting }" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-xl active:scale-95 transition disabled:active:scale-100">
                <span x-show="!isSubmitting">Place Order</span>
                <span x-show="isSubmitting">Processing...</span>
            </button>

        </div>

    </div>


    <!-- ================= CONFIRM REMOVE MODAL ================= -->
    <div x-show="confirmOpen" x-transition.opacity x-cloak @keydown.escape.window="confirmNo()" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4" @click.self="confirmNo()">
        <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90" class="bg-white rounded-2xl shadow-2xl p-5 md:p-8 w-full max-w-[85vw] sm:max-w-xs md:max-w-sm text-center">
            <div class="text-3xl md:text-4xl mb-3">🗑️</div>
            <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-1">Remove item?</h2>
            <p class="text-xs md:text-sm text-gray-500 mb-5">This item will be removed from your order.</p>

            <div class="flex gap-3">
                <button @click="confirmNo()" class="flex-1 py-2 md:py-3 rounded-xl border border-gray-300 text-gray-700 text-sm md:text-base font-medium hover:bg-gray-100 active:scale-95 transition">
                    Cancel
                </button>
                <button @click="confirmYes()" class="flex-1 py-2 md:py-3 rounded-xl bg-red-500 text-white text-sm md:text-base font-medium hover:bg-red-600 active:scale-95 transition">
                    Remove
                </button>
            </div>
        </div>
    </div>


    <script>
        function checkoutData() {
            return {
                open: false
                , src: ''
                , cart: []
                , sizeLabels: {
                    Small: '8oz'
                    , Medium: '12oz'
                    , Large: '16oz'
                }
                , isSubmitting: false
                , errorMessage: ''
                , confirmOpen: false
                , pendingRemoveIndex: null,

                init() {
                    this.loadCart();
                    window.addEventListener('storage', () => {
                        this.loadCart();
                    });
                },

                loadCart() {
                    this.cart = JSON.parse(localStorage.getItem('cart')) || [];
                },

                clearCart() {
                    localStorage.removeItem('cart');
                    this.cart = [];
                },

                confirmRemove(index) {
                    this.pendingRemoveIndex = index;
                    this.confirmOpen = true;
                },

                removeItem(index) {
                    this.cart.splice(index, 1);
                    localStorage.setItem('cart', JSON.stringify(this.cart));
                },

                confirmYes() {
                    if (this.pendingRemoveIndex !== null) this.removeItem(this.pendingRemoveIndex);
                    this.confirmOpen = false;
                    this.pendingRemoveIndex = null;
                },

                confirmNo() {
                    this.confirmOpen = false;
                    this.pendingRemoveIndex = null;
                },

                async submitOrder() {
                    if (this.cart.length === 0) {
                        this.errorMessage = 'Your cart is empty!';
                        return;
                    }

                    if (this.isSubmitting) return;

                    this.isSubmitting = true;
                    this.errorMessage = '';

                    const orders = this.cart.map(item => ({
                        product_name: item.name
                        , flavor_name: item.flavor
                        , quantity: parseInt(item.quantity)
                        , total_amount: parseFloat((Number(item.price) * Number(item.quantity)).toFixed(2))
                        , size: item.size || null
                    }));

                    try {
                        const response = await fetch('{{ route("sales.store") }}', {
                            method: 'POST'
                            , headers: {
                                'Content-Type': 'application/json'
                                , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                , 'Accept': 'application/json'
                            }
                            , body: JSON.stringify({
                                orders
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.clearCart();
                            window.location.href = '{{ route("order.success") }}';
                        } else {
                            this.errorMessage = data.message || 'Failed to submit order. Please try again.';
                            this.isSubmitting = false;
                        }
                    } catch (error) {
                        console.error('Error submitting order:', error);
                        this.errorMessage = 'Network error. Please check your connection and try again.';
                        this.isSubmitting = false;
                    }
                }
            }
        }

    </script>

</body>
</html>
