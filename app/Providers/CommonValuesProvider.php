<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CommonValuesProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      $this->composeFooter();
    }




    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }



    private function composeFooter()
    {
      view()->composer('admin.*','App\TheApp\ViewComposers\Admin\StatisticsComposer');
      view()->composer('admin.pages.*','App\TheApp\ViewComposers\Admin\PagesComposer');
    }
}