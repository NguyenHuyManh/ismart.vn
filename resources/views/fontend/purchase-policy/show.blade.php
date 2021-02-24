@extends('fontend.layout.post')

@section('title')
    <title>ISMART STORE - {{ $item->title }}</title>
@endsection

@section('breadcrumb')
    <div class="secion" id="breadcrumb-wp">
        <div class="secion-detail">
            <ul class="list-item clearfix">
                <li>
                    <a href="{{url('/')}}" title="">Trang chủ</a>
                </li>
                <li>
                    {{ $item->title }}
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="main-content fl-right" style="background: #fff; padding: 20px 15px;">
        <div class="section" id="detail-blog-wp">
            <div class="section-head clearfix">
                <h3 class="section-title" style="margin-bottom: 20px">{{ $item->title }}</h3>
            </div>
            <div class="section-detail">
                <div class="detail">
                    {!! $item->content !!}
                </div>
            </div>
        </div>
    </div>
@endsection
