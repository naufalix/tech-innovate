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
        <button class="ms-auto btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">Tambah</button>
      </div>
      <!--end::Heading-->
      <!--begin::Block-->
      <div class="my-5 table-responsive">
        <table id="myTable" class="table table-striped table-hover table-rounded border gs-7">
          <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
              <th style="max-width: 25px">No.</th>
              <th>Username</th>
              <th>Name</th>
              <th>Instant R</th>
              <th>Survey</th>
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
              <td><span class="badge badge-success">{{ count($u->instant) }}</span></td>
              <td><span class="badge badge-primary">{{ count($u->survey) }}</span></td>
              <td>{{date_format($date,"M d, Y")}}</td>
              <td>
                <a href="#" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#edit" onclick="edit({{ $u->id }})"><i class="bi bi-pencil-fill"></i></a>
                <a href="#" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapus" onclick="hapus({{ $u->id }})"><i class="fa fa-times"></i></a>
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

<div class="modal fade" tabindex="-1" id="tambah">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Tambah User</h3>
        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
          <i class="bi bi-x-lg"></i>
        </div>
      </div>
      <form class="form" method="post" action="">
        @csrf
        <div class="modal-body">
          <div class="row g-9 mb-8">
            <div class="col-12">
              <label class="required fw-bold mb-2">Nama</label>
              <input type="text" class="form-control" name="name" required>
            </div>
          </div>
          <div class="row g-9 mb-8">
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Username</label>
              <input type="text" class="form-control" name="username" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Password</label>
              <input type="password" class="form-control" name="password" required>
            </div>
          </div>
          <div class="row g-9 mb-8">
            <div class="col-12 col-md-6">
              <label class="fw-bold mb-2">Pendidikan</label>
              <input type="text" class="form-control" name="education">
            </div>
            <div class="col-12 col-md-6">
              <label class="fw-bold mb-2">Pengalaman</label>
              <input type="text" class="form-control" name="experience">
            </div>
          </div>
          <div class="row g-9 mb-8">
            <div class="col-12 col-md-6">
              <label class="fw-bold mb-2">Bakat</label>
              <input type="text" class="form-control" name="skill">
            </div>
            <div class="col-12 col-md-6">
              <label class="fw-bold mb-2">Minat</label>
              <input type="text" class="form-control" name="passion">
            </div>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" name="submit" value="store">Submit</button>
        </div>
      </form>
    </div>
  </div>
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
        <input type="hidden" class="d-none" id="eid" name="id">
        <div class="modal-body">
          <div class="row g-9 mb-8">
            <div class="col-12">
              <label class="required fw-bold mb-2">Nama</label>
              <input type="text" class="form-control" id="enm" name="name" required>
            </div>
          </div>
          <div class="row g-9 mb-8">
            <div class="col-12 col-md-6">
              <label class="required fw-bold mb-2">Username</label>
              <input type="text" class="form-control" id="eun" name="username" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="fw-bold mb-2">Password</label>
              <input type="password" class="form-control" name="password">
              <span class="text-danger">*Kosongkan jika tidak ingin mengganti password</span>
            </div>
          </div>
          <div class="row g-9 mb-8">
            <div class="col-12 col-md-6">
              <label class="fw-bold mb-2">Pendidikan</label>
              <input type="text" class="form-control" id="eed" name="education">
            </div>
            <div class="col-12 col-md-6">
              <label class="fw-bold mb-2">Pengalaman</label>
              <input type="text" class="form-control" id="eex" name="experience">
            </div>
          </div>
          <div class="row g-9 mb-8">
            <div class="col-12 col-md-6">
              <label class="fw-bold mb-2">Bakat</label>
              <input type="text" class="form-control" id="esk" name="skill">
            </div>
            <div class="col-12 col-md-6">
              <label class="fw-bold mb-2">Minat</label>
              <input type="text" class="form-control" id="eps" name="passion">
            </div>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" name="submit" value="update">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="hapus">
  <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Hapus User</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </div>
        </div>
        <form class="form" method="post" action="">
          @csrf
          <input type="hidden" id="hi" name="id">
          <div class="modal-body">
            <p id="hd">Apakah anda yakin ingin menghapus user ini?</p>
          </div>
          
          <div class="modal-footer">
            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger" name="submit" value="destroy">Hapus</button>
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
        $("#eid").val(id);
        $("#enm").val(mydata.name);
        $("#eun").val(mydata.username);
        $("#eed").val(mydata.education);
        $("#eex").val(mydata.experience);
        $("#esk").val(mydata.skill);
        $("#eps").val(mydata.passion);
        $("#et").text("Edit "+mydata.name);
      }
    });
  }
  function hapus(id){
    $.ajax({
      url: "/api/user/"+id,
      type: 'GET',
      dataType: 'json', // added data type
      success: function(response) {
        var mydata = response.data;
        $("#hi").val(id);
        $("#hd").text('Apakah anda yakin ingin menghapus "'+mydata.name+'"?');
      }
    });
  }
</script>
@endsection