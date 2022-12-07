<?php

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Exceptions\OrderProcessException;
use Domain\Order\Models\Order;
use Illuminate\Support\Facades\DB;

class DecreaseProductsQuantities implements OrderProcessContract
{
    /**
     * @throws OrderProcessException
     */
    public function handle(Order $order, $next)
    {
        foreach (cart()->items() as $item) {
            $item->product()->update([
                'quantity' => DB::raw('quantity - ' . $item->quantity)
            ]);
        }

        return $next($order);
    }
}
