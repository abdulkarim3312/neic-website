@extends('backend.master')

@section('title', 'committee')
@push('styles')
<style>
    .big-checkbox {
        transform: scale(1.5);
        margin: 5px;
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Public Opinion List</h5>
    </div>
    <div class="card-body">
        <table id="responsive-datatable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>User IP</th>
                    <th>Entry Time</th>
                    {{-- <th>Status</th> --}}
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    let table = $('#responsive-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("comments.index") }}',
        columns: [
            { data: 'name', name: 'name' },
            { data: 'phone', name: 'phone' },
            { data: 'user_ip', name: 'user_ip' },
            { data: 'entry_time', name: 'entry_time', width:'15%' },
            // { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false, width:'15%' }
        ]
    });

    $(document).on('submit', '.delete-form', function (e) {
        e.preventDefault();
        const form = this;
        const id = $(form).data('id');
        const name = $(form).data('name') || 'this category';
        const url = '{{ route("comments.destroy", ":id") }}'.replace(':id', id);

        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete <b>${name}</b>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        table.ajax.reload();
                        toastr.success(response.message || 'Deleted successfully');
                    },
                    error: function () {
                        Swal.fire('Error', 'Failed to delete.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
