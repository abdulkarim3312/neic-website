<?php

namespace App\Http\Controllers\backend;

use Illuminate\Support\Str;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class MenuCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!auth('admin')->user()->can('menu_categories.view')) {
            abort(403, 'Access denied');
        }
        if ($request->ajax()) {
            $categories = MenuCategory::with('user');
            return DataTables::of($categories)
                ->addColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<input type="checkbox" class="status-toggle big-checkbox" data-id="' . $row->id . '" ' . $checked . '>';
                })
                ->addColumn('user', function ($row) {
                    return $row->user->name ?? '';
                })
                ->addColumn('entry_time', function ($row) {
                    if ($row->entry_time) {
                        return $row->entry_time->timezone('Asia/Dhaka')->format('d M Y, h:i:s A');
                    }
                    return '';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';

                    if (auth('admin')->user()->can('menu_categories.edit')) {
                        $buttons .= '<a href="' . route('menu-categories.edit', $row->id) . '"
                            class="btn btn-sm btn-primary text-white mx-1">
                            <i class="fa fa-edit"></i>
                        </a>';
                    }

                    if (auth('admin')->user()->can('menu_categories.delete')) {
                        $buttons .= '<form action="' . route('menu-categories.destroy', $row->id) . '" method="POST" class="delete-form d-inline" data-id="' . $row->id . '" data-name="' . $row->name . '">' .
                            csrf_field() .
                            method_field('DELETE') .
                            '<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>' .
                            '</form>';
                    }

                    return $buttons;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.menu_category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth('admin')->user()->can('menu_categories.create')) {
            abort(403, 'Access denied');
        }
        return view('backend.menu_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth('admin')->user()->can('menu_categories.create')) {
            abort(403, 'Access denied');
        }
        $request->merge([
            'name_bn' => preg_replace('/\s+/', ' ', trim($request->input('name_bn'))),
            'name_en' => preg_replace('/\s+/', ' ', trim($request->input('name_en')))
        ]);
        $request->validate([
            'name_bn' => 'required|string|max:255|unique:menu_categories,name_bn',
            'name_en' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $category = new MenuCategory();
        $category->name_bn = $request->name_bn;
        $category->name_en = $request->name_en;
        $category->slug = Str::slug($request->name_en);
        $category->status = $request->status;
        $category->entry_by = auth()->user()->id;
        $category->entry_time = Carbon::now();
        $category->save();
        return redirect()->route('menu-categories.index')->with('success', 'created successfully !');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth('admin')->user()->can('menu_categories.edit')) {
            abort(403, 'Access denied');
        }
        $category = MenuCategory::findOrFail($id);
        return view('backend.menu_category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!auth('admin')->user()->can('menu_categories.edit')) {
            abort(403, 'Access denied');
        }
        $request->merge([
            'name_bn' => preg_replace('/\s+/', ' ', trim($request->input('name_bn'))),
            'name_en' => preg_replace('/\s+/', ' ', trim($request->input('name_en')))
        ]);

        $request->validate([
            'name_bn' => 'required|string|max:255|unique:menu_categories,name_bn,' . $id,
            'name_en' => 'required|string|max:255|unique:menu_categories,name_en,' . $id,
            'status'  => 'required|boolean',
        ]);

        $category = MenuCategory::findOrFail($id);
        $category->name_bn = $request->name_bn;
        $category->name_en = $request->name_en;

        if ($category->isDirty('name_en')) {
            $category->slug = Str::slug($request->name_en) . '-' . $id;
        }

        $category->status          = $request->status;
        $category->last_update_by  = auth()->user()->id;
        $category->last_update_time = Carbon::now(); 

        $category->save();

        return redirect()->route('menu-categories.index')->with('success', 'Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth('admin')->user()->can('menu_categories.delete')) {
            abort(403, 'Access denied');
        }
        $category = MenuCategory::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully!'
        ]);
    }


    public function updateStatus(Request $request, $id)
    {
        $category = MenuCategory::findOrFail($id);
        $category->status = $request->status;
        $category->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}
