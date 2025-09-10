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
    <div class="card shadow-sm rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i> Committee Member Details</h5>
            <a href="{{ route('committee-members.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <tbody>
                    <tr>
                        <th style="width: 25%;">Photo</th>
                        <td>
                            @if($member->photo)
                                <img src="{{ asset($member->photo) }}" 
                                    alt="Member Photo" 
                                    class="img-thumbnail" 
                                    style="max-width: 120px; height: auto;">
                            @else
                                <span class="text-muted">No Photo</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Designation</th>
                        <td>{{ $member->designation->name_en ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Bangla Name</th>
                        <td>{{ $member->name_bn }}</td>
                    </tr>
                    <tr>
                        <th>English Name</th>
                        <td>{{ $member->name_en }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $member->email }}</td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td>{{ $member->mobile }}</td>
                    </tr>
                    <tr>
                        <th>Article URL</th>
                        <td>
                            @if($member->article_url)
                                <a href="{{ $member->article_url }}" target="_blank" class="text-primary">
                                    {{ $member->article_url }}
                                </a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $member->description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($member->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Entry By</th>
                        <td>{{ $member->entryUser?->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Entry Time</th>
                        <td>{{ $member->entry_time?->timezone('Asia/Dhaka')->format('d M, Y h:i A') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Last Update By</th>
                        <td>{{ $member->updateUser?->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Last Update Time</th>
                        <td>{{ $member->last_update_time?->timezone('Asia/Dhaka')->format('d M, Y h:i A') ?? '-' }}</td>
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
