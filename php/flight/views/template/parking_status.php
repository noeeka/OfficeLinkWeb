<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="James">
        <title><?php echo $lang[$_COOKIE['systec_lang']]['parkingstatus']; ?></title>
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
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['parkingstatus']; ?></li>
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
                                    <?php echo $lang[$_COOKIE['systec_lang']]['parked_extension']; ?>
                                </td>
                                <td align='center' valign='middle'>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['parking']; ?>
                                </td>
                                <td align='center' valign='middle'>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['timeout']; ?>
                                </td>
                            </tr>
                        </thead>
                        <tbody id="parkings_status">
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
            $(function () {
                $.get("/api/parkings/status/1/20", function (result) {
                    ajaxPagination(1);
                }, "json");
            });

            function ajaxPagination(page) {
                $.get("/api/parkings/status/" + page + "/20", function (result) {
                    var str = "";
                    var pagination = "";
                    $.each(result.parkings, function (i, n) {
                        str += "<tr>";
                        str += "<td>" + n.extension + "</td><td align='center' valign='middle'>" + n.parked_extension + "</td><td align='center' valign='middle'>" + n.space + "</td><td align='center' valign='middle'>" + n.timeout + "</td>";
                        str += "</tr>";
                    });
                    $("#parkings_status").html(str);
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
