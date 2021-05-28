<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h2 class="font-weight-bold">Product</h2>
                    </div>
                    <div class="col-md-6">
                        <input wire:model="search" type="text" class="form-control" placeholder="search product ..">
                    </div>
                </div>
                <div class="row">
                    @forelse ($products as $product)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <img src="{{ asset('storage/images/'.$product->image) }}" alt="gambar" style="object-fit:contain; width:100%;height:120px">
                                </div>
                                <div class="card-footer">
                                    <h6>{{ $product->name }}</h6>
                                    <button wire:click="addItem({{ $product->id }})" class="btn btn-primary btn-sm btn-block">Add to cart</button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12 mt-3">
                            <p class="text-center text-secondary">No Product found . .</p>
                        </div>
                    @endforelse
                </div>
                <div class="row" style="display:flex;justify-content:center;">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h2 class="font-weight-bold">Cart</h2>
                <span class="text-danger">
                    @if (session()->has('error'))
                        {{ session('error') }}
                    @endif
                </span>
                <div class="row">
                    <table class="table table-bordered table-sm">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <td>No</td>
                                <td>Name</td>
                                <td>Price</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($carts as $i => $cart)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        {{ $cart['name'] }} 
                                        <br>Qty : {{ $cart['qty'] }}
                                        <button wire:click="increaseItem('{{ $cart['rowId'] }}')" class="btn btn-sm btn-primary">+</button>
                                        <button wire:click="decreaseItem('{{ $cart['rowId'] }}')" class="btn btn-sm btn-primary">-</button>
                                        <button wire:click="removeItem('{{ $cart['rowId'] }}')" class="btn btn-sm btn-danger">x</button>

                                    </td>
                                    <td>Rp {{ number_format($cart['price'], 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3"><h6 class="text-center">Empty Cart</h6></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="font-weight-bold">Summary</h4>
                <h6 class="font-weight-bold">Sub Total : Rp {{ number_format($summary['sub_total'], 0, ',', '.') }}</h6>
                <h6 class="font-weight-bold">Pajak : Rp {{ number_format($summary['pajak'], 0, ',', '.') }}</h6>
                <h6 class="font-weight-bold">Total : Rp {{ number_format($summary['total'], 0, ',', '.') }}</h6>
                <button wire:click="enableTax" class="btn btn-primary btn-block"> Add Tax</button>
                <button wire:click="disableTax" class="btn btn-danger btn-block"> Remove Tax</button>
                <div class="mt-4">
                    <button class="btn btn-success btn-block"> Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
