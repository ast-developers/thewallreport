var Menu = function () {
    var dataTable;
    var initMenuDataTable   = function () {
        dataTable = $('#menu-grid').DataTable({
            "processing": true,
            "serverSide": true,
            "order"     : [[1, "asc"]],
            "columnDefs": [{
                "targets"   : 0,
                "orderable" : false,
                "searchable": false

            }],
            "ajax"      : {
                url  : menuAjaxPaginateUrl, // json datasource
                type : "post",  // method  , by default get
                error: function (data) {  // error handling
                    $(".user-grid-error").html("");
                    $("#user-grid").append('<tbody class="user-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#user-grid_processing").css("display", "none");

                }
            }
        });
    };
    var validateMenu        = function () {
        $('.menu-form').validate({
            errorElement: 'label', //default input error message container
            errorClass  : 'help-inline', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules       : {
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
                $('.alert-error', $('.menu-form')).show();
            },

            highlight: function (element) { // hightlight error inputs
                $(element).closest('.control-group').addClass('error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.control-group').removeClass('error');
                label.remove();
            },

            errorPlacement: function (error, element) {
                error.addClass('help-small no-left-padding').insertAfter(element.closest('.validation'));
            }
        });
    };
    var manageMenuSortOrder = function () {
        $('#menu-list').sortable({
            axis  : 'y',
            cursor: 'move',
            update: function (event, ui) {
                var data = $(this).sortable('serialize');
                $.ajax({
                    data: data,
                    type: 'POST',
                    url : updateMenuSortOrder,
                });
            }
        });
    };
    var manageDropdown      = function () {
        $("#post-dropdown").toggleClass("hidden", $("#menu-type").val() != 1);
        $("#page-dropdown").toggleClass("hidden", $("#menu-type").val() != 2);
        $("#external-url-textbox").toggleClass("hidden", $("#menu-type").val() != 3);
        $("#menu-type").on('click', function () {
            $("#post-dropdown").toggleClass("hidden", $(this).val() != 1);
            $("#page-dropdown").toggleClass("hidden", $(this).val() != 2);
            $("#external-url-textbox").toggleClass("hidden", $(this).val() != 3);
        });
    };

    return {
        //function to initiate User Listing Page
        initList: function () {
            App.init();
            initMenuDataTable();
            App.initBulkDelete({'deleteElement': $('#deleteMenus'), 'deleteUrl': menuBulkDeleteUrl, 'deleteSuccessMsg': 'Menus deleted successfully.', 'dataTable': dataTable});
            manageMenuSortOrder();
        },

        //function to initiate User Add/Edit Page
        initManagement: function () {
            App.init();
            validateMenu();
            manageDropdown()
        }
    };
}();