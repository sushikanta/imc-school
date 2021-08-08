<?php
use App\Classes\Utility;

if(is_array($post->img_src)){
    //Utility::pr($post->img_src);
    //---------------
    $img_src = @$post->img_src['thumbs']['740W_NONSQUARECROP']['path'];
}else{
    $img_src =  asset('storage/'.$post->img_src);
}

$title = str_limit(strip_tags($post->title), $limit = 100, $end = '...');
$description = str_limit(strip_tags($post->meta_description), $limit = 400, $end = '...');

?>
@extends('layouts.frontend')

@section('title')
    {{ '- '.$title }}
    @endsection
@section('description', $post->meta_description)
@section('keywords', $post->meta_keywords)
@section('robots', 'index, follow')
@section('revisit-after', 'content="3 days')


@section('og_title', $title)
@section('og_description', $description)
@section('og_image', $img_src)


@section('content')
    <!-- BEGIN .wrapper -->
    <div class="wrapper">

        <div class="content-wrapper">

            <!-- BEGIN .composs-main-content -->
            <div class="composs-main-content composs-main-content-s-1">

                <!-- BEGIN .composs-panel -->
                <div class="composs-panel">

                    <!-- <div class="composs-panel-title">
                        <strong>Blog page style #1</strong>
                    </div> -->

                    <div class="composs-panel-inner">

                        <div class="composs-main-article-content">

                            <h1>{{$post->title}}</h1>



                            <div class="composs-main-article-head" style="width: 55%; float: left; margin-right: 20px;">
                                <div class="composs-main-article-media center-cropped " style="background-image: url('{{$img_src}}');">
                                    <img class="post-photo" style="width: 100%" src="{{$img_src}}" alt="" />
                                </div>
                                <div class="composs-main-article-meta post-info-share-container"  >
                                    <span class="item"><i class="material-icons">access_time</i>{{ Utility::convertTimeToUSERzone($post->published_at, 'F d, Y')}}</span>
                                    {{--<a href="#comments" class="item"><i class="material-icons">chat_bubble_outline</i>3 Comments</a>--}}
                                    <span class="item"><i class="material-icons">folder_open</i><a href="#">{{$post->category->title}}</a></span>

                                    {{--<div class="fb-share-button" data-href="{{Request::url()}}" data-layout="button" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{Request::url()}}" class="fb-xfbml-parse-ignore">Share</a></div>--}}

                                </div>
                                <div class="composs-main-article-meta post-info-share-container" >
                                    <div class="share-wrapper">
                                        <div class="sharethis-inline-share-buttons"></div>
                                    </div>
                                </div>
                         {{--       <p>Tota argumentum nec in. Sed an everti melius eleifend. Et tation legere referrentur eos. Duo erat tempor ea. An mollis delicata adolescens eum, ea putent eruditi argumentum sit, eos ex facilis rationibus.</p>
                         --}}
                            </div>

                            <div class="shortcode-content" style="margin-bottom: 20px">
                                {!! $post->description  !!}
                            </div>

                           {{-- <div class="composs-review-block">
                                <div class="composs-review-block-score">
                                    <span>6.5</span>
                                </div>
                                <div class="composs-review-block-good">
                                    <strong>The Good</strong>
                                    <ul>
                                        <li>Mei pertinax mandamus</li>
                                        <li>Percipitur no lorem aperiri</li>
                                        <li>Habemus eum ea te vi</li>
                                    </ul>
                                </div>
                                <div class="composs-review-block-bad">
                                    <strong>The Bad</strong>
                                    <ul>
                                        <li>Habemus eum ea te vi</li>
                                        <li>Accommodare</li>
                                    </ul>
                                </div>
                            </div>--}}

                        {{--    <div class="composs-tag-list">
                                <a href="blog.html">Women</a>
                                <a href="blog.html">Women in Business</a>
                                <a href="blog.html">Women in Tech</a>
                            </div>

                         --}}


                        </div>

                    </div>

                    <!-- END .composs-panel -->
                </div>

                <!-- END .composs-main-content -->
            </div>

            <!-- BEGIN #sidebar -->
            <aside id="sidebar">

                <!-- BEGIN .widget -->
                <div class="widget">
                    <h3>Other articles</h3>
                    <div class="widget-content ot-w-article-list">



                        <?php if(@$other_posts){
                        foreach($other_posts as $post){
                        if(is_array($post->img_src)){
                            $img_src = @$post->img_src['thumbs']['100W_SQUARECROP']['path'];
                        }else{
                            $img_src =  asset('storage/'.$post->img_src);
                        }
                        ?>
                            <div class="item">
                                <div class="item-header">
                                    <a href="{{ route('post.details.slug', $post->slug) }}"><img src="{{ $img_src }}"  alt="" /></a>
                                </div>
                                <div class="item-content">
                                    <h4><a href="{{ route('post.details.slug', $post->slug) }}">{{$post->title}}</a></h4>
                                    <span class="item-meta">
												<span class="item-meta-item"><i class="material-icons">access_time</i>{{ Utility::convertTimeToUSERzone($post->published_at, 'F d, Y')}}</span>
											</span>
                                </div>
                            </div>

                        <?php
                        }
                        } ?>



                    </div>
                    <!-- END .widget -->
                </div>

                <!-- END #sidebar -->
            </aside>

        </div>

        <!-- END .wrapper -->
    </div>
@endsection