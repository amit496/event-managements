<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategorySaveRequest;
use App\Http\Requests\Admin\CategoryStatusRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->string('sort')->toString();
        $dir = $request->string('dir')->toString() === 'asc' ? 'asc' : 'desc';
        $allowedSorts = ['name', 'status', 'created_at'];
        $sort = in_array($sort, $allowedSorts, true) ? $sort : 'created_at';

        $categories = Category::query()
            ->when($request->filled('q'), function ($query) use ($request): void {
                $term = trim((string) $request->input('q'));
                $query->where(function ($inner) use ($term): void {
                    $inner->where('name', 'like', '%'.$term.'%')
                        ->orWhere('description', 'like', '%'.$term.'%')
                        ->orWhere('status', 'like', '%'.$term.'%');
                });
            })
            ->orderBy($sort, $dir)
            ->paginate(10)
            ->appends($request->query());

        return view('admin.category.category', [
            'categories' => $categories,
            'statuses' => CategoryStatus::cases(),
            'sortOptions' => $allowedSorts,
        ]);
    }

    public function store(CategorySaveRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return back()->with('flash', ['type' => 'success', 'message' => 'Category created successfully.']);
    }

    public function update(CategorySaveRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return back()->with('flash', ['type' => 'success', 'message' => 'Category updated successfully.']);
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return back()->with('flash', ['type' => 'warning', 'message' => 'Category deleted successfully.']);
    }

    public function updateStatus(CategoryStatusRequest $request, Category $category): RedirectResponse
    {
        $category->update(['status' => $request->validated('status')]);

        return back()->with('flash', ['type' => 'success', 'message' => 'Category status updated successfully.']);
    }
}
