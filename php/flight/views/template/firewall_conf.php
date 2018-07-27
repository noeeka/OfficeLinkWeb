<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $lang[$_COOKIE['systec_lang']]['firewallconf']; ?></title>
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
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['firewallconf']; ?></li>	  	
                            </ol>
                        </div>
                    </div>
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add_firewall">
                        <?php echo $lang[$_COOKIE['systec_lang']]['addfirewall']; ?>
                    </button>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>
                                </th>
                                <th>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['ip']; ?>
                                </th>
                                <th>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['port']; ?>
                                </th>
                                <th>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['protocol']; ?>
                                </th>
                                <th>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['action']; ?>
                                </th>
                                <th>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="firewalls">
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
        <div class="modal fade" id="add_firewall" tabindex="-1" role="dialog"  aria-hidden="true">
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
                            <?php echo $lang[$_COOKIE['systec_lang']]['addfirewall']; ?>
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
                                    <td><?php echo $lang[$_COOKIE['systec_lang']]['ip']; ?></td>
                                    <td><input id="ip" name="ip" class="input-small" type="text"></td>
                                </tr>

                                <tr>
                                    <td><?php echo $lang[$_COOKIE['systec_lang']]['port']; ?></td>
                                    <td><input id="port" name="port" class="input-small" type="text"></td>
                                </tr>

                                <tr>
                                    <td><?php echo $lang[$_COOKIE['systec_lang']]['protocol']; ?></td>
                                    <td><input id="protocol" name="protocol" class="input-small" type="text"></td>
                                </tr>

                                <tr>
                                    <td><?php echo $lang[$_COOKIE['systec_lang']]['action']; ?></td>
                                    <td><input id="action" name="action" class="input-small" type="text"></td>
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


        <div class="modal fade" id="edit_firewall" tabindex="-1" role="dialog"  aria-hidden="true">
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
                            <?php echo $lang[$_COOKIE['systec_lang']]['editfirewall']; ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <table>
                                <tr>
                                    <td><?php echo $lang[$_COOKIE['systec_lang']]['name']; ?></td>
                                    <td><input id="edit_name" name="edit_name" class="input-mini" type="text"></td>
                                </tr>

                                <tr>
                                    <td><?php echo $lang[$_COOKIE['systec_lang']]['ip']; ?></td>
                                    <td><input id="edit_ip" name="edit_ip" class="input-small" type="text"></td>
                                </tr>

                                <tr>
                                    <td><?php echo $lang[$_COOKIE['systec_lang']]['port']; ?></td>
                                    <td><input id="edit_port" name="edit_port" class="input-small" type="text"></td>
                                </tr>

                                <tr>
                                    <td><?php echo $lang[$_COOKIE['systec_lang']]['protocol']; ?></td>
                                    <td><input id="edit_protocol" name="edit_protocol" class="input-small" type="text"></td>
                                </tr>

                                <tr>
                                    <td><?php echo $lang[$_COOKIE['systec_lang']]['action']; ?></td>
                                    <td><input id="edit_action" name="edit_action" class="input-small" type="text"></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <?php echo $lang[$_COOKIE['systec_lang']]['cancel']; ?>
                        </button>
                        <button type="button" class="btn btn-primary" id="edit_submit">
                            <?php echo $lang[$_COOKIE['systec_lang']]['update']; ?>
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
<!-- jquery knob 
<script src="/assets/jquery-knob/js/jquery.knob.js"></script>-->
<script src="/js/scripts.js"></script>
<script>
    $(function () {
        ajaxPagination(1);
        //添加保存
        $("#add_submit").click(function () {

            var name = $("#name").val();
            var ip = $("#ip").val();
            var port = $("#port").val();
            var protocol = $("#protocol").val();
            var action = $("#action").val();
            //添加验证服务，暂缺
            $.post("/api/firewall/filters/add/", {"name": name, "ip": ip, "port": port, "proto": protocol, "action": action}, function (result) {
                if (result.state == 0) {
                    window.location.reload();
                }
            }, "json");
        });

        $("#edit_submit").on("click", function () {
            var name = $("#edit_name").val();
            var ip = $("#edit_ip").val();
            var port = $("#edit_port").val();
            var protocol = $("#edit_protocol").val();
            var action = $("#edit_action").val();
            $.post("/api/firewall/filters/update/", {"name": name, "ip": ip, "port": port, "proto": protocol, "action": action}, function (result) {
                if (result.state == 0) {
                    window.location.reload();//刷新当前页面.
                }
            }, "json");
        });
    });

    function ShowEditPanel(uid) {
        $('#edit_firewall').on('show.bs.modal',
                function () {
                    $.post("/api/firewall/filters/info", {"name": uid},
                            function (data) {
                                $("#edit_name").val(data.name);
                                $("#edit_ip").val(data.ip);
                                $("#edit_port").val(data.port);
                                $("#edit_protocol").val(data.proto);
                                $("#edit_action").val(data.action);
                            }, 'json');
                });
    }

    function ajaxPagination(page) {
        $.get("/api/firewall/filters/" + page + "/10", function (result) {
            var str = "";
            var pagination = "";
            $.each(result.filters, function (k, n) {
                str += "<tr>";
                str += "<td>" + n.name + "</td><td>" + n.ip + "</td><td>" + n.port + "</td><td>" + n.proto + "</td><td>" + n.action + "</td><td><div class='btn-group'><button type='button' class='btn btn-default' data-toggle='modal' data-target='#edit_firewall' onclick='ShowEditPanel(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['update']; ?></button><button type='button' class='btn btn-default' data-toggle='modal' data-target='#del_com' onclick='Delete(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button></div></td>";
                str += "</tr>";
            });
            $("#firewalls").html(str);
            pagination = '<li><a href="#">&laquo;</a></li>';
            for (i = 1; i <= Math.ceil(result.total_count / 10); i++) {
                pagination += '<li><a href="#" onclick="ajaxPagination(' + i + ')">' + i + '</a></li>';
            }
            pagination += '<li><a href="#">&raquo;</a></li>';
            $(".pagination").html(pagination);
        }, "json");
    }

    function strToJson(str) {
        var json = eval('(' + str + ')');
        return json;
    }
</script>


<!--添加删除服务-->
<div class="modal fade bs-example-modal-sm" id="del_com" tabindex="-1" role="dialog" aria-labelledby="del_comLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4>确定删除吗</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_del();">取消</button>
                <button type="button" class="btn btn-danger" id="confirm_del_btn" filed="" onclick="confirm_del();">删除</button>
            </div>
        </div>
    </div>
</div>
<script>
    function Delete(uid) {
        $("#del_com").addClass("in");
        $("#del_com").show();
        $("#confirm_del_btn").attr("filed", uid);
    }

    function cancel_del() {
        $("#del_com").hide();
    }
    function confirm_del() {
        $.post("/api/firewall/filters/delete/", {name: $("#confirm_del_btn").attr("filed")}, function (result) {
            if (result.state == 0) {
                $.get("/api/conf/reload", function (result) {}, "json");
                $("#del_com").hide();
                $(".modal-backdrop.in").hide();
                var trList = $("#firewalls").children("tr");
                for (var i = 0; i < trList.length; i++) {
                    var tdArr = trList.eq(i).find("td");
                    for (var j = 0; j < tdArr.length; j++) {
                        if (tdArr[j].innerHTML == $("#confirm_del_btn").attr("filed")) {
                            trList.eq(i).remove();
                        }
                    }
                }
            }
        }, "json");
    }
</script>
