$("#search-input").on("keyup", function (event) {
    var text = $('#search-input').val();
    var model_content = $('.modal-content').find('.row');
    if (text.length > 2) {
        $.ajax({
            url: url,
            dataType: "json",
            method: 'POST',
            data: {term: text},
            beforeSend: function () {
                $('.spinner').html("<img src='" + spinner + "' />");
            },
            success: function (data) {
                console.log(data)
                $('.spinner').empty();
                $('.no-found-result').empty();
                $(model_content).empty();
                $('.button-area').empty()
                var result_message = (typeof data.count != 'undefined' && data.count > 0) ? "FOUND " + data.count + " RESULTS FOR: <span class='search-text'>" + text + "</span>" : "NO RESULTS FOUND FOR:<span class='search-text'>" + text + "</span>";
                if (typeof data.count != 'undefined' && data.count > 0) {
                    $('.found-result').html(result_message);
                    $.each(data.data, function (key, value) {
                        $(model_content).append("<div class='col-lg-4 text-center pb-2'><a href='" + value.slug + "'><div class='search-img hidden-md-down'><img src=" + value.featured_image + "></div><h2 class='title'>" + value.name + "</h2></a><span class='search-date d-block'>" + value.published_at + "</span></div>");
                    });
                    $("<a class='see-all-btn' href='" + search_url + text + "'>SEE ALL RESULTS</a>").appendTo('.button-area');
                } else {
                    $('.button-area').empty();
                    $('.found-result').empty();
                    $('.no-found-result').html(result_message)
                }
            }
        });
    }
});
$('#search-input').keyup(function (e) {
    if (e.keyCode == 13) {
        window.location.href = search_url + $('#search-input').val();
    }
});