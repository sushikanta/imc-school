<?php

namespace App\Http\Controllers;

use App\Classes\Utility;
use App\Models\Category;
use App\Models\Post;
use App\Models\Registration;
use App\Models\Videos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class HomeController extends Controller
{

    const disp_main = 'main';
    const disp_brief = 'brief';
    const disp_unspecified = 'unspecified';

    /**
     * Display a listing of the countries.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $req)
    {


        $main_post = Post::with('category')
            ->where('published', true)
            ->where('display_type', self::disp_main)
            ->orderByDesc('published_at')
            ->take(1)
            ->get();


        $main_post = $main_post->first();
        if($main_post && $main_post->img_src && $decoded_img_src = json_decode($main_post->img_src, true))  {
            $main_post->img_src = $decoded_img_src;
        }
        // ----------- brief news
        $brief_posts = Post::where('published', true)
            ->where('display_type', self::disp_brief)
            ->orderByDesc('published_at')->take(10)->get();

        $brief_posts->transform(function($item) {
            if($item->published_at){
                $str = Utility::getTimeDifference($item->published_at);
                $item->past_duration = $str;
            }
            return $item;
        });
//        $item = $brief_posts->first();
//        $str = Utility::getTimeDifference($item->published_at);
        //dd($str);
        $other_posts = Post::where('published', true)
            ->where('display_type', self::disp_unspecified)
            ->orderByDesc('published_at')->take(10)->get();

        $other_posts->transform(function($item) {
            if($item->img_src && $decoded_img_src = json_decode($item->img_src, true))  {
                $item->img_src = $decoded_img_src;
            }
            return $item;
        });

        if(isset($req['video_id'])){
            $video_home_default = Videos::find($req['video_id']);
            $video_home_others = Videos::whereNotIn('id', [$req['video_id']])->limit(9)->orderBy('created_at', 'DESC')->get();

        }else{
            $video_home_default = Videos::where('display_type', 'home_default')->orderBy('created_at', 'DESC')->first();
            $video_home_others = Videos::whereNotIn('id', [$video_home_default->id])->limit(9)->orderBy('created_at', 'DESC')->get();
        }


        $video_home_others->transform(function($item) {
            if($item->img_src && $decoded_img_src = json_decode($item->img_src, true))  {
                $item->img_src = $decoded_img_src;
            }
            return $item;
        });

       // dd($video_home_others->toArray());
        return view('frontend.home', compact('main_post', 'other_posts', 'brief_posts', 'video_home_default', 'video_home_others'));
    }

    public function showSluggifiedPost($post)
    {
        return $this->showPost($post->id);
    }
    public function showPost($post_id)
    {

        $post = Post::with('category')->find($post_id);
        if($post->img_src && $decoded_img_src = json_decode($post->img_src, true))  {
            $post->img_src = $decoded_img_src;
        }

        // -----------
        $other_posts = Post::where('published', true)
            ->where('display_type', self::disp_unspecified)
            ->where('published', true)
            ->where('id', '<>', $post_id)
            ->orderByDesc('published_at')->take(10)->get();

        $other_posts->transform(function($item) {
            if($item->img_src && $decoded_img_src = json_decode($item->img_src, true))  {
                $item->img_src = $decoded_img_src;
            }
            return $item;
        });

      return view('frontend.post_details', compact('post', 'other_posts'));
    }

    public function showCategoryPosts($category_id)
    {
        // dd($category_id);
        $category = Category::find($category_id);
        $category_posts = Post::where('category_id', $category_id) ->where('published', true)->orderByDesc('published_at')->get();
//        dd($category_posts);

        $category_posts->transform(function($item) {
            if($item->img_src && $decoded_img_src = json_decode($item->img_src, true))  {
                $item->img_src = $decoded_img_src;
            }
            return $item;
        });

        return view('frontend.category_posts', compact('category','category_posts'));
    }

    public function showSlugCategoryPosts($category)
    {
            return $this->showCategoryPosts($category->id);
    }

    public function showContactUs()
    {
       // return view('frontend.contact_us');
        return view('site-pharma.contactus');
    }

    public function newHome()
    {
        //return view('school.home');
        return view('school.home');
    }

    public function register()
    {
        //return view('school.home');
        return view('school.register');
    }

    public function storeRegistration(Request $request) {

        try {
            $obj = new Registration();
            $data = Registration::getValidatedData($request);
            $obj->fill($data);
            $obj->save();
            return redirect()->route('register')
                ->with('success_message',' Registation submitted successfully! We will get back to you soon. Thank you.');


        } catch (Exception $exception) {
            $error_messages = ['main_error' => $exception->getMessage()];
            if(@$exception->validator){
                $error_messages = $exception->validator;
            }
            return back()->withInput()
                ->withErrors($error_messages);
        }


    }
}
