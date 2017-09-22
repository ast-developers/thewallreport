var ContatcUs = function () {

    var validateContactUs = function () {
        $('.contact-us-form').validate({
            errorElement: 'label',
            errorClass: 'help-inline',
            focusInvalid: false,
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true
                },
                message: {
                    required: true
                },
                security_check: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "Name is required."
                },
                email: {
                    required: "Email is required."
                },
                message: {
                    accept: 'Email is required.'
                },
                security_check: {
                    accept: 'Security check is required.'
                }
            },
            invalidHandler: function (event, validator) {
                $('.alert-error', $('.login-form')).show();
            },
            highlight: function (element) {
                $(element)
                    .closest('.form-group').addClass('error');
            },
            success: function (label) {
                console.log('1')
                label.closest('.form-group').removeClass('error');
                label.remove();
            },
            errorPlacement: function (error, element) {
                error.addClass('help-small no-left-padding validation-error').insertAfter(element.closest('.validation'));
            }
        });
    };

    return {
        initList: function () {
            validateContactUs();
        },
    };
}();