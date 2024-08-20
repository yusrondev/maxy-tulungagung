@extends('layouts.backoffice')
@section('menu-setting', 'active')
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
      <div class="card">
          <div class="card-body">            <div class="max-w-xl">
                @include('admin.profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('admin.profile.partials.update-password-form')
            </div>
        </div>
    </div>
</div>
@endsection