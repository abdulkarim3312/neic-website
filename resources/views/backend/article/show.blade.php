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
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>
@endpush
@section('content')
<div class="card">
    <div class="card shadow-sm rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-newspaper me-2"></i> Article Details</h5>
            <div class="no-print">
                <a href="{{ route('articles.index') }}" class="btn btn-light btn-sm me-1">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
                <button onclick="window.print();" class="btn btn-secondary btn-sm">
                    <i class="fas fa-print me-1"></i> Print
                </button>
            </div>
        </div>

        <div class="card-body" id="printableArea">
            <table class="table table-bordered table-striped align-middle">
                <tbody>
                    <tr>
                        <th style="width: 25%;">Category</th>
                        <td>{{ $article->category?->name_en ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Title (Bangla)</th>
                        <td>{{ $article->title_bn ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Title (English)</th>
                        <td>{{ $article->title_en ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Slug</th>
                        <td>{{ $article->slug ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Details (Bangla)</th>
                        <td>{!! $article->details_bn ?? '-' !!}</td>
                    </tr>
                    <tr>
                        <th>Details (English)</th>
                        <td>{!! $article->details_en ?? '-' !!}</td>
                    </tr>
                    <tr>
                        <th>Attachment</th>
                        <td>
                            @if($article->attachment && $article->attachment)
                                <a href="{{ asset($article->attachment) }}" target="_blank">
                                    {{ $article->attachment_display_name }}
                                </a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($article->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Entry By</th>
                        <td>{{ $article->entryUser?->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Entry Time</th>
                        <td>{{ $article->entry_time?->timezone('Asia/Dhaka')->format('d M, Y h:i A') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Last Update By</th>
                        <td>{{ $article->updateUser?->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Last Update Time</th>
                        <td>{{ $article->last_update_time?->timezone('Asia/Dhaka')->format('d M, Y h:i A') ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
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
