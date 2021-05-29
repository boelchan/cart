<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <div class="row">
                    <div class="col-md-6"> <h3 class="font-weight-bold">Product</h3> </div>
                    <div class="col-md-6"> <input wire:model="search" type="text" class="form-control" placeholder="search product .."> </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse ($products as $product)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body" wire:click="addItem({{ $product->id }})" style="cursor: pointer">
                                    <img src="{{ asset('storage/images/'.$product->image) }}" alt="gambar" style="object-fit:contain; width:100%;height:170px">
                                    <button wire:click="addItem({{ $product->id }})" class="btn btn-primary" style="position:absolute;top:0;right:0;padding:10px 15px"> <i class="fas fa-cart-plus fa-1x"></i></button>

                                    <h6 class="text-center font-weight-bold mt-2">{{ $product->name }}</h6>
                                    <h6 class="text-center text-grey">{{ number_format($product->price, 0, ',', '.') }}</h6>
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
            <div class="card-header bg-white">
                <h3 class="font-weight-bold">Cart</h3>
            </div>
            <div class="card-body">
                @if (session()->has('error'))
                <p class="text-danger">
                    {{ session('error') }}
                </p>
                @endif
                <div class="row">
                    <table class="table table-bordered table-sm">
                        <thead class="bg-white">
                            <tr class="font-weight-bold">
                                <td class="p-2" width="5%">No</td>
                                <td class="p-2" width="45%">Name</td>
                                <td class="p-2" width="25%">Qty</td>
                                <td class="p-2" width="25%">Price</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($carts as $i => $cart)
                                <tr>
                                    <td class="p-2">{{ $i + 1 }}</td>
                                    <td class="p-2">
                                        <span class="font-weight-bold">{{ $cart['name'] }}</span>
                                        <br>@ {{ number_format($cart['priceSingle'], 0, ',', '.') }}
                                    </td>
                                    <td class="p-2">
                                        <button wire:click="increaseItem('{{ $cart['rowId'] }}')" class="btn btn-sm btn-primary" style="padding: 7px 7px "><i class="fas fa-plus"></i></button>
                                        {{ $cart['qty'] }}
                                        <button wire:click="decreaseItem('{{ $cart['rowId'] }}')" class="btn btn-sm btn-primary" style="padding: 7px 7px "><i class="fas fa-minus"></i></button>
                                        <button wire:click="removeItem('{{ $cart['rowId'] }}')" class="btn btn-sm btn-danger" style="padding: 7px "><i class="fas fa-trash"></i></button>
                                    </td>
                                    <td class="p-2 text-end">{{ number_format($cart['price'], 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"><h6 class="text-center">Empty Cart</h6></td>
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
                <h6 class="font-weight-bold">Sub Total : {{ number_format($summary['sub_total'], 0, ',', '.') }}</h6>
                <h6 class="font-weight-bold">Pajak : {{ number_format($summary['pajak'], 0, ',', '.') }}</h6>
                <h6 class="font-weight-bold">Total : {{ number_format($summary['total'], 0, ',', '.') }}</h6>
                <div class="row pt-4">

                    <div class="col-md-6">
                        <button wire:click="enableTax" class="btn btn-primary btn-block"> Add Tax</button>
    
                    </div>
                    <div class="col-md-6">
                        <button wire:click="disableTax" class="btn btn-danger btn-block"> Remove Tax</button>
    
                    </div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-success btn-block"> Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
