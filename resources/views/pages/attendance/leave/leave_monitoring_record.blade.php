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
                    <h2 class="pageheader-title">List of Filed Leave</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Attendance</a></li>
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Leave</a></li>
                                <li class="breadcrumb-item active" aria-current="page">List of Filed Leave</li>
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
                <button class="btn btn-space btn-secondary"data-toggle="modal" data-target="#modal_file_leave">File Leave</button>
            </div>
        </div>
        <div class="row">
            <!-- ============================================================== -->
            <!-- data table  -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tbl_list_of_filed_leave" class="table table-striped table-bordered second" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>No.</th>
                                        <th>Employee ID</th>
                                        <th>Date Leave</th>
                                        <th>Status</th>
                                        <th>Approve Date/Time</th>
                                        <th>Remarks</th>
                                        <th>Date Filed</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_list_of_filed_leave"></tbody>
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

    {{-- file leave modal --}}

    <div id="modal_file_leave" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
              
                <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">File Leave Form</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {{-- modal body --}}
                    <div class="form-group">
                        <form class="needs-validation" novalidate>
                            <div class="form-row">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                                    <label for="Select Type">Select Type</label>
                                    <select class="form-control" name="slc_type" id="slc_leave_type" required>
                                        <option value="" selected disabled>-- Choose One --</option>
                                        <option value="SL">Sick leave</option>
                                        <option value="VL">Vacation Leave</option>
                                        <option value="ML">Maternal Leave</option>
                                        <option value="PL">Paternal Leave Leave</option>
                                        <option value="MA">Matrimonial Leave</option>
                                        <option value="BL">Birthday Leave</option>
                                        <option value="EL">Emergency Leave</option>
                                        <option value="BV">Bereavement Leave</option>
                                    </select>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 mb-2">
                                    <label for="File Date from">Date From</label>
                                    <input type="date" class="form-control" id="txt_file_date_form" required> 
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 mb-2">
                                    <label for="File Date to">Date To</label>
                                    <input type="date" class="form-control" id="txt_file_date_to" required> 
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <label for="Destination">Reason</label>
                                    <input type="text" class="form-control" id="txt_leave_reason" placeholder="Input Reason"  required>
                                    
                                </div>
                            </div>
                        </form>     
                                
                    {{-- end modal body --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn_save_filed_leave" onclick="LEAVE.save_file_leave();">Save</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
              
        </div>
    </div>
    {{-- end of file leave modal --}}

    {{-- edit leave modal --}}

        <div id="modal_edit_leave" class="modal fade" role="dialog">
            <div class="modal-dialog">
              
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">File Leave Form</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="Leave ime in">Time In</label>
                                <input class="form-control form-control-lg" id="txt_edit_leave_time_in" type="time" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="Leave Date">Date</label>
                                <input class="form-control form-control-lg" id="txt_edit_leave_date" type="date" placeholder="" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="Leave Date">Reason</label>
                                <input class="form-control form-control-lg" id="txt_edit_leave_reason" type="date" placeholder="" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btn_save_edit_filed_leave" onclick="LEAVE.save_edit_leave();">Save</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
              
            </div>
        </div>
              {{-- end of edit leave modal --}}
@endsection

@section('custom_scripts')
    <script src="{{asset('scripts/attendance/leave.js') }}"></script>
@endsection

