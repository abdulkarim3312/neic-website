@extends('backend.master')

@section('title', 'product')
@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
<style>
    .big-checkbox {
        transform: scale(1.5); 
        -webkit-transform: scale(1.5); 
        margin: 5px;
        cursor: pointer;
    }
    .image-thumb {
        position: relative;
        display: inline-block;
        margin: 5px;
    }

    .image-thumb img {
        height: 80px;
        width: 80px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .remove-btn {
        position: absolute;
        top: -6px;
        right: -6px;
        background: red;
        color: white;
        border: none;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        font-size: 12px;
        cursor: pointer;
    }
    .feature-thumb {
        position: relative;
        display: inline-block;
    }

    .feature-thumb img {
        height: 100px;
        width: 100px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .feature-remove-btn {
        position: absolute;
        top: -6px;
        right: -6px;
        background: red;
        color: white;
        border: none;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        font-size: 12px;
        cursor: pointer;
    }
    .btn_size{
        width: 13px;
        height: 22px;
    }
    .img_size{
        border: 1px solid gray;
    }
    .gallery-preview-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border: 1px solid #3d3737;
        border-radius: 4px;
    }

    .gallery-image {
        width: 100px;
        height: 100px;
        object-fit: cover; /* ensures image doesn't stretch */
        border-radius: 4px;
    }

    #existing-gallery .position-relative {
        width: 100px;
    }
    .feature-remove-btn {
        position: absolute;
        top: 0;
        right: 0;
        padding: 2px 6px;
        background: red;
        color: #fff;
        border: none;
        border-radius: 0 0 0 4px;
        font-size: 14px;
    }
</style>
@endpush
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Edit Product</h4>
        <a href="{{ route('products.index') }}" class="btn btn-dark waves-effect waves-light text-end btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Left Column (col-8) -->
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Name</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $product->name ?? '' }}" name="name" placeholder="name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mb-7">
                            <label for="feature_image" class="form-label fw-medium">Feature Image</label>
                            
                            <input type="file" id="feature_image" name="feature_image" accept="image/*" class="form-control form-control-sm mb-2">

                            <div id="feature-preview-area" class="mt-2">
                                @if($product->feature_image)
                                    <div class="feature-thumb">
                                        <div class="position-relative d-inline-block" id="existing-feature-preview">
                                            <img src="{{ asset($product->feature_image) }}" alt="Feature Image" class="img-thumbnail img_size" width="100">
                                            <button type="button" class="feature-remove-btn" onclick="removeFeatureImage()">&times;</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>


                        
                        <div class="mb-3">
                            <label for="new_images" class="form-label fw-medium">Add New Gallery Images</label>
                            <input type="file" id="image" name="new_images[]" accept="image/*" multiple class="form-control form-control-sm mb-2" onchange="previewNewImages(event)">
                        </div>

                        
                        <div id="new-images-preview" class="d-flex flex-wrap gap-2 mb-3"></div>


                        @if($product->galleries && $product->galleries->count())
                            <div class="d-flex flex-wrap gap-3" id="existing-gallery-wrapper">
                                @foreach($product->galleries as $gallery)
                                    <div class="position-relative text-center" style="width: 100px;" id="gallery-{{ $gallery->id }}">
                                        <img src="{{ asset($gallery->image) }}" class="img-thumbnail gallery-image mb-1" alt="gallery image" width="100">
                                        <input type="file" name="images[{{ $gallery->id }}]" accept="image/*" class="form-control form-control-sm mb-1">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="removeExistingGallery({{ $gallery->id }})">Remove</button>
                                        <input type="hidden" name="existing_images[]" value="{{ $gallery->id }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="col-md-12 col-12">
                            <div class="mb-3 mt-3">
                                <label for="nameInput" class="form-label">Short Description</label>
                                <textarea name="short_description" id="" class="form-control form-control-sm" rows="4">{{ $product->short_description ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Long Description</label>
                                <textarea name="description" id="summernote" class="form-control" rows="4">{!! $product->description ?? '' !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Product Tags</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $product->product_tag ?? '' }}" name="product_tag" placeholder="tags">
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mb-2">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $product->meta_keywords ?? '' }}" name="meta_keywords" placeholder="Meta keywords">
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Meta Description</label>
                                <textarea name="meta_description" id="" class="form-control form-control-sm" rows="4" placeholder="Enter meta description">{{ $product->meta_description ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (col-4) -->
                <div class="col-md-4">
                    <div class="mb-4">
                        <label class="form-label fw-medium">Cost Price</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">৳</span>
                            <input type="number" class="form-control" value="{{ $product->cost_price ?? '' }}" name="cost_price" placeholder="Enter Previous Price">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">Sale Price</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">৳</span>
                                <input type="number" class="form-control" value="{{ $product->sale_price ?? '' }}" name="sale_price" placeholder="Enter Current Price">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">Discount Price (%)</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">৳</span>
                                <input type="number" class="form-control" value="{{ $product->discount_price ?? '' }}" name="discount_price" id="discount" placeholder="Enter Current Price">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">Category <span class="text-danger">*</span></label>
                        <select class="form-select form-select-sm" name="category_id" id="categorySelect">
                            <option value="">--Select--</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name ?? '' }}
                                </option>
                            @endforeach
                        </select>

                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">Sub Category</label>
                        <select class="form-select form-select-sm" name="sub_category_id" id="subcategorySelect">
                            <option value="">--Select--</option>
                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" {{ old('sub_category_id', $product->sub_category_id) == $subCategory->id ? 'selected' : '' }}>
                                    {{ $subCategory->name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">Child Category</label>
                        <select class="form-select form-select-sm" name="child_category_id" id="childCategorySelect">
                            <option value="">--Select--</option>
                            @foreach ($childCategories as $childCategory)
                                <option value="{{ $childCategory->id }}" {{ old('child_category_id', $product->child_category_id) == $childCategory->id ? 'selected' : '' }}>
                                    {{ $childCategory->name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">Brand</label>
                        <select class="form-select form-select-sm" name="brand_id">
                            <option value="">--Select--</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">Total Stock</label>
                        <div class="input-group input-group-sm">
                            <input type="number" class="form-control" value="{{ $product->total_stock ?? '' }}" name="total_stock" placeholder="Total Stock">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">SKU</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" readonly value="{{ $product->sku ?? '' }}" name="sku" placeholder="Enter SKU">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">Video Link</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" value="{{ $product->video_link ?? '' }}" name="video_link" placeholder="Enter Video Link">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="status">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="1" {{ $product->status == 1 ? 'selected': '' }}>Active</option>
                            <option value="0" {{ $product->status == 0 ? 'selected': '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="text-start mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-save me-1"></i> Update
                </button>
                
                <a href="{{ route('products.index') }}" class="btn btn-dark waves-effect waves-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
<script>
let selectedImages = [];
$(document).ready(function () {
    $('#summernote').summernote({
        placeholder: 'Write the long description here...',
        tabsize: 2,
        height: 200,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    $('#categorySelect').on('change', function () {
        var categoryId = $(this).val();
        if (categoryId) {
            let url = "{{ route('get-subcategories', ':id') }}".replace(':id', categoryId);

            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    $('#subcategorySelect').empty().append('<option value="">--Select--</option>');
                    $.each(data, function (id, name) {
                        $('#subcategorySelect').append('<option value="' + id + '">' + name + '</option>');
                    });
                }
            });
        } else {
            $('#subcategorySelect').html('<option value="">--Select--</option>');
        }
    });

    $('#subcategorySelect').on('change', function () {
        var subCategoryId = $(this).val();
        if (subCategoryId) {
            let url = "{{ route('get-child-categories', ':id') }}".replace(':id', subCategoryId);

            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    $('#childCategorySelect').empty().append('<option value="">--Select--</option>');
                    $.each(data, function (id, name) {
                        $('#childCategorySelect').append('<option value="' + id + '">' + name + '</option>');
                    });
                }
            });
        } else {
            $('#childCategorySelect').html('<option value="">--Select--</option>');
        }
    });

    $(document).on('submit', '.delete-form', function (e) {
      e.preventDefault();

      const form = this;
      const id = $(form).data('id');
      const name = $(form).data('name') || 'this item';
      const url = '{{ route("brands.destroy", ":id") }}'.replace(':id', id);

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
              location.reload();
              toastr.success(response.message);
            },
            error: function () {
              Swal.fire('Error', 'Failed to delete the project.', 'error');
            }
          });
        }
      });
    });


    $('#feature_image').on('change', function (e) {
            const file = e.target.files[0];
            selectedFeatureImage = file;

            if (!file || !file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = function (event) {
                const html = `
                    <div class="feature-thumb">
                        <img src="${event.target.result}" alt="Feature Preview">
                        <button type="button" class="feature-remove-btn" onclick="removeFeatureImage()">&times;</button>
                    </div>
                `;
                $('#feature-preview-area').html(html);
            };
            reader.readAsDataURL(file);
        });
    });

    
    function removeFeatureImage() {
        selectedFeatureImage = null;

        const dt = new DataTransfer(); 
        document.getElementById('feature_image').files = dt.files;

        $('#feature-preview-area').empty();
    }

    function removeExistingGallery(id) {
        const el = document.getElementById('gallery-' + id);
        if (el) el.remove();
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'delete_galleries[]';
        input.value = id;
        document.querySelector('form').appendChild(input);
    }
</script>
<script>
    function previewNewImages(event) {
        const previewWrapper = document.getElementById('new-images-preview');
        previewWrapper.innerHTML = '';

        const files = event.target.files;
        if (files) {
            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const container = document.createElement('div');
                    container.className = 'text-center me-2 mb-2';
                    container.style.width = '100px';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail';
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover'; 

                    const removeBtn = document.createElement('button');
                    removeBtn.textContent = 'Remove';
                    removeBtn.className = 'btn btn-sm btn-danger mt-1 w-100';
                    removeBtn.type = 'button';
                    removeBtn.onclick = () => container.remove();

                    container.appendChild(img);
                    container.appendChild(removeBtn);
                    previewWrapper.appendChild(container);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    function removeExistingGallery(id) {
        const element = document.getElementById('gallery-' + id);
        if (element) {
            element.remove();
        }

        const removedInput = document.createElement('input');
        removedInput.type = 'hidden';
        removedInput.name = 'remove_image_ids[]';
        removedInput.value = id;
        document.querySelector('form').appendChild(removedInput);
    }

    const discountInput = document.getElementById("discount");

    discountInput.addEventListener("keyup", function () {
        let value = parseInt(this.value);

        if (isNaN(value)) return;

        if (value < 1 || value > 99) {
            alert("Discount must be between 1 and 99.");
            this.value = "";
            this.focus(); 
        }
    });
</script>

@endpush
