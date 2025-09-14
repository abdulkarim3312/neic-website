<?php

namespace App\Http\Controllers\backend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CommitteeMemberInfo;
use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\MemberCategory;
use Yajra\DataTables\Facades\DataTables;

class CommitteeMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $members = CommitteeMemberInfo::query();
            return DataTables::of($members)
                ->addColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<input type="checkbox" class="status-toggle big-checkbox" data-id="' . $row->id . '" ' . $checked . '>';
                })
                ->addColumn('user', function ($row) {
                    return $row->entryUser->name ?? '';
                })

                ->addColumn('designation', function ($row) {
                    return $row->designation->name_en ?? '';
                })
                ->addColumn('entry_time', function ($row) {
                    if ($row->entry_time) {
                        return $row->entry_time->timezone('Asia/Dhaka')->format('d M Y, h:i:s A');
                    }
                    return '';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';

                    $buttons .= '<a href="' . route('committee-members.show', $row->id) . '"
                        class="btn btn-sm btn-success text-white mx-1">
                        <i class="fa fa-eye"></i>
                    </a>';
                    $buttons .= '<a href="' . route('committee-members.edit', $row->id) . '"
                        class="btn btn-sm btn-primary text-white mx-1">
                        <i class="fa fa-edit"></i>
                    </a>';

                    $buttons .= '<form action="' . route('committee-members.destroy', $row->id) . '" method="POST" class="delete-form d-inline" data-id="' . $row->id . '" data-name="' . $row->name . '">' .
                        csrf_field() .
                        method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>' .
                        '</form>';
                    

                    return $buttons;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.committee_member.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = MemberCategory::where('status', 1)->get();
        $designations = Designation::where('status', 1)->get();
        return view('backend.committee_member.create', compact('designations', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'designation_id' => 'nullable|exists:designations,id',
            'member_category_id' => 'nullable|exists:member_categories,id',
            'article_url' => 'nullable|url|max:255',
            'entry_by' => 'nullable|integer',
            'last_update_by' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();


            $photoPath = null;

            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/members_photo'), $imageName);
                $photoPath = 'uploads/members_photo/' . $imageName;
            }

            $committeeMember = new CommitteeMemberInfo();
            $committeeMember->designation_id = $request->designation_id;
            $committeeMember->member_category_id = $request->member_category_id;
            $committeeMember->name_bn = $request->name_bn;
            $committeeMember->name_en = $request->name_en;
            $committeeMember->email = $request->email;
            $committeeMember->mobile = $request->mobile;
            $committeeMember->description = $request->description;
            $committeeMember->slug = Str::slug($request->name_en) . '-' . Str::lower(Str::random(6));
            $committeeMember->article_url = $request->article_url;
            $committeeMember->entry_by = auth()->user()->id;
            $committeeMember->entry_time = now();
            $committeeMember->photo = $photoPath;
            $committeeMember->status = $request->status ?? true;
            $committeeMember->save();

            DB::commit();

            return redirect()->route('committee-members.index')->with('success', 'created successfully !');

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
        $member = CommitteeMemberInfo::with('entryUser', 'updateUser')->findOrFail($id);
        return view('backend.committee_member.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = MemberCategory::where('status', 1)->get();
        $designations = Designation::where('status', 1)->get();
        $member = CommitteeMemberInfo::findOrFail($id);

        return view('backend.committee_member.edit', compact('designations', 'member', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'designation_id' => 'nullable|exists:designations,id',
            'member_category_id' => 'nullable|exists:member_categories,id',
            'article_url' => 'nullable|url|max:255',
            'slug' => 'nullable|string|max:255',
            'last_update_by' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();

            $committeeMember = CommitteeMemberInfo::findOrFail($id);

            if ($request->hasFile('photo')) {
                if ($committeeMember->photo && file_exists(public_path($committeeMember->photo))) {
                    unlink(public_path($committeeMember->photo));
                }

                $image = $request->file('photo');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/members_photo'), $imageName);
                $committeeMember->photo = 'uploads/members_photo/' . $imageName;
            }


            $committeeMember->designation_id = $request->designation_id ?? $committeeMember->designation_id;
            $committeeMember->member_category_id = $request->member_category_id;
            $committeeMember->name_bn = $request->name_bn;
            $committeeMember->name_en = $request->name_en;
            $committeeMember->email = $request->email;
            $committeeMember->mobile = $request->mobile;
            $committeeMember->description = $request->description;
            $committeeMember->article_url = $request->article_url ?? $committeeMember->article_url;
            if ($committeeMember->isDirty('name_en')) {
                $committeeMember->slug = Str::slug($request->name_en) . '-' . $id;
            }
            $committeeMember->last_update_by = auth()->user()->id;
            $committeeMember->last_update_time = now();
            $committeeMember->status = $request->status ?? $committeeMember->status;
            $committeeMember->save();

            DB::commit();

            return redirect()->route('committee-members.index')->with('success', 'Updated successfully !');

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
        $committeeMember = CommitteeMemberInfo::findOrFail($id);
        $committeeMember->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully!'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $committeeMember = CommitteeMemberInfo::findOrFail($id);
        $committeeMember->status = $request->status;
        $committeeMember->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}
