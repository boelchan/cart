<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product as ProductModel;
use Illuminate\Support\Facades\Storage;

class Product extends Component
{
    use WithFileUploads;

    public $name ;
    public $image;
    public $description;
    public $qty;
    public $price;
    
    public function render()
    {
        $products = ProductModel::latest()->get();
        return view('livewire.product', [
                'products' => $products
            ]);
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'image' => 'required|image|max:2000',
            'description' => 'required',
            'qty' => 'required',
            'price' => 'required',
        ]);

        $imageName = md5($this->image.microtime().'.'.$this->image->extension());
        Storage::putFileAs(
            'public/images',
            $this->image,
            $imageName
        );

        ProductModel::create([
            'name' => $this->name,
            'image' => $imageName,
            'description' => $this->description,
            'qty' => $this->qty,
            'price' => $this->price,
        ]);

        session()->flash('berhasil');

        $this->name = '';
        $this->image = '';
        $this->description = '';
        $this->qty = '';
        $this->price = '';
    }
}
