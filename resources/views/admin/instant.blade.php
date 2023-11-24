@extends('layouts.admin')

@section('content') 

<div class="card mb-2">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div>
      <!--begin::Heading-->
      <div class="col-12 d-flex">
        <h1 class="anchor fw-bolder mb-5" id="striped-rounded-bordered">Data rekomendasi</h1>
        <button class="ms-auto btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#tambah">Prompt</button>
      </div>
      <!--end::Heading-->
      <!--begin::Block-->
      <div class="my-5 table-responsive">
        <table id="myTable" class="table table-striped table-hover table-rounded border gs-7" style="min-width: 1000px">
          <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
              <th style="width: 25px">No.</th>
              <th style="width: 250px">Nama</th>
              <th>Deskripsi</th>
              <th style="min-width: 70px">Jobs 1</th>
              <th style="min-width: 70px">Jobs 2</th>
              <th style="min-width: 70px">Jobs 3</th>
              <th style="width: 100px">Date created</th>
              <th style="width: 50px;">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($instants as $i)
            @php
              $date = date_create($i->created_at);
              if($jobs->find($i->jobs1)){$j1=$jobs->find($i->jobs1)->name;}else{$j1='-';}
              if($jobs->find($i->jobs2)){$j2=$jobs->find($i->jobs2)->name;}else{$j2='-';}
              if($jobs->find($i->jobs3)){$j3=$jobs->find($i->jobs3)->name;}else{$j3='-';}
            @endphp
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $i->user->name }}</td>
              <td>{{ $i->prompt }}</td>
              <td>{{ $j1 }}</td>
              <td>{{ $j2 }}</td>
              <td>{{ $j3 }}</td>
              <td>{{date_format($date,"M d, Y")}}</td>
              <td>
                <a href="#" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapus" onclick="hapus({{ $i->id }})"><i class="fa fa-times"></i></a>
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

<div class="modal fade" tabindex="-1" id="hapus">
  <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Hapus Rekomendasi</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="bi bi-x-lg"></i>
          </div>
        </div>
        <form class="form" method="post" action="">
          @csrf
          <input type="hidden" id="hi" name="id">
          <div class="modal-body">
            <p id="hd">Apakah anda yakin ingin menghapus hasil rekomendasi ini?</p>
          </div>
          
          <div class="modal-footer">
            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger" name="submit" value="destroy">Hapus</button>
          </div>
        </form>
      </div>
  </div>
</div>

<script>
  function hapus(id){
    $("#hi").val(id);
  }
</script>

@endsection