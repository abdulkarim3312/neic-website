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
        <h5 class="card-title mb-0">Create Committee Member</h5>
        <a href="{{ route('committee-members.index') }}" class="btn btn-dark waves-effect waves-light text-end btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('committee-members.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 col-12 mb-2">
                            <div class="mb-4">
                                <label for="member_category_id">Category</label>
                                <select name="member_category_id" class="select2" required>
                                    <option value="">--Select--</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->name_en ?? '' }}</option>
                                    @endforeach
                                </select>
                                @error('member_category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12 mb-2">
                            <div class="mb-4">
                                <label for="designation_id">Designation</label>
                                <select name="designation_id" class="select2" required>
                                    <option value="">--Select--</option>
                                    @foreach ($designations as $item)
                                        <option value="{{ $item->id }}">{{ $item->name_en ?? '' }}</option>
                                    @endforeach
                                </select>
                                @error('designation_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12 mb-2">
                            <div class="mb-4">
                                <label for="status">Status</label>
                                <select name="status" class="form-select form-select-sm">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Bangla Name</label>
                                <input type="text" class="form-control form-control-sm" required name="name_bn" placeholder="name">
                                @error('name_bn')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">English Name</label>
                                <input type="text" class="form-control form-control-sm" required name="name_en" placeholder="name">
                                @error('name_en')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Mobile</label>
                                <input type="text" class="form-control form-control-sm" required name="mobile" placeholder="mobile">
                                @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12 mb-2">
                            <div class="mb-3">
                                <label for="email">Email</label>
                               <input type="email" class="form-control form-control-sm" required name="email" placeholder="email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-12 mb-2">
                            <div class="mb-3">
                                <label for="article_url">Article Url</label>
                               <input type="text" class="form-control form-control-sm" required name="article_url" placeholder="url">
                                @error('article_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-12 mb-2">
                            <div class="mb-4">
                                <label for="photo">Photo</label>
                               <input type="file" class="form-control form-control-sm" required name="photo" placeholder="url">
                                @error('photo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mb-2">
                            <div class="mb-4">
                                <label for="photo">Description</label>
                               <textarea name="description" class="form-control" id="" cols="30" rows="5"></textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-start mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save me-1"></i> Save
                </button>
                
                <a href="{{ route('committee-members.index') }}" class="btn btn-dark waves-effect waves-light btn-sm">
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
