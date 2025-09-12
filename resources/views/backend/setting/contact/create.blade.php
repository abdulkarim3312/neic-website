@extends('backend.master')

@section('title', 'contact')
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
        <h5 class="card-title mb-0">Create Attachment</h5>
        <a href="{{ route('attachment-categories.index') }}" class="btn btn-dark waves-effect waves-light text-end btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
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

@endsection
@push('scripts')
<script>

</script>
@endpush
