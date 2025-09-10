@extends('backend.master')

@section('title', 'menu')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
        <h5 class="card-title mb-0">Edit Attachment</h5>
        <a href="{{ route('attachments.index') }}" class="btn btn-dark waves-effect waves-light text-end btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('attachments.update', $attachment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 col-12 mb-2">
                            <div class="mb-4">
                                <label for="attachment_id">Attachment Category</label>
                                <select name="attachment_id" class="select2" required>
                                    <option value="">--Select--</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}" {{ $attachment->attachment_id == $item->id ? 'selected': '' }}>{{ $item->name_en ?? '' }}</option>
                                    @endforeach
                                </select>
                                @error('attachment_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <div class="mb-4">
                                <label for="status">Status</label>
                                <select name="status" class="form-select form-select-sm">
                                    <option value="1" {{ $attachment->status == 1 ? 'selected': '' }}>Active</option>
                                    <option value="0" {{ $attachment->status == 0 ? 'selected': '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Bangla Title</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $attachment->title_bn ?? '' }}" required name="title_bn" placeholder="Title">
                                @error('title_bn')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">English Title</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $attachment->title_en ?? '' }}" required name="title_en" placeholder="Title">
                                @error('title_en')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mb-2">
                            <div class="mb-4">
                                <label for="file_name">File</label>
                                <input type="file" class="form-control form-control-sm" name="file_name" placeholder="Select file">
                                @error('file_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                @if(isset($attachment->file_name))
                                    <small>Current file: 
                                        <a href="{{ asset($attachment->file_name) }}" target="_blank">
                                            {{ basename($attachment->file_name) }}
                                        </a>
                                    </small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mb-2">
                            <div class="mb-4">
                                <label for="file_display_name">File Title Name</label>
                               <input type="text" class="form-control form-control-sm" value="{{ $attachment->file_display_name ?? '' }}" required name="file_display_name" placeholder="Display name">
                                @error('file_display_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-start mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save me-1"></i> Update
                </button>
                
                <a href="{{ route('attachments.index') }}" class="btn btn-dark waves-effect waves-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "--Select--",
            width: '100%' 
        });
    });
</script>
@endpush
