<div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="font-weight-bold mb-3">Product List</h2>
                    <table class="table table-bordered table-hovered">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Name</td>
                                <td width="20%">Image</td>
                                <td>Description</td>
                                <td>Qty</td>
                                <td>Price</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $i => $product)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td><img src="{{ asset('storage/images/'.$product->image) }}" class="img-fluid"></td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->qty }}</td>
                                    <td>{{ $product->price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="font-weight-bold mb-3">Create Product</h2>
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label>Name</label>
                            <input wire:model="name" type="text" class="form-control">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <div class="custom-file">
                                <input wire:model="image" type="file" class="custom-file-input" id="customFile">
                                <label for="customFile" class="custom-file-label">pilih gambar</label>
                                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            @if ($image)
                                <label class="mt-2">Preview</label>
                                <img src="{{ $image->temporaryUrl() }}" alt="image preview" class="img-fluid">
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea wire:model="description" class="form-control" rows="3"></textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Qty</label>
                            <input wire:model="qty" type="number" class="form-control">
                            @error('qty') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input wire:model="price" type="number" class="form-control">
                            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
