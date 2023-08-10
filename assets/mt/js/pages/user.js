$('#myTable').DataTable();
$('.dropify').dropify();

$(document).ready(function() {
    validate();	
});

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#preview').attr('src', e.target.result);
        }

      reader.readAsDataURL(input.files[0]);
    }
}

//image read
$("#image-preview").change(function() {
    readURL(this);
});

// function validate form
function validate() {
    var form 	= $("#user-form"); 
    var submit 	= $("#user-form .btn-submit");
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
            fullname:
            {
                required: true,
            },
            username:
            {
                required: true,
            },
            email:
            {
                required: true,
            },
            password:
            {
                required: true,
            },
            pass_conf : {
                required: true,
                equalTo: "#password"
            },
            role_id: {
                required: true
            }
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
                    $('.preloader').show();
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
                                title: data['notif_title'],
                                text: data['notif_message'],
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

function refreshTable() {
    $('#myTable').each(function() {
        dt = $(this).dataTable();
        dt.fnDraw();
    })
  }

$(document).on('click', '.btn-delete', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    swal({
        title: "Are you sure!",
        type: "error",
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes!",
        showCancelButton: true,
    },
    function() {
        $.ajax({
            beforeSend: function()
            {
                $('.preloader').show();
            },
            type: "POST",
            url: BASE_URL+ "user/delete",
            data: {
                id:id
            },
            success: function (data) {
                $('.preloader').hide();
                // console.log(data['is_error']);
                if(data['is_error'] == true) {
                    // alert(data['error_msg']);
                    alert(data['error_msg']);
                    return false;
                } else {
                    setTimeout(function() {
                        swal({
                            title: 'Success!',
                            text: data['success_msg'],
                            type: "success"
                        }, function() {
                            window.location.reload();
                        });
                    }, 1000);
                }
            }         
        });
    });
});