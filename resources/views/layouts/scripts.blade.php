 <!-- Optional JavaScript -->
 <script src="vendor/jquery/jquery-3.3.1.min.js"></script>
 <script src="vendor/bootstrap/js/bootstrap.bundle.js"></script>
 <script src="vendor/slimscroll/jquery.slimscroll.js"></script>
 <script src="vendor/multi-select/js/jquery.multi-select.js"></script>
 <script src="libs/js/main-js.js"></script>
 <script src="../node_modules/datatables.net/js/jquery.dataTables.js"></script>
 <script src="vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
 <script src="../node_modules/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
 <script src="vendor/datatables/js/buttons.bootstrap4.min.js"></script>
 <script src="vendor/datatables/js/data-table.js"></script>
 {{-- <script src="../node_modules/jszip/dist/jszip.min.js"></script> --}}
 {{-- <script src="../node_modules/pdfmake/build/pdfmake.min.js"></script> --}}
 {{-- <script src="../node_modules/pdfmake/build/vfs_fonts.js"></script> --}}
 <script src="../node_modules/datatables.net-buttons/js/buttons.html5.min.js"></script>
 <script src="../node_modules/datatables.net-buttons/js/buttons.print.min.js"></script>
 <script src="../node_modules/datatables.net-buttons/js/buttons.colVis.min.js"></script>
 {{-- <script src="https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js"></script> --}}
 {{-- <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script> --}}
 {{-- <script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script> --}}

      
<script src="../node_modules/moment/min/moment.min.js"></script>
<script src="../node_modules/bootstrap4-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script>
    const _TOKEN = $('#csrf-token').attr('content');
    const BASE_URL = "{{ URL::to('/') }}";

    $('.datetimepicker').datetimepicker({
    // Formats
    format: 'YYYY/MM/DD hh:mm:ss',

    icons: {
        time: 'fas fa-clock-o',
        date: 'fa fa-calendar',
        up: 'fa fa-chevron-up',
        down: 'fa fa-chevron-down',
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-check',
        clear: 'fa fa-trash',
        close: 'fa fa-times'
    }
    });
</script>