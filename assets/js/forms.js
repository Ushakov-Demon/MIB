jQuery(document).ready(function($) {
    $(document).on('wpcf7mailsent', function(event) {
        var form = $('#' + event.detail.id);
        
        if (form.length) {
            form.find('.wpcf7-form-control-wrap, .wpcf7-submit').parent().hide();
            
            if (form.find('.send-again-button').length === 0) {
                var sendAgainButton = $('<button>', {
                    'class': 'button send-again-button',
                    'text': sendAgainTranslation
                });
                
                sendAgainButton.on('click', function() {
                    form.find('.wpcf7-form-control-wrap, .wpcf7-submit').parent().show();
                    form.find('.wpcf7-response-output').hide();
                    $(this).remove();
                });
                
                form.find('.wpcf7-response-output').after(sendAgainButton);
            }
        }
    });
});