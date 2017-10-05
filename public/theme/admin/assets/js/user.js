var User = function () {
    var dataTable;
    var initUserDataTable = function () {
        dataTable = $('#user-grid').DataTable({
            "processing": true,
            "serverSide": true,
            "order"     : [[1, "asc"]],
            "responsive": true,
            "columnDefs": [{
                "targets"   : 0,
                "orderable" : false,
                "searchable": false,
                "className": 'selectall-checkbox'

            }],
            "ajax"      : {
                url  : userAjaxPaginateUrl, // json datasource
                type : "post",  // method  , by default get
                error: function (data) {  // error handling
                    $(".user-grid-error").html("");
                    $("#user-grid").append('<tbody class="user-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#user-grid_processing").css("display", "none");

                }
            }
        });
    };
    var validateUser      = function () {
        $('.user-form').validate({
            errorElement: 'label', //default input error message container
            errorClass  : 'help-inline', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules       : {
                username : {
                    required: true
                },
                password : {
                    required: true
                },
                rpassword: {
                    equalTo: "#password"
                },
                email    : {
                    required: true,
                    email   : true
                },
                avatar   : {
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
                avatar  : {
                    accept: 'Please upload Image file only.'
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                $('.alert-error', $('.user-form')).show();
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
                if (element.attr("name") == "avatar") {
                    error.insertAfter(element.closest('.file-upload-button-area'));
                } else {
                    error.addClass('help-small no-left-padding').insertAfter(element.closest('.validation'));
                }
            }
        });
    };

    return {
        //function to initiate User Listing Page
        initList: function () {
            App.init();
            initUserDataTable();
            App.initBulkDelete({'deleteElement': $('#deleteUsers'), 'deleteUrl': userBulkDeleteUrl, 'deleteSuccessMsg': 'Users deleted successfully.', 'dataTable': dataTable});
        },

        //function to initiate User Add/Edit Page
        initManagement: function () {
            App.init();
            validateUser();
        }
    };
}();