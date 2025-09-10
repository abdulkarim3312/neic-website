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
        <h5 class="card-title mb-0">Edit Menu</h5>
        <a href="{{ route('menus.index') }}" class="btn btn-dark waves-effect waves-light text-end btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('menus.update', $menu->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Bangla Name</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $menu->name_bn ?? '' }}" required name="name_bn" placeholder="name">
                                @error('name_bn')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">English Name</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $menu->name_en ?? '' }}" required name="name_en" placeholder="name">
                                @error('name_en')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <div class="mb-4">
                                <label for="menu_category_id">Menu Category</label>
                                <select name="menu_category_id" class="select2" required>
                                    <option value="">--Select--</option>
                                    @foreach ($menuCategories as $item)
                                        <option value="{{ $item->id }}" {{ $menu->menu_category_id ==  $item->id ? 'selected': ''}}>{{ $item->name_en ?? '' }}</option>
                                    @endforeach
                                </select>
                                @error('menu_category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12 mb-2">
                            <div class="mb-4">
                                <label for="status">Status</label>
                                <select name="status" class="form-select form-select-sm">
                                    <option value="1" {{ $menu->status == 1 ? 'selected': '' }}>Active</option>
                                    <option value="0" {{ $menu->status == 0 ? 'selected': '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-start mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save me-1"></i> Update
                </button>
                
                <a href="{{ route('menus.index') }}" class="btn btn-dark waves-effect waves-light btn-sm">
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
            allowClear: true,
            width: '100%' 
        });
    });
</script>
@endpush
