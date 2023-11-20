@extends('layouts.admin')

@section('content') 
<div class="card mb-2">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div>
      <!--begin::Heading-->
      <div class="col-12 d-flex">
        <h1 class="anchor fw-bolder mb-5" id="striped-rounded-bordered">Data user</h1>
        <button class="ms-auto btn btn-info d-none" data-bs-toggle="modal" data-bs-target="#tambah">Tambah User</button>
      </div>
      <!--end::Heading-->
      <!--begin::Block-->
      <div class="my-5 table-responsive">
        <table id="myTable" class="table table-striped table-hover table-rounded border gs-7">
          <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
              <th style="max-width: 20px">No.</th>
              <th>Username</th>
              <th>Name</th>
              <th>Date created</th>
              <th style="max-width: 100px;">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $u)
            @php
              $date = date_create($u->created_at);
            @endphp
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $u->username }}</td>
              <td>{{ $u->name }}</td>
              <td>{{date_format($date,"M d, Y")}}</td>
              <td>
                <a href="#" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#edit" onclick="edit({{ $u->id }})"><i class="bi bi-pencil-fill"></i></a>
                <a href="#" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#body" onclick="editbody({{ $u->id }})"><i class="fa fa-times"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!--end::Block-->
    </div>
    <!--end::Section-->
  </div>
  <!--end::Card Body-->
</div>

<div class="modal fade" tabindex="-1" id="edit">
  <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="et">Edit User</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </div>
        </div>
        <form class="form" method="post" action="">
          @csrf
          <input type="hidden" id="eui" name="uid">
          <div class="modal-body">
            <div class="row g-9 mb-8">
              <div class="col-12">
                <label class="required fw-bold mb-2">Name</label>
                <input type="text" class="form-control" id="eus" name="user" required>
              </div>
            </div>
            <div class="row g-9 mb-8">
              <div class="col-12">
                <label class="required fw-bold mb-2">Email</label>
                <input type="email" class="form-control" id="eem" name="email" required>
              </div>
            </div>
          </div>
          
          <div class="modal-footer">
            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-info" name="submit" value="update">Save</button>
          </div>
        </form>
      </div>
  </div>
</div>
@endsection

@section('script')
<script>
  function edit(id){
    $.ajax({
      url: "/api/user/"+id,
      type: 'GET',
      dataType: 'json', // added data type
      success: function(response) {
        var mydata = response.data;
        $("#eui").val(id);
        $("#eus").val(mydata.username);
        $("#eem").val(mydata.name);
        $("#et").text("Edit "+mydata.name);
      }
    });
  }
</script>
@endsection