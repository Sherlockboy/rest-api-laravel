<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function all()
    {
        return $this->product->with('user', 'category')->get();
    }

    public function findById(int $id)
    {
        return $this->product->whereId($id)->with('user', 'category')->first();
    }

    public function search(string $query)
    {
        return $this->product->where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhere('price', floatval($query))
            ->with('user', 'category')
            ->get();
    }

    public function create(array $data)
    {
        return $this->product->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->product->find($id)->update($data);
    }

    public function delete(int $id)
    {
        return $this->product->destroy($id);
    }
}
