<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Flavor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.product_name' => 'required|string',
            'orders.*.flavor_name' => 'required|string',
            'orders.*.quantity' => 'required|integer|min:1',
            'orders.*.total_amount' => 'required|numeric|min:0',
            'orders.*.size' => 'nullable|string',
        ]);

        $user = Auth::user();
        $orders = $request->orders;
        $savedSales = [];

        DB::beginTransaction();

        try {
            foreach ($orders as $order) {
                // Find product by name
                $product = Product::where('name', $order['product_name'])->first();

                if (!$product) {
                    throw new \Exception("Product '{$order['product_name']}' not found in database.");
                }

                // Find flavor by name
                $flavor = Flavor::where('name', $order['flavor_name'])->first();

                if (!$flavor) {
                    throw new \Exception("Flavor '{$order['flavor_name']}' not found in database.");
                }

                // Create sale record
                $sale = Sale::create([
                    'user_id' => $user->id,
                    'branch_id' => $user->branch_id,
                    'product_id' => $product->id,
                    'size' => $order['size'] ?? null,
                    'flavor_id' => $flavor->id,
                    'qty' => $order['quantity'],
                    'total_amount' => $order['total_amount'],
                    'sale_date' => Carbon::now(),
                ]);

                $savedSales[] = $sale;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sales recorded successfully!',
                'sales_count' => count($savedSales),
                'total_amount' => array_sum(array_column($orders, 'total_amount')),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error saving sales: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function success()
    {
        return view('order.success');
    }
    
}
