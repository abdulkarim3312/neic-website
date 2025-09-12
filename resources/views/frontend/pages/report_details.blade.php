@extends('frontend.master')

@section('title', $article->title_bn ?? 'Article Details')

@section('css')
<style>
    .article-card {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .article-header {
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .article-body {
        line-height: 1.7;
    }
    .btn-view {
        background-color: #28a745;
        color: #fff;
    }
    .btn-view:hover {
        background-color: #218838;
        color: #fff;
    }
    .btn-download {
        background-color: #007bff;
        color: #fff;
    }
    .btn-download:hover {
        background-color: #0069d9;
        color: #fff;
    }
</style>
@endsection

@section('main-content')
<div class="center mx-auto" style="width: 75%;">
    <div class="article-card">
        <div class="article-header text-center">
            <h3 class="fw-bold">{{ $article->title_bn ?? '-' }}</h3>
            @if($article->created_at)
                <p class="text-muted">
                    প্রকাশের তারিখ: {{ \Carbon\Carbon::parse($article->created_at)->locale('bn')->isoFormat('D MMMM, YYYY') }}
                </p>
            @endif
        </div>

        <div class="article-body">
            {!! $article->details_bn ?? '<p>কোনো বিস্তারিত নেই।</p>' !!}
        </div>



        @if(!empty($article->attachment))
            <div class="text-start mt-4">
               Attachment:<a href="{{ asset($article->attachment) }}" target="_blank" class="btn mx-2">
                    Download File
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
