<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\api\v1\storeCategoryRequest;
use App\Http\Requests\api\v1\updateCategoryRequest;
use App\Traits\ApiResponses;

class CategoryController extends Controller
{
    use ApiResponses;

    public function index()
    {
        $categories = Category::all();
        return $this->ok("Categories Listed.", $categories);
    }

    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return $this->error("Category did not find for showing.", 404);
        }

        return $this->ok("Found successfully for show.", $category);
    }

    public function store(storeCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return $this->ok("Category created successfully.", $category);
    }

    public function update(updateCategoryRequest $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return $this->error("Category did not find for updating.", 404);
        }

        $category->update($request->validated());
        return $this->ok("Category updated successfully", $category);
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return $this->error("Category did not find for deleting.", 404);
        }

        $category->delete();
        return $this->ok("Category deleted successfully.");
    }
}
