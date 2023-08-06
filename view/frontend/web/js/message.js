require(
    [
        "jquery",
        "mage/url",
        "jquery/ui"
    ], function($, url){
        $(document).on('click', '.message-submit', function() {
            let  message = $('#message-form').serializeArray();
            callAjax(message);
            $('#message-form :input').val('');
        });

        // setInterval(function() {
        //     let  message = null;
        //     callAjax(message);
        // }, 5000);

        function callAjax(message) {
            $.ajax({
                url: url.build('b2bspace/index/response'),
                type: "POST",
                dataType: "json",
                data: message,
                success: function (response) {
                    $(".b2b-messages").html(response.data);
                }
            });
        }


        $('#message-search').keyup(function () {
            setTimeout(() => {
                let searchValue = $('#message-search').val();
                if (searchValue === '') {
                    $('.autocomplete-suggestions').hide();
                    $('.no-results-found').hide();
                } else {
                    var params = {
                        'query': searchValue
                    };
                    $.ajax({
                        url: url.build('b2bspace/index/search'),
                        type: 'GET',
                        data: params,
                        success: function (response) {
                            if (response.count > 0) {
                                let data = response.html;
                                let html = '';
                                $.each(data, function (key, value) {
                                    html += '<div class="autocomplete-suggestion" data-index="' + key + '">\n' +
                                        '<a href="#' + key + '">\n' +
                                        '<div class="searched-name">\n' + value.message + '</div>\n' +
                                        '</a>\n' +
                                        '</div>'
                                });
                                $('.autocomplete-suggestions').empty().append(html).show();
                                $('.no-results-found').hide();
                            } else {
                                $('.autocomplete-suggestions').empty();
                                $('.no-results-found').show();
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            },300);
        });


        $(document).mouseup(function (e) {
            if ($(e.target).closest("#message-search").length
                === 0) {
                $('.autocomplete-suggestions').hide();
                $('.no-results-found').hide();
            }
        });

        $('#message-search').keypress(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });
