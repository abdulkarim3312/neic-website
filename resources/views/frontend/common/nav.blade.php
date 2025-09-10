@php
    use App\Models\MenuCategory;
    $topMenuCategory = MenuCategory::with('menus')
        ->where('slug', 'top-menu') 
        ->where('status', 1)
        ->first();
@endphp
<div class="header">
    <div class="headerTop">
        <div class="row">
            <div class="col-12"> 
                <div class="title">
                    <h4>জাতীয় সংসদ নির্বাচন (২০১৪, ২০১৮, ২০২৪) তদন্ত কমিশন</h4>
                    <h4>National Election (2014, 2018, 2024) Inquiry Commission</h4>
                </div>
            </div>
                
        </div>
    </div>

    <div class="headerBottom">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav w-100 justify-content-between text-center">
                        @if($topMenuCategory && $topMenuCategory->menus->count() > 0)
                            @foreach($topMenuCategory->menus as $menu)
                                <li class="nav-item flex-fill">
                                    <a class="nav-link" href="{{ url($menu->slug ?? '#') }}">
                                        {{ $menu->name_bn }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>