<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bangladesh Election Commission</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/details.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link rel="shortcut icon" href="asset/img/logo.png" type="image/x-icon">
    @yield('css')
</head>

<body>

<div class="container">
    <div class="shadow">
        @include('frontend.common.nav')

        <div class="bodyContent">
            @include('frontend.common.body_left_side')

            @yield('main-content')

            @if (Route::currentRouteName() == 'home.index')
                <div class="right">
                    <div class="card ">
                        <div class="card-header">
                            <p>কমিশন চেয়ারম্যান</p>
                        </div>
                        <div class="card-body">
                            <a href="#">
                                <img src="{{ asset('frontend/asset/img/shamim-hasnain.jpg') }}" alt="">
                                <span>বিচারপতি শামীম হাসনাইন</span>
                            </a>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <p>কমিশনের সদস্যবৃন্দ</p>
                        </div>
                        <div class="card-body">
                            @if ($members->isNotEmpty())
                                @foreach ($members as $item)
                                    <a class="border rounded" href="{{ route('member_details', $item->slug) }}">
                                        <img src="{{ asset($item->photo) }}" alt="">
                                        <span>{{ $item->name_bn }}</span>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @include('frontend.common.footer')
    </div>
</div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>    


    <script>
        
    </script>
    @yield('script')
</body>
</html>