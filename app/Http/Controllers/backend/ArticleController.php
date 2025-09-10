<?php

namespace App\Http\Controllers\backend;

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $menus = Article::query();
            return DataTables::of($menus)
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

                    $buttons .= '<a href="' . route('articles.show', $row->id) . '"
                        class="btn btn-sm btn-success text-white mx-1">
                        <i class="fa fa-eye"></i>
                    </a>';
                    $buttons .= '<a href="' . route('articles.edit', $row->id) . '"
                        class="btn btn-sm btn-primary text-white mx-1">
                        <i class="fa fa-edit"></i>
                    </a>';
                    $buttons .= '<form action="' . route('articles.destroy', $row->id) . '" method="POST" class="delete-form d-inline" data-id="' . $row->id . '" data-name="' . $row->name . '">' .
                        csrf_field() .
                        method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>' .
                        '</form>';
                    

                    return $buttons;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.article.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ArticleCategory::where('status', 1)->get();
        return view('backend.article.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'article_category_id' => 'nullable|exists:article_categories,id',
            'title_bn' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'details_bn' => 'nullable|string',
            'details_en' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,mp4|max:512000', // max 500 MB for video
            'status' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            $article = new Article();
            $article->article_category_id = $request->article_category_id;
            $article->title_bn = $request->title_bn;
            $article->title_en = $request->title_en;
            $article->slug = Str::slug($request->title_en) . '-' . Str::lower(Str::random(6));
            $article->details_bn = $request->details_bn;
            $article->details_en = $request->details_en;
            $article->attachment_display_name = $request->attachment_display_name;
            $article->entry_by = auth()->user()->id;
            $article->entry_time = now();
            $article->status = $request->status;

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '_' . Str::slug($file->getClientOriginalName());
                $file->move(public_path('uploads/attachment'), $filename);
                $article->attachment = 'uploads/attachment/' . $filename;
                $article->attachment_display_name = $file->getClientOriginalName();
            }

            $article->save();

            DB::commit();

            return redirect()->route('articles.index')->with('success', 'created successfully !');
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
        $article = Article::findOrFail($id);
        return view('backend.article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = ArticleCategory::where('status', 1)->get();
        $article = Article::findOrFail($id);
        return view('backend.article.edit', compact('categories', 'article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'article_category_id' => 'nullable|exists:article_categories,id',
            'title_bn' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'details_bn' => 'nullable|string',
            'details_en' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,mp4|max:512000', // max 500 MB for video
            'status' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            $article->article_category_id = $request->article_category_id;
            $article->title_bn = $request->title_bn;
            $article->title_en = $request->title_en;
            $article->slug = Str::slug($request->title_en) . '-' . Str::lower(Str::random(6));
            $article->details_bn = $request->details_bn;
            $article->details_en = $request->details_en;
            $article->status = $request->status;
            $article->last_update_by = auth()->user()->id;
            $article->last_update_time = now();

            if ($request->hasFile('attachment')) {
                if ($article->attachment && file_exists(public_path($article->attachment))) {
                    unlink(public_path($article->attachment));
                }

                $file = $request->file('attachment');
                $filename = time() . '_' . Str::slug($file->getClientOriginalName());
                $file->move(public_path('uploads/attachment'), $filename);

                $article->attachment = 'uploads/attachment/' . $filename;
                $article->attachment_display_name = $file->getClientOriginalName();
            }

            $article->save();

            DB::commit();

            return redirect()->route('articles.index')->with('success', 'Updated successfully!');
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
        $article = Article::findOrFail($id);
        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully!'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->status = $request->status;
        $article->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}
