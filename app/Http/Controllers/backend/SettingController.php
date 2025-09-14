<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Contact;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function aboutUs()
    {
        $about = AboutUs::first();
        $contact = Contact::first();
        return view('backend.setting.about.create', compact('about', 'contact'));
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
    public function contact()
    {
        $contact = Contact::first();
        return view('backend.setting.contact.create', compact('contact'));
    }

    public function contactUpdateOrCreate(Request $request)
    {
        // dd($request->all());
        $check = Contact::first();
        $data = [
            'title' => $request->title,
            'address' => $request->address,
            'email' => $request->email
        ];

        if ($check) {
            $check->update($data);
        } else {
            Contact::create($data);
        }

        return redirect()->back()->with('success', 'Updated Successfully!');
    }
}
