@extends('fontend.layout.post')

@section('title')
    <title>Liên hệ</title>
@endsection

@section('breadcrumb')
    <div class="secion" id="breadcrumb-wp">
        <div class="secion-detail">
            <ul class="list-item clearfix">
                <li>
                    <a href="{{url('/')}}" title="">Trang chủ</a>
                </li>
                <li>
                    Liên hệ
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="main-content fl-right" style="background: #fff; padding: 20px 15px;">
        <div class="section" id="detail-blog-wp">
            <div class="section-head clearfix">
                <h3 class="section-title">Liên hệ với chúng tôi</h3>
                <div class="info-us">
                    @if ($contact)
                        {!! $contact->info_contact !!}
                    @endif 
                </div>
                <div class="info-map">
                    @if ($contact)
                        {!! $contact->info_map !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
