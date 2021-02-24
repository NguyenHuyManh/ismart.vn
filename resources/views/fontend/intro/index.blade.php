@extends('fontend.layout.post')

@section('title')
    <title>Giới thiệu</title>
@endsection

@section('breadcrumb')
    <div class="secion" id="breadcrumb-wp">
        <div class="secion-detail">
            <ul class="list-item clearfix">
                <li>
                    <a href="{{url('/')}}" title="">Trang chủ</a>
                </li>
                <li>
                    Giới thiệu
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
<div class="main-content fl-right" style="background: #fff; padding: 20px 15px;">
    <div class="section" id="detail-blog-wp">
        <div class="section-head clearfix">
            <h3 class="section-title">Giới thiệu</h3>
        </div>
        <div class="section-detail">
            <div class="detail">
                @if ($introduce)
                {!!$introduce->content!!}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
