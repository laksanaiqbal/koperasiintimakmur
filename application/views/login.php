<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="<?php echo base_url(); ?>assets/cuba/assets/images/koperasi.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/cuba/assets/images/koperasi.png"
        type="image/x-icon">
    <!-- <link rel="icon" href="<?php echo base_url(); ?>assets/cuba/assets/images/logo-light-icon.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/cuba/assets/images/logo-light-icon.png"
        type="image/x-icon"> -->
    <title>KIM || Koperasi Inti Makmur</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/cuba/assets/css/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/cuba/assets/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/cuba/assets/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/cuba/assets/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css"
        href="<?php echo base_url(); ?>assets/cuba/assets/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/cuba/assets/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/cuba/assets/css/style.css">
    <link id="color" rel="stylesheet" href="<?php echo base_url(); ?>assets/cuba/assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/cuba/assets/css/responsive.css">
    <link href="<?php echo base_url(); ?>assets/mt/assets/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <style>
    img {
        /* width: 35px; */
        -webkit-filter: drop-shadow(3px 3px 3px #00008B);
        filter: drop-shadow(3px 3px 3px #00008B);
    }

    b {
        /* width: 35px; */
        -webkit-filter: drop-shadow(5px 3px 5px #00008B);
        filter: drop-shadow(5px 3px 5px #00008B);
    }
    </style>
</head>

<body>
    <!-- login page start-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-7"><img class="bg-img-cover bg-center"
                    src="<?php echo base_url(); ?>assets/cuba/assets/images/login/2.jpg" alt="looginpage"></div>
            <div class="col-xl-5 p-0">
                <div class="login-card">
                    <div>
                        <div><a class="logo text-start"><img class="img-fluid for-light"
                                    src="<?php echo base_url(); ?>assets/cuba/assets/images/logo/LOGO-IEI-2.png"
                                    width="35px" heigt="35px" alt="looginpage"><img class="img-fluid for-dark"
                                    src="<?php echo base_url(); ?>assets/cuba/assets/images/logo/LOGO-IEI-2.png"
                                    width="35px" heigt="35px" alt="looginpage">
                                <h7> <b>PT. Inti Everspring Indonesia</b></h7>
                            </a></div>
                        <div class="login-main">
                            <form class="theme-form" method="post" id="loginform"
                                action="<?php echo site_url('auth/proses_login'); ?>">
                                <b>
                                    <h4>Sign in to </h4>
                                </b>
                                <b>
                                    <h4>
                                        Koperasi Inti Makmur
                                    </h4>
                                </b>
                                <p>Enter your username & password to login</p>
                                <div class="form-group">
                                    <label class="col-form-label">Username</label>
                                    <input class="form-control" type="text" required="" id="username" name="username"
                                        placeholder="Type Username Here">
                                    <!-- <input class="form-control" type="email" required="" placeholder="Jhoni"> -->
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <!-- <input class="form-control" type="password" name="login[password]" required="" placeholder="Type Password Here"> -->
                                        <input class="form-control" type="password" required="" id="password"
                                            name="password" placeholder="Type Password Here">
                                        <div toggle="#password" class="show-hide toggle-password"><span
                                                class="show"></span></div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="checkbox p-0">
                                        <input id="checkbox1" type="checkbox">
                                        <!-- <label class="text-muted" for="checkbox1">Remember password</label> -->
                                    </div>
                                    <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- latest jquery-->
        <script src="<?php echo base_url(); ?>assets/cuba/assets/js/jquery-3.5.1.min.js"></script>
        <!-- Bootstrap js-->
        <script src="<?php echo base_url(); ?>assets/cuba/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
        <!-- feather icon js-->
        <script src="<?php echo base_url(); ?>assets/cuba/assets/js/icons/feather-icon/feather.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/cuba/assets/js/icons/feather-icon/feather-icon.js"></script>
        <!-- scrollbar js-->
        <!-- Sidebar jquery-->
        <script src="<?php echo base_url(); ?>assets/cuba/assets/js/config.js"></script>
        <!-- Plugins JS start-->
        <!-- Plugins JS Ends-->
        <!-- Theme js-->
        <script src="<?php echo base_url(); ?>assets/cuba/assets/js/script.js"></script>

        <!-- login js-->
        <!-- Plugin used-->
        <script src="<?php echo base_url(); ?>assets/mt/assets/plugins/jquery/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/mt/horizontal/js/jquery.validate.js"></script>
        <script src="<?php echo base_url(); ?>assets/mt/horizontal/js/jquery.form.min.js"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="<?php echo base_url(); ?>assets/mt/assets/plugins/bootstrap/js/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/mt/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="<?php echo base_url(); ?>assets/mt/horizontal/js/jquery.slimscroll.js"></script>
        <!--Wave Effects -->
        <script src="<?php echo base_url(); ?>assets/mt/horizontal/js/waves.js"></script>
        <!--Menu sidebar -->
        <script src="<?php echo base_url(); ?>assets/mt/horizontal/js/sidebarmenu.js"></script>
        <!--stickey kit -->
        <script src="<?php echo base_url(); ?>assets/mt/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js">
        </script>
        <script src="<?php echo base_url(); ?>assets/mt/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
        <!--Custom JavaScript -->
        <script src="<?php echo base_url(); ?>assets/mt/horizontal/js/custom.min.js"></script>
        <!-- ============================================================== -->
        <!-- Style switcher -->
        <!-- ============================================================== -->
        <script src="<?php echo base_url(); ?>assets/mt/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
        <script src="<?php echo base_url(); ?>assets/mt/assets/plugins/sweetalert/sweetalert.min.js"></script>
        <script type="text/javascript">
        $(".toggle-password").click(function() {
            // $(this).toggleClass("fa fa-fw fa-eye");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(document).ready(function() {
            validate();
        });

        function validate() {
            var form = $("#loginform");
            var submit = $("#loginform .btn-submit");
            $(form).validate({
                errorClass: 'invalid',
                errorElement: 'em',

                highlight: function(element) {
                    $(element).parent().removeClass('state-success').addClass("state-error");
                    $(element).removeClass('valid');
                },

                unhighlight: function(element) {
                    $(element).parent().removeClass("state-error").addClass('state-success');
                    $(element).addClass('valid');
                },

                debug: false,
                rules: {
                    username: {
                        required: true,
                    },
                    password: {
                        required: true,
                    },
                },
                messages: {},
                //ajax form submition
                submitHandler: function(form) {
                    $(form).ajaxSubmit({
                        dataType: 'json',
                        beforeSend: function() {
                            $(submit).attr('disabled', true);
                        },
                        success: function(data) {
                            $('.preloader').hide();
                            if (data['is_error'] == true) {
                                swal({
                                    title: "Error!",
                                    text: data['error_msg'],
                                    showConfirmButton: false,
                                    timer: 2025,
                                    type: "error"
                                });
                                $(submit).attr('disabled', false);
                            } else {
                                window.location = data['redirect'];

                            }
                        },
                        error: function() {
                            swal({
                                title: "Oops!",
                                text: "Something went wrong , please check your login",
                                showConfirmButton: false,
                                timer: 1999,
                                type: "warning"
                            });
                        }
                    });
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element.parent());
                },
            });
        }
        //disable screenshoot
        const copyToClipboard = () => {
            var textToCopy = "Print Screen Disabled By System";
            // navigator.clipboard.writeText(textToCopy);
            swal({
                title: "Oops!",
                text: textToCopy, //"Something went wrong , please check your login",
                showConfirmButton: false,
                timer: 1999,
                type: "warning"
            });
        }

        $(window).keyup((e) => {
            if (e.keyCode == 44) {
                setTimeout(
                    copyToClipboard(),
                    10
                );
            }
        });

        document.addEventListener("keyup", function(e) {
            var keyCode = e.keyCode ? e.keyCode : e.which;
            if (keyCode == 44) {
                stopPrntScr();
            }
        });

        function stopPrntScr() {

            var inpFld = document.createElement("input");
            inpFld.setAttribute("value", ".");
            inpFld.setAttribute("width", "0");
            inpFld.style.height = "0px";
            inpFld.style.width = "0px";
            inpFld.style.border = "0px";
            document.body.appendChild(inpFld);
            inpFld.select();
            document.execCommand("copy");
            inpFld.remove(inpFld);
        }

        function AccessClipboardData() {
            try {
                window.clipboardData.setData('text', "Access   Restricted");
            } catch (err) {}
        }
        setInterval("AccessClipboardData()", 10);
        </script>
    </div>
</body>

</html>