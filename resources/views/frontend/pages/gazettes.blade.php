@extends('frontend.master')

@section('title', 'Home')

@section('css')
    <style>

    </style>
@endsection

@section('main-content')
<div class="center mx-auto" style="width: 75%;">
    <div class="heading">
                গ্যাজেটসমূহ 
    </div>
    {{-- <div class="text-">
           <h3> গ্যাজেটসমূহ</h3>
           <hr/>
    </div> --}}
    <div class="personData">
        <div class="personBody">
                <div >
                  <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col" width="50%">বিষয়</th>
                                <th class="text-center" scope="col" width="">প্রকাশের তারিখ</th>
                                <th class="text-center" scope="col" width="">ডাউনলোড</th>
                            </tr>
                        </thead>

                        @php
                            function bn_number($number) {
                                $search = ['0','1','2','3','4','5','6','7','8','9'];
                                $replace = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
                                return str_replace($search, $replace, $number);
                            }
                        @endphp

                        <tbody>
                            @forelse ($gazettes as $item)
                                <tr>
                                    <th scope="row" class="text-center">{{ bn_number($loop->iteration) }}</th>
                                    <td>{{ $item->file_display_name ?? '-' }}</td>
                                    <td class="text-center">
                                        @if($item->created_at)
                                            {{ bn_number(\Carbon\Carbon::parse($item->created_at)->locale('bn')->format('d-m-Y')) }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(!empty($item->file_name))
                                            <a href="{{ asset($item->file_name) }}" target="_blank" class="btn btn-sm btn-primary">
                                                ডাউনলোড
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">কোনো ফাইল পাওয়া যায়নি</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            <p>&nbsp;</p>
        </div>
    </div>
</div>
@endsection


@section('script')
    
@endsection
