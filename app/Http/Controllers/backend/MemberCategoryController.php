<?php

namespace App\Http\Controllers\backend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MemberCategory;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class MemberCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = MemberCategory::query();
            return DataTables::of($categories)
                ->addColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<input type="checkbox" class="status-toggle big-checkbox" data-id="' . $row->id . '" ' . $checked . '>';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';

                    $buttons .= '<button type="button" class="btn btn-sm btn-primary text-white edit_btn editBtn mx-1" data-id="' . $row->id . '">
                        <i class="fa fa-edit"></i>
                    </button>';

                    $buttons .= '<form action="' . route('member-categories.destroy', $row->id) . '" method="POST" class="delete-form d-inline" data-id="' . $row->id . '" data-name="' . $row->name . '">' .
                        csrf_field() .
                        method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>' .
                        '</form>';

                    return $buttons;
                })
                ->addColumn('meta_keywords', function ($row) {
                    return $row->meta_keywords ?? '';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        return view('backend.member_category.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'name_bn' => preg_replace('/\s+/', ' ', trim($request->input('name_bn'))),
            'name_en' => preg_replace('/\s+/', ' ', trim($request->input('name_en')))
        ]);
        $request->validate([
            'name_bn' => 'required|string|max:255|unique:member_categories,name_bn',
            'name_en' => 'required|string|max:255|unique:member_categories,name_en',
            'status' => 'required|boolean',
        ]);

        $category = new MemberCategory();
        $category->name_bn = $request->name_bn;
        $category->name_en = $request->name_en;
        $category->slug = Str::slug($request->name_en);
        $category->status = $request->status;
        $category->save();
        return response()->json(['success' => true, 'message' => 'created successfully!']);

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = MemberCategory::findOrFail($id);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->merge([
            'name_bn' => preg_replace('/\s+/', ' ', trim($request->input('name_bn'))),
            'name_en' => preg_replace('/\s+/', ' ', trim($request->input('name_en')))
        ]);

        $request->validate([
            'name_bn' => 'required|string|max:255|unique:member_categories,name_bn,' . $id,
            'name_en' => 'required|string|max:255|unique:member_categories,name_en,' . $id,
            'status' => 'required|boolean',
        ]);

        $category = MemberCategory::findOrFail($id);

        $category->name_bn = $request->name_bn;
        $category->name_en = $request->name_en;
        $category->slug    = Str::slug($request->name_en);
        $category->status  = $request->status;
        $category->save();

        return response()->json(['success' => true, 'message' => 'Updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = MemberCategory::findOrFail($id);
        $category->delete();

        return response()->json(['success' => true, 'message' => 'deleted successfully!']);
    }

    public function updateStatus(Request $request, $id)
    {
        $category = MemberCategory::findOrFail($id);
        $category->status = $request->status;
        $category->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}
