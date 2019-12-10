let failure_id = "";

$(document).ready(function() {
    FAILURE.load_failure_data();
});


var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();

today =  yyyy + '-' + mm + '-' + dd;

const FAILURE = (() => {

    let this_failure = {};



    this_failure.load_failure_data = () => {
        // alert(1)
        $.ajax({
            url: `${BASE_URL}/failures/all`,
            type: 'get',
            data:
            {
                _token: _TOKEN
            },
            dataType: "json",
            success: response =>
            {
                var tr_body = "";

                $.each(response.data, function (i, column)
                {
                    let name = "";
                    let button = "";

                    if (response.level === "ADMIN") {
                        name = `<td nowrap>${this.last_name}, ${this.first_name}</td>`;
                    }

                    if (column.date_filed === today) 
                    {
                        
                        button = `<td align="center"><button data-id="btn_edit_failure"  class="btn btn-sm btn-success" title= "Edit Failure" onclick="FAILURE.btn_edit_failure('${this.id}','${this.datetime_in}','${this.datetime_out}', '${this.reason}');" method="PATCH"><i class="fas fa-edit"></i></button> <button data-id="btn_edit_failure"  class="btn btn-sm btn-danger" title= "Delete Late" onclick="FAILURE.btn_delete_filed_failure('${this.id}');" method="DELETE"><i class="far fa-trash-alt"></i> </button></td>`;

                    }
                    else
                    {

                        button = `<td></td>`;
                       
                    }

                    tr_body += `<tr>
                        ${button}
                        ${name}
                        <td nowrap>${this.datetime_in}</td>
                        <td nowrap>${this.datetime_out}</td>
                        <td nowrap>${this.reason}</td>
                        <td nowrap>${this.date_filed}</td>
                    </tr>`;
                });

                if ($.fn.DataTable.isDataTable('#tbl_list_of_filed_failure')) {
                    $('#tbl_list_of_filed_failure').DataTable().destroy();
                }

                $("#tbl_list_of_filed_failure tbody").html(tr_body);
                $('#tbl_list_of_filed_failure').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": true,
                    
                });
            },
            error: function(result) {
                // console.log(result)
            }

        });

    }

    this_failure.save_file_failure = () => {

        $.ajax({
            url: `${BASE_URL}/failures`,
            type: 'post',
            data: 
            {
                _token:_TOKEN,
                datetime_in     :   $('#txt_failure_datetime_in').val(),
                datetime_out    :   $('#txt_failure_datetime_out').val(),
                reason          :   $('#txt_failure_reason').val()

            },
            success: data => {

                $('#modal_file_failure').hide();
            
            },
            error: function(data) {
                console.log(result)
            }

        });

    }

    this_failure.btn_edit_failure = (id,datetime_in,datetime_out,reason) => {  

        $('#modal_edit_failure').modal("show");

        failure_id       = id,
        txt_datetime_in  = $('#txt_edit_failure_datetime_in').val(datetime_in),
        txt_datetime_out = $('#txt_edit_failure_datetime_out').val(datetime_out),
        txt_reason       = $('#txt_edit_failure_reason').val(reason)
    }

    this_failure.save_edit_late = () => {
        alert('saved edit!')

        $.ajax({
            url: `${BASE_URL}/failures/${failure_id}`,
            type: 'post',
            data: 
            {

                _token          :   _TOKEN,
                _method          :   'patch',
                datetime_in     :   $('#txt_edit_failure_datetime_in').val(),
                datetime_out    :   $('#txt_edit_failure_datetime_out').val(),
                reason          :   $('#txt_edit_failure_reason').val()


            },
            success: data => {

                $('#modal_edit_failure').modal("show");
            
            },
            error: function(data) {
                console.log(result)
            }

        });

    }

    this_failure.btn_delete_filed_failure = (id) => {
       
        if(confirm("Are you sure want to remove?"))
        {

            $.ajax({
                url: `${BASE_URL}/failures/${id}`,
                type: 'post',
                data: 
                {
                    _token      : _TOKEN,
                    _method     : 'delete'
                },
                success: data => {
    
                    
                    // $('#modal_file_late').hide();
                
                },
                error: function(data) {
                    // console.log(result)
                }
    
            });

        }

    }

    

    return this_failure;

})();