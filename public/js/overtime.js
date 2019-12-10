
const OVERTIME = (() =>
{
    let this_overtime = {};

    this_overtime.tbl_init = () =>
    {
        return $('#tbl_overtime').DataTable({
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
    };

    this_overtime.get_data = () => 
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

                if (response.level === "ADMIN")
                {
                    _display_overall_summary(response.data);
                }
                else
                {
                    _display_user_summary(response.data);
                }

                $.each(response.data, function ()
                {
                    let name = "";

                    if (response.level === "ADMIN")
                    {
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
                        <td>${_convert_ot_status(this.ot_status)}</td>
                        <td nowrap>${this.reviewer_1}</td>
                        <td nowrap>${this.reviewer_2}</td>
                        <td nowrap>${this.reviewer_3}</td>
                        <td nowrap>${this.reviewer_4}</td>
                        <td nowrap>${this.remarks}</td>
                    </tr>`;
                });

                if ($.fn.DataTable.isDataTable('#tbl_overtime'))
                {
                    $('#tbl_overtime').DataTable().destroy();
                }

                $("#tbl_overtime tbody").html(tr_body);
                OVERTIME.tbl_init();
            }
        });
    };

    this_overtime.get_equivalent_ot_hours = (ot_hours) =>
    {
        switch (ot_hours)
        {
            case '17:10':
                return 1.5;
                break;

            case '22:50':
                return 3;
                break;

            case '16:30':
                return 8;
                break;

            default:
                return null;
                break;
        }
    };

    _display_overall_summary = (data) =>
    {
        var return_data = {};
        var tr_body = "";

        $.each(data, function ()
        {
            let user_id = this.users_id;
            let found = return_data.hasOwnProperty(`it_${user_id}`);
            let ot_hours = moment(this.datetime_out).format("HH:mm");
            let duration_hours = OVERTIME.get_equivalent_ot_hours(ot_hours);

            if (!found)
            {
                return_data[`it_${user_id}`] = {
                    user_id: this.users_id,
                    name: `${this.last_name}, ${this.first_name}`,
                    total_hours: duration_hours
                };
            }
            else
            {
                return_data[`it_${user_id}`].total_hours += duration_hours;
            }
        });

        $.each(return_data, function ()
        {
            tr_body += `<tr>
                        <td>${this.name}</td>
                        <td class="text-center">${this.total_hours}</td>
                        </tr>`;
        });

        $("#tbl_overtime_summary tbody").html(tr_body);
    };

    _display_user_summary = (data) =>
    {
        let duration_hours = 0;

        $.each(data, function ()
        {
            let ot_hours = moment(this.datetime_out).format("HH:mm");
            duration_hours += OVERTIME.get_equivalent_ot_hours(ot_hours);
        });

        $("#h1_total_overtime_hours").html(`${duration_hours} hours`);
    };

    _convert_ot_status = (ot_status) => 
    {
        switch (ot_status)
        {
            case 1:
                return "Approved";
                break;

            case 1:
                return "Declined";
                break;

            case 1:
                return "Cancelled";
                break;

            default:
                return "Pending";
                break;
        }
    };

    return this_overtime;
})();