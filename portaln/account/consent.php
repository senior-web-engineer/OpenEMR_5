<?php 
session_start();
session_regenerate_id(true);
require_once("../../interface/globals.php");
?>
<html>
<head>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="description" content="Developed By sjpadgett@gmail.com">

    <link href="<?php echo $GLOBALS['assets_static_relative']; ?>/font-awesome-4-6-3/css/font-awesome.min.css"
          rel="stylesheet" type="text/css"/>
    <link rel="stylesheet"
          href="<?php echo $GLOBALS['assets_static_relative']; ?>/jquery-datetimepicker-2-5-4/build/jquery.datetimepicker.min.css">
    <link href="<?php echo $GLOBALS['assets_static_relative']; ?>/bootstrap-3-3-4/dist/css/bootstrap.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="./../assets/css/register.css" rel="stylesheet" type="text/css"/>
    <!-- Cstm-site.css Link -->
    <link href="./../assets/css/cstm-site.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo $GLOBALS['assets_static_relative']; ?>/jquery-min-3-1-1/index.js"
            type="text/javascript"></script>

    <script src="<?php echo $GLOBALS['assets_static_relative']; ?>/bootstrap-3-3-4/dist/js/bootstrap.min.js"
            type="text/javascript"></script>
    <script type="text/javascript"
            src="<?php echo $GLOBALS['assets_static_relative']; ?>/jquery-datetimepicker-2-5-4/build/jquery.datetimepicker.full.min.js"></script>
    <script type="text/javascript"
            src="<?php echo $GLOBALS['assets_static_relative']; ?>/emodal-1-2-65/dist/eModal.js"></script>
</head>
<body class="skin-blue md-bg">
<div class="container">
    <!-- End Insurance. Next what we've been striving towards..the end-->
    <div class="row" class="display-block">
        <div class="col-xs-12 col-md-12">
            <fieldset>
                <legend class="bg-success title-bg text-center">Terms of Usage and Privacy Policy</legend>
                <div class="well ml-bg register-success">
                    
                        <div class="so-tabwrap">
                            <ul class="nav nav-tabs so-tabnav" id="nav-tab" role="tablist">
                                <li class="nav-item active">
                                    <a class="nav-link active" id="unassign-tab" data-toggle="tab" href="#unassign" role="tab" aria-controls="unassign" aria-selected="true" aria-expanded="true"><i class="fa fa-exclamation-circle icon-rspace" aria-hidden="true"></i>Parenting</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="individual-tab" data-toggle="tab" href="#individual" rol="tab" aria-controls="individual-profile" aria-selected="false" aria-expanded="false">Counseling</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="soteam-tab" data-toggle="tab" href="#soteam" rol="tab" aria-controls="soteam-profile" aria-selected="false" aria-expanded="false">Terms &amp; Condition</a>
                                </li>
                            </ul>
                        <div class="tab-content tabconten-block" id="nav-tabContent">
                            <div class="tab-pane fade active in" id="unassign" role="tabpanel">
                                    <div class="tabinnercontent">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                    </div>
                            </div>
                <!--Start of Individual Tab-->
                            <div class="tab-pane fade" id="individual" role="tabpanel">
                                <div class="tabinnercontent">
                                    <p>This is Tab Two</p>
                                </div>
                            </div>
                <!--End of Individual Tab-->  
                <!--Start of SO Team-->
                            <div class="tab-pane fade" id="soteam" role="tabpanel">
                                <div class="tabinnercontent">
                                    <p>This is Tab Three</p>
                                </div>
                            </div>
                <!--End of SO Team Member-->
                
                        </div>
                    </div>

                       <!-- <div class="col-sm-12 termscheck-wrap">
                            <form>
                              <label class="ctmcontainer">I agree to OpenEMR <a href="#">Terms of Use and Privacy Policy.</a>
                                <input type="checkbox" checked="checked">
                                <span class="checkmark"></span>   
                            </label>
                            </form>
                        </div> -->
                        <style>
                        /*Start of Tab CSS*/
                        /* TAB CSS for Open EMr */
                            .tabconten-block {
                                background: #fff;
                                padding: 0px 15px;
                            }
                            .tabinnercontent {
                              margin: 15px 0px;
                              display: inline-block;
                              width: 100%;
                            }

                            .so-tabnav, .so-tabwrap{
                              -webkit-box-shadow: 0px -2px 20px 0px rgba(163,163,163,0.10);
                              -moz-box-shadow: 0px -2px 20px 0px rgba(163,163,163,0.10);
                              box-shadow: 0px -2px 25px 0px rgba(163,163,163,0.10);
                            }
                            .so-tabnav {
                              background: rgba(250,250,250,1);
                              background: -moz-linear-gradient(top, rgba(250,250,250,1) 0%, rgba(235,235,235,1) 100%);
                              background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(250,250,250,1)), color-stop(100%, rgba(235,235,235,1)));
                              background: -webkit-linear-gradient(top, rgba(250,250,250,1) 0%, rgba(235,235,235,1) 100%);
                              background: -o-linear-gradient(top, rgba(250,250,250,1) 0%, rgba(235,235,235,1) 100%);
                              background: -ms-linear-gradient(top, rgba(250,250,250,1) 0%, rgba(235,235,235,1) 100%);
                              background: linear-gradient(to bottom, rgb(248, 252, 255) 0%, rgb(234, 245, 255) 100%);
                            }
                            .so-tabnav li a {
                              padding: 12px 20px 12px 10px;
                            }
                            .so-tabnav>li.active>a, .so-tabnav>li.active>a:focus, .so-tabnav>li.active>a:hover {
                              border-top: 3px solid #1d6ebc;
                            }
                            .so-tabnav>li>a:hover {
                                border-color: #f2f9ff #ecf6ff #ebf5ff;
                                background-color: #e2f1ff!important;
                            }
                        /*End of Tab CSS*/
                            /* Customize the label (the container) */
                            /*.termscheck-wrap{
                                width:48%;
                                margin:0 auto;
                            }*/
                            .termscheck-wrap a{
                                color:#333;
                            }
                            .termscheck-wrap a:hover{
                                color:#1d6ebc;
                            }
                            .ctmcontainer {
                              display: block;
                              position: relative;
                              padding-left: 35px;
                              margin-bottom: 12px;
                              cursor: pointer;
                              font-size: 16px;
                              font-weight:normal;
                              text-align:left;
                              -webkit-user-select: none;
                              -moz-user-select: none;
                              -ms-user-select: none;
                              user-select: none;
                            }

                            /* Hide the browser's default checkbox */
                            .ctmcontainer input {
                              position: absolute;
                              opacity: 0;
                              cursor: pointer;
                              height: 0;
                              width: 0;
                            }

                            /* Create a custom checkbox */
                            .checkmark {
                              position: absolute;
                              top: 0;
                              left: 0;
                              height: 22px;
                              width: 22px;
                              background-color: #eee;
                            }

                            /* On mouse-over, add a grey background color */
                            .ctmcontainer:hover input ~ .checkmark {
                              background-color: #ccc;
                            }

                            /* When the checkbox is checked, add a blue background */
                            .ctmcontainer input:checked ~ .checkmark {
                              background-color: #1d6ebc;
                            }

                            /* Create the checkmark/indicator (hidden when not checked) */
                            .checkmark:after {
                              content: "";
                              position: absolute;
                              display: none;
                            }

                            /* Show the checkmark when checked */
                            .ctmcontainer input:checked ~ .checkmark:after {
                              display: block;
                            }

                            /* Style the checkmark/indicator */
                            .ctmcontainer .checkmark:after {
                              left: 9px;
                              top: 5px;
                              width: 5px;
                              height: 10px;
                              border: solid white;
                              border-width: 0 3px 3px 0;
                              -webkit-transform: rotate(45deg);
                              -ms-transform: rotate(45deg);
                              transform: rotate(45deg);
                            }
                        </style>
                    <!--<div class="row">
                        <div class="col-sm-12">
                            <button class="btn btn-primary prevBtn btn-sm pull-left mt-4 mb-3" type="button">Previous</button>
                            <button class="btn btn-success btn-sm pull-right mt-4 mb-3 send-r" style="width:15%;" type="button" id="submitPatient">Send Request</button>
                        </div>
                    </div>-->
                </div>
            </fieldset>
        </div>
    </div>
</div>
</body>
</html>