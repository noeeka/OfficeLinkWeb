<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $lang[$_COOKIE['systec_lang']]['backups']; ?></title>
        <!-- Bootstrap CSS -->    
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/widgets.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">
        <link href="/css/style-responsive.css" rel="stylesheet" />
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
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['backups']; ?></li>
                            </ol>
                        </div>
                    </div>
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add_backups">
                        <?php echo $lang[$_COOKIE['systec_lang']]['addbackups']; ?>
                    </button>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>
                                </th>
                                <th>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['remark']; ?>
                                </th>
                                <th>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['datetime']; ?>
                                </th>
                                <th>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="backups_conf">
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

        <!--添加备份弹层-->
        <div class="modal fade" id="add_backups" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">
                                &times;
                            </span>
                            <span class="sr-only">
                                Close
                            </span>
                        </button>
                        <h4 class="modal-title">
                            <?php echo $lang[$_COOKIE['systec_lang']]['addbackups']; ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <table>
                                <tr>
                                    <td><?php echo $lang[$_COOKIE['systec_lang']]['name']; ?></td>
                                    <td><input id="name" name="name" class="input-mini" type="text"></td>
                                </tr>

                                <tr>
                                    <td><?php echo $lang[$_COOKIE['systec_lang']]['remark']; ?></td>
                                    <td><input id="remark" name="remark" class="input-small" type="text"></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <?php echo $lang[$_COOKIE['systec_lang']]['cancel']; ?>
                        </button>
                        <button type="button" class="btn btn-primary" id="add_submit">
                            <?php echo $lang[$_COOKIE['systec_lang']]['create']; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>        
    </body>
</html>

<!-- nice scroll -->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.scrollTo.min.js"></script>
<script src="/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="/js/scripts.js"></script>
<script>
    $(function () {
        //添加保存
        $("#add_submit").click(function () {

            var name = $("#name").val();
            var remark = $("#remark").val();
            //添加验证服务，暂缺
            $.post("/api/backups/create/", {"name": name, "remark": remark}, function (result) {
                if (result.state == 0) {
                    window.location.reload();
                }
            }, "json");
        });
    });

    function ShowEditPanel(uid) {
        $('#AddMeeting').on('show.bs.modal',
                function () {
                    $.post("/api/meetingrooms/info", {"extension": uid},
                            function (data) {

                                $("#extension").val(data.extension);
                                $("#user_pin").val(data.user_pin);
                                $("#admin_pin").val(data.admin_pin);

                            }, 'json');
                });
    }

    function Delete(uid) {
        if (confirm("确定删除吗")) {
            $.post("/api/backups/delete/", {name: uid},
                    function (result) {
                        if (result.state == 0) {
                            window.location.reload();
                        }
                    }, "json");
        }
    }


    function strToJson(str) {
        var json = eval('(' + str + ')');
        return json;
    }
</script>
