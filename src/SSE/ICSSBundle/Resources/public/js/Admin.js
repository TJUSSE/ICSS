Admin.setup_icheck = function(subject) {
    if (window.SONATA_CONFIG && window.SONATA_CONFIG.USE_ICHECK) {
        jQuery("input[type='checkbox']:not('label.btn>input'), input[type='radio']:not('label.btn>input')", subject).iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square',
        });
    }
};