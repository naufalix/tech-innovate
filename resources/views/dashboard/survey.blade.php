@extends('layouts.dashboard')

@section('content') 
<div class="card mb-2 col-12">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div class="mb-2">
      <!--begin::Heading-->
      <div class="col-12 d-flex">
        <h1 class="anchor fw-bolder mb-5" id="striped-rounded-bordered">{{ Auth::user()->name }}</h1>
      </div>
      <!--end::Heading-->
      <!--begin::Block-->
      <div class="row g-9 mb-8">
        <div class="col-12 col-md-3">
          <label class="fw-bold mb-2">Pendidikan</label>
          <p class="fw-bolder">- {{ Auth::user()->education }}</p>
        </div>
        <div class="col-12 col-md-3">
          <label class="fw-bold mb-2">Pengalaman</label>
          <p class="fw-bolder">- {{ Auth::user()->experience }}</p>
        </div>
        <div class="col-12 col-md-3">
          <label class="fw-bold mb-2">Minat</label>
          <p class="fw-bolder">- {{ Auth::user()->passion }}</p>
        </div>
        <div class="col-12 col-md-3">
          <label class="fw-bold mb-2">Keahlian</label>
          <p class="fw-bolder">- {{ Auth::user()->skill }}</p>
        </div>
      </div>
      <hr>
      @php
        $p = Auth::user();
      @endphp
      @if ($p->education&&$p->experience&&$p->passion&&$p->skill)
        <div class="d-flex">
          <button type="button" class="btn btn-primary" onclick="start()">Mulai Asesmen</button>
        </div>
      @else
        <div class="alert alert-dismissible alert-danger d-flex flex-column flex-sm-row p-5 mb-10">
          <div class="d-flex flex-column text-light pe-0 pe-sm-10">
              <h4 class="mb-2 text-danger">Peringatan</h4>
              <span class="text-danger">Anda tidak bisa melakukan asesmen sebelum melengkapi profil</span>
          </div>
          <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
              <i class="mdi mdi-close text-light fs-2"></i>
          </button>
        </div>
        
      @endif
      <!--end::Block-->
    </div>
    <!--end::Section-->
  </div>
  <!--end::Card Body-->
</div>

<div class="card mb-2 col-12" id="card-survey" style="display: none">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div class="mb-2">
      <form method="post" enctype="multipart/form-data">
        @csrf
        <!--begin::Heading-->
        <div class="col-12 d-flex">
          <h2 class="anchor fw-bolder mb-5" id="qname">{{ $questions[0]->name }}</h2>
        </div>
        <!--end::Heading-->
        <textarea class="col-12 d-none" name="questions" id="questions" rows="3"></textarea>
        <!--begin::Block-->
        <div class="mt-5" id="btn-survey" style="display: flex">
          <button type="button" class="btn btn-primary me-2" onclick="next(201)">Ya</button>
          <button type="button" class="btn btn-danger" onclick="next(202)">Tidak</button>
        </div>
        <!--end::Block-->
      </form>
    </div>
    <!--end::Section-->
  </div>
  <!--end::Card Body-->
</div>

<div class="card mb-2">
  <!--begin::Card Body-->
  <div class="card-body fs-6 py-15 px-10 py-lg-15 px-lg-15 text-gray-700">
    <!--begin::Section-->
    <div>
      <!--begin::Heading-->
      <div class="col-12 d-flex">
        <h1 class="anchor fw-bolder mb-5" id="striped-rounded-bordered">Riwayat asesmen</h1>
      </div>
      <!--end::Heading-->
      <!--begin::Block-->
      <div class="my-5 table-responsive">
        <table id="myTable" class="table table-striped table-hover table-rounded border gs-7">
          <thead>
            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
              <th style="max-width: 25px">No.</th>
              <th style="width: 70px">Rekomendasi 1</th>
              <th style="width: 70px">Rekomendasi 2</th>
              <th style="width: 70px">Rekomendasi 3</th>
              <th style="width: 110px">Tanggal asesmen</th>
              <th style="max-width: 100px;">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($surveys as $s)
            @php
              $date = date_create($s->created_at);
              if($jobs->find($s->jobs1)){$j1=$jobs->find($s->jobs1)->name;}else{$j1='-';}
              if($jobs->find($s->jobs2)){$j2=$jobs->find($s->jobs2)->name;}else{$j2='-';}
              if($jobs->find($s->jobs3)){$j3=$jobs->find($s->jobs3)->name;}else{$j3='-';}
            @endphp
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $j1 }}</td>
              <td>{{ $j2 }}</td>
              <td>{{ $j3 }}</td>
              <td>{{date_format($date,"M d, Y")}}</td>
              <td>
                <a href="#" class="btn btn-icon btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#hapus" onclick="hapus({{ $s->id }})"><i class="fa fa-times"></i></a>
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

  function start(){
    $('#card-survey').css("display","block");
    next(101);
    $('#questions').val(101);
  }
  function next(code){
    $("#btn-survey").css("display","none");
    var question = $('#questions').val();
    $('#questions').val(question+","+code)
    
    $.ajax({
      url: "/api/question/"+code,
      type: 'GET',
      dataType: 'json', // added data type
      success: function(response) {
        var mydata = response.data;
        var name = mydata.name;
        var y = mydata.y;
        var n = mydata.n;
        if(code==999){
          $("#btn-survey").html('<button type="submit" class="btn btn-success" name="submit" value="survey">Submit</button>');  
        }else{
          $("#btn-survey").html('<button type="button" class="btn btn-primary me-2" onclick="next('+y+')">Ya</button><button type="button" class="btn btn-danger" onclick="next('+n+')">Tidak</button>');
        }
        $("#qname").text(mydata.name);
        $("#btn-survey").css("display","flex");
      }
    });
  }
  
</script>

@endsection