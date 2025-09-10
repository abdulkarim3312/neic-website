<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\PublicOpenion;
use App\Models\PublicOpinion;
use App\Models\CommitteeMemberInfo;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PublicOpinionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $comments = PublicOpinion::query();
            return DataTables::of($comments)
                ->addColumn('entry_time', function ($row) {
                    if ($row->entry_time) {
                        return $row->entry_time->timezone('Asia/Dhaka')->format('d M Y, h:i:s A');
                    }
                    return '';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';
                
                    $buttons .= '<a href="' . route('comments.show', $row->id) . '"
                        class="btn btn-sm btn-primary text-white mx-1">
                        <i class="fa fa-eye"></i>
                    </a>';
                
                    $buttons .= '<form action="' . route('comments.destroy', $row->id) . '" method="POST" class="delete-form d-inline" data-id="' . $row->id . '" data-name="' . $row->name . '">' .
                        csrf_field() .
                        method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>' .
                        '</form>';
                    

                    return $buttons;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('backend.public_opinion.index');
    }

    public function show($id)
    {
        $opinion = PublicOpinion::with('entryUser', 'updateUser')->findOrFail($id);
        return view('backend.public_opinion.show', compact('opinion'));
    }

    public function destroy(string $id)
    {
        $opinion = PublicOpinion::findOrFail($id);
        if ($opinion->attachment && file_exists(public_path($opinion->attachment))) {
            unlink(public_path($opinion->attachment));
        }

        $opinion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully with file!'
        ]);
    }

}
