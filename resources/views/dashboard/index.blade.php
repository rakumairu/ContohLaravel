@extends('template.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
             <div class="col-md-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Welcome</h3>
                  </div>
                  <div class="card-body">
                    Welcome {{ Auth::user()->username }}, please use this system Carefully..
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <?php if(Auth::user()->role == 2) {?>
              <div class="col-md-12">
                  <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Loan Transaction</h3>
                        <div class="card-tools">
                          <!-- Buttons, labels, and many other things can be placed here! -->
                          <!-- Here is a label for example -->
                          {{-- <span class="badge badge-primary">Label</span> --}}
                        </div>
                        <!-- /.card-tools -->
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <div class="row">
                          <div id="waiting-box" class="col-lg-3 col-6">
                              <div class="small-box bg-warning">
                                <div class="inner">
                                  <h3 class="num">0</h3>

                                  <p>Ini di role 2</p>
                                </div>
                                <div class="icon">
                                  <i class="fas fa-clock"></i>
                                </div>
                                <a href="#" class="small-box-footer"> <!--<i class="fas fa-arrow-circle-right">--></i></a>
                              </div>
                          </div>
                        </div>
                      </div>
                      <!-- /.card-body -->
                      {{-- <div class="card-footer">
                        The footer of the card
                      </div> --}}
                      <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
              </div>
            <?php }?>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection