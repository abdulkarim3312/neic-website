<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\CommissionActivity;
use App\Models\Contact;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function aboutUs()
    {
        $about = AboutUs::first();
        $contact = Contact::first();
        $commissionActivity = CommissionActivity::first();
        return view('backend.setting.about.create', compact('about', 'contact', 'commissionActivity'));
    }

    public function aboutUpdateOrCreate(Request $request)
    {

        $check = AboutUs::first();
        $data = [
            'title' => $request->title,
            'description' => $request->description
        ];

        if ($check) {
            $check->update($data);
        } else {
            AboutUs::create($data);
        }

        return redirect()->back()->with('success', 'Updated Successfully!');
    }

    public function activityUpdateOrCreate(Request $request)
    {
        $check = CommissionActivity::first();
        $data = [
            'title' => $request->title,
            'description' => $request->description
        ];

        if ($check) {
            $check->update($data);
        } else {
            CommissionActivity::create($data);
        }

        return redirect()->back()->with('success', 'Updated Successfully!');
    }
}
