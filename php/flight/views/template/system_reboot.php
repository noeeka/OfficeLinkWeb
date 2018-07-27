<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $lang[$_COOKIE['systec_lang']]['reboot']; ?></title>
        <!-- Bootstrap CSS -->    
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <!-- bootstrap theme -->
        <link href="/css/bootstrap-theme.css" rel="stylesheet">

        <link href="/css/widgets.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">
        <link href="/css/style-responsive.css" rel="stylesheet" />

        <link rel="stylesheet" href="/css/jquery.fileupload.css">
        <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/>

        <script src="/js/jquery.js"></script>
        <script src="/js/jquery-1.8.3.min.js"></script>
        <script src="/js/languages.js"></script>
    </head>
    <body>
        <section id="container" class="">
            <?php include 'header.php'; ?> 
            <?php include 'navigate.php'; ?>
            <section id="main-content">
                <section class="wrapper">   
                    <div class="row">
                        <div class="col-lg-12">
                            <ol class="breadcrumb">
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['systemcong']; ?></li>
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['reboot']; ?></li>
                            </ol>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#del_com' id="edit_submit">
                                        <?php echo $lang[$_COOKIE['systec_lang']]['reboot']; ?>
                                    </button></td>
                            </tr>

                        </table>


                    </div>
                </section>
            </section>
            <!--main content end-->
        </section> 
    </body>
</html>

<!-- nice scroll -->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.scrollTo.min.js"></script>
<script src="/js/jquery.nicescroll.js" type="text/javascript"></script>
<!-- jquery knob 
<script src="/assets/jquery-knob/js/jquery.knob.js"></script>-->
<script src="/js/scripts.js"></script>



<!--添加删除服务-->
<div class="modal fade bs-example-modal-sm" id="del_com" tabindex="-1" role="dialog" aria-labelledby="del_comLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4><?php echo $lang[$_COOKIE['systec_lang']]['reboot_tips']; ?></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_del();"><?php echo $lang[$_COOKIE['systec_lang']]['cancel']; ?></button>
                <button type="button" class="btn btn-success" id="confirm_del_btn" onclick="confirm_del();"><?php echo $lang[$_COOKIE['systec_lang']]['confirm']; ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    function cancel_del() {
        $("#del_com").hide();
    }
    function confirm_del() {
        window.location.href="/";
        $.post("/api/system/reboot", {hostname: $("#hostname").val(), mac: $("#mac").val(), ip: $("#ip").val(), gateway: $("#gateway").val(), netmask: $("#netmask").val(), dns: $("#dns").val(), dhcp: $("#dhcp").val()}, function (result) {
            if (result.state == 0) {
                logout();
            }
        }, "json");
    }
</script>

<script>
    $(function () {
        $("#edit_submit").click(function () {
            $("#del_com").addClass("in");
            $("#del_com").show();
            $("#confirm_del_btn").attr("filed", uid);
        });
    });
</script>


