<?php

namespace App\Http\Services;

use App\Http\Repositories\Interfaces\ProductRepositoryInterface;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProductService
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts()
    {
        return ProductResource::collection($this->productRepository->all());
    }

    public function getSingleProduct(int $id)
    {
        $product = $this->productRepository->findById($id);
        
        if(empty($product)) {
            return response()->json([
                'error' => true,
                'message' => 'Product not found!'
            ], 404);
        }
            
        return new ProductResource($product);
    }

    public function createProduct(object $request)
    {
        try {
            $this->productRepository->create($this->prepareData($request));
        } catch (Throwable $th) {
            Log::alert($th->getMessage());

            return response()->json([
                'error' => true,
                'message' => 'Unable to create product!'
            ], 500);
        }

        return response()->json([
            'error' => false,
            'message' => 'Product successfully created!'
        ], 200);
    }

    public function updateProduct(object $request, int $id)
    {
        try {
            $this->productRepository->update($id, $this->prepareData($request));
        } catch (Throwable $th) {
            Log::alert($th->getMessage());

            return response()->json([
                'error' => true,
                'message' => 'Unable to update product!'
            ], 500);
        }

        return response()->json([
            'error' => false,
            'message' => 'Product successfully updated!'
        ], 200);
    }

    public function deleteProduct(int $id)
    {
        try {
            $this->productRepository->delete($id);
        } catch (Throwable $th) {
            Log::alert($th->getMessage());

            return response()->json([
                'error' => true,
                'message' => 'Unable to delete product!'
            ], 500);
        }

        return response()->json([
            'error' => false,
            'message' => 'Product successfully deleted!'
        ], 200);
    }

    private function prepareData(object $request)
    {
        return $request->only(
            'user_id',
            'category_id',
            'photo',
            'name',
            'description',
            'price'
        );
    }
}
