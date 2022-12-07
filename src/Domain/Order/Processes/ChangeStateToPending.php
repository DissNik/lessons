<?php

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Exceptions\OrderProcessException;
use Domain\Order\Models\Order;
use Domain\Order\States\PendingOrderState;

class ChangeStateToPending implements OrderProcessContract
{
    /**
     * @throws OrderProcessException
     */
    public function handle(Order $order, $next)
    {
        $order->status->transitionTo(new PendingOrderState($order));

        return $next($order);
    }
}
