<?php
use \App\Classes\Utility;
?>
@extends('layouts.frontend')
@section('title', ' - Real Estate News | Latest Realty & Real Estate Industry Information and Update')
@section('description', 'The latest real estate news, views and updates from all top sources for the Indian Realty industry')
@section('keywords', 'real estate news, real estate, realty, real estate industry news, realty news, real estate industry, real estate industry in India')
@section('content')

<!-- BEGIN .wrapper -->
<div class="wrapper">

    <div class="content-wrapper">

        <!-- BEGIN .composs-main-content -->
        <div class="composs-main-content ">

            <!-- BEGIN .composs-panel -->
            <div class="composs-panel">

                {{-- <div class="composs-panel-title composs-panel-title-tabbed">
                     <strong class="active">Todays hottest articles</strong>
                     <strong>Gadget news</strong>
                     <strong>Fashion trends</strong>
                 </div>--}}

                <div class="composs-panel-inner">
                    <div class="composs-panel-tab active">

                        <div class="composs-article-split-block">

                            <div class="item-large">

                                <div class="item">
                                    <div class="item-header">
                                        <?php if(@$main_post){
                                        if(is_array($main_post->img_src)){
                                            $img_src = @$main_post->img_src['thumbs']['740W_NONSQUARECROP']['path'];
                                        }else{
                                            $img_src =  asset('storage/'.$main_post->img_src);
                                        }
                                        ?>
                                        <h2 style="margin-top: 0px"><a href="{{ route('post.details.slug', $main_post->slug) }}">{{$main_post->title}}</a></h2>
                                        <a href="{{ route('post.details.slug', $main_post->slug) }}"><img  src="{{ $img_src }}" alt="" /></a>
                                        <?php } ?>

                                    </div>

                                </div>

                            <?php
                                                if(@$brief_posts && $brief_posts->count()){
                                                    ?>
                                <div class="composs-panel news-brief-default">

                                    {{--<div class="composs-panel-title" data-ot-css="border-color: #dd4b39;" style="border-color: #dd4b39; display: none">
                                        <strong data-ot-css="background-color: #dd4b39;" style="background-color: #dd4b39; display: none">News Brief</strong>
                                    </div>
--}}
                                    <div class="composs-panel-inner">
                                        @if(false)

                                        <div class="composs-blog-list lets-do-1" style="display: none">

                                            <div class="item">
                                                <?php
                                                    if(false){
                                                foreach ($brief_posts as $post){
                                                ?>
                                                <p class="news-links"><a href="{{ route('post.details.slug', $post->slug) }}">{{$post->past_duration}} - {{$post->title}}</a></p>

                                                <?php
                                                    }
                                                }

                                                ?>
                                            </div>
                                        </div>

                                        @endif
                                        <div style="margin-top: 20px; border:1px solid #d6d1d1">
                                            <a href="http://www.iccpl.in/" target="_blank"><img src="{{ asset('frontend/images/new/iccpl_ad.jpg') }}"></a>
                                        </div>

                                      <?php if(@$video_home_default): ?>
                                            <div style="margin-top: 20px; text-align: center">
                                                <iframe width="300" height="200"
                                                        src="{{  Utility::getYoutubeEmbededUrl($video_home_default->youtube_url)}}">
                                                </iframe>
                                                <h5 style="    font-size: 11px;
                                                font-weight: bold;
                                                margin: 0px;
                                            }">{{$video_home_default->title}}</h5>
                                            </div>
                                      <?php endif; ?>

                                    <?php if(@$video_home_others): ?>
                                            <div style="  margin-top: 20px">
                                    <?php foreach ($video_home_others as $item): ?>
                                            <div>
                                                <?php
                                                $img_src = "";
                                                if(is_array($item->img_src)){
                                                    $img_src = @$item->img_src['thumbs']['740W_NONSQUARECROP']['path'];
                                                }
                                                ?>
                                                <a class="vid-cover-wrapper" title="{{$item->title}}" href="{{ route('home' , ['video_id' => $item->id]) }}" >
                                                    <div class="vid-cover" style="  background-image: url({{ $img_src }})"></div>
                                                    <h4>{{$item->title}}</h4>
                                                </a>

                                            </div>
                                            <?php
                                            endforeach;
                                            ?></div><?php
                                            endif; ?>

                                    </div>



                                {{--<div class="composs-panel-pager" style="margin-top: 0px">
                                    <a href="#" class="composs-pager-button">View more articles</a>
                                </div>--}}


                                <!-- END .composs-panel -->
                                </div>
                                <?php
                                                }
                                                ?>


                            </div>


                            <div class="item-small custom-items">
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

                                        <a href="{{ route('post.details.slug', $post->slug) }}"><img style="width: 90px" src="{{ $img_src }}" alt="" /></a>
                                    </div>
                                    <div class="item-content">
                                        <p class="item-type">{{$post->category->title}}</p>
                                        <h2><a href="{{ route('post.details.slug', $post->slug) }}">{{$post->title}}</a></h2>
                                    </div>
                                </div>

                                <?php
                                }
                                } ?>



                                    <div class="composs-panel news-brief-mobile">
                                        <?php
                                        if(false && @$brief_posts && $brief_posts->count()){
                                        ?>
                                        <div class="composs-panel-title" data-ot-css="border-color: #dd4b39;" style="border-color: #dd4b39;">
                                            <strong data-ot-css="background-color: #dd4b39;" style="background-color: #dd4b39;">News Brief</strong>
                                        </div>

                                        <div class="composs-panel-inner">

                                            <div class="composs-blog-list lets-do-1">

                                                <div class="item">
                                                    <?php
                                                    foreach ($brief_posts as $post){
                                                    ?>
                                                    <p class="news-links"><a href="{{ route('post.details.slug', $post->slug) }}">{{$post->past_duration}} - {{$post->title}}</a></p>

                                                    <?php
                                                    }
                                                    ?>
                                                </div>



                                            </div>

                                        </div>



                                    {{--<div class="composs-panel-pager" style="margin-top: 0px">
                                        <a href="#" class="composs-pager-button">View more articles</a>
                                    </div>--}}


                                    <!-- END .composs-panel -->
                                            <?php
                                            }
                                            ?>
                                        <div style="margin-top: 20px; border: 1px solid grey">
                                            <a href="http://www.iccpl.in/" target="_blank"><img src="{{ asset('frontend/images/new/iccpl_ad.jpg') }}"></a>
                                        </div>

                                            <?php if(@$video_home_default): ?>
                                            <div style="margin-top: 20px; text-align: center">
                                                <iframe width="300" height="200"
                                                        src="{{  Utility::getYoutubeEmbededUrl($video_home_default->youtube_url)}}">
                                                </iframe>
                                                <h5 style="    font-size: 11px;
                                                font-weight: bold;
                                                margin: 0px;
                                            }">{{$video_home_default->title}}</h5>
                                            </div>
                                            <?php endif; ?>

                                            <?php if(@$video_home_others): ?>
                                            <div style="  margin-top: 20px">
                                                <?php foreach ($video_home_others as $item): ?>
                                                <div>
                                                    <?php
                                                    $img_src = "";
                                                    if(is_array($item->img_src)){
                                                        $img_src = @$item->img_src['thumbs']['740W_NONSQUARECROP']['path'];
                                                    }
                                                    ?>
                                                    <a class="vid-cover-wrapper" title="{{$item->title}}" href="{{ route('home' , ['video_id' => $item->id]) }}" >
                                                        <div class="vid-cover" style="  background-image: url({{ $img_src }})"></div>
                                                        <h4>{{$item->title}}</h4>
                                                    </a>

                                                </div>
                                                <?php
                                                endforeach;
                                                ?></div><?php
                                            endif; ?>
                                    </div>



                            </div>



                        </div>

                    </div>
                </div>

                <!-- END .composs-panel -->
            </div>



            <!-- END .composs-main-content -->
        </div>

        <!-- BEGIN #sidebar -->


    </div>

    <!-- END .wrapper -->
</div>

<!-- BEGIN .content -->
@endsection