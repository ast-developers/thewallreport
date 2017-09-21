var Menu = function () {
    var dataTable;
    var initMenuDataTable = function () {
        dataTable = $('#menu-grid').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [[1, "asc"]],
            "bPaginate": false,
            "columnDefs": [{
                "targets": 0,
                "orderable": false,
                "searchable": false

            }],
            "ajax": {
                url: menuAjaxPaginateUrl, // json datasource
                type: "post",  // method  , by default get
                error: function (data) {  // error handling
                    $(".user-grid-error").html("");
                    $("#user-grid").append('<tbody class="user-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#user-grid_processing").css("display", "none");

                }
            }
        });
    };

    var deleteMenu = function () {
        $("#bulkDelete").on('click', function () { // bulk checked
            var status = this.checked;
            $(".deleteRow").each(function () {
                $(this).prop("checked", status);
            });
            if ($("#bulkDelete").is(':checked')) {
                $("#delete-btn").removeClass('hidden');
            } else {
                $("#delete-btn").addClass('hidden')
            }
        });
        $(document).on('click', '.deleteRow', function (event) {
            $("#delete-btn").addClass('hidden')
            var $checked = false;

            $.each($(".deleteRow"), function (index, value) {
                if ($(this).is(':checked')) {
                    $checked = true;
                    $("#delete-btn").addClass('hidden')
                }
            });

            if ($checked) {
                $("#delete-btn").removeClass('hidden');
            } else {
                $('#bulkDelete').prop("checked", false);
            }

        });

        $('#deleteMenus').on("click", function (event) { // triggering delete one by one
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
                    url: menuBulkDeleteUrl,
                    data: {data_ids: ids_string},
                    success: function (result) {
                        dataTable.draw(); // redrawing datatable
                        $('.header-title').after('<div class="alert alert-success">' +
                            '<strong>' + 'Menus deleted successfully.' + '</strong></div>');
                    },
                    async: false
                });
            }
        });
    };

    var validateMenu = function () {
        $('.menu-form').validate({
            errorElement: 'label', //default input error message container
            errorClass: 'help-inline', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                name: {
                    required: true
                },
            },

            messages: {
                name: {
                    required: "Menu name is required."
                },
            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                $('.alert-error', $('.login-form')).show();
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
                console.log(element);
                error.addClass('help-small no-left-padding').insertAfter(element.closest('.validation'));
            }
        });
    };
    var manageDropdown = function () {
        $("#post-dropdown").toggleClass("hidden", $("#menu-type").val() != 1);
        $("#page-dropdown").toggleClass("hidden", $("#menu-type").val() != 2);
        $("#external-url-textbox").toggleClass("hidden", $("#menu-type").val() != 3);
        $("#menu-type").on('click', function () {
            $("#post-dropdown").toggleClass("hidden", $(this).val() != 1);
            $("#page-dropdown").toggleClass("hidden", $(this).val() != 2);
            $("#external-url-textbox").toggleClass("hidden", $(this).val() != 3);
        });
    }

    return {

        //function to initiate User Listing Page
        initList: function () {
            App.init();
            initMenuDataTable();
            deleteMenu();
        },

        //function to initiate User Add/Edit Page
        initManagement: function () {
            App.setPage("table_managed");
            App.init();
            validateMenu();
            manageDropdown()
        },
    };
}();