<?php

namespace App\Http\Controllers\backend;

use App\Models\Menu;
use Illuminate\Support\Str;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!auth('admin')->user()->can('menus.view')) {
            abort(403, 'Access denied');
        }
        if ($request->ajax()) {
            $menus = Menu::query();
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

                    if (auth('admin')->user()->can('menus.edit')) {
                        $buttons .= '<a href="' . route('menus.edit', $row->id) . '"
                            class="btn btn-sm btn-primary text-white mx-1">
                            <i class="fa fa-edit"></i>
                        </a>';
                    }

                    if (auth('admin')->user()->can('menus.delete')) {
                        $buttons .= '<form action="' . route('menus.destroy', $row->id) . '" method="POST" class="delete-form d-inline" data-id="' . $row->id . '" data-name="' . $row->name . '">' .
                            csrf_field() .
                            method_field('DELETE') .
                            '<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>' .
                            '</form>';
                    }

                    return $buttons;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.menu.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth('admin')->user()->can('menus.create')) {
            abort(403, 'Access denied');
        }
        $menuCategories = MenuCategory::where('status', 1)->get();
        return view('backend.menu.create', compact('menuCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_bn' => 'required|string',
            'name_en' => 'required|string',
            'menu_category_id' => 'required|string',
            'status' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            $menu = new Menu();
            $menu->menu_category_id  = $request->menu_category_id;
            $menu->name_bn = $request->name_bn;
            $menu->name_en = $request->name_en;
            $menu->slug = Str::slug($request->name_en);
            $menu->status = $request->status;
            $menu->entry_by = auth()->user()->id;
            $menu->entry_time = Carbon::now();
            $menu->save();

            DB::commit();

            return redirect()->route('menus.index')->with('success', 'Created successfully!');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menuCategories = MenuCategory::where('status', 1)->get();
        $menu = Menu::findOrFail($id);
        return view('backend.menu.edit', compact('menuCategories', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name_bn' => 'required|string',
            'name_en' => 'required|string',
            'menu_category_id' => 'required|string',
            'status' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            $menu = Menu::findOrFail($id);
            $menu->menu_category_id  = $request->menu_category_id;
            $menu->name_bn = $request->name_bn;
            $menu->name_en = $request->name_en;
            if ($menu->isDirty('name_en')) {
                $menu->slug = Str::slug($request->name_en) . '-' . $id;
            }
            $menu->status = $request->status;
            $menu->last_update_by = auth()->user()->id;
            $menu->last_update_time = Carbon::now();
            $menu->save();

            DB::commit();

            return redirect()->route('menus.index')->with('success', 'Updated successfully!');
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
        $category = Menu::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully!'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $category = Menu::findOrFail($id);
        $category->status = $request->status;
        $category->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}
