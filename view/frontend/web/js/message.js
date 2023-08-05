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
    });
