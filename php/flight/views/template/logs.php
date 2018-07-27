<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $lang[$_COOKIE['systec_lang']]['logs']; ?></title>
        <!-- Bootstrap CSS -->    
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/widgets.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">
        <link href="/css/style-responsive.css" rel="stylesheet" />

        <link rel="stylesheet" href="/css/jquery.fileupload.css">
        <link rel="stylesheet" type="text/css" href="/css/jquery.timepicker.css"/>
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
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['logs']; ?></li>
                            </ol>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-2">
                            <div class="input-group">
                                <input id="date" type="text" class="form-control" style="width:160px;" placeholder=" <?php echo $lang[$_COOKIE['systec_lang']]['date']; ?>">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="search"><?php echo $lang[$_COOKIE['systec_lang']]['search']; ?></button>
                                </span>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                    </div><!-- /.row -->

                    <textarea class="form-control" rows="30" id="text"></textarea>




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
<script src="/js/jquery.timepicker.full.min.js"></script>

<script>
    $('#date').datetimepicker({
        autoclose: true,
        timepicker: false,
        format: 'Y.m.d',
    });

    function getNowFormatDate() {
        var date = new Date();
        var seperator1 = ".";
        var seperator2 = ":";
        var month = date.getMonth() + 1;
        var strDate = date.getDate();
        if (month >= 1 && month <= 9) {
            month = "0" + month;
        }
        if (strDate >= 0 && strDate <= 9) {
            strDate = "0" + strDate;
        }
        var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate;
        return currentdate;
    }

    $(function () {
        var mydate = new Date();
        $("#date").val(getNowFormatDate());

        $("#search").click(function () {
            dates = $("#date").val().split(".");

            $.get("/api/logs/" + dates[0] + "/" + dates[1] + "/" + dates[2], function (result) {
                if (result.text == "") {
                    $("#text").html("暂无日志");
                } else {
                    $("#text").html(result.text);
                }

            }, "json");
        });

    })

</script>