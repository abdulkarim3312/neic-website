<?php

namespace App\Http\Controllers\frontend;

use DB;
use Illuminate\Http\Request;
use App\Models\CommitteeMemberInfo;
use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Article;
use App\Models\Attachment;
use App\Models\Contact;

class HomeController extends Controller
{
    public function home()
    {   
        $attachments = Article::where('status' ,1)->take(10)->get();
        return view('frontend.home.index', compact('attachments'));
    }
    public function searchData(Request $req) {
        return view('frontend.home.searchData' , compact('results'));
    }

    public function details() {
        $data = CommitteeMemberInfo::first();
        return view('frontend.pages.person_details', compact('data'));
    }

    public function aboutPage() {
        $about = AboutUs::first();
        return view('frontend.pages.about', compact('about'));
    }

    public function contactPage() {
        $contact = Contact::first();
        return view('frontend.pages.contact', compact('contact'));
    }

    public function commentPage() {
        return view('frontend.pages.comment');
    }
    public function noticePage() {
        $attachments = Attachment::where('status' ,1)->get();
        return view('frontend.pages.notice', compact('attachments'));
    }

    public function reportPage() {
        $articles = Article::where('status' ,1)->get();
        return view('frontend.pages.report', compact('articles'));
    }

    public function reportDetails($slug) {
        $article = Article::where('slug' , $slug)->first();
        return view('frontend.pages.report_details', compact('article'));
    }

    public function memberList() {
        $article = CommitteeMemberInfo::get();
        return view('frontend.pages.member_list', compact('article'));
    }
}
