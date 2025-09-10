@extends('backend.master')

@section('title', 'Article List')
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
        <h5 class="card-title mb-0">Article List</h5>
        <a href="{{ route('articles.create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus-circle"></i> Add New
        </a>
    </div>
    <div class="card-body">
        <table id="responsive-datatable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Bangla Title</th>
                    <th>English Title</th>
                    <th>Entry By</th>
                    <th>Status</th>
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
        ajax: '{{ route("articles.index") }}',
        columns: [
            { data: 'category', name: 'category', width:'15%' },
            { data: 'title_bn', name: 'title_bn', width:'20%' },
            { data: 'title_en', name: 'title_en', width:'20%' },
            { data: 'user', name: 'user' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false, width:'20%' }
        ]
    });

    $(document).on('submit', '.delete-form', function (e) {
        e.preventDefault();
        const form = this;
        const id = $(form).data('id');
        const name = $(form).data('name') || 'this category';
        const url = '{{ route("articles.destroy", ":id") }}'.replace(':id', id);

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

    $(document).on('change', '.status-toggle', function () {
        let id = $(this).data('id');
        let newStatus = $(this).is(':checked') ? 1 : 0;
        const url = '{{ route("article_status", ":id") }}'.replace(':id', id);

        $.post(url, {
            status: newStatus,
            _token: '{{ csrf_token() }}'
        })
        .done(function (res) {
            table.ajax.reload(null, false);
            toastr.success(res.message || 'Status updated');
        })
        .fail(function () {
            toastr.error('Failed to update status');
        });
    });

    function resetFormFeedback() {
        $('.invalid-feedback').remove();
        $('.is-invalid').removeClass('is-invalid');
    }
});
</script>
@endpush
