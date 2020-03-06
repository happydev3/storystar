<script>
    jQuery(document).ready(function () {
        var chk = true;
        var errorClass = 'invalid';
        var errorElement = 'em';

        $("<?php echo $validator['selector']; ?>").validate({
            errorElement: errorElement,
            errorClass: errorClass,

            errorPlacement: function (error, element) {



                if (element.parent('.input-group').length ||
                    element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                    error.insertAfter(element.parent().parent());
                    // else just place the validation message immediatly after the input
                }
                else if (element.prop('type') == "select-one") {
                    error.insertAfter(element.next());
                }
                else if (element.prop('type') == "file") {
                    error.insertAfter(element.parent().parent());
                }
                else {
                    //error.insertAfter(element);
                    error.insertAfter(element.parent());
                }

                if (error.text()) {
                    if (chk == true) {
                        chk = false;
                        $("html, body").animate({scrollTop: 150}, "slow");

                    }
                }


            },
            highlight: function (element) {
                $(element).parent().removeClass('state-success').addClass("state-error");
                $(element).removeClass('valid');
            },
            unhighlight: function (element) {
                $(element).parent().removeClass("state-error").addClass('state-success');
                $(element).addClass('valid');
            },


            ignore: ".ignore, .select2-input",

            success: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // remove the Boostrap error class from the control group
            },

            focusInvalid: false, // do not focus the last invalid input
            <?php if (Config::get('jsvalidation.focus_on_error')): ?>
            invalidHandler: function (form, validator) {

                if (!validator.numberOfInvalids())
                    return;

                $('html, body').animate({
                    scrollTop: $(validator.errorList[0].element).offset().top
                }, <?php echo Config::get('jsvalidation.duration_animate') ?>);
                $(validator.errorList[0].element).focus();

            },
            <?php endif; ?>

            rules: <?php echo json_encode($validator['rules']); ?>
        })
    })
</script>
