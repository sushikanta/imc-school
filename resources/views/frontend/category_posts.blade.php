<?php
use App\Classes\Utility;
?>
@extends('layouts.frontend')
@section('title')
    {{ '- '.$category->title }}
@endsection
@section('description', $category->meta_description)
@section('keywords', $category->meta_keywords)
@section('robots', 'index, follow')

@section('revisit-after', 'content="3 days')
@section('content')
    <!-- BEGIN .wrapper -->
    <div class="wrapper">

        <div class="content-wrapper">

            <!-- BEGIN .composs-main-content -->
            <div class="composs-main-content ">

                <!-- BEGIN .composs-panel -->
                <div class="composs-panel">

                    <div class="composs-panel-title">
                        <strong>{{$category->title}}</strong>
                    </div>

                    <div class="composs-panel-inner">

                        <div class="composs-blog-list lets-do-2">
                            <?php
                            if(@$category_posts && $category_posts->count()){
                              //  dd($category_posts);
                                foreach ($category_posts as $post){

                                    $post_url = route('post.details.slug', $post->slug);
                            if(is_array($post->img_src)){
                               // dd($post->img_src);
                                $img_src = @$post->img_src['thumbs']['160W_SQUARECROP']['path'];
                            }else{
                                $img_src =  asset('storage/'.$post->img_src);
                            }
                                    ?>
                                <div class="item">
                                    <div class="item-header">
                                        {{--<a href="#" class="img-read-later-button">Read later</a>--}}
                                        <a href="{{$post_url}}"><img src="{{$img_src}}" alt="" /></a>
                                    </div>
                                    <div class="item-content">
                                        <h2><a href="{{$post_url}}">{{$post->title}}</a></h2>
                                        <span class="item-meta">
													<span class="item-meta-item"><i class="material-icons">access_time</i>{{ \App\Classes\Utility::convertTimeToUSERzone($post->published_at, 'F d, Y')}}</span>
													{{--<a href="{{$post_url}}" class="item-meta-item"><i class="material-icons">chat_bubble_outline</i>35</a>--}}
												</span>
                                        <p>
                                            {{str_limit(strip_tags(html_entity_decode($post->description)), 150)}}
                                        </p>
                                    </div>
                                </div>

                            <?php
                                }
                            }else{
                                ?>
                                <div style="text-align: center; padding-top: 20px; padding-bottom: 20px">No posts found.</div>
                                <?php
                                }
                            ?>

                        </div>

                    </div>

                    {{--<div class="composs-panel-pager">
                        <a class="prev page-numbers" href="#"><i class="fa fa-angle-double-left"></i>Previous</a>
                        <a class="page-numbers" href="#">1</a>
                        <span class="page-numbers current">2</span>
                        <a class="page-numbers" href="#">3</a>
                        <a class="page-numbers" href="#">4</a>
                        <a class="page-numbers" href="#">5</a>
                        <a class="next page-numbers" href="#">Next<i class="fa fa-angle-double-right"></i></a>
                    </div>

                    <div class="composs-panel-pager">
                        <a href="#" class="composs-pager-button">View more articles</a>
                    </div>

                    <div class="composs-panel-pager">
                        <a href="#" class="composs-pager-button left"><i class="fa fa-angle-double-left"></i>Newer posts</a>
                        <a href="#" class="composs-pager-button right active">Older posts<i class="fa fa-angle-double-right"></i></a>
                        <p>3 of 7 pages</p>
                    </div>--}}

                    <!-- END .composs-panel -->
                </div>

                <!-- END .composs-main-content -->
            </div>



        </div>

        <!-- END .wrapper -->
    </div>
@endsection