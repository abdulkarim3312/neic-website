@extends('frontend.master')

@section('title', $category->name_bn ?? 'Members')

@section('css')
<style>
.person-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    transition: 0.3s;
    background-color: #fff;
}
.person-card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.person-card img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 10px;
}
.person-card span {
    display: block;
    font-weight: 500;
    margin-top: 5px;
}
.card-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}
.card {
    border-radius: 8px;
}
.card-title {
    font-size: 20px;
    font-weight: bold;
}
.table td {
    vertical-align: middle;
    padding: 6px 10px;
}
</style>
@endsection

@section('main-content')
<div class="center mx-auto" style="width: 75%;">
    <h3>{{ $category->name_bn ?? 'Members' }}</h3>
    <hr/>

    @if ($memberLists->isNotEmpty())
        @foreach($memberLists as $key => $item)
            <div class="card mb-3 shadow-sm">
                <div class="row g-0">
                    <div class="col-md-3 d-flex align-items-center justify-content-center p-3">
                        <img src="{{ asset($item->photo) }}" 
                            alt="{{ $item->name_bn }}" 
                            class="img-fluid rounded shadow-sm" 
                            style="max-height: 220px;">
                    </div>

                    <div class="col-md-9">
                        <div class="card-body">
                            <table class="table table-bordered mb-3">
                                <tr>
                                    <td style="width: 120px;"><strong>নাম</strong></td>
                                    <td>{{ $item->name_bn ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>পদবি</strong></td>
                                    <td>{{ optional($item->designation)->name_bn ?? '' }}</td>
                                </tr>
                                {{-- <tr>
                                    <td><strong>অফিস</strong></td>
                                    <td>{{ $item->office ?? 'শিক্ষা মন্ত্রণালয়' }}</td>
                                </tr> --}}
                                <tr>
                                    <td><strong>ইমেইল</strong></td>
                                    <td>{{ $item->email ?? '' }}</td>
                                </tr>
                            </table>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('member_details', $item->slug) }}" class="btn btn-sm btn-primary">
                                    বিস্তারিত
                                </a>
                                <div>
                                    <span class="fw-bold">ফোন (অফিস):</span> {{ $item->mobile ?? '' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

</div>
@endsection
