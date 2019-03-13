@extends('front._layouts._master')
@section('content')
<div class="html-top-content">
  <header class="theme-main-header">
    <div class="container">
      <div class="menu-wrapper clearfix">
        <div class="logo float-left">
          <a href="#.">
            <img src="{{ url(settings('logo')) }}" alt="Logo" style="width:72px;">
          </a>
        </div>
        <ul class="button-group float-right">
          <li>
            <a href="{{ url(settings('facebook')) }}" class="tran3s" style="width: 78px">
              <i class="fa fa-facebook" aria-hidden="true"></i>
            </a>
          </li>
          <li>
            <a href="{{ url(settings('twitter')) }}" class="tran3s" style="width: 78px">
              <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>
          </li>
          <li>
            <a href="{{ url(settings('instagram')) }}" class="tran3s" style="width: 78px">
              <i class="fa fa-instagram" aria-hidden="true"></i>
            </a>
          </li>
          <li>
            <a href="{{ url(settings('linkedin')) }}" class="tran3s" style="width: 78px">
              <i class="fa fa-linkedin" aria-hidden="true"></i>
            </a>
          </li>
        </ul>
        
      </div>
    </div>
  </header>
  <div id="theme-main-banner" class="banner-one">
    <div data-src="front/images/home/slide-1.jpg">
      <div class="camera_caption">
        <div class="main-container">
          <div class="container">
            <h5 class="wow fadeInUp animated">{{ settings('app_name_en') }}</h5>
            <h1 class="wow fadeInUp animated">Download Now !.</h1>
            <a href="{{ url(settings('ios_app')) }}" class="tran3s wow fadeInLeft animated button-one" data-wow-delay="0.499s">
              <i class="fa fa-apple" aria-hidden="true"></i>App Store
            </a>
            <a href="{{ url(settings('android_app')) }}" class="tran3s wow fadeInRight animated button-two" data-wow-delay="0.499s">
              <img src="{{ url('front/images/icon/2.png') }}" alt="">GooglePlay
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop