@extends('layouts.dashboard')

@section('content') 
<div class="card mb-2 col-12">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div class="mb-2">
      <!--begin::Heading-->
      <div class="col-12 d-flex">
        <h1 class="anchor fw-bolder mb-5" id="striped-rounded-bordered">My Profile</h1>
      </div>
      <!--end::Heading-->
      <!--begin::Block-->
      <form method="post">
        @csrf
        <div class="row g-9 mb-8">
          <div class="col-12 col-md-6">
            <label class="fw-bold mb-2">Username</label>
            <input type="text" class="form-control" name="username" value="{{ Auth::user()->username }}" disabled>
          </div>
          <div class="col-12 col-md-6">
            <label class="fw-bold mb-2">Name</label>
            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
          </div>
          <div class="col-12 col-md-6">
            <label class="fw-bold mb-2">Pendidikan</label>
            <input type="text" class="form-control" name="education" value="{{ Auth::user()->education }}" required>
          </div>
          <div class="col-12 col-md-6">
            <label class="fw-bold mb-2">Pengalaman</label>
            <input type="text" class="form-control" name="experience" value="{{ Auth::user()->experience }}" required>
          </div>
          <div class="col-12 col-md-6">
            <label class="fw-bold mb-2">Minat</label>
            <input type="text" class="form-control" name="passion" value="{{ Auth::user()->passion }}" required>
          </div>
          <div class="col-12 col-md-6">
            <label class="fw-bold mb-2">Keahlian</label>
            <input type="text" class="form-control" name="skill" value="{{ Auth::user()->skill }}" required>
          </div>
        </div>
        <hr>
        <div class="d-flex">
          <button type="submit" class="btn btn-primary" name="submit" value="profile">Save</button>
        </div>
      </form>
      <!--end::Block-->
    </div>
    <!--end::Section-->
  </div>
  <!--end::Card Body-->
</div>

@endsection