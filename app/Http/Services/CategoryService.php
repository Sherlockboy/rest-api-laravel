<?php

namespace App\Http\Services;

use App\Http\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Log;
use Throwable;

class CategoryService
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        return CategoryResource::collection($this->categoryRepository->all());
    }

    public function createCategory(object $request)
    {
        try {
            $this->categoryRepository->create($request->only('title'));
        } catch (Throwable $th) {
            Log::alert($th->getMessage());

            return response()->json([
                'error' => true,
                'message' => 'Unable to create category!'
            ], 500);
        }

        return response()->json([
            'error' => false,
            'message' => 'Category successfully created!'
        ], 200);
    }

    public function updateCategory(object $request, int $id)
    {
        try {
            $this->categoryRepository->update($id, $request->only('title'));
        } catch (Throwable $th) {
            Log::alert($th->getMessage());

            return response()->json([
                'error' => true,
                'message' => 'Unable to update category!'
            ], 500);
        }

        return response()->json([
            'error' => false,
            'message' => 'Category successfully updated!'
        ], 200);
    }

    public function deleteCategory(int $id)
    {
        try {
            $this->categoryRepository->delete($id);
        } catch (Throwable $th) {
            Log::alert($th->getMessage());

            return response()->json([
                'error' => true,
                'message' => 'Unable to delete category!'
            ], 500);
        }

        return response()->json([
            'error' => false,
            'message' => 'Category successfully deleted!'
        ], 200);
    }
}
