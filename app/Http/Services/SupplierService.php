<?php

namespace App\Http\Services;

use App\Models\Supplier;
use Illuminate\Support\Str;

class SupplierService
{
    public function getSuppliers($paginate = false)
    {
        if ($paginate) {
            $suppliers = Supplier::when(request()->search, function ($query){
                $query->where('name', 'like', '%' . request()->search . '%');
            })->latest()->paginate(10);
              // append search
            $suppliers->appends(['search' => request()->search]);
        }else{
            $suppliers = Supplier::when(request()->search, function ($query){
                $query->where('name', 'like', '%' . request()->search . '%');
            })->latest()->get();
        }
        return $suppliers;
    }

    public function getbyfirst(string $column, string $value)
    {
        return Supplier::where($column, $value)->first();
    }
    public function createSupplier($supplier){
        $supplier['slug'] = Str::slug($supplier['name']);
        return Supplier::create($supplier);
    }
}
