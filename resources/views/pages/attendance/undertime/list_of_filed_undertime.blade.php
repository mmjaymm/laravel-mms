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
<!-- ============================================================== -->
            <!-- wrapper  -->
            <!-- ============================================================== -->
            <div class="dashboard-wrapper">
                <div class="container-fluid dashboard-content">
                    <!-- ============================================================== -->
                    <!-- pageheader -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">List of Filed Undertime</h2>
                               
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Attendance</a></li>
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Undertime</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">List of Filed Undertime</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader -->
                    <!-- ============================================================== -->
     {{-- button for filing undertime --}}
    <div class="form-group row text-right">
        <div class="col col-sm-12 col-lg-12">
            <button class="btn btn-space btn-secondary"data-toggle="modal" data-target="#modal_file_undertime">File Undertime</button>
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
                        <table id="tbl_list_of_filed_undertime" class="table table-striped table-bordered second" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>No.</th>
                                    <th>Employee ID</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Last Name</th>
                                    <th>Date</th>
                                    <th>Time out</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_list_of_filed_undertime">
                                
                            </tbody>
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

     {{-- File Undertime Modal --}}

     <div id="modal_file_undertime" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
        
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">File Undertime Form</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
                </div>
                <div class="modal-body">
                    {{-- modal body --}}
                    <div class="form-group">
                            <form class="needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                                            <label for="Select Type">Select Type</label>
                                            <select class="form-control" name="slc_type" id="slc_type" required>
                                                <option value="" selected disabled>-- Choose One --</option>
                                                <option value="HD">Half Day</option>
                                                <option value="UT">Undertime</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                                            <label for="validationCustom04">Date</label>
                                            <input type="date" class="form-control" id="validationCustom04" required> 
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                                            <label for="validationCustom03">Name</label>
                                            <input type="text" class="form-control" id="validationCustom03" placeholder="Name" required>
                                            
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                                            <label for="validationCustom04">Section</label>
                                            <input type="text" class="form-control" id="validationCustom04" placeholder="MIT" required>
                                            
                                        </div>
                            </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                            <label for="validationCustom01">Destination</label>
                                            <input type="text" class="form-control" id="validationCustom01" placeholder="Input Destination"  required>
                                            
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                            <label for="validationCustom02">Purpose/Reason</label>
                                            <input type="text" class="form-control" id="validationCustom02" placeholder="Input Your Purpose/Reason"  required>
                                           
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                                            <label for="validationCustom03">Scheduled Date</label>
                                            <input type="date" class="form-control" id="validationCustom03" placeholder="City" required>
                                            
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
                                            <label for="validationCustom04">Scheduled Time</label>
                                            <input type="time" class="form-control" id="validationCustom04" placeholder="State" required>
                                           
                                        </div>
                                        
                                        
                                    </div>
                                </form>     
                                
                    {{-- end modal body --}}
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn_save_filed_late" onclick="UNDERTIME.save_file_undertime()">Save</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        
            </div>
        </div>
    
        {{-- end of file undertime modal --}}
@endsection



@section('custom_scripts')
    <script src="{{asset('scripts/attendance/undertime.js') }}"></script>
@endsection