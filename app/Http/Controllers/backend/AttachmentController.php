<?php

namespace App\Http\Controllers\backend;

use App\Models\Attachment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AttachmentCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $attachments = Attachment::query();
            return DataTables::of($attachments)
                ->addColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<input type="checkbox" class="status-toggle big-checkbox" data-id="' . $row->id . '" ' . $checked . '>';
                })
                ->addColumn('user', function ($row) {
                    return $row->user->name ?? '';
                })

                ->addColumn('category', function ($row) {
                    return $row->category->name_en ?? '';
                })
                ->addColumn('entry_time', function ($row) {
                    if ($row->entry_time) {
                        return $row->entry_time->timezone('Asia/Dhaka')->format('d M Y, h:i:s A');
                    }
                    return '';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';

                
                    $buttons .= '<a href="' . route('attachments.edit', $row->id) . '"
                        class="btn btn-sm btn-primary text-white mx-1">
                        <i class="fa fa-edit"></i>
                    </a>';
                

                
                    $buttons .= '<form action="' . route('attachments.destroy', $row->id) . '" method="POST" class="delete-form d-inline" data-id="' . $row->id . '" data-name="' . $row->name . '">' .
                        csrf_field() .
                        method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>' .
                        '</form>';
                    

                    return $buttons;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.attachment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = AttachmentCategory::where('status', 1)->get();
        return view('backend.attachment.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'attachment_id' => 'nullable|exists:attachment_categories,id',
            'file_name' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx',
            'slug' => 'nullable|string|max:255',
            'file_display_name' => 'nullable|string|max:255',
            'entry_by' => 'nullable|integer',
            'last_update_by' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            $filePath = null;

            if ($request->hasFile('file_name')) {
                $file = $request->file('file_name');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/file_name'), $fileName);
                $filePath = 'uploads/file_name/' . $fileName;
            }

            $attachment = new Attachment();
            $attachment->attachment_id = $request->attachment_id;
            $attachment->file_name = $filePath;
            $attachment->title_bn = $request->title_bn;
            $attachment->title_en = $request->title_en;
            $attachment->file_display_name = $request->file_display_name;
            $attachment->slug = Str::slug($request->file_display_name) . '-' . Str::lower(Str::random(6));
            $attachment->entry_by = auth()->user()->id;
            $attachment->entry_time = now();
            $attachment->last_update_by = $request->last_update_by;
            $attachment->last_update_time = now();
            $attachment->status = $request->status ?? true;
            $attachment->save();

            DB::commit();

            return redirect()->route('attachments.index')->with('success', 'created successfully !');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
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
        $categories = AttachmentCategory::where('status', 1)->get();
        $attachment = Attachment::findOrFail($id);
        return view('backend.attachment.edit', compact('categories', 'attachment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'attachment_id' => 'nullable|exists:attachment_categories,id',
            'file_name' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx',
            'slug' => 'nullable|string|max:255',
            'file_display_name' => 'nullable|string|max:255',
            'last_update_by' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            $attachment = Attachment::findOrFail($id);

            if ($request->hasFile('file_name')) {
                if ($attachment->file_name && file_exists(public_path($attachment->file_name))) {
                    unlink(public_path($attachment->file_name));
                }

                $file = $request->file('file_name');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/file_name'), $fileName);
                $attachment->file_name = 'uploads/file_name/' . $fileName;
            }

            $attachment->title_bn = $request->title_bn;
            $attachment->title_en = $request->title_en;

            $attachment->attachment_id = $request->attachment_id ?? $attachment->attachment_id;
            $attachment->file_display_name = $request->file_display_name ?? $attachment->file_display_name;

            if ($request->file_display_name) {
                $attachment->slug = Str::slug($request->file_display_name) . '-' . Str::lower(Str::random(6));
            }

            $attachment->last_update_by = auth()->user()->id;
            $attachment->last_update_time = now();
            $attachment->status = $request->status ?? $attachment->status;
            $attachment->save();

            DB::commit();

            return redirect()->route('attachments.index')->with('success', 'Updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attachment = Attachment::findOrFail($id);
        $attachment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully!'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $attachment = Attachment::findOrFail($id);
        $attachment->status = $request->status;
        $attachment->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}
