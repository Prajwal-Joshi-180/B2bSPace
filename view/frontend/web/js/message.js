/**
 * @package     Team Ode To Code
 * @author      Codilar Technologies
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.codilar.com/
 */
require(
    [
        "jquery",
        "mage/url",
        "Magento_Ui/js/modal/modal",
        "jquery/ui"
    ], function($, url,modal){
        $(document).ready(function() {

            // Scrolling Down
            const b2bMessages = $('.b2b-messages');
            b2bMessages.scrollTop(b2bMessages[0].scrollHeight);

            // Prevent form submission on pressing Enter key
            $('.message-form').on('submit', function (event) {
                event.preventDefault();
            });

            // Pop-Up Modal
            let options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                title: 'Members in this Space',
                buttons: [{
                    text: $.mage.__('Close'),
                    class: '',
                    click: function () {
                        this.closeModal();
                    }
                }]
            };

            let popup = modal(options, $('#company-members'));
            /**
             * Open  Modal Pop-UP on clicking of View All Members Button
             */
            $(".view-all-members").on('click',function(){
                $("#company-members").modal("openModal");
            });
        });


        /**
         * Call the Ajax after click on send message
         */
        $(document).on('click', '.message-submit', function() {
            let  message = $('.message-input').val();
            callAjax(message);
            $('#message-form :input').val('');
        });


        /**
         * Call the Ajax after click on delete message
         */
        $(document).on('click', '.delete-message', function() {
            let parentDiv = $(this).closest(".b2b_message");
            let id = parentDiv.attr("id");
            callAjax(null,id);
            });


        /**
         * Updating the messages by time interval
         */
        setInterval(function() {
            callAjax();
        }, 5000);

        /**
         * Ajax function to Update messages
         * @param message
         * @param id
         */
        function callAjax(message= null,id = null) {
            $.ajax({
                url: url.build('b2bspace/index/response'),
                type: "POST",
                dataType: "json",
                data: {message,id},
                success: function (response) {
                    $(".b2b-messages").html(response.data);
                    const b2bMessages = $('.b2b-messages');
                    b2bMessages.scrollTop(b2bMessages[0].scrollHeight);
                }
            });
        }

        /**
         * Calling the Search Ajax on keypress and updating response
         */
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


        /**
         * Preventing to hide search suggestions clicking on outside
         */
        $(document).mouseup(function (e) {
            if ($(e.target).closest("#message-search").length
                === 0) {
                $('.autocomplete-suggestions').hide();
                $('.no-results-found').hide();
            }
        });

        /**
         * Preventing the default behavior of the "Enter" key on search
         */
        $('#message-search').keypress(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });
