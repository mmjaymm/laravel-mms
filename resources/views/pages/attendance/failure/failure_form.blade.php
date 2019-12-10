@extends('template')
@section('custom_css')
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link href="vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="libs/css/style.css">
    <link rel="stylesheet" href="vendor/fonts/fontawesome/css/fontawesome-all.css">
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
                                <h2 class="pageheader-title">Undertime Form</h2>
                               
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Attendance</a></li>
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Failure</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Failure Form</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader -->
                    <!-- ============================================================== -->
                    
                    <div class="row">
                            <!-- ============================================================== -->
                            <!-- validation form -->
                            <!-- ============================================================== -->
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Failure to Log-In and Log-Out Form</h5>
                                    <div class="card-body">
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
                                                    <input type="date" class="form-control" id="validationCustom04" placeholder="" required>
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
                                            <div class="form-row">
                                                {{-- <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                                    <label for="validationCustom03">Guard on Duty</label>
                                                    <input type="text" class="form-control" id="validationCustom03" placeholder="City" required>
                                                    
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                                    <label for="validationCustom04">Actual Departure</label>
                                                    <input type="text" class="form-control" id="validationCustom04" placeholder="State" required>
                                                   
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2">
                                                    <label for="validationCustom05">Actual Arrival</label>
                                                    <input type="text" class="form-control" id="validationCustom05" placeholder="Zip" required>
                                                   
                                                </div> --}}
                                                
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                    <button class="btn btn-secondary" type="submit" id="btn_submit_undertime">Submit form</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end validation form -->
                            <!-- ============================================================== -->
                        </div>
@endsection

@section('custom_scripts')
    <script src="vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="vendor/parsley/parsley.js"></script>
@endsection