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
                        <label for="attribute_id">Attribute</label>
                        <select name="attribute_id" id="attribute_id" class="form-select form-select-sm">
                            <option value="">--Select--</option>
                            @foreach ($attributes as $attribute)
                                <option value="{{ $attribute->id }}" {{ old('attribute_id') == $attribute->id ? 'selected' : '' }}>
                                    {{ $attribute->name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" id="value" name="value" class="form-control form-control-sm">
                    </div>

                    <div class="mb-3">
                        <label for="total_stock">Stock</label>
                        <input type="number" id="total_stock" name="total_stock" class="form-control form-control-sm">
                    </div>
                    <div class="mb-3">
                        <label for="price">Price</label>
                        <input type="number" id="price" name="price" class="form-control form-control-sm">
                    </div>

                    {{-- <div class="mb-3">
                        <label for="status">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div> --}}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-sm btn-primary" type="submit">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>