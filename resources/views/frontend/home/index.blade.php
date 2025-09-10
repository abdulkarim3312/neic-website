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
            
            <li>
                <a href="">
                    <img src="{{ asset('frontend/asset/img/right-arrow.webp') }}" alt="right-arrow"> 
                    <span> (নং-৫১০) জাতীয় সংসদের নির্বাচনি এলাকার সীমানার প্রাথমিক তালিকার উপর দাবী/আপত্তি নিষ্পত্তির লক্ষ্যে শুনানীর তারিখ, সময় ও স্থান নির্ধারণ সংক্রান্ত প্রজ্ঞাপন।</span> 
                </a>
            </li>
        </ul>
    </div>
</div>
    
@endsection


@section('script')
    <script>
        
    </script>
@endsection
