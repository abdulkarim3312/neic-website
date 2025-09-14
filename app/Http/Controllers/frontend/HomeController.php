<?php

namespace App\Http\Controllers\frontend;

use DB;
use App\Models\AboutUs;
use App\Models\Article;
use App\Models\Contact;
use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Models\MemberCategory;
use App\Models\CommitteeMemberInfo;
use App\Http\Controllers\Controller;
use App\Models\AttachmentCategory;
use App\Models\CommissionActivity;

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

    public function aboutPage() {
        $about = AboutUs::first();
        return view('frontend.pages.about', compact('about'));
    }

    public function commissionActivity() {
        $commissionActivity = CommissionActivity::first();
        return view('frontend.pages.commission_activity', compact('commissionActivity'));
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

    public function memberList($slug) {
        $category = MemberCategory::where('slug', $slug)->first();
        $memberLists = CommitteeMemberInfo::with('designation')->where('status', 1)
            ->where('member_category_id', $category->id) 
            ->get();
        return view('frontend.pages.member_list', compact('memberLists', 'category'));
    }

    public function memberDetails($slug) {
        $category = MemberCategory::where('slug', $slug)->first();
        $memberDetails = CommitteeMemberInfo::with('designation')->where('status', 1)
            ->where('slug', $slug) 
            ->first();
        return view('frontend.pages.member_details', compact('memberDetails', 'category'));
    }

    public function gazettes($slug) {
        $category = AttachmentCategory::where('slug', $slug)->first();
        $gazettes = Attachment::where('status', 1)
            ->where('attachment_id', $category->id) 
            ->get();
        return view('frontend.pages.gazettes', compact('gazettes', 'category'));
    }
}
