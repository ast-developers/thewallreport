$(document).ready(function () {
    App.init();

    var dataTable = $('#user-grid').DataTable({
        "processing": true,
        "serverSide": true,
        "columnDefs": [{
            "targets": 0,
            "orderable": false,
            "searchable": false

        }],
        "ajax": {
            url: userAjaxPaginateUrl, // json datasource
            type: "post",  // method  , by default get
            error: function (data) {  // error handling
                $(".user-grid-error").html("");
                $("#user-grid").append('<tbody class="user-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#user-grid_processing").css("display", "none");

            }
        }
    });

    $("#bulkDelete").on('click', function () { // bulk checked
        var status = this.checked;
        $(".deleteRow").each(function () {
            $(this).prop("checked", status);
        });
    });

    $('#deleteTriger').on("click", function (event) { // triggering delete one by one
        if ($('.deleteRow:checked').length > 0) {  // at-least one checkbox checked
            var ids = [];
            $('.deleteRow').each(function () {
                if ($(this).is(':checked')) {
                    ids.push($(this).val());
                }
            });
            var ids_string = ids.toString();
            // array to string conversion
            $.ajax({
                type: "POST",
                url: userBulkDeleteUrl,
                data: {data_ids: ids_string},
                success: function (result) {
                    dataTable.draw(); // redrawing datatable
                },
                async: false
            });
        }
    });
});