
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

            }
        });
    };

    return _overtime;
})();