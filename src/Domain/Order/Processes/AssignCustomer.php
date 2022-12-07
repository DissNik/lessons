<?php

namespace Domain\Order\Processes;

use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Exceptions\OrderProcessException;
use Domain\Order\Models\Order;

class AssignCustomer implements OrderProcessContract
{
    public function __construct(protected array $customer)
    {
    }

    /**
     * @throws OrderProcessException
     */
    public function handle(Order $order, $next)
    {
        $order->orderCustomer()
            ->create($this->customer);

        return $next($order);
    }
}
