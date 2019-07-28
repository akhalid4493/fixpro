<?php
namespace App\TheApp\ViewComposers\Admin;

use App\TheApp\Repository\Admin\Subscriptions\SubscriptionRepository as Subscription;
use App\TheApp\Repository\Admin\Services\ServiceRepository as Service;
use App\TheApp\Repository\Admin\Previews\PreviewRepository as Preview;
use App\TheApp\Repository\Admin\Orders\OrderRepository as Order;
use App\TheApp\Repository\Admin\Users\UserRepository as User;
use Illuminate\View\View;

class StatisticsComposer
{
    public function __construct(
        Subscription $subscription,
        Preview $preview,
        Service $service,
        Order $order,
        User $user
    )
    {
        $this->userStDate       = $user->userCreatedStatistics();
        $this->userStActive     = $user->userActiveStatus();
        $this->users            = $user->count();
        $this->services         = $service->count();
        $this->orders           = $order->countDone();
        $this->ordersProfit     = $order->totalProfit();
        $this->newOrders        = $order->countNewOrders();
        $this->orderChart       = $order->monthlyProfite();
        $this->order_profit     = $order->monthlyProfiteOnly();
        $this->orderStatus      = $order->ordersType();
        $this->newPreviews      = $preview->countNewPreviews();
        $this->donePreviews     = $preview->countDone();
        $this->subscriptionChart= $subscription->monthlyProfite();
        $this->totalSubscriptions = $subscription->totalSubscriptions();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('allUsers'              , $this->users);
        $view->with('userStDate'            , $this->userStDate);
        $view->with('userStActive'          , $this->userStActive);
        $view->with('allServices'           , $this->services);
        $view->with('allOrders'             , $this->orders);
        $view->with('allProfit'             , $this->ordersProfit);
        $view->with('newOrders'             , $this->newOrders);
        $view->with('orderChart'            , $this->orderChart);
        $view->with('order_profit'          , $this->order_profit);
        $view->with('subscriptionChart'     , $this->subscriptionChart);
        $view->with('orderStatus'           , $this->orderStatus);
        $view->with('newPreviews'           , $this->newPreviews);
        $view->with('donePreviews'          , $this->donePreviews);
        $view->with('totalSubscriptions'    , $this->totalSubscriptions);
    }
}
