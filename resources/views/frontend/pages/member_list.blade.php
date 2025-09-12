@extends('frontend.master')

@section('title', 'Home')

@section('css')
    <style>

    </style>
@endsection

@section('main-content')
<div class="center mx-auto" style="width: 75%;">
    <div class="text-">
           <h3> গেজেট/বিজ্ঞপ্তি</h3>
           <hr/>
    </div>
    <div class="personData">
        <div class="personBody">
                <div >
                  <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col" width="55%">বিষয়</th>
                                <th class="text-center" scope="col" width="15%">প্রকাশের তারিখ</th>
                                <th class="text-center" scope="col" width="15%">ডাউনলোড</th>
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
