<?php

namespace App\Http\Repositories\Eloquent;

use App\Http\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    private Category $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function all()
    {
        return $this->category->all();
    }
    
    public function create(array $data)
    {
        return $this->category->create($data);
    }
    
    public function update(int $id, array $data)
    {
        return $this->category->find($id)->update($data);
    }
    
    public function delete(int $id)
    {
        return $this->category->destroy($id);
    }
}
