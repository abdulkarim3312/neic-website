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
                {{-- <h5>Bangladesh Election Commission</h5> --}}
                <h5>{{ $contact->title ?? '' }}</h5>
                <p>{{ $contact->address ?? '' }}</p>
                <p>ইমেইল: <a href="feedback@neic.gov.bd">{{ $contact->email ?? '' }}</a></p>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script>
        
    </script>
@endsection
