<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="James Chen">
    <title><?php echo $lang[$_COOKIE['systec_lang']]['providersetting']; ?></title>
    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/widgets.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/style-responsive.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="/css/tooltipster.bundle.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-shadow.min.css"/>
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
                        <li><?php echo $lang[$_COOKIE['systec_lang']]['pbx']; ?></li>
                        <li><?php echo $lang[$_COOKIE['systec_lang']]['providersetting']; ?></li>
                    </ol>
                </div>
            </div>
            <?php if ($couldadd == true) { ?>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#AddSip">
                    <?php echo $lang[$_COOKIE['systec_lang']]['addprovider']; ?>
                </button>
            <?php } ?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>
                        <?php echo $lang[$_COOKIE['systec_lang']]['provider_name']; ?>
                    </td>
                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['provider_user']; ?>
                    </td>
                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['provider_addr']; ?>
                    </td>
                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['port']; ?>
                    </td>
                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['provider_type']; ?>
                    </td>
                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?>
                    </td>
                </tr>
                </thead>
                <tbody id="extensions_conf">
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


<!--添加分机弹层-->
<div class="modal fade" id="AddSip" tabindex="-1" role="dialog" aria-labelledby="AddUserLabel" aria-hidden="true">
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
                    <?php echo $lang[$_COOKIE['systec_lang']]['addprovider']; ?>
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <table cellpadding="5">
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['provider_name']; ?>
                            </td>
                            <td>
                                <input id="provider_name" name="provider_name"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['provider_name']; ?>"
                                       class="input-mini" type="text">
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_provider_name_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_provider_name_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_provider_name_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>


                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['provider_type']; ?>
                            </td>
                            <td>
                                <select id="provider_type" name="provider_type">
                                    <option value="sip">SIP</option>
                                    <option value="pstn">PSTN</option>
                                </select>
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_provider_type_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_provider_type_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_provider_type_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['provider_user']; ?>
                            </td>
                            <td>
                                <input style="display: none" type="text"/>
                                <input style="display: none" type="password"/>
                                <input id="provider_user" name="provider_user"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['provider_user']; ?>"
                                       class="input-small" type="text">
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_provider_user_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_provider_user_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_provider_user_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['password']; ?></td>
                            <td>
                                <input id="provider_password" name="provider_password"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['password']; ?>"
                                       type="password">

                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_provider_password_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_provider_password_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_provider_password_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['provider_addr']; ?>
                            </td>
                            <td>
                                <input id="provider_addr" name="provider_addr"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['provider_addr']; ?>"
                                       class="input-small" type="text">
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_provider_addr_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_provider_addr_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_provider_addr_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['port']; ?></td>
                            <td><input id="provider_port" name="provider_port"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['port']; ?>"
                                       class="input-small" type="text">

                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_provider_port_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_provider_port_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_provider_port_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
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
<!-- 编辑分机弹层 -->
<div class="modal fade" id="EditUser" tabindex="-1" role="dialog" aria-labelledby="EditUserLabel" aria-hidden="true">
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
                    <?php echo $lang[$_COOKIE['systec_lang']]['editprovider']; ?>
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <table cellpadding="5">
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['provider_name']; ?>
                            </td>
                            <td>
                                <input id="edit_provider_name" name="edit_provider_name"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['provider_name']; ?>"
                                       type="text" disabled="disabled" readonly="readonly">
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_provider_name_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_provider_name_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_provider_name_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>


                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['provider_type']; ?>
                            </td>
                            <td>
                                <select id="edit_provider_type" name="edit_provider_type">
                                    <option value="sip">SIP</option>
                                    <option value="pstn">PSTN</option>
                                </select>
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_provider_type_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_provider_type_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_provider_type_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['provider_user']; ?>
                            </td>
                            <td>
                                <input id="edit_provider_user" name="edit_provider_user"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['provider_user']; ?>"
                                       type="text">
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_provider_user_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_provider_user_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_provider_user_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['password']; ?></td>
                            <td>
                                <input id="edit_provider_password" name="edit_provider_password"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['password']; ?>"
                                       type="password">

                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_provider_password_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_provider_password_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_provider_password_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['provider_addr']; ?>
                            </td>
                            <td>
                                <input id="edit_provider_addr" name="edit_provider_addr"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['provider_addr']; ?>"
                                       type="text">
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_provider_addr_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_provider_addr_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_provider_addr_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['port']; ?></td>
                            <td><input id="edit_provider_port" name="edit_provider_port"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['port']; ?>" type="text">
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_provider_port_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_provider_port_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_provider_port_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
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
<script>
    $(function () {
        if (window.location.href.indexOf("#") > 0) {
            page = window.location.href.split("#").pop();
        } else {
            page = 1;
        }
        ajaxPagination(page);

        $("#provider_type").change(function () {
            if ($(this).val() == "pstn") {
                $("#provider_user").attr("disabled", "disabled");
                $("#provider_password").attr("disabled", "disabled");
            } else {
                $("#provider_user").removeAttr("disabled");
                $("#provider_password").removeAttr("disabled");
            }
        });

        $("#edit_provider_type").change(function () {
            if ($(this).val() == "pstn") {
                $("#edit_provider_user").attr("disabled", "disabled");
                $("#edit_provider_password").attr("disabled", "disabled");
            } else {
                $("#edit_provider_user").removeAttr("disabled");
                $("#edit_provider_password").removeAttr("disabled");
            }
        });

        $("#dialplan").click(function () {
            $("#modal_dailplans").show();
            ajaxPaginationforDailplans(1);
        });
        $("#edit_dialplan").click(function () {
            $("#edit_modal_dailplans").show();
            ajaxPaginationforDailplans(1);
        });

        $("#add_submit").click(function () {
            if (is_repeat_val($("#provider_name"), "/api/providers/checkname", "name", "<?php echo $lang[$_COOKIE['systec_lang']]['provider_name_repeat_tips']; ?>") == false) {
                return false;
            }

            if (is_not_null($("#provider_name"), "") == false) {
                return false;
            }
            if (is_validate_length($("#provider_name"), "", 20) == false) {
                return false;
            }
            if (is_not_null($("#provider_addr"), "") == false) {
                return false;
            }
            if (is_validate_length($("#provider_addr"), "", 40) == false) {
                return false;
            }
            if (is_validate_charactor($("#provider_addr"), "") == false) {
                return false;
            }

            if (is_validate_charactor($("#provider_user"), "") == false) {
                return false;
            }

            if (is_validate_charactor($("#provider_port"), "") == false) {
                return false;
            }

            if (is_validate_number($("#provider_port"), "") == false) {
                return false;
            }
            var provider_name = $("#provider_name").val();
            var provider_user = $("#provider_user").val();
            var provider_password = $("#provider_password").val();
            var provider_addr = $("#provider_addr").val();
            var provider_port = $("#provider_port").val();
            var provider_entry = "entry";
            var provider_type = $("#provider_type").val();
            var data = {
                name: provider_name,
                user: provider_user,
                password: provider_password,
                address: provider_addr,
                port: provider_port,
                dialplan: "dialplan",
                entry: provider_entry,
                type: provider_type
            };
            //添加验证
            if ($("#provider_type").val() == "sip" && $("#provider_password").val() == "") {
                $("#provider_password").css("border-color", "red");
                $("#provider_password").focus();
                return false;
            } else {
                $("#provider_password").removeAttr("style");
            }

            if ($("#provider_type").val() == "sip" && $("#provider_user").val() == "") {
                $("#provider_user").css("border-color", "red");
                $("#provider_user").focus();
                return false;
            } else {
                $("#provider_user").removeAttr("style");
            }
            if ($("#provider_type").val() == "sip" && is_validate_length($("#provider_user"),"",20)==false) {
                $("#provider_user").css("border-color", "red");
                $("#provider_user").focus();
                return false;
            } else {
                $("#provider_user").removeAttr("style");
            }

            if ($("#provider_type").val() == "sip" && is_validate_length($("#provider_password"),"",20)==false) {
                $("#provider_password").css("border-color", "red");
                $("#provider_password").focus();
                return false;
            } else {
                $("#provider_password").removeAttr("style");
            }


            $.post("/api/providers/add/", data, function (result) {
                if (result.state == 0) {
                    $.get("/api/conf/reload", function (result) {
                    }, "json");
                    window.location.reload();
                }
            }, "json");
        });


        $("#edit_submit").click(function () {
            var provider_name = $("#edit_provider_name").val();
            var provider_user = $("#edit_provider_user").val();
            var provider_password = $("#edit_provider_password").val();
            var provider_addr = $("#edit_provider_addr").val();
            var provider_port = $("#edit_provider_port").val();
            var provider_type = $("#edit_provider_type").val();
            var provider_entry = "entry";
            var data = {
                name: provider_name,
                user: provider_user,
                password: provider_password,
                address: provider_addr,
                port: provider_port,
                dialplan: "dialplan",
                entry: provider_entry,
                type: provider_type
            };

            if (is_not_null($("#edit_provider_addr"), "") == false) {
                return false;
            }
            if (is_validate_length($("#edit_provider_addr"), "", 40) == false) {
                return false;
            }

            if(is_validate_charactor($("#edit_provider_addr"), "") == false) {
                return false;
            }

            if(is_validate_charactor($("#edit_provider_port"), "") == false) {
                return false;
            }

            if (is_validate_length($("#edit_provider_name"), "", 20) == false) {
                return false;
            }

            if (is_validate_number($("#edit_provider_port"), "") == false) {
                return false;
            }

            if (is_validate_charactor($("#edit_provider_user"), "") == false) {
                return false;
            }

            //添加验证
            if ($("#edit_provider_type").val() == "sip" && $("#edit_provider_password").val() == "") {
                $("#edit_provider_password").css("border-color", "red");
                $("#edit_provider_password").focus();
                return false;
            } else {
                $("#edit_provider_password").removeAttr("style");
            }

            if ($("#edit_provider_type").val() == "sip" && $("#edit_provider_user").val() == "") {
                $("#edit_provider_user").css("border-color", "red");
                $("#edit_provider_user").focus();
                return false;
            } else {
                $("#edit_provider_user").removeAttr("style");
            }

            if ($("#provider_type").val() == "sip" && is_validate_length($("#edit_provider_user"),"",20)==false) {
                $("#edit_provider_user").css("border-color", "red");
                $("#edit_provider_user").focus();
                return false;
            } else {
                $("#edit_provider_user").removeAttr("style");
            }

            if ($("#provider_type").val() == "sip" && is_validate_length($("#edit_provider_password"),"",20)==false) {
                $("#edit_provider_password").css("border-color", "red");
                $("#edit_provider_password").focus();
                return false;
            } else {
                $("#edit_provider_password").removeAttr("style");
            }

            $.post("/api/providers/update/", data, function (result) {
                if (result.state == 0) {
                    $.get("/api/conf/reload", function (result) {
                    }, "json");
                    window.location.reload();
                }
            }, "json");
        });
    });

    function ajaxPagination(page) {
        $.get("/api/providers/" + page + "/20", function (result) {
            var str = "";
            var pagination = "";
            $.each(result.providers, function (i, n) {
                str += "<tr>";
                if (n.type == "sip") {
                    var type = "SIP";
                } else {
                    var type = "PSTN";
                }
                str += "<td>" + n.name + "</td><td align='center' valign='middle'>" + n.user + "</td><td align='center' valign='middle'>" + n.address + "</td><td align='center' valign='middle'>" + n.port + "</td><td align='center' valign='middle'>" + type + "</td><td align='center' valign='middle'><div class='btn-group'><button type='button' class='btn btn-default' data-toggle='modal' data-target='#EditUser' onclick='ShowEditPanel(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['update']; ?></button><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#del_com' onclick='DeleteSip(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button></div></td>";
                str += "</tr>";
            });
            $("#extensions_conf").html(str);
        }, "json");
    }

    function strToJson(str) {
        var json = eval('(' + str + ')');
        return json;
    }
</script>

<!--添加编辑服务-->
<script>
    function ShowEditPanel(uid) {
        $('#EditUser').show();
        $.post("/api/providers/info", {name: uid},
            function (data) {
                $("#edit_provider_name").val(data.name);
                $("#edit_provider_user").val(data.user);
                $("#edit_provider_password").val(data.password);
                $("#edit_provider_addr").val(data.address);
                $("#edit_provider_port").val(data.port);
                $("#edit_dialplan").val(data.dialplan);
                $("#edit_provider_entry").val(data.entry);
                $("#edit_provider_type").val(data.type);
                if (data.type == "pstn") {
                    $("#edit_provider_user").attr("disabled", "disabled");
                    $("#edit_provider_password").attr("disabled", "disabled");
                }
            }, 'json');
    }
</script>

<!--添加删除服务-->
<div class="modal fade bs-example-modal-sm" id="del_com" tabindex="-1" role="dialog" aria-labelledby="del_comLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4><?php echo $lang[$_COOKIE['systec_lang']]['areusure']; ?></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_del();"><?php echo $lang[$_COOKIE['systec_lang']]['cancel']; ?></button>
                <button type="button" class="btn btn-danger" id="confirm_del_btn" filed="" onclick="confirm_del();"><?php echo $lang[$_COOKIE['systec_lang']]['confirm']; ?>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function DeleteSip(uid) {
        $("#del_com").addClass("in");
        $("#del_com").show();
        $("#confirm_del_btn").attr("filed", uid);
    }

    function cancel_del() {
        $("#del_com").hide();
    }
    function confirm_del() {
        $.post("/api/providers/delete", {name: $("#confirm_del_btn").attr("filed")}, function (result) {
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
<!-- nice scroll -->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.scrollTo.min.js"></script>
<script src="/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="/js/scripts.js"></script>
<script type="text/javascript" src="/js/tooltipster.bundle.js"></script>
<script>
    $(function () {
        $('.tips').tooltipster({
            theme: 'tooltipster-shadow',
            maxWidth: 400,
            side: 'right'
        });
    });
</script>
</body>
</html>
