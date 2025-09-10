@extends('backend.master')

@section('title', 'menu category')
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
        <h5 class="card-title mb-0">Edit Menu Category</h5>
        <a href="{{ route('menu-categories.index') }}" class="btn btn-dark waves-effect waves-light text-end btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('menu-categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Bangla Name</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $category->name_bn ?? '' }}" required name="name_bn" placeholder="name">
                                @error('name_bn')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">English Name</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $category->name_en ?? '' }}" required  name="name_en" placeholder="name">
                                @error('name_en')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mb-2">
                            <div class="mb-4">
                                <label for="status">Status</label>
                                <select name="status" class="form-select form-select-sm">
                                    <option value="1" {{ $category->status == 1 ? 'selected': '' }}>Active</option>
                                    <option value="0" {{ $category->status == 0 ? 'selected': '' }}>Inactive</option>
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
                
                <a href="{{ route('menu-categories.index') }}" class="btn btn-dark waves-effect waves-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
@push('scripts')
<script>

</script>
@endpush
