@extends('backend.master')

@section('title', 'Product List')
@push('styles')
<style>
    .big-checkbox {
        transform: scale(1.5); 
        -webkit-transform: scale(1.5); 
        margin: 5px;
        cursor: pointer;
    }
</style>
@endpush
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Product List</h4>
        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus-circle"></i> Add New
        </a>
    </div>
    <div class="card-body">
        <table id="data-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Cost Price</th>
                    <th>Sale Price</th>
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
  $(document).ready(function () {

    const table = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("products.index") }}',
        columns: [
            { data: 'image', name: 'image', orderable: false, searchable: false },
            { data: 'name', name: 'name', width: '30%' },
            { data: 'cost_price', name: 'cost_price' },
            { data: 'sale_price', name: 'sale_price' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    $(document).on('submit', '.delete-form', function (e) {
        e.preventDefault();

        const form = this;
        const id = $(form).data('id');
        const name = $(form).data('name') || 'this item';

        const url = `/admin/products/${id}`;

        Swal.fire({
            title: 'Are you sure?',
            html: `You are about to delete <strong>${name}</strong>.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST', 
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        toastr.success(response.message || 'Product deleted successfully');
                        $(form).closest('tr').fadeOut(); // Optional: remove from UI
                    },
                    error: function (xhr) {
                        Swal.fire('Error', 'Failed to delete the product.', 'error');
                    }
                });
            }
        });
    });

    $(document).on('change', '.status-toggle', function () {
        var rowId = $(this).data('id');
        var newStatus = $(this).is(':checked') ? 1 : 0;
        const url = '{{ route("product_status", ":id") }}'.replace(':id', rowId);

        $.ajax({
        url: url,
        type: 'POST',
        data: {
            status: newStatus,
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            table.ajax.reload(null, false);
            toastr.success(response.message || 'Status updated successfully');
        },
        error: function (xhr) {
            toastr.error('Failed to update status');
        }
        });
    });
  });
</script>
@endpush
