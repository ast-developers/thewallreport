var Category = function () {
    var dataTable;
    var initCategoryDataTable = function () {
        dataTable = $('#category-grid').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [[ 1, "asc" ]],
            "bPaginate": false,
            "columnDefs": [{
                "targets": 0,
                "orderable": false,
                "searchable": false

            }],
            "ajax": {
                url: categoryAjaxPaginateUrl, // json datasource
                type: "post",  // method  , by default get
                error: function (data) {  // error handling
                    $(".category-grid-error").html("");
                    $("#category-grid").append('<tbody class="user-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#category-grid_processing").css("display", "none");

                }
            }
        });
    };

    var deleteCategory = function () {
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
                    url: categoryBulkDeleteUrl,
                    data: {data_ids: ids_string},
                    success: function (result) {
                        dataTable.draw(); // redrawing datatable
                        $('.header-title').after('<div class="alert alert-success">'+
                            '<strong>'+'Categories Deleted successfully.'+'</strong></div>');
                    },
                    async: false
                });
            }
        });
    };
    var validateCategory = function () {
        $('.category-form').validate({
            errorElement: 'label', //default input error message container
            errorClass: 'help-inline', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                name: {
                    required: true
                },
                slug:{
                    required: true
                },
            },

            messages: {
                name: {
                    required: "Category name is required."
                },
                slug: {
                    required: "Slug is required."
                },
            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                $('.alert-error', $('.category-form')).show();
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.control-group').addClass('error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.control-group').removeClass('error');
                label.remove();
            },

            errorPlacement: function (error, element) {
                error.addClass('help-small no-left-padding').insertAfter(element.closest('.input-icon'));
            }
        });
    };

    return {

        //function to initiate User Listing Page
        initList: function () {
            App.init();
            initCategoryDataTable();
            deleteCategory();
            validateCategory();
        },

    };
}();