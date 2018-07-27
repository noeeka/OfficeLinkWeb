<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="James">
        <title><?php echo $lang[$_COOKIE['systec_lang']]['meetingroomststus']; ?></title>
        <!-- Bootstrap CSS -->    
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <!-- bootstrap theme -->
        <link href="/css/bootstrap-theme.css" rel="stylesheet">
        <!--external css-->
        <!-- font icon -->
        <link href="/css/widgets.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">
        <link href="/css/style-responsive.css" rel="stylesheet" />
        <script src="/js/jquery.js"></script>
        <script src="/js/jquery-1.8.3.min.js"></script>
        <script src="/js/languages.js"></script>
    </head>

    <body>
        <!-- container section start -->
        <section id="container" class="">
            <!--header start-->
            <?php include 'header.php'; ?>
            <!--header end-->
            <!--navigate start-->
            <?php include 'navigate.php'; ?>
            <!--navigate end-->
            <!--main content start-->
            <section id="main-content">
                <section class="wrapper">            
                    <!--overview start-->
                    <div class="row">
                        <div class="col-lg-12">
                            <ol class="breadcrumb">
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['statusinfo']; ?></li>
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['meetingroomststus']; ?></li>
                            </ol>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?>
                                </td>
                                <td align='center' valign='middle'>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['extensioncount']; ?>
                                </td>
                                <td align='center' valign='middle'>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['readmore']; ?>
                                </td>
                            </tr>
                        </thead>
                        <tbody id="meetingroom_status">
                        </tbody>
                    </table>

                    <nav>
                        <ul class="pagination">


                        </ul>
                    </nav>

                </section>
            </section>
            <!--main content end-->
        </section>

        <div class="modal fade" id="readmore" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true" id="close1">
                                &times;
                            </span>
                            <span class="sr-only">
                                Close
                            </span>
                        </button>
                        <h4 class="modal-title">
                            <?php echo $lang[$_COOKIE['systec_lang']]['meetingroomststus']; ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <table width="100%">
                            <thead>
                                <tr>
                                    <td>
                                        <?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?>
                                    </td>
                                    <!--<td>
                                        <?php echo $lang[$_COOKIE['systec_lang']]['channel']; ?>
                                    </td>
                                    -->
                                    <td>
                                        <?php echo $lang[$_COOKIE['systec_lang']]['status']; ?>
                                    </td>
                                    <td>
                                        <?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?>
                                    </td>

                                </tr>
                            </thead>

                            <tbody id="meetme_sts">

                            </tbody>

                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="close2">
                            <?php echo $lang[$_COOKIE['systec_lang']]['cancel']; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>       
        <script>
            function read_more(ex) {
                obj = strToJson($("#" + ex).attr("data"));
                $("#meetme_sts").html("");
                $('#readmore').show();
                var str = "";
                $.each(obj, function (i, n) {
                    var checked = "";
                    if (n.mute == true) {
                        var mute = "<?php echo $lang[$_COOKIE['systec_lang']]['mute']; ?>";
                        var checked = "checked=checked";
                    } else {
                        var mute = "<?php echo $lang[$_COOKIE['systec_lang']]['unmute']; ?>";
                        var checked = "";

                    }
                    str = "<tr><td>" + n.extension + "</td><td>" + mute + "</td><td><input class='mute_status' type='checkbox' userid='" + n.userid + "' " + checked + "/></td></tr>";
                    $("#meetme_sts").append(str);
                });
                $("#meetme_sts").attr("room", ex);
            }

            function strToJson(str) {
                var json = eval('(' + str + ')');
                return json;
            }
            $(function () {
                ajaxPagination(1);
                if (window.location.href.indexOf("#") > 0) {
                    page = window.location.href.split("#").pop();
                } else {
                    page = 1;
                }
                $(".mute_status").live("click", function () {
                    var mute_status = $(this);
                    if ($(this).attr("checked") == "checked") {
                        var confno = $(this).parent().parent().parent().attr("room");
                        $.get("/api/meetingrooms/control/mute/" + confno + "/" + $(this).attr("userid"), function (result) {
                            if (result.state == 0) {
                                mute_status.parent().prev().html("<?php echo $lang[$_COOKIE['systec_lang']]['mute']; ?>");
                            }
                        }, "json");
                    } else {
                        var confno = $(this).parent().parent().parent().attr("room");
                        $.get("/api/meetingrooms/control/unmute/" + confno + "/" + $(this).attr("userid"), function (result) {
                            if (result.state == 0) {
                                mute_status.parent().prev().html("<?php echo $lang[$_COOKIE['systec_lang']]['unmute']; ?>");
                            }

                        }, "json");
                    }
                });

                $("#close1").click(function(){
                    window.location.reload();//刷新当前页面.
                });

                $("#close2").click(function(){
                    window.location.reload();//刷新当前页面.
                });

            });



            function ajaxPagination(page) {
                $.get("/api/meetingrooms/status/" + page + "/20", function (result) {
                    var str = "";
                    var pagination = "";
                    $.each(result.meetingrooms, function (i, n) {
                        str += "<tr>";
                        var ex = JSON.stringify(n.extensions);
                        str += "<td>" + n.room_extension + "</td><td align='center' valign='middle'>" + n.count + "</td><td align='center' valign='middle'><button id=" + n.room_extension + " type='button' class='btn btn-default' data-toggle='modal' data-target='#readmore' data='" + ex + "' onclick='read_more(\"" + n.room_extension + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['readmore']; ?></button></td>";
                        str += "</tr>";
                    });
                    $("#meetingroom_status").html(str);
                    getPagiation(result.total_count,$(".pagination"));
                }, "json");
            }
        </script>
        <!-- nice scroll -->
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/jquery.scrollTo.min.js"></script>
        <script src="/js/jquery.nicescroll.js" type="text/javascript"></script>
        <script src="/js/scripts.js"></script>
    </body>
</html>
