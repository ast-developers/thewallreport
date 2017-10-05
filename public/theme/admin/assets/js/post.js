var Post = function () {
    var dataTable;
    var initPostDataTable  = function () {
        dataTable = $('#post-grid').DataTable({
            "processing": true,
            "serverSide": true,
            "order"     : [[1, "asc"]],
            "columnDefs": [{
                "targets"   : 0,
                "orderable" : false,
                "searchable": false,
                "className": 'selectall-checkbox',

            }],
            "ajax"      : {
                url  : postAjaxPaginateUrl, // json datasource
                type : "post",  // method  , by default get
                error: function (data) {  // error handling
                    $(".user-grid-error").html("");
                    $("#user-grid").append('<tbody class="user-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#user-grid_processing").css("display", "none");

                }
            }
        });
    };
    var validatePost       = function () {
        $('.post-form').validate({
            errorElement: 'label', //default input error message container
            errorClass  : 'help-inline', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules       : {
                name          : {
                    required: true
                },
                views         : {
                    number: true
                },
                featured_image: {
                    accept: "image/*"
                }
            },

            messages: {
                name          : {
                    required: "Post name is required."
                },
                views         : {
                    number: "Please enter valid number."
                },
                featured_image: {
                    accept: 'Please upload Image file only.'
                }

            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                $('.alert-error', $('.post-form')).show();
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
                    error.addClass('help-small no-left-padding').insertAfter(element.closest('.validation'));
                }
            }
        });
    };
    var manageDeleteImage  = function () {
        $("#deleteImage").on('click', function () {
            $("input[name='delete_featured_image']").val(1);
            $('.featured-image-area').find('img').attr('src', 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image');
            $(".featured-image-delete-btn").hide();
        });
    };
    var manageStatusButton = function () {
        $("#status_submit").html('Save as ' + $("#status-type").val());
        $("#status-type").on('click', function () {
            $("#status_submit").html('Save as ' + $("#status-type").val());
        });
    };

    return {
        //function to initiate User Listing Page
        initList: function () {
            App.init();
            initPostDataTable();
            App.initBulkDelete({'deleteElement': $('#deletePosts'), 'deleteUrl': postBulkDeleteUrl, 'deleteSuccessMsg': 'Posts deleted successfully.', 'dataTable': dataTable});
        },

        //function to initiate User Add/Edit Page
        initManagement: function () {
            App.init();
            validatePost();
            manageStatusButton();
            manageDeleteImage();
        }
    };
}();