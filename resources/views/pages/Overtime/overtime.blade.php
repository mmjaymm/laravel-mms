@extends('template')

@section('custom_css')
    <link href="{{ asset('../node_modules/gijgo/css/gijgo.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('custom_scripts')
    <script src="{{ asset('../node_modules/gijgo/js/gijgo.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        const _TOKEN = "{{ csrf_token() }}";

        $(document).ready(function ()
        {
            $('#txt_date_from').datepicker({ format: 'yyyy-mm-dd' });
            $('#txt_date_to').datepicker({ format: 'yyyy-mm-dd' });

            OVERTIME.get_data();
        });
    </script>
    <script src="js/overtime.js"></script>
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
                        <h2 class="pageheader-title">Dashboard</h2>
                        <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                        <div class="page-breadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Pages</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end pageheader -->
            <!-- ============================================================== -->
        </div>
        <div class="container-fluid">
            <div class="card">
                <h4 class="card-header bg-primary text-white">OVERTIME</h4>
                <div class="card-body">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-4">
                                        <div class="form-group">
                                            Date From : 
                                            <input class="form-control" value="{{ date('Y-m-01') }}" id="txt_date_from" type="text">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-4">
                                        <div class="form-group">
                                            Date To : 
                                            <input class="form-control" value="{{ date('Y-m-15') }}" id="txt_date_to" type="text">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-4">
                                        <button class="btn btn-block btn-success"><i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-text">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <table id="tbl_overtime" class="compact table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            @if (Auth::user()->roles->level === "ADMIN")
                                            <th>Name</th>
                                            @endif
                                            <th>Type</th>
                                            <th>Datetime IN</th>
                                            <th>Datetime OUT</th>
                                            <th>Reason</th>
                                            <th>Filling Type</th>
                                            <th>Status</th>
                                            <th>Reviewer 1</th>
                                            <th>Reviewer 2</th>
                                            <th>Reviewer 3</th>
                                            <th>Reviewer 4</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
@endsection