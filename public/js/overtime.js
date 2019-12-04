
const OVERTIME = (function ()
{
    let _overtime = {};

    _overtime.get_data = () => 
    {
        var txt_date_from = $("#txt_date_from").val();
        var txt_date_to = $("#txt_date_to").val();

        $.ajax({
            type: "POST",
            url: `${BASE_URL}/overtime/retrieve`,
            data: {
                _token: _TOKEN,
                txt_date_from: txt_date_from,
                txt_date_to: txt_date_to,
            },
            dataType: "json",
            success: response =>
            {
                var tr_body = "";

                $.each(response.data, function ()
                {
                    let name = "";

                    if (response.level === "ADMIN") {
                        name = `<td nowrap>${this.last_name}, ${this.first_name}</td>`;
                    }

                    tr_body += `<tr>
                        <td></td>
                        ${name}
                        <td>${this.overtime_type}</td>
                        <td nowrap>${this.datetime_in}</td>
                        <td nowrap>${this.datetime_out}</td>
                        <td nowrap>${this.reason}</td>
                        <td>${this.filling_type}</td>
                        <td>${this.ot_status}</td>
                        <td nowrap>${this.reviewer_1}</td>
                        <td nowrap>${this.reviewer_2}</td>
                        <td nowrap>${this.reviewer_3}</td>
                        <td nowrap>${this.reviewer_4}</td>
                        <td nowrap>${this.remarks}</td>
                    </tr>`;
                });

                $("#tbl_overtime tbody").html(tr_body);
                $('#tbl_overtime').DataTable({
                    'scrollY': true,
                    'scrollX': true,
                    "columnDefs": // replace all null to dash(-)
                        [
                            {
                                /**
                                 * @param data refers to the data of the cell
                                 * @param type refers data requested - this will be 'filter', 'display', 'type' or 'sort'
                                 * @param row referes to complete row data
                                 * @returns {string}
                                 */
                                "mRender": function (data, type, row)
                                {
                                    return (data != "null") ? data : "-";
                                },
                                "targets": "_all"
                            }
                        ]
                });
            }
        });
    };

    return _overtime;
})();