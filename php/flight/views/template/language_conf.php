<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $lang[$_COOKIE['systec_lang']]['lang']; ?></title>
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
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['lang']; ?></li>
                            </ol>
                        </div>
                    </div>


                    <h2 class="sub-header">
                        <?php echo $lang[$_COOKIE['systec_lang']]['lang']; ?>
                    </h2>
                    <div class="table-responsive">
                        <fieldset id="rulers">
                            <div class="control-group">
                                <label class="control-label" for="language"> <?php echo $lang[$_COOKIE['systec_lang']]['curlang']; ?>：</label>
                                <select id="language">
                                    <option value="cn"><?php echo $lang[$_COOKIE['systec_lang']]['chinese']; ?></option>
                                    <option value="en"><?php echo $lang[$_COOKIE['systec_lang']]['english']; ?></option>
                                </select>
                            </div>
                        </fieldset>

                        <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#del_com' id="edit_submit">
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


<script src="/js/scripts.js"></script>

<!--添加删除服务-->
<div class="modal fade bs-example-modal-sm" id="del_com" tabindex="-1" role="dialog" aria-labelledby="del_comLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4><?php echo $lang[$_COOKIE['systec_lang']]['areusure']; ?></h4>
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
        //添加验证服务，暂缺
        $.post("/api/language/update", {language: $("#language").val()}, function (result) {
            if (result.state == 0) {
                $.get("/api/conf/reload", function (result) {}, "json");
                window.location.reload();
            }
        }, "json");
    }
</script>

<script>
    $(function () {
        $.get("/api/language", function (result) {
            $("#language").val(result.language);
        }, "json");
    })
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

