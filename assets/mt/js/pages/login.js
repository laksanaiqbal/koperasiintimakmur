$(document).ready(function() {
    validate();	
});
// function validate form
function validate() {
    var form 	= $("#loginform"); 
    var submit 	= $("#loginform .btn-submit");
    // alert();
    $(form).validate({
        errorClass      : 'invalid',
        errorElement    : 'em',

        highlight: function(element) {
            // console.log(element);
            $(element).parent().removeClass('state-success').addClass("state-error");
            $(element).removeClass('valid');
        },

        unhighlight: function(element) {
            $(element).parent().removeClass("state-error").addClass('state-success');
            $(element).addClass('valid');
        },

        debug: false,

        //rules form validation
        rules: 
        {
            username:
            {
                required: true,
            },
            password:
            {
                required: true,
            },
        },

        //messages
        messages:
        {},
        
        //ajax form submition
        submitHandler: function(form)
        {
            $(form).ajaxSubmit({
                dataType: 'json',
                beforeSend: function()
                {
                    $(submit).attr('disabled', true);
                    // $('.preloader').show();
                },
                success: function(data)
                {
                    $('.preloader').hide();
                    //validate if error
                    if(data['is_error'] == true) {
                        // stopLoading();
                        swal("Oops!", data['error_msg'], "error");
                        $(submit).attr('disabled', false);
                    } 
                    else {
                        // console.log(data['title_msg']);
                        // console.log(data['success_msg']);
                        setTimeout(function() {
                            swal({
                                title: "Wow!",
                                text: data['error_msg'],
                                type: "success"
                            }, function() {
                                window.location = data['redirect'];
                            });
                        }, 1000);
                        //success
                    }                    
                },
                error: function() {
                    $(submit).attr('disabled', false);
                }
            });
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent());
        },
    });
}