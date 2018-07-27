<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang[$_COOKIE['systec_lang']]['userconf']; ?></title>
    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/widgets.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/style-responsive.css" rel="stylesheet"/>

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
                        <li><?php echo $lang[$_COOKIE['systec_lang']]['userconf']; ?></li>
                    </ol>
                </div>
            </div>
            <?php if($couldadd==true){?>
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add_user">
                <?php echo $lang[$_COOKIE['systec_lang']]['adduser']; ?>
            </button>
            <?php } ?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>
                        <?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>
                    </td>

                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['accesslist']; ?>
                    </td>
                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?>
                    </td>
                </tr>
                </thead>
                <tbody id="users">
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
<div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">
                                &times;
                            </span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">
                    <?php echo $lang[$_COOKIE['systec_lang']]['adduser']; ?>
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <table>
                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['name']; ?></td>
                            <td>
                                <input style="display: none" type="text" />
                                <input style="display: none" type="password"/>
                                <input id="name" name="name" class="input-mini" type="text" autocomplete="false">
                            </td>
                        </tr>

                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['accesslist']; ?></td>
                            <td>
                                <select id="accesslist" name="accesslist">
                                    <option value="api"><?php echo $lang[$_COOKIE['systec_lang']]['loguser']; ?></option>
                                    <option value="gui"><?php echo $lang[$_COOKIE['systec_lang']]['administrator']; ?></option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['password']; ?></td>
                            <td><input id="password" name="password" class="input-small" type="password"></td>
                        </tr>

                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['confirm']; ?><?php echo $lang[$_COOKIE['systec_lang']]['password']; ?></td>
                            <td><input id="con_password" name="con_password" class="input-small" type="password"></td>
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


<div class="modal fade" id="edit_user" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <?php echo $lang[$_COOKIE['systec_lang']]['edituser']; ?>
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <table>
                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['name']; ?></td>
                            <td><input id="edit_name" name="edit_name" class="input-mini" type="text"
                                       readonly="readonly" disabled="disabled"></td>
                        </tr>

                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['accesslist']; ?></td>
                            <td>
                                <select id="edit_accesslist" name="edit_accesslist">
                                    <option value="api"><?php echo $lang[$_COOKIE['systec_lang']]['loguser']; ?></option>
                                    <option value="gui"><?php echo $lang[$_COOKIE['systec_lang']]['administrator']; ?></option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['password']; ?></td>
                            <td><input id="edit_password" name="edit_password" class="input-small" type="password"></td>
                        </tr>

                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['confirm']; ?><?php echo $lang[$_COOKIE['systec_lang']]['password']; ?></td>
                            <td><input id="con_edit_password" name="con_edit_password" class="input-small"
                                       type="password"></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?php echo $lang[$_COOKIE['systec_lang']]['cancel']; ?>
                </button>
                <button type="button" class="btn btn-primary" id="edit_submit">
                    <?php echo $lang[$_COOKIE['systec_lang']]['save']; ?>
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
        if (window.location.href.indexOf("#") > 0) {
            page = window.location.href.split("#").pop();
        } else {
            page = 1;
        }
        ajaxPagination(page);
        //添加保存
        $("#add_submit").click(function () {
            if(is_not_null($("#name"),"")==false){
                return false;
            }

            if(is_validate_charactor($("#name"),"")==false){
                return false;
            }
            if(is_validate_length($("#name"),"",20)==false){
                return false;
            }

            if(is_validate_length($("#password"),"",20)==false){
                return false;
            }
            if(is_not_null($("#password"),"")==false){
                return false;
            }

            if(is_validate_length($("#con_password"),"",20)==false){
                return false;
            }
            if(is_not_null($("#con_password"),"")==false){
                return false;
            }

            var accesslist = $("#accesslist").val();
            var password = $("#password").val();

            if(is_repeat_val($("#name"),"/api/users/checkname","username","<?php echo $lang[$_COOKIE['systec_lang']]['user_repeat_tips']; ?>")==false){
                return false;
            }


            if ($("#password").val() != $("#con_password").val()) {
                $("#password").css("border-color", "red");
                $("#password").focus();
                $("#password").val("");
                $("#password").attr("placeholder", "<?php echo $lang[$_COOKIE['systec_lang']]['user_password_tips']; ?>");
                return false;
            } else {
                $("#password").removeAttr("style");
            }
            $.post("/api/users/add/", {name: $("#name").val(), permits: accesslist, password: password}, function (result) {
                if (result.state == 0) {
                    window.location.reload();
                }
            }, "json");
        });

        $("#edit_submit").on("click", function () {
            var name = $("#edit_name").val();
            var accesslist = $("#edit_accesslist").val();
            var password = $("#edit_password").val();
            if(is_validate_length($("#edit_password"),"",20)==false){
                return false;
            }
            if(is_not_null($("#edit_password"),"")==false){
                return false;
            }

            if ($("#edit_password").val() != $("#con_edit_password").val()) {
                $("#edit_password").css("border-color", "red");
                $("#edit_password").focus();
                return false;
            } else {
                $("#edit_password").removeAttr("style");
            }

            $.post("/api/users/update/", {
                "name": name,
                "permits": accesslist,
                "password": password
            }, function (result) {
                if (result.state == 0) {
                    window.location.reload();//刷新当前页面.
                }
            }, "json");
        });
    });

    function ShowEditPanel(uid) {
        $('#edit_user').show();
        $("#edit_accesslist").val("");
        $.post("/api/users/info", {"name": uid}, function (data) {
            if(data.permits.indexOf("gui") >= 0){
                $("#edit_accesslist").val("gui");
            }else{
                $("#edit_accesslist").val("api");
            }

            if(data.permits.indexOf("gui") >= 0){
                $("#edit_accesslist").attr("disabled",true)
            }else{
                $("#edit_accesslist").attr("disabled",false)
            }
            $("#edit_name").val(data.name);
            $("#edit_password").val(data.password);
            $("#con_edit_password").val(data.password);
        }, 'json');
    }


    function ajaxPagination(page) {
        $.get("/api/users/" + page + "/20", function (result) {
            var str = "";
            var pagination = "";
            $.each(result.users, function (k, n) {
                str += "<tr>";
                if (n.permits.indexOf("api") >= 0) {
                    var perm = "<?php echo $lang[$_COOKIE['systec_lang']]['loguser']; ?>"
                } else if (n.permits.indexOf("gui") >= 0) {
                    var perm = "<?php echo $lang[$_COOKIE['systec_lang']]['administrator']; ?>"
                } else {
                    var perm = "用户"
                }
                if(n.name==getCookie("username")){
                    var del_flag="";
                }else{
                    var del_flag="<button type='button' class='btn btn-danger' data-toggle='modal' data-target='#del_com' onclick='Delete(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button>";
                }
                str += "<td>" + n.name + "</td><td align='center' valign='middle'>" + perm + "</td><td align='center' valign='middle'><div class='btn-group'><button type='button' class='btn btn-default' data-toggle='modal' data-target='#edit_user' onclick='ShowEditPanel(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['update']; ?></button>"+del_flag+"</div></td>";
                str += "</tr>";
            });
            $("#users").html(str);
            getPagiation(result.total_count,$(".pagination"));
        }, "json");
    }

    function strToJson(str) {
        var json = eval('(' + str + ')');
        return json;
    }
</script>

<div class="modal fade bs-example-modal-sm" id="del_com" tabindex="-1" role="dialog" aria-labelledby="del_comLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4><?php echo $lang[$_COOKIE['systec_lang']]['areusure']; ?></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_del();"><?php echo $lang[$_COOKIE['systec_lang']]['cancel']; ?></button>
                <button type="button" class="btn btn-danger" id="confirm_del_btn" filed="" onclick="confirm_del();"><?php echo $lang[$_COOKIE['systec_lang']]['confirm']; ?></button>
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
        $.post("/api/users/delete/", {name: $("#confirm_del_btn").attr("filed")}, function (result) {
            if (result.state == 0) {
                $.get("/api/conf/reload", function (result) {
                }, "json");
                if ($("body").find("table").eq(0).find("tr").length == 2) {
                    var urls = window.location.href.split("#");
                    window.location.href = urls[0];
                } else {
                    window.location.reload();
                }
            }
        }, "json");
    }
</script>
