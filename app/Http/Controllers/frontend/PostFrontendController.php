<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryPost;
use App\Models\Post;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class PostFrontendController extends Controller
{
    public function detaiCategoryPost($slug){
        $slider = Slider::where('slider_status', '1')->take(4)->get();
        $category = Category::where('category_status', '1')->orderby('category_id','desc')->get();
        $brand = Brand::where('brand_status', '1')->orderby('brand_id','desc')->get();
        $categorypost = CategoryPost::where('cate_post_status', '1')->orderby('cate_post_id','desc')->get();
        $cate_post_name = CategoryPost::where('cate_post_slug',$slug)->first();
            $cate_id = $cate_post_name->cate_post_id;
        $post = Post::where('post_status', '1')->where('tbl_post.cate_post_id',$cate_id)->orderby('post_id','desc')->limit(8)->get();
        return view('pages.post.show_category_post',compact('category','brand','post','cate_post_name','slider','categorypost'));

    }

    public function postDetail($slug){
        $slider = Slider::where('slider_status', '1')->take(4)->get();
        $category = Category::where('category_status', '1')->orderby('category_id','desc')->get();
        $brand = Brand::where('brand_status', '1')->orderby('brand_id','desc')->get();
        $categorypost = CategoryPost::where('cate_post_status', '1')->orderby('cate_post_id','desc')->get();
        $post = Post::where('post_slug',$slug)->first();
        $view = $post->post_view;
        $post->post_view = $view+1;
        $post->save();
        $cate_post_id = $post->cate_post_id;
        $related_post = Post::where('cate_post_id',$cate_post_id)->where('post_status',1)->whereNotIn('tbl_post.post_slug',[$slug])->get();

        return view('pages.post.show_detail_post',compact('category','brand','post','post','slider','categorypost','related_post'));

    }
}