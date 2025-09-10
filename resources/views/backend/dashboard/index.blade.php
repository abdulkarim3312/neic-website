@extends('backend.master')
@section('title', 'NEIC Dashboard')
@section('content')

@php
    $commentsCount = App\Models\PublicOpinion::count();
    $usersCount = App\Models\Admin::count();
@endphp
    <div class="row gy-4">
      <!-- Total Comments Card -->
      <div class="col-md-6 col-lg-6">
          <div class="card h-100">
              <div class="card-body text-center">
                  <div class="avatar mb-3">
                      <div class="avatar-initial bg-primary rounded-circle shadow-sm" style="width:60px; height:60px; display:flex; align-items:center; justify-content:center;">
                          <i class="ri ri-chat-3-line icon-32px text-white"></i>
                      </div>
                  </div>
                  <h5 class="card-title">Total Comments</h5>
                  <h3 class="text-primary mb-2">{{ $commentsCount ?? 0 }}</h3>
                  <a href="{{ route('comments.index') }}" class="btn btn-sm btn-primary">
                      View All Comments
                  </a>
              </div>
          </div>
      </div>

      <!-- Total Users Card -->
      <div class="col-md-6 col-lg-6">
          <div class="card h-100">
              <div class="card-body text-center">
                  <div class="avatar mb-3">
                      <div class="avatar-initial bg-success rounded-circle shadow-sm" style="width:60px; height:60px; display:flex; align-items:center; justify-content:center;">
                          <i class="ri ri-user-3-line icon-32px text-white"></i>
                      </div>
                  </div>
                  <h5 class="card-title">Total Users</h5>
                  <h3 class="text-success mb-2">{{ $usersCount ?? 0 }}</h3>
                  <a href="{{ route('users.index') }}" class="btn btn-sm btn-success">
                      View Users
                  </a>
              </div>
          </div>
      </div>
  </div>


@endsection
