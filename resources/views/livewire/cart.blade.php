<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h2 class="font-weight-bold">Product</h2>
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <img src="{{ asset('storage/images/'.$product->image) }}" alt="gambar" class="img-fluid">
                                </div>
                                <div class="card-footer">
                                    <h6>{{ $product->name }}</h6>
                                    <button wire:click="addItem({{ $product->id }})" class="btn btn-primary btn-sm btn-block">Add to cart</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                                    <td>{{ $cart['price'] }}</td>
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
                <h6 class="font-weight-bold">Sub Total : {{ $summary['sub_total'] }}</h6>
                <h6 class="font-weight-bold">Pajak : {{ $summary['pajak'] }}</h6>
                <h6 class="font-weight-bold">Total : {{ $summary['total'] }}</h6>
                <button wire:click="enableTax" class="btn btn-primary btn-block"> Add Tax</button>
                <button wire:click="disableTax" class="btn btn-danger btn-block"> Remove Tax</button>
                <div class="mt-4">
                    <button class="btn btn-success btn-block"> Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
