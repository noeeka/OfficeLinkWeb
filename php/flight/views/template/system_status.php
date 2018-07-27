<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="James">
    <title><?php echo $lang[$_COOKIE['systec_lang']]['systemstatus']; ?></title>
    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="/css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="/css/widgets.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/style-responsive.css" rel="stylesheet"/>
    <script src="/js/jquery.js"></script>
    <script src="/js/languages.js"></script>
    <style>
        table {
            border-collapse: separate;
            border-spacing: 10px;
        }
    </style>
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
                        <li><?php echo $lang[$_COOKIE['systec_lang']]['systemstatus']; ?></li>
                    </ol>
                </div>
            </div>

            <table style="background-color:#ffffff" class="table" id="main">
                <tr>
                    <td><?php echo $lang[$_COOKIE['systec_lang']]['version']; ?></td>
                    <td id="version"></td>
                </tr>
                <tr>
                    <td>DNS</td>
                    <td id="dns"></td>
                </tr>
                <tr>
                    <td>
                        <?php echo $lang[$_COOKIE['systec_lang']]['systemload']; ?>
                    </td>
                    <td id="systemload">
                    </td>
                </tr>
                <tr>
                    <td><?php echo $lang[$_COOKIE['systec_lang']]['memory']; ?></td>
                    <td>
                        <div class="progress" style="margin-bottom: 0px;" id="memory">
                            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                                 aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $lang[$_COOKIE['systec_lang']]['harddisk']; ?></td>
                    <td>
                        <div class="progress" style="margin-bottom: 0px;" id="harddisk">
                            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                                 aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </section>
    </section>
    <!--main content end-->
</section>
<script>
    function percentNum(num, num2) {
        return (Math.round(num / num2 * 10000) / 100.00 + "%"); //小数点后两位百分比
    }
    $(function () {
        $.get("/api/system/info", function (n) {
            $("#version").html(n.version);
            $("#mac").html(n.mac);
            $("#ip").html(n.ip);

            var str = "";
            $.each(n.load, function (name, value) {
                str += value + "&nbsp;&nbsp;&nbsp;&nbsp;";
            });
            $("#systemload").html(str);
            //alert($("#systemload").find("tr").eq(1));
            var mems = n.mem;
            var hdd = n.disk;


            if ((getNum(hdd[1]) / getNum(hdd[0])) > 0.5) {
                $("#harddisk").find("div").addClass("progress-bar-danger");
            }
            $("#memory").find("div").css("width", percentNum(mems[1], mems[0]));
            $("#harddisk").find("div").css("width", percentNum(getNum(hdd[1]), getNum(hdd[0])));
        }, "json");
        $.get("/api/network", function (m) {
            var table = '';
            $.each(m.eth, function (k, v) {
                if(v.ip!=""){
                    table += "<tr><td>MAC:</td><td>"+v.mac+"</td></tr><tr><td>IP:</td><td>" + v.ip + "</td></tr><tr><td><?php echo $lang[$_COOKIE['systec_lang']]['gateway']; ?></td><td>" + v.gateway + "</td></tr><tr><td><?php echo $lang[$_COOKIE['systec_lang']]['netmask']; ?></td><td>" + v.netmask + "</td></tr>";

                }
 });
            $("#main").find("tr").eq(0).after(table);
            $.each(m.dns, function (name, value) {
                $("#dns").append("<p>" + value + "</p>");
            });

        }, "json");
    });

    function getNum(text) {
        var value = text.replace(/[^0-9]/ig, "");
        return value;
    }

</script>

<!-- nice scroll -->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.scrollTo.min.js"></script>
<script src="/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="/js/scripts.js"></script>
</body>
</html>
