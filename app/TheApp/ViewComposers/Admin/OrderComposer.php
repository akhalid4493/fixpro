<?php
namespace App\TheApp\ViewComposers\Admin;

use App\TheApp\Repository\Admin\Orders\OrderRepository as Order;
use Illuminate\View\View;

class OrderComposer
{
    public $newOrders = [];

    /**
     * Create a Home composer.
     *
     *  @param HomeRepository $Home
     *
     * @return void
     */
    public function __construct(Order $orderModel)
    {
        $this->newOrders =  $orderModel->count();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('newOrders' , $this->newOrders);
    }
}
