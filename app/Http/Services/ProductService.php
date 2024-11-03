<?php

namespace App\Http\Services;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductService
{
    public function getProduct($paginate = false)
    {
        if ($paginate) {
            $products = Product::with('category:id,name', 'supplier:id,name')->when(request()->search, function ($query) {
                $query->where('name', 'like', '%' . request()->search . '%');
            })
            ->select(['id', 'category_id', 'supplier_id', 'name','image', 'slug', 'price'])
            ->latest()
            ->paginate(1);

            // append search
            $products->appends(['search' => request()->search]);
        } else {
            $products = Product::with('category:id,name', 'supplier:id,name')->when(request()->search, function ($query) {
                $query->where('name', 'like', '%' . request()->search . '%');
            })
            ->latest()
            ->get(['id','uuid', 'category_id', 'supplier_id','image' ,'name', 'slug', 'price']);
        }

        return $products;
    }

    public function getByFirst(string $column, string $value, bool $relation = false)
    {
        if ($relation) {
            return Product::where($column, $value)->with('category:id,name', 'supplier:id,name')->first();
        }

        return Product::where($column, $value)->first();

    }

    public function create(array $data)
    {
        $data['slug'] = Str::slug($data['name']);

        return Product::create($data);
    }
    public function update(array $data, string $uuid)
    {
        $data['slug'] = Str::slug($data['name']);

        return Product::where('uuid', $uuid)->update($data);
    }
}
