<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Services\SupplierService;
use App\Http\Resources\ResponseResource;

class SupplierController extends Controller
{
    public function __construct(
        private SupplierService $supplierService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->paginate) {
            $suppliers = $this->supplierService->getSuppliers(true);
        }else{
            $suppliers = $this->supplierService->getSuppliers(false);
        }

        if ($suppliers->isEmpty()) {
            return new ResponseResource(true, 'suppliers not available', null, [
                'code' => 200
            ], 200);
        }

        return new ResponseResource(
            true,
            'List Data Suppliers',
            $suppliers,
            ['total_suppliers' => $suppliers->count(),],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        $suppliers = $request->validated();
        try {
            $suppliers = $this->supplierService->createSupplier($suppliers);

            return new ResponseResource(true, 'Supplier created',  [
                'uuid' => $suppliers->uuid,
                'code' => $suppliers->code,
                'slug' => $suppliers->slug,
                'name' => $suppliers->name,
                'address' => $suppliers->address,
                'phone' => $suppliers->phone,
                'email' => $suppliers->email
            ], [
                'code' => 201
            ], 201);
        } catch (\Exception $e) {
            return new ResponseResource(false, $e->getMessage(), null, [
                'code' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $uuid)
    {
        $supplier = $this->supplierService->getbyfirst('uuid',$uuid);

        if (!$supplier) {
            return new ResponseResource(false, 'Supplier not found with uuid: ' . $supplier->uuid . '', null, [
                'code' => 404
            ], 404);
        }

        return new ResponseResource(
            true,
            'Detail Supplier',
            [
                'uuid' => $supplier->uuid,
                'code' => $supplier->code,
                'slug' => $supplier->slug,
                'name' => $supplier->name,
                'address' => $supplier->address,
                'phone' => $supplier->phone,
                'email' => $supplier->email
            ],
            [
                'code' => 200
            ],
            200
        );

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierRequest $request, String $uuid)
    {
        $dataSupllier = $request->validated();
        try {
            $supplier = $this->supplierService->getbyfirst('uuid',$uuid);

            if (!$supplier) {
                return new ResponseResource(false, 'Supplier not found with uuid: ' . $supplier->uuid . '', null, [
                    'code' => 404
                ], 404);
            }

            $supplier->update($dataSupllier);
            return new ResponseResource(true, 'Supplier updated',  [
                'uuid' => $supplier->uuid,
                'code' => $supplier->code,
                'slug' => $supplier->slug,
                'name' => $supplier->name,
                'address' => $supplier->address,
                'phone' => $supplier->phone,
                'email' => $supplier->email
            ], [
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            return new ResponseResource(false, 'Gagal update supplier, karena ' . $e->getMessage(), null, [
                'code' => 500
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $uuid)
    {
        try {
            $supplier = Supplier::where('uuid', $uuid)->first();

            if (!$supplier) {
                return new ResponseResource(false, 'Supplier not found with uuid: ' . $supplier->uuid . '', null, [
                    'code' => 404
                ], 404);
            }

            $supplier->delete();

            return new ResponseResource(true, 'Supplier deleted', null, [
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            return new ResponseResource(false, $e->getMessage(), null, [
                'code' => 500
            ], 500);
        }
    }
}
