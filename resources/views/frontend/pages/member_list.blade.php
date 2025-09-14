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
</style>
@endsection

@section('main-content')
<div class="center mx-auto" style="width: 75%;">
    <h3>{{ $category->name_bn ?? 'Members' }}</h3>
    <hr/>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ক্রমিক</th>
                    <th>ছবি</th>
                    <th>নাম</th>
                    <th>পদবি</th>
                    <th>ফোন</th>
                    <th>ইমেইল</th>
                    <th>একশন</th>
                </tr>
            </thead>
            <tbody>
                @if ($memberLists->isNotEmpty())
                    @foreach($memberLists as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <img src="{{ asset($item->photo) }}" alt="" width="50" class="rounded">
                            </td>
                            <td>{{ $item->name_bn ?? ''}}</td>
                            <td>{{ optional($item->designation)->name_bn ?? '' }}</td>
                            <td>{{ $item->mobile ?? '' }}</td>
                            <td>{{ $item->email ?? '' }}</td>
                            <td>
                                <a href="{{ route('member_details', $item->slug) }}" class="btn btn-primary btn-sm">
                                    বিস্তারিত
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

</div>
@endsection
