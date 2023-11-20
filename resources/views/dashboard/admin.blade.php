@extends('layouts.dashboard')

@section('content')

<div class="card mb-2">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div>
      <!--begin::Heading-->
      <div class="col-12 d-flex">
        <h1 class="anchor fw-bolder mb-5" id="striped-rounded-bordered">Data Admin</h1>
        <button class="ms-auto btn btn-info" data-bs-toggle="modal" data-bs-target="#tambah">Tambah Admin</button>
      </div>
      <!--end::Heading-->
      <!--begin::Block-->
      <div class="my-5 table-responsive">
        <table id="myTable" class="table table-striped table-hover table-rounded border gs-7">
          <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
              <th style="max-width: 20px">ID</th>
              <th>Name</th>
              <th>Username</th>
              <th>Role</th>
              <th style="max-width: 100px;">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($admins as $a)
            <tr>
              <td>{{ $a->id }}</td>
              <td>{{ $a->name }}</td>
              <td>{{ $a->username }}</td>
              <td>
                <span class="badge badge-info">{{ $a->role }}</span>
              </td>
              <td>
                <a href="#" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#edit" onclick="edit({{ $a->id }})"><i class="bi bi-pencil-fill"></i></a>
                <a href="#" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#body" onclick="editbody({{ $a->id }})"><i class="bi bi-justify-left"></i></a>
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
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Tambah Seleksi</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </div>
        </div>
        <form class="form" method="post" action="">
          @csrf
          <div class="modal-body">
            <div class="row g-9 mb-8">
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Judul seleksi</label>
                <input type="text" class="form-control" name="title" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Penyelenggara</label>
                <input type="text" class="form-control" name="organizer" required>
              </div>
            </div>
            <div class="row g-9 mb-8">
              <div class="col-12 col-md-4">
                <label class="required fw-bold mb-2">Slug/permalink</label>
                <input type="text" class="form-control" name="slug" required>
              </div>
              <div class="col-6 col-md-4">
                <label class="required fw-bold mb-2">Harga</label>
                <div class="input-group">
                  <span class="input-group-text" id="rp1">Rp.</span>
                  <input type="number" class="form-control" name="price" required aria-describedby="rp1">
                </div>
              </div>
              <div class="col-6 col-md-4">
                <label class="required fw-bold mb-2">Test</label>
                <input type="text" class="form-control" name="test" required>
              </div>
            </div>
            <div class="row g-9 mb-8">
              <div class="col-4">
                <label class="required fw-bold mb-2">Dibuka</label>
                <input type="datetime-local" class="form-control" name="open" required>
              </div>
              <div class="col-4">
                <label class="required fw-bold mb-2">Ditutup</label>
                <input type="datetime-local" class="form-control" name="close" required>
              </div>
              <div class="col-4">
                <label class="required fw-bold mb-2">Pengumuman</label>
                <input type="datetime-local" class="form-control" name="result" required>
              </div>
            </div>
            <div class="row g-9 mb-8">
              <div class="col-12">
                <label class="required fw-bold mb-2">URL Detail</label>
                <input type="text" class="form-control" name="urld" required>
              </div>
            </div>
          </div>
          
          <div class="modal-footer">
            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" name="submit" value="store">Submit</button>
          </div>
        </form>
      </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="edit">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="et">Edit Seleksi</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </div>
        </div>
        <form class="form" method="post" action="">
          @csrf
          <input type="hidden" id="eid" name="id">
          <div class="modal-body">
            <div class="row g-9 mb-8">
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Judul seleksi</label>
                <input type="text" class="form-control" id="eti" name="title" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="required fw-bold mb-2">Penyelenggara</label>
                <input type="text" class="form-control" id="eor" name="organizer" required>
              </div>
            </div>
            <div class="row g-9 mb-8">
              <div class="col-12 col-md-4">
                <label class="required fw-bold mb-2">Slug/permalink</label>
                <input type="text" class="form-control" id="esl" name="slug" required>
              </div>
              <div class="col-6 col-md-4">
                <label class="required fw-bold mb-2">Harga</label>
                <div class="input-group">
                  <span class="input-group-text" id="rp1">Rp.</span>
                  <input type="number" class="form-control" id="epr" name="price" required aria-describedby="rp1">
                </div>
              </div>
              <div class="col-6 col-md-4">
                <label class="required fw-bold mb-2">Test</label>
                <input type="text" class="form-control" id="ete" name="test" required>
              </div>
            </div>
            <div class="row g-9 mb-8">
              <div class="col-4">
                <label class="required fw-bold mb-2">Dibuka</label>
                <input type="datetime-local" class="form-control" id="eop" name="open" required>
              </div>
              <div class="col-4">
                <label class="required fw-bold mb-2">Ditutup</label>
                <input type="datetime-local" class="form-control" id="ecl" name="close" required>
              </div>
              <div class="col-4">
                <label class="required fw-bold mb-2">Pengumuman</label>
                <input type="datetime-local" class="form-control" id="ere" name="result" required>
              </div>
            </div>
            <div class="row g-9 mb-8">
              <div class="col-12">
                <label class="required fw-bold mb-2">URL Detail</label>
                <input type="text" class="form-control" id="eur" name="urld" required>
              </div>
            </div>
          </div>
          
          <div class="modal-footer">
            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" name="submit" value="update">Save</button>
          </div>
        </form>
      </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="body">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="bt">Edit Seleksi</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </div>
        </div>
        <form class="form" method="post" action="">
          @csrf
          <input type="hidden" id="bi" name="id">
          <div class="modal-body">
            <div class="row g-9 mb-8">
              <div class="col-12">
                <label class="required fw-bold mb-2">Body</label>
                <textarea class="form-control" name="body" id="bb" rows="18" required></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" name="submit" value="body">Save</button>
          </div>
        </form>
      </div>
  </div>
</div>

<script type="text/javascript">
  function getDate(strdate){
    var dt = new Date(strdate);
    var months = ["01","02","03","04","05","06","07","08","09","10","11","12"];
    var year = dt.getFullYear();
    var month = months[dt.getMonth()];
    var day = ("0"+dt.getDate()).substr(-2, 2);
    var hours = ("0"+dt.getHours()).substr(-2, 2);
    var minute = ("0"+dt.getMinutes()).substr(-2, 2);
    return year+"-"+month+"-"+day+"T"+hours+":"+minute;
  }
  function edit(id){
    $.ajax({
      url: "/api/selection/"+id,
      type: 'GET',
      dataType: 'json', // added data type
      success: function(response) {
        var mydata = response.data;
        $("#eid").val(id);
        $("#eti").val(mydata.title);
        $("#eor").val(mydata.organizer);
        $("#esl").val(mydata.slug);
        $("#epr").val(mydata.price);
        $("#ete").val(mydata.test);
        $("#eop").val(getDate(mydata.open));
        $("#ecl").val(getDate(mydata.close));
        $("#ere").val(getDate(mydata.result));
        $("#eur").val(mydata.urld);
        $("#et").text("Edit "+mydata.title);
      }
    });
  }
  function editbody(id){
    $.ajax({
      url: "/api/selection/"+id,
      type: 'GET',
      dataType: 'json', // added data type
      success: function(response) {
        //alert(JSON.stringify(mydata));
        var mydata = response.data;
        $("#bi").val(id);
        $("#bb").val(mydata.body);
        $("#bt").text("Edit "+mydata.title);
      }
    });
  }
</script>
@endsection