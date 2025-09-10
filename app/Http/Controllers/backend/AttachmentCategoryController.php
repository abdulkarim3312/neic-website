<?php

namespace App\Http\Controllers\backend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\AttachmentCategory;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class AttachmentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $attachmentCategories = AttachmentCategory::with('user');
            return DataTables::of($attachmentCategories)
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

                    $buttons .= '<a href="' . route('attachment-categories.edit', $row->id) . '"
                        class="btn btn-sm btn-primary text-white mx-1">
                        <i class="fa fa-edit"></i>
                    </a>';
                    
                    $buttons .= '<form action="' . route('attachment-categories.destroy', $row->id) . '" method="POST" class="delete-form d-inline" data-id="' . $row->id . '" data-name="' . $row->name . '">' .
                        csrf_field() .
                        method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>' .
                        '</form>';

                    return $buttons;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.attachment_category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.attachment_category.create');
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
            'name_bn' => 'required|string|max:255|unique:article_categories,name_bn',
            'name_en' => 'required|string|max:255|unique:article_categories,name_en',
            'status' => 'required|boolean',
        ]);

        $attachmentCategory = new AttachmentCategory();
        $attachmentCategory->name_bn = $request->name_bn;
        $attachmentCategory->name_en = $request->name_en;
        $attachmentCategory->slug = Str::slug($request->name_en) . '-' . Str::lower(Str::random(6));
        $attachmentCategory->status = $request->status;
        $attachmentCategory->entry_by = auth()->user()->id;
        $attachmentCategory->entry_time = Carbon::now();
        $attachmentCategory->save();
        return redirect()->route('attachment-categories.index')->with('success', 'created successfully !');

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
        $attachmentCategory = AttachmentCategory::findOrFail($id);
        return view('backend.attachment_category.edit', compact('attachmentCategory'));
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
            'name_bn' => 'required|string|max:255|unique:article_categories,name_bn,' . $id,
            'name_en' => 'required|string|max:255|unique:article_categories,name_en,' . $id,
            'status'  => 'required|boolean',
        ]);

        $attachmentCategory = AttachmentCategory::findOrFail($id);
        $attachmentCategory->name_bn = $request->name_bn;
        $attachmentCategory->name_en = $request->name_en;

        if ($attachmentCategory->isDirty('name_en')) {
            $attachmentCategory->slug = Str::slug($request->name_en) . '-' . $id;
        }

        $attachmentCategory->status          = $request->status;
        $attachmentCategory->last_update_by  = auth()->user()->id;
        $attachmentCategory->entry_by = auth()->user()->id;
        $attachmentCategory->entry_time = Carbon::now();
        $attachmentCategory->last_update_time = Carbon::now(); 

        $attachmentCategory->save();

        return redirect()->route('attachment-categories.index')->with('success', 'Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attachmentCategory = AttachmentCategory::findOrFail($id);
        $attachmentCategory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully!'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $attachmentCategory = AttachmentCategory::findOrFail($id);
        $attachmentCategory->status = $request->status;
        $attachmentCategory->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}
