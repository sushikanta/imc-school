<?php

namespace App\Http\ViewComposers;

use App\MailToken;
use App\Models\Category;
use App\Models\Post;
use App\User;
use Illuminate\View\View;

class FrontendLayoutComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;
    private $frontend_url;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */

    public function __construct()
    {

       // $this->frontend_url = env('FRONTEND_URL', 'http://dev.time2staff.com');
        // Dependencies automatically resolved by service container...

    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $this->getPopularPosts($view);
        $this->getMenuCategories($view);
    }

    public function getPopularPosts($view){
        $popular_posts = Post::where('published', true)
            ->where('display_type', 'unspecified')
            ->take(2)
            ->orderByRaw('RAND()')
            ->get();

        $popular_posts->transform(function($item) {
            if($item->img_src && $decoded_img_src = json_decode($item->img_src, true))  {
                $item->img_src = $decoded_img_src;
            }
            return $item;
        });


        $defaults = compact(
            'popular_posts'
        );
        $view->with($defaults);
    }

    public function getMenuCategories($view) {
        $menu_categories = Category::where('published', true)
            ->get();

        $defaults = compact(
            'menu_categories'
        );
        $view->with($defaults);
    }
}