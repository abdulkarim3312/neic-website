<style>
  .menu-sub {
    display: none;
  }

  .menu-item.open > .menu-sub {
    display: block;
  }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu" >
  <div class="app-brand demo ">
    <a href="/" class="app-brand-link gap-xl-0 gap-2">
      <span class="app-brand-logo demo me-1">
        <span class="text-primary">
        </span>
    </span>
      <span class="app-brand-text demo menu-text fw-semibold ms-2">NEIC</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="menu-toggle-icon d-xl-inline-block align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">

      <!-- Dashboard Header -->
      <li class="menu-header mt-7">
        <span class="menu-header-text" data-i18n="Dashboard">Dashboard</span>
      </li>

      <!-- Dashboard Menu -->
      <li class="menu-item">
        <a href="{{ route('dashboard') }}" class="menu-link">
          <i class="menu-icon icon-base ri ri-home-smile-line"></i>
          <div data-i18n="Dashboards">Dashboard</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{ route('dashboard') }}" class="menu-link">
          <i class="menu-icon icon-base ri ri-chat-3-line"></i>
          <div data-i18n="Dashboards">Public Opinion</div>
        </a>
      </li>

      @php
        $isUserActive = request()->routeIs('users.index', 'users.create', 'users.edit');
        $isRoleActive = request()->routeIs('roles.index', 'roles.create', 'roles.edit');
        $isUserManagementOpen = $isUserActive || $isRoleActive;
      @endphp

      @can('user.manage')
        <li class="menu-item {{ $isUserManagementOpen ? 'active open' : '' }}">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-user-3-line"></i>
            <div data-i18n="Dashboards">User Management</div>
          </a>
          <ul class="menu-sub">
            @can('user.view')
                <li class="menu-item {{ $isUserActive ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}" class="menu-link">
                        <div data-i18n="Dashboard">User</div>
                    </a>
                </li>
            @endcan

            @can('role.view')
                <li class="menu-item {{ $isRoleActive ? 'active' : '' }}">
                    <a href="{{ route('roles.index') }}" class="menu-link">
                        <div data-i18n="Blank Pages">Role</div>
                    </a>
                </li>
            @endcan
          </ul>
        </li>
      @endcan
        
      <!-- category Manage Menu -->
      @php
          $isCategoryActive      = request()->routeIs('menu-categories.index', 'menu-categories.create', 'menu-categories.edit');
          $isSubCategoryActive   = request()->routeIs('menus.index', 'menus.create', 'menus.edit');
          $isChildCategoryActive = request()->routeIs('child-categories.index', 'child-categories.create', 'child-categories.edit');

          $isCategoryManagementOpen = $isCategoryActive || $isSubCategoryActive || $isChildCategoryActive;
      @endphp

      @can('menu_categories.manage') 
          <li class="menu-item {{ $isCategoryManagementOpen ? 'active open' : '' }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon fas fa-layer-group fs-5"></i>
                  <div data-i18n="Category">Menu Manage</div>
              </a>
              <ul class="menu-sub">

                  @can('menu_categories.view') 
                      <li class="menu-item {{ $isCategoryActive ? 'active' : '' }}">
                          <a href="{{ route('menu-categories.index') }}" class="menu-link">
                              <div>Menu Category</div>
                          </a>
                      </li>
                  @endcan

                  @can('menus.view') 
                      <li class="menu-item {{ $isSubCategoryActive ? 'active' : '' }}">
                          <a href="{{ route('menus.index') }}" class="menu-link">
                              <div>Menu</div>
                          </a>
                      </li>
                  @endcan

              </ul>
          </li>
      @endcan
      <!-- product Manage Menu -->
      {{-- @can('article_categories.manage')  --}}
        <li class="menu-item {{ 
            Route::is('article-categories.index') || 
            Route::is('article-categories.create') || 
            Route::is('article-categories.edit') ||
            Route::is('articles.index') || 
            Route::is('articles.create') || 
            Route::is('articles.show') || 
            Route::is('articles.edit') 
            ? 'active open' : '' 
        }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-shopping-cart-line"></i>
                <div data-i18n="Product">Article Manage</div>
            </a>
            <ul class="menu-sub">
                {{-- @can('article_categories.view')  --}}
                  <li class="menu-item {{ Route::is('article-categories.index') || Route::is('article-categories.create') || Route::is('article-categories.edit') ? 'active' : '' }}">
                      <a href="{{ route('article-categories.index') }}" class="menu-link">
                          <div data-i18n="Product List">Category</div>
                      </a>
                  </li>
                {{-- @endcan --}}
                {{-- @can('articles.view')  --}}
                  <li class="menu-item {{ Route::is('articles.index') || Route::is('articles.show') || Route::is('articles.create') || Route::is('articles.edit') ? 'active' : '' }}">
                      <a href="{{ route('articles.index') }}" class="menu-link">
                          <div data-i18n="Add Product">Article</div>
                      </a>
                  </li>
                {{-- @endcan --}}
            </ul>
        </li>
      {{-- @endcan --}}

      {{-- @can('designations.manage')  --}}
        <li class="menu-item {{ 
            Route::is('designations.index') || 
            Route::is('designations.create') || 
            Route::is('designations.edit') ||
            Route::is('committee-members.index') || 
            Route::is('committee-members.create') || 
            Route::is('committee-members.show') || 
            Route::is('committee-members.edit') 
            ? 'active open' : '' 
        }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-team-line"></i>
                <div data-i18n="Product">Member Manage</div>
            </a>
            <ul class="menu-sub">
                {{-- @can('designations.view')  --}}
                  <li class="menu-item {{ Route::is('designations.index') || Route::is('designations.create') || Route::is('designations.edit') ? 'active' : '' }}">
                      <a href="{{ route('designations.index') }}" class="menu-link">
                          <div data-i18n="Product List">Designation</div>
                      </a>
                  </li>
                {{-- @endcan --}}
                @can('committee_member_info.view') 
                  <li class="menu-item {{ Route::is('committee-members.index') || Route::is('committee-members.show') || Route::is('committee-members.create') || Route::is('committee-members.edit') ? 'active' : '' }}">
                      <a href="{{ route('committee-members.index') }}" class="menu-link">
                          <div data-i18n="Add Product">Committee Member</div>
                      </a>
                  </li>
                {{-- @endcan --}}
            </ul>
        </li>
      {{-- @endcan --}}

      {{-- @can('attachment_categories.manage')  --}}
        <li class="menu-item {{ 
            Route::is('attachment-categories.index') || 
            Route::is('attachment-categories.create') || 
            Route::is('attachment-categories.edit') ||
            Route::is('attachments.index') || 
            Route::is('attachments.create') || 
            Route::is('attachments.edit') 
            ? 'active open' : '' 
        }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-attachment-line"></i>
                <div data-i18n="Product">Attachment Manage</div>
            </a>
            <ul class="menu-sub">
                {{-- @can('attachment_categories.view')  --}}
                  <li class="menu-item {{ Route::is('attachment-categories.index') || Route::is('attachment-categories.create') || Route::is('attachment-categories.edit') ? 'active' : '' }}">
                      <a href="{{ route('attachment-categories.index') }}" class="menu-link">
                          <div data-i18n="Product List">Category</div>
                      </a>
                  </li>
                {{-- @endcan --}}
                {{-- @can('attachments.view')  --}}
                  <li class="menu-item {{ Route::is('attachments.index') || Route::is('attachments.create') || Route::is('attachments.edit') ? 'active' : '' }}">
                      <a href="{{ route('attachments.index') }}" class="menu-link">
                          <div data-i18n="Add Product">Attachment</div>
                      </a>
                  </li>
                {{-- @endcan --}}
            </ul>
        </li>
      @endcan
    </ul>
</aside>

<div class="menu-mobile-toggler d-xl-none rounded-1">
  <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
    <i class="ri ri-menu-line icon-base"></i>
    <i class="ri ri-arrow-right-s-line icon-base"></i>
  </a>
</div>
