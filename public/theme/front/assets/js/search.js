$("#search-input").on("keyup", function (event) {
    var text = $('#search-input').val();
    var model_content = $('.modal-content').find('.model-body');
    if (text.length > 2) {
        $.ajax({
            url: url,
            method: 'POST',
            data: {term: text},
            beforeSend: function () {
                $('.spinner').show();
            },
            success: function (data) {
                $('.spinner').hide();
                $(model_content).html(data);
            }
        });
    }
});
$('#search-input').keyup(function (e) {
    if (e.keyCode == 13) {
        window.location.href = search_url + $('#search-input').val();
    }
});