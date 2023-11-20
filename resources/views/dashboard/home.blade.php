@extends('layouts.dashboard')

@section('content')
<!--begin::Card-->
<div class="card mb-2">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
      <div class="px-md-10 pt-md-10 pb-md-5">
        <!--begin::Block-->
        <div class="text-center mb-20">
          <h1 class="fs-2tx fw-bolder mb-8">
          Welcome
          <span class="d-inline-block position-relative ms-2">
            <span class="d-inline-block mb-2">{{ Auth::user()->name }}</span>
            <span class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-success translate rounded"></span>
          </span></h1>
          <div class="fw-bold fs-2 text-gray-500 mb-10">Welcome to the career recommendation system by TechInnovate</div>
        </div>
        <!--end::Block-->
      </div>
    <!--end::Section-->
  </div>
  <!--end::Card Body-->
</div>
<!--end::Card-->
@endsection