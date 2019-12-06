@extends('template')

@section('custom_css')
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link href="vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="libs/css/style.css">
    <link rel="stylesheet" href="vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" type="text/css" href="vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="vendor/datatables/css/buttons.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="vendor/datatables/css/select.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="vendor/datatables/css/fixedHeader.bootstrap4.css">
@endsection

@section('content_page')
<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">List of Filed Failure LogIN/Out</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Attendance</a></li>
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Failure</a></li>
                                <li class="breadcrumb-item active" aria-current="page">List of Filed Failure LogIN/Out</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
        <div class="form-group row text-right">
            <div class="col col-sm-12 col-lg-12">
                <button class="btn btn-space btn-secondary"data-toggle="modal" data-target="#modal_file_failure">File Failure LogIn/Out</button>
            </div>
        </div>
        <div class="row">
            <!-- ============================================================== -->
            <!-- data table  -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    {{-- <div class="card-header">
                        <h5 class="mb-0">Data Tables - Print, Excel, CSV, PDF Buttons</h5>
                        
                    </div> --}}
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tbl_list_of_filed_failure" class="table table-striped table-bordered second" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>No.</th>
                                        <th>Employee ID</th>
                                        <th>DateTime in</th>
                                        <th>DateTime out</th>
                                        <th>Reason</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_list_of_filed_failure"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end data table  -->
            <!-- ============================================================== -->
        </div>
        
    </div>

    {{-- file late modal --}}

    <div id="modal_file_failure" class="modal fade" role="dialog">
        <div class="modal-dialog">
              
                <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">File Failure Form</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Failure DateTime in">DateTime In</label>
                            <input class="form-control form-control-lg" id="txt_failure_datetime_in" type="time" placeholder="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="Late Date">DateTime Out</label>
                            <input class="form-control form-control-lg" id="txt_failure_datetime_out" type="date" placeholder="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="Late Date">Reason</label>
                            <input class="form-control form-control-lg" id="txt_failure_reason" type="text" placeholder="" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn_save_filed_failure" onclick="LATE.save_file_failure();">Save</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
              
        </div>
    </div>
    {{-- end of file late modal --}}

    {{-- edit late modal --}}

        <div id="modal_edit_late" class="modal fade" role="dialog">
            <div class="modal-dialog">
              
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">File Late Form</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="Late ime in">Time In</label>
                                <input class="form-control form-control-lg" id="txt_edit_late_time_in" type="time" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="Late Date">Date</label>
                                <input class="form-control form-control-lg" id="txt_edit_late_date" type="date" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="Late Date">Reason</label>
                                <input class="form-control form-control-lg" id="txt_edit_late_reason" type="text" placeholder="" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btn_save_edit_filed_late" onclick="LATE.save_edit_late();">Save</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
              
            </div>
        </div>
              {{-- end of edit late modal --}}
@endsection

@section('custom_scripts')
    <script src="{{asset('scripts/attendance/failure.js') }}"></script>
@endsection

