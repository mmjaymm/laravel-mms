$(document).ready(function() {
    UNDERTIME.load_undertime();
});

const UNDERTIME = (() => {

    let this_undertime = {};



    this_undertime.load_undertime = () => {
        // alert(1)

        $.ajax({
            url: 'undertimes/all',
            type: 'post',
            data:
            {
                _token: _TOKEN
            },
            success: result => {
                $('#tbl_list_of_filed_undertime').DataTable().destroy();
                $('#tbody_list_of_filed_undertime').empty();

                var undertime = '';


                $.each(result, function() {

                    undertime +=
                    `<tr>
                        <td align="center"><button data-id="btn_edit_undertime"  class="btn btn-sm btn-info" title= "Edit Undertime" onclick="UNDERTIME.btn_edit_undertime('${this.id}');" method="POST"EDIT</button> &nbsp <button data-id="btn_edit_undertime"  class="btn btn-sm btn-info" title= "Edit Undertime" onclick="UNDERTIME.btn_edit_undertime('${this.id}');" method="POST"DELETE</button></td>
                        <td align="center">${this.id}</td>
                        <td align="center">${this.employee_number}</td>
                        <td align="center">${this.first_name}</td>
                        <td align="center">${this.middle_name}</td>
                        <td align="center">${this.last_name}</td>
                        <td align="center">${this.date}</td>
                        <td align="center">${this.date_time_out}</td>
                        <td align="center">${this.reason}</td>
					</tr>`;
                });
                $('#tbody_list_of_filed_undertime').html(undertime);

                $('#tbl_list_of_filed_undertime').DataTable({
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

    this_undertime.save_file_undertime = () => {
        alert('saved!')

        $.ajax({
            url: 'undertime',
            type: 'post',
            data: '',
            success: data => {

                
                // $('#modal_file_undertime').hide();
            
            },
            error: function(data) {
                // console.log(result)
            }

        });

    }

    this_undertime.btn_edit_undertime = () => {
        alert('EDIT!')     
    $('#modal_edit_undertime').modal("show");

    }

    this_undertime.save_edit_undertime = () => {
        alert('saved edit!')

        $.ajax({
            url: 'undertime',
            type: 'post',
            data: '',
            success: data => {

                
                // $('#modal_file_undertime').hide();
            
            },
            error: function(data) {
                // console.log(result)
            }

        });

    }



    return this_undertime;

})();