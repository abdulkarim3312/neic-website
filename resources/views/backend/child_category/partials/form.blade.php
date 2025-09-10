<div class="modal fade" id="formModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="modalForm">
            @csrf
            <input type="hidden" name="id" id="rowId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-select form-select-sm">
                            <option value="">--Select--</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="subcategory_id">Sub Category</label>
                        <select name="subcategory_id" id="subcategory_id" class="form-select form-select-sm">
                            <option value="">--Select--</option>
                            
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control form-control-sm">
                    </div>

                    <div class="mb-3">
                        <label for="status">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-sm btn-primary" type="submit">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>