@extends('backend.master')

@section('title', 'site setting')
@push('styles')
<style>
    .big-checkbox {
        transform: scale(1.5); 
        -webkit-transform: scale(1.5); 
        margin: 5px;
        cursor: pointer;
    }
</style>
@endpush
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">About Page Information</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('about_store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Title</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $about->title ?? '' }}" name="title">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Description</label>
                                <textarea name="description" class="form-control my-editor">{{ $about->description ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-start mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save me-1"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-1">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Contact Page Information</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('contact_store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="row">
                <div class="row">
                    <div class="col-md-6 col-12 mb-2">
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">Title</label>
                            <input type="text" class="form-control form-control-sm" value="{{ $contact->title ?? '' }}" name="title">
                        </div>
                    </div>
                    <div class="col-md-6 col-12 mb-2">
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm" value="{{ $contact->email ?? '' }}" name="email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-12 mb-2">
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">Address</label>
                            <input type="text" class="form-control form-control-sm" value="{{ $contact->address ?? '' }}" name="address">
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-start mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save me-1"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-1">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Commission Activities (কমিশনের কার্যপরিধি)</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('commission_activity_store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="row">
                <div class="row">
                    <div class="col-md-12 col-12 mb-2">
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">Title</label>
                            <input type="text" class="form-control form-control-sm" value="{{ $commissionActivity->title ?? '' }}" name="title">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-12 mb-2">
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">Description</label>
                            <textarea name="description" class="form-control my-editor">{{ $commissionActivity->description ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-start mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save me-1"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
@push('scripts')
<script>
    tinymce.init({
    selector: 'textarea.my-editor',
    height: 400,
    plugins: 'image link media code lists table',
    toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image media | code',
    relative_urls: false,
    automatic_uploads: true,
    file_picker_types: 'image file',
    file_picker_callback: function(callback, value, meta) {
        let cmsURL = '{{ url("laravel-filemanager") }}?editor=tinymce&type=' + (meta.filetype === 'image' ? 'Images' : 'Files');
        console.log('Opening Filemanager at:', cmsURL); // Debug
        let x = window.innerWidth * 0.8;
        let y = window.innerHeight * 0.8;

        tinyMCE.activeEditor.windowManager.openUrl({
            url: cmsURL,
            title: 'File Manager',
            width: x,
            height: y,
            resizable: true,
            maximizable: true,
            inline: true,
            onMessage: function(api, message) {
                if (message.content) {
                    callback(message.content, { alt: '' }); // Ensure proper callback
                }
            },
            onClose: function() {
                console.log('Filemanager closed');
            }
        });
    }
});
    
</script>
@endpush
