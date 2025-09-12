@extends('backend.master')

@section('title', 'Public Opinion Details')

@push('styles')
<style>
    .opinion-card {
        max-width: 100%;
        margin: 30px auto;
        padding: 25px;
        background-color: #fefeff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .opinion-header {
        text-align: center;
        margin-bottom: 20px;
    }
    .opinion-header h3 {
        font-weight: 700;
        margin-bottom: 5px;
    }
    .opinion-header p {
        color: #6c757d;
        margin-bottom: 0;
    }
    .opinion-status {
        margin-top: 5px;
    }
    .opinion-body p {
        line-height: 1.7;
        margin-bottom: 12px;
    }
    .opinion-attachment a {
        color: #007bff;
        text-decoration: none;
    }
    .opinion-attachment a:hover {
        text-decoration: underline;
    }
    .print-btn {
        display: block;
        margin: 0 auto 15px auto;
        background-color: #28a745;
        color: #fff;
        border: none;
        padding: 7px 15px;
        border-radius: 6px;
        cursor: pointer;
    }
    .print-btn:hover {
        background-color: #218838;
    }

    /* Print styling */
    @media print {
        body * {
            visibility: hidden;
        }
        #printableArea, #printableArea * {
            visibility: visible;
        }
        #printableArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .print-btn {
            display: none;
        }
    }
</style>
@endpush

@section('content')
<div class="opinion-card" id="printableArea">
    <button class="print-btn" onclick="window.print()">
        <i class="fas fa-print me-1"></i> Print
    </button>
    


     @php
        function bn_number($number) {
            $search = ['0','1','2','3','4','5','6','7','8','9'];
            $replace = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
            return str_replace($search, $replace, $number);
        }
    @endphp
    <div class="opinion-header">
        {{-- <h3>{{ $opinion->name ?? '-' }}</h3> --}}
        @if($opinion->entry_time)
            <p>তারিখ: {{ bn_number(\Carbon\Carbon::parse($opinion->entry_time)->locale('bn')->timezone('Asia/Dhaka')->isoFormat('D MMMM, YYYY, h:mm:s A')) }}</p>
        @endif
    </div>

    <div class="opinion-body">
        <p><strong>নাম:</strong> {{ $opinion->name ?? '-' }}</p>
        <p><strong>মোবাইল:</strong> {{ $opinion->phone ?? '-' }}</p>
        <p><strong>মন্তব্য:</strong> {!! nl2br(e($opinion->comment ?? '-')) !!}</p>
        <p class="opinion-attachment"><strong>সংযুক্তি:</strong>
            @if($opinion->attachment)
                <a href="{{ asset($opinion->attachment) }}" target="_blank">
                    {{ $opinion->attachment_display_name ?? basename($opinion->attachment) }}
                </a>
            @else
                N/A
            @endif
        </p>
        <p><strong>ইউজার আইপি:</strong> {{ $opinion->user_ip ?? '-' }}</p>
        <p><strong>ইউজার এজেন্ট:</strong> <small class="text-muted">{{ $opinion->user_agent_info ?? '-' }}</small></p>
        <p><strong>তারিখ :</strong> {{ $opinion->created_at?->timezone('Asia/Dhaka')->format('d M, Y h:i:s A') ?? '-' }}</p>
    </div>
</div>
@endsection
