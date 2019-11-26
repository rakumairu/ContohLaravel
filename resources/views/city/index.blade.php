@extends('template.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">City Options</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">City Options</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              City Options Settings</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="col-sm-4 form-group">
                <button type="button" data-toggle="modal" data-target="#modal-add" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add</button>
                {{-- Untuk reload tabel --}}
                <button type="button" onclick="reload_table()" class="btn btn-default btn-sm"><i class="fas fa-sync"></i> Reload</button>
              </div>
              <table id="table_format" class="table table-bordered table-striped table-datas" width="100%">
                <thead>
                  <tr>
                    <th width="">Province</th>
                    <th width="">Code</th>
                    <th width="">Description</th>
                    <th width="20%">Options</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  {{-- Modal --}}
  {{-- modal-add --}}
  <div class="modal fade" id="modal-add">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            <img class="img-circle" width="40" src="{{ asset('/img/ikiasset/i-logo.png') }}" alt=""> 
            Add City Options
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" id="form_add">
            {{-- Jadi di laravel ada namanya csrf token, itu dipake untuk kemanan method yang pake POST --}}
            {{ csrf_field() }}
            <div class="card-body">
              <div class="form-group">
                <label for="provinceId">Province</label>
                <select class="form-control" id="provinceDropDown" name="provinceId" required>
                  {{-- Fill with Ajax --}}
                  <option hidden disabled selected value>-- Choose Province --</option>
                </select>
                <label for="code">Code</label>
                <input type="text" name="code" class="form-control form-control-sm"  id="code" maxlength="32">
                <label for="description">Description</label>
                <input type="text" name="description" class="form-control form-control-sm"  id="description" maxlength="50">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary btn-sm" onclick="save_default()">Simpan</button>
        </div>
      </div>
    </div>
  </div>
  
  {{-- modal-edit --}}
  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            <img class="img-circle" width="40" src="{{ asset('/img/ikiasset/i-logo.png') }}" alt=""> 
            Edit City
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" id="form_update">
            {{ csrf_field() }}
            <div class="card-body">
              <div class="form-group">
                <label for="edit_provinceDropDown">Province</label>
                <select class="form-control" id="edit_provinceDropDown" name="provinceId" required>
                  {{-- Fill with Ajax --}}
                </select>
                <label for="edit_description">Description</label>
                <input type="hidden" name="code" id="edit_code">
                <input type="text" name="description" id="edit_description" class="form-control form-control-sm" placeholder="Description" maxlength="50">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" onclick="update_default()">Save</button>
        </div>
      </div>
    </div>
  </div>
  
  {{-- modal-delete --}}
  <div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            <img class="img-circle" width="40" src="{{ asset('/img/ikiasset/i-logo.png') }}" alt=""> 
            Hapus City
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary btn-sm" onclick="delete_default()">Hapus</button>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    // Id tabel
    var table_format;

    $(document).ready(function() {
      // Inisialisasi tabel
      table_format = $('#table_format').DataTable({ 
        
        "processing": true, 
        "serverSide": true,
        "order": [], 
        "scrollX": true,
        
        "ajax": {
          "url": "{{ route('city.list') }}",
          "type": "POST",
          "data": {
            "_token": "{{ csrf_token() }}",
          }
        },
        
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ -1 ], //first column / numbering column
          "orderable": false, //set not orderable
        },
        {
          "className": "break-word",
          "targets": "_all"
        }
        ],
        
      });

      // Load province list
      $.ajax({
        type: "POST",
        url: "{{ route('city.province') }}",
        data: {
          _token: "{{ csrf_token() }}",
        },
        success: function(data){
          $.each(data, function(i, d) {
            $('#provinceDropDown').append('<option value=' + d.code + '>' + d.description + '</option>');
            $('#edit_provinceDropDown').append('<option value=' + d.code + '>' + d.description + '</option>');
          });
        }
      });
    });
    
    // Save new data
    function save_default(){
      var check = [];
      check.push($('#provinceDropDown').val())
      $('#modal-add input[type="text"]').each(function() {
        if ($(this).val() == '') {
          check.push(null);
        }else{
          check.push('yes');
        }
      });
      if (check.includes(null) == true) {
        toastr.error('Harap Isi field dengan benar');
      }else{
        $.ajax({
          url: '/city/api_save_city',
          type: 'POST',
          dataType: 'JSON',
          data: $('#form_add').serialize(),
          success: function(d){
            if (d.status == 'true') {
              toastr.success(d.message);
            }else{
              toastr.error(d.message);
            }
            $('#modal-add').modal('hide');
            $('#form_add')[0].reset();
          }
        });
        reload_table();
      }
      
    }
    
    // Fetch existing data to edit
    function edit_default(id){
      $.ajax({
        url: '{{ route("city.get") }}',
        type: 'post',
        dataType: 'json',
        data: {
          code: id,
          _token: "{{ csrf_token() }}",
        },
        success:function(d){
          if (d.status == 'true') {
            $('#edit_code').val(d.datas.code);
            $('#edit_description').val(d.datas.description);
            $('#edit_provinceDropDown').val(d.datas.provinceId);
            $('#modal-edit').modal('show');
          }else{
            alert('fail');
          }
        }
      });
    }
    
    // Update existing data
    function update_default(){
      $.ajax({
        url: '{{ route("city.update") }}',
        type: 'post',
        dataType: 'json',
        data: $('#form_update').serialize(),
        success: function(d){
          if (d.status == 'true'){
            toastr.success(d.message);
          }else{
            toastr.error(d.message);
          }
          $('#modal-edit').modal('hide');
          reload_table();
          $('#form_update')[0].reset();
        }
      });
    }
    
    // Open delete modal
    function show_delete(id, nama){
      $('#modal-delete .modal-body').html('<input id="id_hapus" type="hidden" value="'+id+'"> Apakah Ingin menghapus '+nama+'?');
      $('#modal-delete').modal('show');
    }
    
    // Delete existing data
    function delete_default(){
      $.ajax({
        url: '{{ route("city.delete") }}',
        type: 'post',
        dataType: 'json',
        data: {
          idhapus: $('#id_hapus').val(),
          _token: '{{ csrf_token() }}',
        },
        success: function(d){
          if (d.status == 'true') {
            toastr.success(d.message);
          }else{
            toastr.error(d.message);
          }
          reload_table();
          $('#modal-delete').modal('hide');
        }
      });
    }

    // Reload datatable
    function reload_table(){
      table_format.ajax.reload();
    }
    
  </script>
  @endsection