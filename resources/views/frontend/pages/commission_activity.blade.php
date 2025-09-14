@extends('frontend.master')

@section('title', 'Home')

@section('css')
    <style>

    </style>
@endsection

@section('main-content')
    <div class="center mx-auto card rounded-3 p-3" style="width: 75%; background-color: #f8f9fa;">
        <div class="personData">
            <div class="personAddress mt-4 p-3">
                <h2>{{ $commissionActivity->title ?? '' }}</h2>
                <p>
                    {!! $commissionActivity->description ?? '' !!}
                </p>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script>
        
    </script>
@endsection
