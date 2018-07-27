<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="James">
        <title><?php echo $lang[$_COOKIE['systec_lang']]['providerststus']; ?></title>
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
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['providerststus']; ?></li>

                                <span style="float: right"><img style="margin-bottom: 3px;" src="/img/status_green.png"/><?php echo $lang[$_COOKIE['systec_lang']]['registered']; ?>  <img style="margin-bottom: 3px;" src="/img/status_gray.png"/> <?php echo $lang[$_COOKIE['systec_lang']]['unavailable']; ?> </span>
                            </ol>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['providername']; ?>
                                </td>
                                <td align='center' valign='middle'>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['username']; ?>
                                </td>
                                <td align='center' valign='middle'>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['address']; ?>
                                </td>
                                <td align='center' valign='middle'>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['port']; ?>
                                </td>
                                <td align='center' valign='middle'>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['status']; ?>
                                </td>
                            </tr>
                        </thead>
                        <tbody id="providers_status">
                        </tbody>
                    </table>
                </section>
            </section>
            <!--main content end-->
        </section>
        <script>
            $(function () {
                $.get("/api/providers/status/1/20", function (result) {
                    var str = "";
                    var pagination = "";
                    $.each(result.providers, function (i, n) {
                        str += "<tr>";
                        if(n.state=="105 Registered"){
                            state='<img src="/img/status_green.png">';
                        }else{
                            state='<img src="/img/status_gray.png">';
                        }
                        str += "<td>" + n.name + "</td><td align='center' valign='middle'>" + n.user + "</td><td align='center' valign='middle'>" + n.address + "</td><td align='center' valign='middle'>" + n.port + "</td><td align='center' valign='middle'>" + state + "</td>";
                        str += "</tr>";
                    });
                    $("#providers_status").html(str);
                }, "json");
            });
        </script>
        <!-- nice scroll -->
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/jquery.scrollTo.min.js"></script>
        <script src="/js/jquery.nicescroll.js" type="text/javascript"></script>
        <!-- jquery knob -->
        <script src="/js/scripts.js"></script>
    </body>
</html>
