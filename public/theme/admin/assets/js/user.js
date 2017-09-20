var User = function () {
    var dataTable;
    var initUserDataTable = function () {
         dataTable = $('#user-grid').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [[ 1, "asc" ]],
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
    };

    var deleteUser = function () {

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
            if ($(this).is(':checked')) {
                $("#delete-btn").removeClass('hidden');
            } else {
                $("#delete-btn").addClass('hidden')
            }
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
                        $('.header-title').after('<div class="alert alert-success">'+
                            '<strong>'+'Users deleted successfully.'+'</strong></div>');
                    },
                    async: false
                });
            }
        });
    };

    var validateUser = function () {
        $('.user-form').validate({
            errorElement: 'label', //default input error message container
            errorClass: 'help-inline', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                username: {
                    required: true
                },
                password:{
                    required: true
                },
                rpassword: {
                    equalTo: "#register_password"
                },
                email: {
                    required: true,
                    email: true
                },
                avatar: {
                    accept: "image/*"
                }
            },

            messages: {
                username: {
                    required: "Username is required."
                },
                password: {
                    required: "Password is required."
                },
                avatar:{
                    accept: 'Please upload Image file only.'
                }
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

            errorPlacement: function (error, element) { console.log(element);
                if (element.attr("name") == "avatar") {
                    error.insertAfter(element.closest('.file-upload-button-area'));
                } else {
                error.addClass('help-small no-left-padding').insertAfter(element.closest('.input-icon'));}
            }
        });
    };

    return {

        //function to initiate User Listing Page
        initList: function () {
            App.init();
            initUserDataTable();
            deleteUser();
        },

        //function to initiate User Add/Edit Page
        initManagement: function () {
            App.setPage("table_managed");
            App.init();
            validateUser();
        },
    };
}();