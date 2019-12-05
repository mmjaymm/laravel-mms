$(document).ready(function() {
    LATE.load_late_data();
});

const LATE = (() => {

    let this_late = {};



    this_late.load_late_data = () => {
        // alert(1)

        $.ajax({
            url: 'lates/all',
            type: 'post',
            data:
            {
                _token: _TOKEN
            },
            success: result => {
                $('#tbl_list_of_filed_late').DataTable().destroy();
                $('#tbody_list_of_filed_late').empty();

                var late = '';


                $.each(result, function() {

                    late +=
                    `<tr>
                        <td align="center"><button data-id="btn_edit_late"  class="btn btn-sm btn-success" title= "Edit Late" onclick="LATE.btn_edit_late('${this.id}','${this.datetime_in}', '${this.reason}', '${this.date_filed}');" method="POST"><i class="fas fa-edit"></i></button> <button data-id="btn_edit_late"  class="btn btn-sm btn-danger" title= "Delete Late" onclick="LATE.btn_delete_filed_late('${this.id}');" method="POST"><i class="far fa-trash-alt"></i> </button></td>
                        <td align="center">${this.id}</td>
                        <td align="center">${this.employee_number}</td>
                        <td align="center">${this.datetime_in}</td>
                        <td align="center">${this.reason}</td>
                        <td align="center">${this.date_filed}</td>
					</tr>`;
                });
                $('#tbody_list_of_filed_late').html(late);

                $('#tbl_list_of_filed_late').DataTable({
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

    this_late.save_file_late = () => {
        alert('saved!')

        $.ajax({
            url: 'lates',
            type: 'post',
            data: '',
            success: data => {

                
                // $('#modal_file_late').hide();
            
            },
            error: function(data) {
                // console.log(result)
            }

        });

    }

    this_late.btn_edit_late = () => {
        alert('EDIT!')     
    $('#modal_edit_late').modal("show");

    }

    this_late.save_edit_late = () => {
        alert('saved edit!')

        $.ajax({
            url: 'late',
            type: 'post',
            data: '',
            success: data => {

                
                // $('#modal_file_late').hide();
            
            },
            error: function(data) {
                // console.log(result)
            }

        });

    }

    this_late.btn_delete_filed_late = () => {
        alert('Deleted!')

        $.ajax({
            url: 'late',
            type: 'post',
            data: '',
            success: data => {

                
                // $('#modal_file_late').hide();
            
            },
            error: function(data) {
                // console.log(result)
            }

        });
    }

    



    return this_late;

})();