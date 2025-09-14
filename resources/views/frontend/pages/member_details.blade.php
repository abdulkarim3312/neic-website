@extends('frontend.master')

@section('title', 'Home')

@section('css')
    <style>
    </style>
@endsection

@section('main-content')
    <div class="center mx-auto" style="width: 75%;">
        <div class="heading">
                {{ $memberDetails->name_bn ?? ''}} এঁর জীবনবৃত্তান্ত 
        </div>
        <div class="personData">
            <div class="personaHeader">
                <div class="dataBox">
                    <h3>{{ $memberDetails->name_bn ?? '' }}</h3>
                    <span>{{ $memberDetails->designation->name_bn ?? '' }}</span>
                    <span>জাতীয় সংসদ নির্বাচন (২০১৪, ২০১৮, ২০২৪) তদন্ত কমিশন</span>
                </div>
                <div class="imageBox">
                    <img src="{{ asset($memberDetails->photo) }}" alt="">
                </div>
            </div>

            <div class="personBody">
                <p>{{ $memberDetails->description ?? '' }}</p>
                {{-- <p>হাসনাইন এবং বিচারপতি এম আর হাসান ২০১১ সালের এপ্রিলে দল ও পুলিশের মধ্যে সংঘর্ষের সময় পুলিশ কর্মকর্তাদের লাঞ্ছিত করার অভিযোগে দায়ের করা মামলায় বাংলাদেশ জামায়াত-ই-ইসলামী নেতাদের জামিন মঞ্জুর করেন।</p>
                <p>হাসনাইন ১০১৭ সালে বাংলাদেশের স্বাধীনতা যুদ্ধের সময় যুদ্ধাপরাধের জন্য সালাউদ্দিন কাদের চৌধুরীর আপিলের পক্ষে সাক্ষী ছিলেন।তার মা জিন্নাত আরা বেগম প্রাথমিক বিচারে চৌধুরীর পক্ষে বিবৃতি লিখেছিলেন।</p>
                <p>&nbsp;</p> --}}
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        
    </script>
@endsection
