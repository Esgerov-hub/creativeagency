<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\Utils;
?>
<style>
    .post-img-m {
        min-height: 200px;
    }

    .post-img-m img {
        object-fit: cover;
        min-height: 200px;
        width: 100%;
        height: 100%;
    }

    .owl-carousel .item {
        padding: 1rem;
    }

    .owl-carousel__nav {
        display: flex;
        gap: 20px;
        align-items: center;
        justify-content: flex-end;
    }

    .owl-carousel__prev,
    .owl-carousel__next {
        width: fit-content;
        background: #aba9a9;
        color: #fff;
        padding: 8px 15px;
        cursor: pointer;
        border-radius: 20px;
    }

    .owl-carousel__prev:hover,
    .owl-carousel__next:hover {
        background: #858585;
    }

    .owl-carousel__next {
        right: 0px;
    }

    .m_news {
        padding: 80px;
        position: relative;
    }

    @media only screen and (max-width: 480px) {
        #call {
            left: 0 !important;
            margin: 0 auto;
        }

        .adress {
            margin: 0 auto !important;
            padding: 0 50px;
        }

        .social_media_mobile {
            margin: 0;
            padding: 0 40px;
        }

        .owl-carousel__nav {
            justify-content: center;
        }

        .owl-dots {
            margin-bottom: 20px;
        }
    }
</style>
<!-- Slider Area Start Here -->
<div class="slider-area slider-layout2">
    <div class="bend niceties preview-1">

        <div id="ensign-nivoslider-4" class="slides">
            <?php foreach ($slides as  $loop=>$slider) { ?>
                <img src="<?= Url::base(true); ?>/uploads/slide/<?= !empty($slider['image'])? $slider['image']: null ?>" alt="slider" title="#slider-direction-<?= 1+$loop ?>" />
            <?php } ?>
        </div>

        <?php foreach ($slides as  $key=>$slide) { ?>
            <div id="slider-direction-<?= 1+$key ?>" class="t-cn slider-direction">
                <div class="slider-content s-tb slide-<?= 1+$key ?>">
                    <div class="text-left title-container s-tb-c">
                        <div class="container">
                            <h1 class="slider-big-text"><?= !empty($slide['title'])? $slide['title']: null  ?></h1>
                            <div class="slider-paragraph"><?= !empty( $slide['text'])?  $slide['text']: null ?></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<!-- Slider Area End Here -->
<!-- Service Area Start Here -->
<section class="service-wrap-layout1">
    <div class="container">
        <div class="row">
            <?php foreach ($blocks as  $key=>$block) { ?>
                <div class="col-xl-4 col-md-6">
                    <div class="service-box-layout1">
                        <div class="item-img">
                            <img src="<?= Url::base(true); ?>/uploads/block/<?= !empty($block['image'])? $block['image']: null ?>" alt="service">
                        </div>
                        <div class="item-content" style="    padding: 18px 102px;!important;">
                            <h3 class="item-title"><a href=""><?= !empty($block['title'])? $block['title']: null   ?></a></h3>
                            <div class="btn-wrap">
<!--                                <a href="" class="item-btn"><i class="fas fa-long-arrow-alt-right"></i></a>-->
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- Service Area End Here -->
<!-- About Us Area Start Here -->
<section class="about-wrap-layout1">
    <div class="container">
        <div class="row">

            <div class="col-xl-6 col-12">
                <div class="about-box-layout2">
                    <div class="item-img">
                        <video muted autoplay="true" loop="true"width="500" height="350" controls>
                            <source src="<?=  Url::base(true); ?>/uploads/contents/video/<?= !empty($generalInformation['video'])?$generalInformation['video']: null ?>" type="video/mp4">
                        </video>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var video = document.getElementById("myVideo");

            video.play();
            video.loop = true;
            video.muted = true;
    });
</script>

                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-12">
                <div class="about-box-layout1">
                    <div class="item-subtitle"><?= Yii::t('app','general_information') ?>  </div>
                    <h2 class="item-title"><?= !empty($generalInformation['title'])? $generalInformation['title']: null   ?></h2>
                    <p><?= !empty($generalInformation['text'])? $generalInformation['text']: null   ?></p>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Us Area End Here -->
<section class="pd-y-80">
    <div class="container">
        <div class="heading-layout1">
            <h2 class="item-title"><?= Yii::t('app','partners_suppliers') ?></h2>
        </div>
        <div class="rc-carousel nav-control-layout2" data-loop="true" data-items="10" data-margin="30"
             data-autoplay="true" data-autoplay-timeout="0" data-smart-speed="1000" data-dots="false"
             data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="true"
             data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="true"
             data-r-x-medium-dots="false" data-r-small="3" data-r-small-nav="true"
             data-r-small-dots="false" data-r-medium="3" data-r-medium-nav="true"
             data-r-medium-dots="false" data-r-large="4" data-r-large-nav="true"
             data-r-large-dots="false" data-r-extra-large="4" data-r-extra-large-nav="true"
             data-r-extra-large-dots="false">
            <?php foreach ($partners as $key=>$partner) { ?>
                <div class="brand-box-layout2">
                    <a href="<?= !empty($partner['url'])? $partner['url']: null   ?>"  target="_blank">
                        <div class="item-img">
                            <img src="<?= Url::base(true); ?>/uploads/partner/<?= !empty($partner['image'])? $partner['image']: null  ?>" alt="<?= !empty($partner['title'])? $partner['title']: null ?>">
                        </div></a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- Why Choose Area Start Here -->

<section class="why-choose-wrap-layout1">
    <div class="container">
        <div class="row">

            <div class="col-xl-6 col-12">
                <div class="about-box-layout2">
                    <div class="item-img">
                        <div class="main-img">
                            <img src="<?= Url::base(true); ?>/uploads/contents/<?= !empty($listOfService['image'])? $listOfService['image']: null ?>" alt="about">
                        </div>
                        <div class="sub-img"  style="z-index: 3!important; left: -75px!important; bottom: -210px!important; ">
                            <img src="<?= Url::base(true); ?>/uploads/contents/<?= !empty($listOfService['image_other'])? $listOfService['image_other']: null ?>" alt="about">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-12">
                <div class="about-box-layout1">
                    <div class="item-subtitle"><?= Yii::t('app','list_of_service') ?></div>
                    <p><?= !empty($listOfService['text'])? $listOfService['text']: null ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Why Choose Area End Here -->
<!-- Team Area Start Here -->
<section class="team-wrap-layout1 section-shape1">
    <div class="container">
        <div class="heading-layout1">
            <h2 class="item-title"><?= Yii::t('app','photo_gallery_text') ?></h2>
        </div>
        <div class="rc-carousel nav-control-layout2" data-loop="true" data-items="10" data-margin="30"
             data-autoplay="true" data-autoplay-timeout="1000" data-smart-speed="1000" data-dots="false"
             data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="true"
             data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="true"
             data-r-x-medium-dots="false" data-r-small="3" data-r-small-nav="true"
             data-r-small-dots="false" data-r-medium="3" data-r-medium-nav="true"
             data-r-medium-dots="false" data-r-large="4" data-r-large-nav="true"
             data-r-large-dots="false" data-r-extra-large="4" data-r-extra-large-nav="true"
             data-r-extra-large-dots="false">
            <?php foreach ($photos as  $key=>$gallery) { ?>
                <div class="brand-box-layout2">
                    <div class="team-box-layout1">
                        <div class="item-img bg-common" data-bg-image="img/team/bg-shape.png">
                            <img src="<?= Url::base(true); ?>/uploads/photos/<?=  !empty($gallery['image'])? $gallery['image']: null ?>" alt="<?=  !empty($gallery['title'])? $gallery['title']: null ?>">
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<!-- Team Area End Here -->

<section class="pd-y-80">
    <div class="container">
        <div class="heading-layout1">
            <h2 class="item-title"><?= Yii::t('app','valued_customers') ?></h2>
        </div>
        <div class="rc-carousel nav-control-layout2" data-loop="true" data-items="10" data-margin="30"
             data-autoplay="true" data-autoplay-timeout="1000" data-smart-speed="1000" data-dots="false"
             data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="true"
             data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="true"
             data-r-x-medium-dots="false" data-r-small="3" data-r-small-nav="true"
             data-r-small-dots="false" data-r-medium="3" data-r-medium-nav="true"
             data-r-medium-dots="false" data-r-large="4" data-r-large-nav="true"
             data-r-large-dots="false" data-r-extra-large="4" data-r-extra-large-nav="true"
             data-r-extra-large-dots="false">
            <?php foreach ($clients as $key=>$client) { ?>
                <div class="brand-box-layout2">
                    <a href="<?= isset($client['url'])? $client['url']: '' ?>"  target="_blank">
                        <div class="item-img">
                            <img src="<?= Url::base(true); ?>/uploads/clients/<?=  !empty($client['image'])? $client['image']: null ?>" alt="<?=  !empty($client['title'])? $client['title']: null ?>">
                        </div></a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<section class="pd-y-80 m_news">
    <div class="heading-layout1">
        <h2 class="item-title"><?= Yii::t('app','our_latest_news') ?></h2>
    </div>
    <div class="owl-carousel owl-theme">
        <?php foreach ($blogs as  $key=>$blog) { ?>
        <div class="item">
            <div>
                <div class="blog-box-layout1">
                    <div class="post-img post-img-m">
                        <a href="<?=  !empty($blog['slug'])? Yii::$app->urlManager->createUrl(['site/blog-detail','slug'=>$blog['slug']]): null; ?>">
                            <img src="<?= Url::base(true); ?>/uploads/blog/<?=  !empty($blog['image'])? $blog['image']: null  ?>"  alt="<?= !empty($blog['title'])? $blog['title']: null ?>">
                        </a>
                    </div>
                    <div class="post-content">
                        <div class="post-date"><?= !empty($blog['add_datetime'])? $formattedDate = date("d M, Y", strtotime($blog['add_datetime'])): null  ?></div>
                        <h3 class="post-title">
                            <a href="<?=  !empty($blog['slug'])? Yii::$app->urlManager->createUrl(['site/blog-detail','slug'=>$blog['slug']]): null; ?>"><?= !empty($blog['title'])? $blog['title']: null ?></a>
                        </h3>
                        <p></p>
                        <p>
                            <?=  !empty($blog['text'])? Utils::limitStringLength($blog['text'], 100): null  ?>
                        </p>
                        <a href="<?=  !empty($blog['slug'])? Yii::$app->urlManager->createUrl(['site/blog-detail','slug'=>$blog['slug']]): null; ?>" class="ghost-btn-md item-btn body-text border-aash">
                            <?= Yii::t('app','read_more') ?>
                            <i  class="fas fa-long-arrow-alt-right text-accent" ></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="owl-carousel__nav">
        <div class="owl-carousel__prev" style="font-size: 20px">&#8592;</div>
        <div class="owl-carousel__next" style="font-size: 20px">&#8594;</div>
    </div>
</section>
<!-- Google Map Area Start Here -->
<div class="google-map-area">
    <iframe src="https://www.google.com/maps/embed?pb=!1m13!1m8!1m3!1d6092.542215037972!2d49.563372!3d40.225274!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNDDCsDEzJzMzLjIiTiA0OcKwMzQnMDAuNyJF!5e0!3m2!1sen!2saz!4v1696421326063!5m2!1sen!2saz"  width="1800" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</div>
<!-- Google Map Area End Here -->
<!-- Call To Action Area Start Here -->
<section class="action-wrap-layout1">
    <div class="container">
        <div class="row">
            <div class="col-4" id="call" style="left: -68px;!important;">
                <div class="action-box-layout1">
                    <div class="item-content">
                        <div class="item-icon">
                            <i class="flaticon-call-answer"></i>
                        </div>
                        <h2 class="item-title" style="font-size: 18px;!important;"><span><?= Yii::t('app','call_text') ?> :</span> <?= Yii::t('app','phone_number') ?></h2>
                    </div>
                </div>
            </div>
            <div class="offset-lg-8 adress" style="margin-left: -16.333333%;!important;">
                <div class="header-topbar-layout1">
                    <div class="header-top-left">
                        <ul>
                            <li><i class="fas fa-map-marker-alt"></i><?= Yii::t('app','address') ?></li>
                            <li><i class="far fa-clock"></i><?= Yii::t('app','opening_hours') ?> </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="offset-lg-4 social_media_mobile" style="margin-left: 1.333333%;!important;">
                <div class="header-topbar-layout1">
                    <div class="header-top-right">
                        <ul>
                            <li class="social-icon">
                                <!--<a href="mailto:<?php /*= Yii::t('app','email_url') */?>"><i class="fa fa-envelope" aria-hidden="true"></i></a>-->
                                <a href="tel:<?= Yii::t('app','phone_number') ?>"><i class="fa fa-phone" aria-hidden="true"></i></a>
                                <a href="<?= Yii::t('app','whatsapp') ?>"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
                                <a href="<?= Yii::t('app','facebook') ?>"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                                <a href="<?= Yii::t('app','twitter') ?>"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                                <a href="<?= Yii::t('app','linkedin') ?>"><i class="fab fa-linkedin" aria-hidden="true"></i></a>
                                <a href="mailto:sales@farsagroup.az"><i class="far fa-envelope"></i> sales@farsagroup.az </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
    $(document).ready(function () {
        const owl = $(".owl-carousel");
        owl.owlCarousel({
            loop: true,
            margin: 5,
            nav: false,
            items: 3,
            dots: true,
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 2,
                },
                1000: {
                    items: 3,
                },
            },
        });

        // Custom Navigation
        $(".owl-carousel__next").click(() =>
            owl.trigger("next.owl.carousel")
        );
        $(".owl-carousel__prev").click(() =>
            owl.trigger("prev.owl.carousel")
        );
    });
</script>
<!-- Call To Action Area End Here -->
