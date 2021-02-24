@extends('fontend.layout.post')

@section('title')
    <title>{{$detailPost->title}}</title>
@endsection

@section('breadcrumb')
    <div class="secion" id="breadcrumb-wp">
        <div class="secion-detail">
            <ul class="list-item clearfix">
                <li>
                    <a href="{{url('/')}}" title="">Trang chủ</a>
                </li>
                <li>
                    <a href="{{route('post.index')}}" title="">Tin tức</a>
                </li>
                <li>
                   {{$detailPost->title}}
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
<div class="main-content fl-right" style="background: #fff; padding: 20px 15px;">
    <div class="section" id="detail-blog-wp">
        <div class="section-head clearfix">
            <h3 class="section-title">{{$detailPost->title}}</h3>
        </div>
        <div class="section-detail">
            <span class="create-date">{{$date_time}}</span>
            <div class="detail">
                {!! $detailPost->content !!}
            </div>
        </div>
    </div>
</div>
@endsection
