<?php
namespace App\TheApp\ViewComposers\Admin;

use App\TheApp\Repository\Admin\Pages\PageRepository as Page;
use Illuminate\View\View;

class PagesComposer
{
    public $pages = [];

    /**
     * Create a Home composer.
     *
     *  @param HomeRepository $Home
     *
     * @return void
     */
    public function __construct(Page $pageModel)
    {
        $this->pages =  $pageModel;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('pages' , $this->pages);
    }
}
