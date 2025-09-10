@extends('backend.master')

@section('title', 'Brand')
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
        <h4 class="card-title mb-0">Banner List</h4>
        <button type="button" id="addNew" class="btn btn-primary btn-sm">
            <i class="fa fa-plus-circle"></i> Add New
        </button>
    </div>
    <div class="card-body">
        <table id="DataTable" class="table table-bordered" >
            <thead>
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@include('backend.banner.partials.form')
@endsection
@push('scripts')
<script>
  $(document).ready(function () {
    const table = $('#DataTable').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('banners.index') }}',
      columns: [
        { data: 'image', name: 'image', orderable: false, searchable: false },
        { data: 'title', name: 'title' },
        { data: 'status', name: 'status', orderable: true, searchable: true },
        { data: 'action', name: 'action', orderable: false, searchable: false },
      ]
    });

    $('#addNew').click(function () {
      $('#modalForm')[0].reset();
      $('#rowId').val('');
      $('.modal-title').text('Add New Banner');
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

    $(document).on('click', '#removeImage', function () {
      $('#previewImage').attr('src', '');
      $('#image').val('');
      $('#hide_image').hide();
    });

    $(document).on('click', '.editBtn', function () {
      const id = $(this).data('id');
      const url = '{{ route("banners.edit", ":id") }}'.replace(':id', id);

      $.get(url, function (data) {
        $('#modalForm')[0].reset();
        $('#rowId').val(data.id);
        $('[name="title"]').val(data.title);
        $('[name="status"]').val(data.status);
        $('.modal-title').text('Edit Banner');
        $('#formModal').modal('show');

        $('.invalid-feedback').remove();
        $('.is-invalid').removeClass('is-invalid');

        if (data.image) {
            const fullImageUrl = window.location.origin + '/' + data.image;
            $('#previewImage').attr('src', fullImageUrl);
            $('#hide_image').show();
        } else {
            $('#previewImage').attr('src', '');
            $('#hide_image').hide();
        }
      });
    });

    $('#modalForm').submit(function (e) {
        e.preventDefault();
        const form = $(this)[0];
        const formData = new FormData(form);
        const id = $('#rowId').val();
        const url = id
            ? '{{ route("banners.update", ":id") }}'.replace(':id', id)
            : '{{ route("banners.store") }}';

        if (id) {
            formData.append('_method', 'PUT');
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#formModal').modal('hide');
                $('#modalForm')[0].reset();
                $('#imagePreviewContainer').hide();
                $('#previewImage').attr('src', '');
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
      const url = '{{ route("banners.destroy", ":id") }}'.replace(':id', id);

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
        const url = '{{ route("banner_status", ":id") }}'.replace(':id', rowId);

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
