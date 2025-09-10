@extends('frontend.master')

@section('title', 'Home')

@section('css')
    <style>

    </style>
@endsection

@section('main-content')
<div class="center mx-auto card rounded-3 p-3" style="width: 75%; background-color: #f8f9fa;">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="text-center mb-3">
        <h2 class="fw-bold">মতামত ফর্ম</h2>
        <h6 class="text-muted">বিগত ২০১৪, ২০১৮ এবং ২০২৪ সালের জাতীয় সংসদ নির্বাচন সংক্রান্ত</h6>
    </div>
    <div class="personData">
        <form action="{{ route('comment.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label fw-semibold">আপনার নাম</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="আপনার নাম লিখুন">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label fw-semibold">ফোন নম্বর</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="আপনার ফোন নম্বর লিখুন">
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="comment" class="form-label fw-semibold">আপনার মতামত</label>
                    <textarea class="form-control" id="comment" required name="comment" rows="7" placeholder="আপনার মতামত লিখুন"></textarea>
                    @error('comment')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="attachment" class="form-label fw-semibold">সংশ্লিষ্ট ফাইল (যদি থাকে)</label>
                    <input class="form-control" type="file" id="attachment" name="attachment">
                    @error('attachment')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 text-center mt-3">  
                    <button class="btn btn-primary px-4 fw-bold" type="submit">
                        Submit
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>


@endsection


@section('script')
    <script>
        
    </script>
@endsection
