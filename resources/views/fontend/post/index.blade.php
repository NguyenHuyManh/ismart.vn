@extends('fontend.layout.post')

@section('title')
    <title>Tin tức</title>
@endsection

@section('breadcrumb')
    <div class="secion" id="breadcrumb-wp">
        <div class="secion-detail">
            <ul class="list-item clearfix">
                <li>
                    <a href="{{url('/')}}" title="">Trang chủ</a>
                </li>
                <li>
                    Tin tức
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
<div class="main-content fl-right">
    <div class="section" id="list-blog-wp">
        <div class="section-head clearfix">
            <h3 class="section-title">Tin tức</h3>
        </div>
        <div class="section-detail">
            <ul class="list-item">
                @foreach ($posts as $item)
                    <li class="clearfix">
                        @if ($item->avatar)
                            <a href="{{route('post.show', ['slug' => $item->slug, 'id' => $item->id])}}" title="" class="thumb fl-left">
                                <img src="{{url($item->avatar)}}" alt="">
                            </a>
                        @endif                       
                        <div class="info fl-right">
                            <a href="{{route('post.show', ['slug' => $item->slug, 'id' => $item->id])}}" title="" class="title">{{$item->title}}</a>
                            <span class="create-date">{{$item->created_at->format('d-m-Y')}}</span>
                            <p class="desc">{{$item->desc}}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="section" id="paging-wp">
        <div class="section-detail">
            {{$posts->links()}}
        </div>
    </div>
</div>
@endsection
