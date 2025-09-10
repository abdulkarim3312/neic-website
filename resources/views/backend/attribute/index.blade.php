@extends('backend.master')

@section('title', 'Attribute')
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
        <h4 class="card-title mb-0">Attribute List</h4>
        <button type="button" id="addNew" class="btn btn-primary btn-sm">
            <i class="fa fa-plus-circle"></i> Add New
        </button>
    </div>
    <div class="card-body">
        <table id="DataTable" class="table table-bordered" >
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@include('backend.attribute.partials.form')
@endsection
@push('scripts')
<script>
  $(document).ready(function () {
    let product_id = {{ $id }};
    const table = $('#DataTable').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route("products.attributes", $id) }}',
      columns: [
          { data: 'name', name: 'name' },
          { data: 'status', name: 'status' },
          { data: 'action', name: 'action', orderable: false, searchable: false }
      ]
    });

    $('#addNew').click(function () {
      $('#modalForm')[0].reset();
      $('#rowId').val('');
      $('.modal-title').text('Add New Attribute');
      $('#formModal').modal('show');
      $('.invalid-feedback').remove();
      $('.is-invalid').removeClass('is-invalid');
      $('#hide_image').hide();
      $('#previewImage').attr('src', '');
    });

    $('#image').on('change', function (e) {
      const file = e.target.files[0];
      if (file) {
        const previewURL = URL.createObjectURL(file);
        $('#previewImage').attr('src', previewURL);
        $('#hide_image').show();
      } else {
        $('#hide_image').hide();
        $('#previewImage').attr('src', '');
      }
    });

    $(document).on('click', '.editBtn', function () {
      const id = $(this).data('id');
      const url = '{{ route("attributes.edit", ":id") }}'.replace(':id', id);

      $.get(url, function (data) {
        $('#modalForm')[0].reset();
        $('#rowId').val(data.id);
        $('[name="name"]').val(data.name);
        $('[name="status"]').val(data.status);
        $('.modal-title').text('Edit Attribute');
        $('#formModal').modal('show');

        $('.invalid-feedback').remove();
        $('.is-invalid').removeClass('is-invalid');
      });
    });

    $('#modalForm').submit(function (e) {
      e.preventDefault();

      const id = $('#rowId').val();
      const product_id = @json($id); 
      
      const url = id
          ? '{{ route("attributes.update", ":id") }}'.replace(':id', id)
          : '{{ route("attributes.store") }}';

      const formData = new FormData(this);
      formData.append('_method', id ? 'PUT' : 'POST');
      formData.append('product_id', product_id);

      $.ajax({
          url: url,
          type: 'POST', 
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
              $('#formModal').modal('hide');
              $('#modalForm')[0].reset();
              toastr.success(response.message);
              table.ajax.reload(null, false);
          },
          error: function (xhr) {
              let errors = xhr.responseJSON?.errors;
              $('.invalid-feedback').remove();
              $('.is-invalid').removeClass('is-invalid');
              if (errors) {
                  $.each(errors, function (field, messages) {
                      let input = $('[name="' + field + '"]');
                      input.addClass('is-invalid');
                      if (input.next('.invalid-feedback').length === 0) {
                          input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                      }
                  });
              } else {
                  toastr.error('An unexpected error occurred.');
              }
          }
      });
    });

    $('#formModal').on('hidden.bs.modal', function () {
      $('#modalForm')[0].reset();
      $('#rowId').val('');
      $('.invalid-feedback').remove();
      $('.is-invalid').removeClass('is-invalid');
      $('#hide_image').hide();
      $('#previewImage').attr('src', '');
    });

    $(document).on('submit', '.delete-form', function (e) {
      e.preventDefault();
      const form = this;
      const id = $(form).data('id');
      const url = '{{ route("attributes.destroy", ":id") }}'.replace(':id', id);

      Swal.fire({
        title: 'Are you sure?',
        html: `You are about to delete`,
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
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function (response) {
              toastr.success(response.message);
              table.ajax.reload(null, false);
            },
            error: function () {
              Swal.fire('Error', 'Failed to delete the project.', 'error');
            }
          });
        }
      });
    });

    $(document).on('change', '.status-toggle', function () {
        var rowId = $(this).data('id');
        var newStatus = $(this).is(':checked') ? 1 : 0;
        const url = '{{ route("attribute_status", ":id") }}'.replace(':id', rowId);

        $.ajax({
        url: url,
        type: 'POST',
        data: {
            status: newStatus,
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            toastr.success(response.message || 'Status updated successfully');
            table.ajax.reload(null, false);
        },
        error: function (xhr) {
            toastr.error('Failed to update status');
        }
        });
    });
  });
</script>
@endpush