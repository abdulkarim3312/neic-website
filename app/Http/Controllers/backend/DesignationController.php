<?php

namespace App\Http\Controllers\backend;

use App\Models\Designation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $designations = Designation::with('user');
            return DataTables::of($designations)
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

                    $buttons .= '<a href="' . route('designations.edit', $row->id) . '"
                        class="btn btn-sm btn-primary text-white mx-1">
                        <i class="fa fa-edit"></i>
                    </a>';
                
                    $buttons .= '<form action="' . route('designations.destroy', $row->id) . '" method="POST" class="delete-form d-inline" data-id="' . $row->id . '" data-name="' . $row->name . '">' .
                        csrf_field() .
                        method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>' .
                        '</form>';
                    

                    return $buttons;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.designation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.designation.create');
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
            'name_bn' => 'required|string|max:255|unique:attachment_categories,name_bn',
            'name_en' => 'required|string|max:255|unique:attachment_categories,name_en',
            'status' => 'required|boolean',
        ]);

        $designation = new Designation();
        $designation->name_bn = $request->name_bn;
        $designation->name_en = $request->name_en;
        $designation->slug = Str::slug($request->name_en) . '-' . Str::lower(Str::random(6));
        $designation->status = $request->status;
        $designation->entry_by = auth()->user()->id;
        $designation->last_update_by  = auth()->user()->id;
        $designation->last_update_time = Carbon::now(); 
        $designation->entry_time = Carbon::now();
        $designation->save();
        return redirect()->route('designations.index')->with('success', 'created successfully !');

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
        $designation = Designation::findOrFail($id);
        return view('backend.designation.edit', compact('designation'));
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
            'name_bn' => 'required|string|max:255|unique:attachment_categories,name_bn,' . $id,
            'name_en' => 'required|string|max:255|unique:attachment_categories,name_en,' . $id,
            'status'  => 'required|boolean',
        ]);

        $designation = Designation::findOrFail($id);
        $designation->name_bn = $request->name_bn;
        $designation->name_en = $request->name_en;

        if ($designation->isDirty('name_en')) {
            $designation->slug = Str::slug($request->name_en) . '-' . $id;
        }

        $designation->status          = $request->status;
        $designation->entry_by = auth()->user()->id;
        $designation->entry_time = Carbon::now();
        $designation->last_update_by  = auth()->user()->id;
        $designation->last_update_time = Carbon::now(); 

        $designation->save();

        return redirect()->route('designations.index')->with('success', 'Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $designation = Designation::findOrFail($id);
        $designation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully!'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $designation = Designation::findOrFail($id);
        $designation->status = $request->status;
        $designation->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}
