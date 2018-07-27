<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="James">
        <title><?php echo $lang[$_COOKIE['systec_lang']]['extensionststus']; ?></title>
        <!-- Bootstrap CSS -->    
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <!-- bootstrap theme -->
        <link href="/css/bootstrap-theme.css" rel="stylesheet">
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
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['extensionststus']; ?></li>
                                <span style="float: right"><img style="margin-bottom: 3px;" src="/img/status_green.png"/><?php echo $lang[$_COOKIE['systec_lang']]['idel']; ?> <img style="margin-bottom: 3px;" src="/img/status_orange.png"/> <?php echo $lang[$_COOKIE['systec_lang']]['ringing']; ?> <img style="margin-bottom: 3px;" src="/img/status_red.png"/> <?php echo $lang[$_COOKIE['systec_lang']]['busy']; ?> <img style="margin-bottom: 3px;" src="/img/status_gray.png"/> <?php echo $lang[$_COOKIE['systec_lang']]['unavailable']; ?> </span>
                            </ol>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr style="color: #688a7e;">
                                <td>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?>
                                </td>
                                <td align='center' valign='middle'>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['nickname']; ?>
                                </td>
                                <td align='center' valign='middle'>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['extensionststus']; ?>
                                </td>
                                <td align='center' valign='middle'>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['voicemailststus']; ?>
                                </td>
                            </tr>
                        </thead>
                        <tbody id="extensions_status">
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
        <script>
            ajaxPagination(1);
            $(function () {
                if (window.location.href.indexOf("#") > 0) {
                    page = window.location.href.split("#").pop();
                } else {
                    page = 1;
                }
            });

            function ajaxPagination(page) {
                $.ajax({
                    url: "/api/extensions/status/" + page + "/20",
                    type: "GET",
                    beforeSend: function () {
                        $("#extensions_status").html("<img src='/img/ajax-loader.gif'/>");
                    },
                    success: function (result) {
                        var str = "";
                        var pagination = "";
                        $.each(result.extensions, function (i, n) {
                            if (n.state == "Idle") {
                                var state = '<img src="/img/status_green.png">';
                            } else if (n.state == "Unavailable") {
                                var state = '<img src="/img/status_gray.png">';
                            } else if (n.state == "InUse") {
                                var state = '<img src="/img/status_red.png">';
                            } else {
                                var state = '<img src="/img/status_orange.png">';
                            }
                            str += "<tr>";
                            str += "<td>" + n.extension + "</td><td align='center' valign='middle'>" + n.nickname + "</td><td align='center' valign='middle'>" + state + "</td><td align='center' valign='middle'>" + n.unread_msg + "/" + n.read_msg + "</td>";
                            str += "</tr>";
                        });
                        $("#extensions_status").html(str);
                        getPagiation(result.total_count,$(".pagination"));
                    },
                    dataType: "json"
                });
            }
        </script>

        <!-- nice scroll -->
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/jquery.scrollTo.min.js"></script>
        <script src="/js/jquery.nicescroll.js" type="text/javascript"></script>
        <script src="/js/scripts.js"></script>
    </body>
</html>
