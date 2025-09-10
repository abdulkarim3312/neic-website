@extends('backend.master')

@section('title', 'menu')
@push('styles')
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
<style>
    .big-checkbox {
        transform: scale(1.5); 
        -webkit-transform: scale(1.5); 
        margin: 5px;
        cursor: pointer;
    }
    .select2-container .select2-selection--single {
        height: 40px !important;  /* Adjust height as needed */
        padding: 10px !important;
        font-size: 12px; /* Adjust text size */
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 6px!important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 18px!important;
    }
</style>
@endpush
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Edit Article</h5>
        <a href="{{ route('articles.index') }}" class="btn btn-dark waves-effect waves-light text-end btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 col-12 mb-2">
                            <div class="mb-4">
                                <label for="article_category_id">Article Category</label>
                                <select name="article_category_id" class="form-select form-select-sm" required>
                                    <option value="">--Select--</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}" {{ $article->article_category_id ==  $item->id ? 'selected': ''}}>{{ $item->name_en ?? '' }}</option>
                                    @endforeach
                                </select>
                                @error('article_category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <div class="mb-4">
                                <label for="status">Status</label>
                                <select name="status" class="form-select form-select-sm">
                                    <option value="1" {{ $article->status == 1 ? 'selected': '' }}>Active</option>
                                    <option value="0" {{ $article->status == 0 ? 'selected': '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Bangla Title</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $article->title_bn ?? '' }}" required name="title_bn" placeholder="Title">
                                @error('title_bn')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">English Title</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $article->title_en ?? '' }}" required name="title_en" placeholder="Title">
                                @error('title_en')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Bangla Details</label>
                                <textarea type="text" class="form-control my-editor" name="details_bn" placeholder="Details">{{ $article->details_bn ?? '' }}</textarea>
                                @error('details_bn')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">English Details</label>
                                <textarea type="text" class="form-control my-editor" name="details_en" placeholder="Details"> {{ $article->details_en ?? '' }}</textarea>
                                @error('details_en')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mb-2">
                            <div class="mb-3">
                                <label for="attachment" class="form-label">Attachment</label>
                                <input type="file" class="form-control form-control-sm" name="attachment">
                                @error('attachment')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                @if(isset($article->attachment) && file_exists(public_path($article->attachment)))
                                    <small class="d-block mt-1">
                                        Current file: 
                                        <a href="{{ asset($article->attachment) }}" target="_blank">
                                            {{ $article->attachment_display_name ?? basename($article->attachment) }}
                                        </a>
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-start mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save me-1"></i> Update
                </button>
                
                <a href="{{ route('articles.index') }}" class="btn btn-dark waves-effect waves-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.4.2/tinymce.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<script>
    tinymce.init({
        selector: 'textarea.my-editor',
        height: 400,
        plugins: 'image link media code lists table',
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image media | code',
        relative_urls: false,
        automatic_uploads: true,
        file_picker_types: 'image file',
        file_picker_callback: function (callback, value, meta) {
            let cmsURL = '/laravel-filemanager?editor=' + meta.fieldname;
            if (meta.filetype === 'image') cmsURL += "&type=Images";
            if (meta.filetype === 'file') cmsURL += "&type=Files";

            let x = window.innerWidth * 0.8;
            let y = window.innerHeight * 0.8;

            tinyMCE.activeEditor.windowManager.openUrl({
                url: cmsURL,
                title: 'File Manager',
                width: x,
                height: y,
                resizable: "yes",
                close_previous: "no",
                onMessage: function (api, message) {
                    callback(message.content);
                }
            });
        }
    });
    
</script>
@endpush
