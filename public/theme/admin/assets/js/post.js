var Post = function () {
    var dataTable;
    var initPostDataTable = function () {
         dataTable = $('#post-grid').DataTable({
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
                url: postAjaxPaginateUrl, // json datasource
                type: "post",  // method  , by default get
                error: function (data) {  // error handling
                    $(".user-grid-error").html("");
                    $("#user-grid").append('<tbody class="user-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#user-grid_processing").css("display", "none");

                }
            }
        });
    };

    var deletePost = function () {
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

            $.each($(".deleteRow"), function(index, value){
                if ($(this).is(':checked')) {
                    $checked = true;
                    $("#delete-btn").addClass('hidden')
                }
            });

            if($checked){
                $("#delete-btn").removeClass('hidden');
            } else {
                $('#bulkDelete').prop("checked", false);
            }

        });

        $('#deletePosts').on("click", function (event) { // triggering delete one by one
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
                    url: postBulkDeleteUrl,
                    data: {data_ids: ids_string},
                    success: function (result) {
                        dataTable.draw(); // redrawing datatable
                        $('.header-title').after('<div class="alert alert-success">'+
                            '<strong>'+'Posts deleted successfully.'+'</strong></div>');
                    },
                    async: false
                });
            }
        });
    };

    var validatePost = function () {
        $('.post-form').validate({
            errorElement: 'label', //default input error message container
            errorClass: 'help-inline', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                name: {
                    required: true
                },
                views:{
                    number: true
                },
                featured_image:{
                    accept: "image/*"
                }
            },

            messages: {
                name: {
                    required: "Post name is required."
                },
                views:{
                    number: "Please enter valid number."
                },
                featured_image:{
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

            errorPlacement: function (error, element) {
                if (element.attr("name") == "featured_image") {
                    error.insertAfter(element.closest('.file-upload-button-area'));
                } else {
                error.addClass('help-small no-left-padding').insertAfter(element.closest('.validation'));}}
        });
    };
    var manageStatusButton = function () {
        $("#publish_button").toggleClass("hidden", $("#status-type").val() != 'publish');
        $("#pending_submit").toggleClass("hidden", $("#status-type").val() != 'pending');
        $("#draft_submit").toggleClass("hidden", $("#status-type").val() != 'draft');
        $("#status-type").on('click', function () {
            $("#publish_button").toggleClass("hidden", $("#status-type").val() != 'publish');
            $("#pending_submit").toggleClass("hidden", $("#status-type").val() != 'pending');
            $("#draft_submit").toggleClass("hidden", $("#status-type").val() != 'draft');
        });
    }

    return {

        //function to initiate User Listing Page
        initList: function () {
            App.init();
            initPostDataTable();
            deletePost();
        },

        //function to initiate User Add/Edit Page
        initManagement: function () {
            App.setPage("table_managed");
            App.init();
            validatePost();
            manageStatusButton();
        },
    };
}();