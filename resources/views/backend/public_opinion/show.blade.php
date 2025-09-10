@extends('backend.master')

@section('title', 'Public Opinion Details')

@push('styles')
<style>
    .table th {
        width: 25%;
        background: #f8f9fa;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card shadow-sm rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-comments me-2"></i> Public Opinion Details</h5>
            <a href="{{ route('comments.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td>{{ $opinion->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $opinion->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Comment</th>
                        <td>{{ $opinion->comment ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Attachment</th>
                        <td>
                            @if($opinion->attachment)
                                <a href="{{ asset($opinion->attachment) }}" target="_blank" class="text-primary">
                                    {{ $opinion->attachment_display_name ?? basename($opinion->attachment) }}
                                </a>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>User IP</th>
                        <td>{{ $opinion->user_ip ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>User Agent Info</th>
                        <td>
                            <small class="text-muted">{{ $opinion->user_agent_info ?? '-' }}</small>
                        </td>
                    </tr>
                    <tr>
                        <th>Entry Time</th>
                        <td>{{ $opinion->entry_time ? $opinion->entry_time->timezone('Asia/Dhaka')->format('d M, Y h:i:s A') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($opinion->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $opinion->created_at?->timezone('Asia/Dhaka')->format('d M, Y h:i:s A') ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
