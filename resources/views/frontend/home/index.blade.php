@extends('frontend.master')

@section('title', 'Home')

@section('css')
    <style>
        .bodyContent .center {
            width: 55%!important;
            float: left;
            overflow: hidden;
            padding: 5px;
        }
    </style>
@endsection

@section('main-content')

<div class="center">
    <div class="heading">
        সাম্প্রতিক তথ্যসমূহ
    </div>

    <div class="dataList">
        <ul>
            @if (count($attachments) > 0)
                @foreach ($attachments as $item)
                    <li>
                        <a href="">
                            <img src="{{ asset('frontend/asset/img/right-arrow.webp') }}" alt="right-arrow"> 
                            <a href="{{ route('commission-report-details', $item->slug) }}">{{ $item->title_bn ?? ''}}</a> 
                        </a>
                    </li>
                @endforeach
            @endif
            
        </ul>
    </div>
</div>
    
@endsection


@section('script')
    <script>
        
    </script>
@endsection
