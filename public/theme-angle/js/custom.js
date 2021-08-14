(function(window, document, $, undefined) {

    $(function() {

        // document ready

        $('.dataTable').on('change', '.js-ajax-checkbox', function() {
            const cntx = $(this);
            const val = cntx.is(":checked");
            const url = cntx.attr('data-ajax-url');
            let data = cntx.data();
            data['value'] = val;
            if(url){
                let request = $.ajax({
                    url:url,
                    method: "GET",
                    data: data,
                });

                request.done(function(data) {
                    let message = 'Record has been successfully updated.';
                    if(data.message){
                        message = data.message;
                    }
                    $.notify(message, {status: "success", pos: "bottom-right"});
                }).fail(function() {
                    $.notify("Unexpected error occurred, <br>please try again later.", {status: "danger", pos: "bottom-right"});
                });
            }


        })

            $(".js-title").focusout(function() {
                const slug = convertToSlug($(this).val());
               $(".js-slug").val(slug);
            })

        function convertToSlug(Text)
        {
            return Text
                .toLowerCase()
                .replace(/[^\w ]+/g,'')
                .replace(/ +/g,'-')
                ;
        }
    });

})(window, document, window.jQuery);