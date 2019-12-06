$(document).ready(function() {
    LEAVE.load_leave_data();
});

const LEAVE = (() => {

    let this_leave = {};



    this_leave.load_leave_data = () => {


        $.ajax({
            url: 'leave-credits',
            type: 'get',
            data:
            {
                _token: _TOKEN
            },
            success: result => {
                $('#tbl_list_of_filed_leave').DataTable().destroy();
                $('#tbody_list_of_filed_leave').empty();

                var leave = '';


                $.each(result, function() {

                    leave +=
                    `<tr>
                        <td  class="text-nowrap" align="center">
                            <button data-id="btn_edit_leave"  class="btn btn-xs btn-info" title= "Edit Leave" onclick="LEAVE.btn_edit_leave('${this.id}');">EDIT</button> &nbsp <button data-id="btn_edit_leave"  class="btn btn-xs btn-info" title= "Edit Leave" onclick="LEAVE.btn_edit_leave('${this.id}');">DELETE</button>
                        </td>
                        <td align="center">${this.id}</td>
                        <td align="center">${this.employee_number}</td>
                        <td align="center">${this.date_leave}</td>
                        <td align="center">${this.leave_type}</td>
                        <td align="center">${this.reviewed_datetime}</td>
                        <td align="center">${this.remarks}</td>
                        <td align="center">${this.date_filed}</td>
					</tr>`;
                });
                $('#tbody_list_of_filed_leave').html(leave);

                $('#tbl_list_of_filed_leave').DataTable({
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

    this_leave.save_file_leave = () => {
        alert('saved!')

        $.ajax({
            url: 'leaves',
            type: 'post',
            data: '',
            success: data => {

                
                // $('#modal_file_leave').hide();
            
            },
            error: function(data) {
                // console.log(result)
            }

        });

    }

    this_leave.btn_edit_leave = () => {
        alert('EDIT!')     
    $('#modal_edit_leave').modal("show");

    }

    this_leave.save_edit_leave = () => {
        alert('saved edit!')

        $.ajax({
            url: 'leave',
            type: 'post',
            data: '',
            success: data => {

                
                // $('#modal_file_leave').hide();
            
            },
            error: function(data) {
                // console.log(result)
            }

        });

    }



    return this_leave;

})();