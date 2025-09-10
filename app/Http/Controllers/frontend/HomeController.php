<?php

namespace App\Http\Controllers\frontend;

use DB;
use Illuminate\Http\Request;
use App\Models\CommitteeMemberInfo;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home()
    {
        return view('frontend.home.index');
    }
    public function searchData(Request $req) {
        return view('frontend.home.searchData' , compact('results'));
    }

    public function details() {
        $member = CommitteeMemberInfo::first();
        return view('frontend.pages.person_details', compact('member'));
    }

    public function contactPage() {
        return view('frontend.pages.contact');
    }

    public function commentPage() {
        return view('frontend.pages.comment');
    }
}
