<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $lang[$_COOKIE['systec_lang']]['sysupdate']; ?></title>
        <!-- Bootstrap CSS -->    
        <link href="/css/bootstrap.min.css" rel="stylesheet">
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
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['sysupdate']; ?></li>
                            </ol>
                        </div>
                    </div>
                    <h2 class="sub-header">
                        <?php echo $lang[$_COOKIE['systec_lang']]['sysupdate']; ?>
                    </h2>
                    <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <td>文件上传：</td>
                            <td><input type="file" id="hostname" /></td>
                        </tr>
 
                        </table>

                        <button type="button" class="btn btn-primary" id="edit_submit">
                            <?php echo $lang[$_COOKIE['systec_lang']]['update']; ?>
                        </button>
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
        <script>
        $(function() {
            $.get("/api/network", function(result){
                $("#hostname").val(result.hostname);
                $("#mac").val(result.mac);
                $("#ip").val(result.ip);
                $("#gateway").val(result.gateway);
                $("#netmask").val(result.netmask);
                $("#dns").val(result.dns);
                $("#dhcp").val(result.dhcp);
                },"json");
            })
        </script>
        <script>
        $(function() {
            $("#edit_submit").click(function(){
                //添加验证服务，暂缺
                $.post("/api/system/update",{hostname:$("#hostname").val(),mac:$("#mac").val(),ip:$("#ip").val(),gateway:$("#gateway").val(),netmask:$("#netmask").val(),dns:$("#dns").val(),dhcp:$("#dhcp").val()},function(result){
                    if(result.state==0){
                        window.location.reload();
                    }
                },"json");
            });
        });
        </script>

