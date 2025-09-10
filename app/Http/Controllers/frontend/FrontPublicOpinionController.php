<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PublicOpinion;
use App\Http\Controllers\Controller;

class FrontPublicOpinionController extends Controller
{
    public function dashboard()
    {
        return view('customer.dashboard.index');
    }

    public function customerOrder()
    {
        return view('customer.dashboard.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'comment' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,mp4,mov,avi,mkv|max:512000',
        ]);

        $opinion = new PublicOpinion();
        $opinion->name = $request->name;
        $opinion->phone = $request->phone;
        $opinion->comment = $request->comment;
        $opinion->user_ip = $request->ip();
        $opinion->user_agent_info = $request->userAgent();
        $opinion->entry_time = now();

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . Str::slug($file->getClientOriginalName());
            $file->move(public_path('uploads/opinions'), $filename);
            $opinion->attachment = 'uploads/opinions/' . $filename;
            $opinion->attachment_display_name = $file->getClientOriginalName();
        }

        $opinion->save();

        return back()->with('success', 'আপনার মতামত সফলভাবে জমা হয়েছে!');
    }
}
