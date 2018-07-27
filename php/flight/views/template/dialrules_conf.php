<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="James">
        <title><?php echo $lang[$_COOKIE['systec_lang']]['dialrulesetting']; ?></title>
        <!-- Bootstrap CSS -->    
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/widgets.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">
        <link href="/css/style-responsive.css" rel="stylesheet" />
        <link rel="stylesheet" href="/css/jquery.fileupload.css">
        <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/>
        <link rel="stylesheet" type="text/css" href="/css/tooltipster.bundle.min.css" />
        <link rel="stylesheet" type="text/css" href="/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-shadow.min.css" />
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
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['dialrulesetting']; ?></li>
                            </ol>
                        </div>
                    </div>
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add_dialrule">
                        <?php echo $lang[$_COOKIE['systec_lang']]['adddialrule']; ?>
                    </button>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>
                                </th>
                                <th>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['specifications']; ?>
                                </th>
                                <th>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="dialrule_conf">
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
        <!--添加拨号方案弹层-->
        <div class="modal fade" id="add_dialrule" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="width: 800px;">
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
                            <?php echo $lang[$_COOKIE['systec_lang']]['adddialrule']; ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <table>
                                <tr>
                                    <td><?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>
                                        <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_dial_rule_content" style="padding-bottom:4px;"/>
                                        <div id="tpl_tips_extension" style="display: none;">
                                            <div id="tips_dial_rule_content">
                                                <p style="text-align:left;">
                                                    <?php echo $lang[$_COOKIE['systec_lang']]['tips_dial_rule_content']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <input id="name" name="name" type="text">
                                    </td>
                                </tr>
                            </table>

                            <fieldset id="rulers">
                                <div id="legend" class="">
                                    <legend class="">
                                        <?php echo $lang[$_COOKIE['systec_lang']]['rulerlist']; ?>
                                        <button id="add_dialrule_rulers" style="position: relative;left:<?php if ($_COOKIE['systec_lang'] == "en") { ?>550px<?php } else { ?>590px<?php } ?>; margin-bottom: 5px;" type="button" class="btn btn-default"><?php echo $lang[$_COOKIE['systec_lang']]['addrulers']; ?></button>
                                    </legend>
                                </div>

                                <table id="rulers_table">
                                    <thead>
                                        <tr>
                                            <td>
                                                <?php echo $lang[$_COOKIE['systec_lang']]['rule']; ?>
                                                <div id="tpl_tips_extension" style="display: none;">
                                                    <div id="tips_dial_rule_content">
                                                        <p style="text-align:left;">
                                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_dial_rule_content']; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $lang[$_COOKIE['systec_lang']]['application']; ?>


                                            </td>
                                            <td><?php echo $lang[$_COOKIE['systec_lang']]['args']; ?>
                                                <img src="/img/tishi.png" class="tips" style="padding-bottom:4px;" data-tooltip-content="#tips_dial_rule_argument_content"/>
                                                <div id="tpl_tips_extension" style="display: none;">
                                                    <div id="tips_dial_rule_argument_content">
                                                        <p style="text-align:left;">
                                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_dial_rule_argument_content']; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo $lang[$_COOKIE['systec_lang']]['strip']; ?>
                                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_strip_content" style="padding-bottom:4px;"/>
                                                <div id="tpl_tips_extension" style="display: none;">
                                                    <div id="tips_strip_content">
                                                        <p style="text-align:left;">
                                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_strip_content']; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo $lang[$_COOKIE['systec_lang']]['prepend']; ?>
                                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_prepend_content" style="padding-bottom:4px;"/>
                                                <div id="tpl_tips_extension" style="display: none;">
                                                    <div id="tips_prepend_content">
                                                        <p style="text-align:left;">
                                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_prepend_content']; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo $lang[$_COOKIE['systec_lang']]['filters']; ?>
                                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_filter_content" style="padding-bottom:4px;"/>
                                                <div id="tpl_tips_extension" style="display: none;">
                                                    <div id="tips_filter_content">
                                                        <p style="text-align:left;">
                                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_filter_content']; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?></td>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td><input id="rule" name="rule" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['rule']; ?>" type="text" size="10"></td>
                                            <td>
                                                <select class="application" name="application" style='width:87px;'></select>
                                                <!--<input id="application" name="application" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['application']; ?>" type="text" size="10">--></td>
                                            <td><input id="arg" name="arg" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['args']; ?>" class="input-mini" type="text"></td>
                                            <td><input id="strip" name="strip" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['strip']; ?>" class="input-mini" type="text" size="4"></td>
                                            <td><input id="prepend" name="prepend" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['prepend']; ?>" size="6" class="input-mini" type="text"></td>
                                            <td><input id="filters" name="filters" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['filters']; ?>" class="input-mini" type="text"></td>
                                            <td><span class="ruler_up"><img src="/img/up_btn_b.png"/></span><span class="ruler_down"><img src="/img/down_btn_b.png"/></span><span class="ruler_del"><button class="btn btn-danger btn-xs"><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </fieldset>
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

        <!--编辑拨号方案弹层-->
        <div class="modal fade" id="edit_dialrule" tabindex="-1" aria-labelledby="edit_dialplanLabel" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="width: 800px;">
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
                            <?php echo $lang[$_COOKIE['systec_lang']]['editdialrule']; ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <table>
                                <tr>
                                    <td><?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>
                                        <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_dial_rule_content" style="padding-bottom:4px;"/>
                                        <div id="tpl_tips_extension" style="display: none;">
                                            <div id="tips_dial_rule_content">
                                                <p style="text-align:left;">
                                                    <?php echo $lang[$_COOKIE['systec_lang']]['tips_dial_rule_content']; ?>
                                                </p>
                                            </div>
                                        </div></td>
                                    <td>
                                        <input readonly="true" id="edit_name" name="edit_name" type="text">
                                    </td>
                                </tr>
                            </table>
                            <fieldset id="edit_rulers">
                                <div id="legend" class="">
                                    <legend class="">
                                        <?php echo $lang[$_COOKIE['systec_lang']]['rulerlist']; ?>
                                        <button id="add_edit_dialplan_rulers" style="position: relative;left:<?php if ($_COOKIE['systec_lang'] == "en") { ?>550px<?php } else { ?>590px<?php } ?>;margin-bottom: 5px;" type="button" class="btn btn-default"><?php echo $lang[$_COOKIE['systec_lang']]['addrulers']; ?></button>
                                    </legend>
                                </div>
                                <table>
                                    <thead>
                                        <tr>
                                            <td><?php echo $lang[$_COOKIE['systec_lang']]['rule']; ?>
                                                <div id="tpl_tips_extension" style="display: none;">
                                                    <div id="tips_dial_rule_content">
                                                        <p style="text-align:left;">
                                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_dial_rule_content']; ?>
                                                        </p>
                                                    </div>
                                                </div></td>
                                            <td><?php echo $lang[$_COOKIE['systec_lang']]['application']; ?></td>
                                            <td>
                                                <?php echo $lang[$_COOKIE['systec_lang']]['args']; ?>
                                                <img src="/img/tishi.png" class="tips" style="padding-bottom:4px;" data-tooltip-content="#tips_dial_rule_argument_content"/>
                                                <div id="tpl_tips_extension" style="display: none;">
                                                    <div id="tips_dial_rule_argument_content">
                                                        <p style="text-align:left;">
                                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_dial_rule_argument_content']; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo $lang[$_COOKIE['systec_lang']]['strip']; ?>
                                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_strip_content" style="padding-bottom:4px;"/>
                                                <div id="tpl_tips_extension" style="display: none;">
                                                    <div id="tips_strip_content">
                                                        <p style="text-align:left;">
                                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_strip_content']; ?>
                                                        </p>
                                                    </div>
                                                </div></td>
                                            <td><?php echo $lang[$_COOKIE['systec_lang']]['prepend']; ?>
                                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_prepend_content" style="padding-bottom:4px;"/>
                                                <div id="tpl_tips_extension" style="display: none;">
                                                    <div id="tips_prepend_content">
                                                        <p style="text-align:left;">
                                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_prepend_content']; ?>
                                                        </p>
                                                    </div>
                                                </div></td>
                                            <td><?php echo $lang[$_COOKIE['systec_lang']]['filters']; ?>
                                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_filter_content" style="padding-bottom:4px;"/>
                                                <div id="tpl_tips_extension" style="display: none;">
                                                    <div id="tips_filter_content">
                                                        <p style="text-align:left;">
                                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_filter_content']; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?></td>
                                        </tr>
                                    </thead>
                                    <tbody id="edit_rulers_table">


                                    </tbody>
                                </table>
                            </fieldset>
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
        <script>
            //获取json元素数量
            function JSONLength(obj) {
                var size = 0, key;
                for (key in obj) {
                    if (obj.hasOwnProperty(key))
                        size++;
                }
                return size;
            }

            $(function () {
                if(window.location.href.indexOf("#") > 0 ){
                    page=window.location.href.split("#").pop();
                }else{
                    page=1;
                }
                $.get("/api/dialrules/"+page+"/20", function (result) {
                    ajaxPagination(page);
                }, "json");





                $("#add_dialrule_rulers").click(function () {
                    $("#rulers_table").find("tbody").append('<tr><td><input id="rule" name="rule" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['rule']; ?>" type="text" size="10"></td><td><select class="application" name="application" style="width: 87px;"></select></td><td><input id="arg" name="arg" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['args']; ?>" class="input-mini" type="text"></td><td><input id="strip" name="strip" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['strip']; ?>" class="input-mini" type="text" size="4"></td><td><input id="prepend" name="prepend" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['prepend']; ?>" size="6" class="input-mini" type="text"></td><td><input id="filters" name="filters" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['filters']; ?>" class="input-mini" type="text"></td><td><span class="ruler_up"><img src="/img/up_btn_b.png"/></span><span class="ruler_down"><img src="/img/down_btn_b.png"/></span><span class="ruler_del"><button class="btn btn-danger btn-xs"><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button></span></td></tr>');
                    $.get("/js/application.json", function (result) {
                        $.each(result, function (k, v) {

                            $(".application").append("<option value='" + v.application + "'>" + v.application + "</option>");
                        });
                    }, "json");
                });

                $("#add_edit_dialplan_rulers").live("click", function () {
                    $("#edit_rulers_table").append('<tr><td><input id="edit_rule" name="edit_rule" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['rule']; ?>"type="text" size="10"></td><td><select class="application" name="edit_application" style="width:87px;"></select></td><td><input id="edit_arg" name="edit_arg" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['args']; ?>" class="input-mini" type="text"></td><td><input id="edit_strip" name="edit_strip" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['strip']; ?>" class="input-mini" type="text" size="4"></td><td><input id="edit_prepend" name="edit_prepend" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['prepend']; ?>" size="6" class="input-mini" type="text"></td><td><input id="edit_filters" name="edit_filters" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['filters']; ?>" class="input-mini" type="text"></td><td><span class="ruler_up"><img src="/img/up_btn_b.png"/></span><span class="ruler_down"><img src="/img/down_btn_b.png"/></span><span class="ruler_del"><button class="btn btn-danger btn-xs"><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button></span></td></tr>');
                    $.get("/js/application.json", function (result) {
                        $.each(result, function (k, v) {
                            $(".application").append("<option value='" + v.application + "'>" + v.application + "</option>");
                        });
                    }, "json");
                });
                $.get("/js/application.json", function (result) {
                    $.each(result, function (k, v) {
                        console.log(v);
                        $(".application").append("<option value='" + v.application + "'>" + v.application + "</option>");
                    });
                }, "json");

                $(".ruler_del").live("click", function () {
                    $(this).parent().parent().remove();
                });
                $(".ruler_up").live("click", function () {
                    $(this).parent().parent().fadeOut().fadeIn();
                    $(this).parent().parent().prev().before($(this).parent().parent());
                });
                $(".ruler_down").live("click", function () {
                    $(this).parent().parent().fadeOut().fadeIn();
                    $(this).parent().parent().next().after($(this).parent().parent());
                });
            });
            function ajaxPagination(page) {
                $.get("/api/dialrules/" + page + "/20", function (result) {
                    var str = "";
                    var pagination = "";
                    $.each(result.dialrules, function (k, n) {
                        str += "<tr>";
                        str += "<td>" + n.name + "</td><td>" + JSONLength(n.rules) + "</td><td><div class='btn-group'><button type='button' class='btn btn-default' data-toggle='modal' data-target='#edit_dialrule' onclick='ShowEditPanel(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['update']; ?></button><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#del_com' onclick='delete_dialrule(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button></div></td>";
                        str += "</tr>";
                    });
                    $("#dialrule_conf").html(str);
                    pagination = '<li><a href="#1" onclick="ajaxPagination(1)">&laquo;</a></li>';
                    for (i = 1; i <= Math.ceil(result.total_count / 20); i++) {
                        if (window.location.href.split("#").pop() == i) {
                            pagination += '<li class="active"><a href="#' + i + '" onclick="ajaxPagination(' + i + ')">' + i + '</a></li>';
                        } else {
                            pagination += '<li><a href="#' + i + '" onclick="ajaxPagination(' + i + ')">' + i + '</a></li>';
                        }
                    }
                    pagination += '<li><a href="#'+Math.ceil(result.total_count / 20)+'" onclick="ajaxPagination(' + Math.ceil(result.total_count / 20) + ')">&raquo;</a></li>';
                    $(".pagination").html(pagination);
                }, "json");
            }
        </script>
        <script>
            $(function () {
                $("#add_submit").click(function () {
                    var selectData = [];
                    $.each($("#rulers_table").find("tbody").find("tr"), function (k, v) {
                        var rule = $(v).find("td").eq(0).find("input").eq(0).val();
                        var application = $(v).find("td").eq(1).find("select").eq(0).val();
                        var args = $(v).find("td").eq(2).find("input").eq(0).val();

                        var strip = $(v).find("td").eq(3).find("input").eq(0).val();
                        var prepend = $(v).find("td").eq(4).find("input").eq(0).val();
                        var filters = $(v).find("td").eq(5).find("input").eq(0).val();
                        selectData.push({"rule": rule, "application": application, "args": args, "strip": strip, "prepend": prepend, "filters": filters});
                    });
                    $.post("/api/dialrules/add/", {name: $("#name").val(), rules: selectData}, function (result) {
                        if (result.state == 0) {
                            $.get("/api/conf/reload", function (result) {}, "json");
                            window.location.reload();//刷新当前页面.
                        }
                    }, "json");
                });
                $("#edit_submit").click(function () {
                    var name = $("#edit_name").val();
                    var selectData = [];
                    $.each($("#edit_rulers_table").find("tr"), function (k, v) {
                        var rule = $(v).find("td").find("input").eq(0).val();
                        var application = $(v).find("td").find("select").val();
                        var args = $(v).find("td").find("input").eq(1).val();
                        var strip = $(v).find("td").find("input").eq(2).val();
                        var prepend = $(v).find("td").find("input").eq(3).val();
                        var filters = $(v).find("td").find("input").eq(4).val();
                        selectData.push({"rule": rule, "application": application, "args": args, "strip": strip, "prepend": prepend, "filters": filters});
                    });
                    $.post("/api/dialrules/update/", {name: name, rules: selectData}, function (result) {
                        if (result.state == 0) {
                            $.get("/api/conf/reload", function (result) {}, "json");
                            window.location.reload();//刷新当前页面.
                        }
                    }, "json");
                });
            });
            function strToJson(str) {
                var json = eval('(' + str + ')');
                return json;
            }
        </script>
        <!--添加编辑服务-->
        <script>
            function ShowEditPanel(id) {
                $('#edit_dialrule').show();
                $.post("/api/dialrules/info/?number=" + Math.random(), {name: id}, function (data) {
                    $("#edit_name").val(data.name);
                    var str = "";
                    $.each(jQuery.parseJSON(data.rules), function (k, v) {
                        str += '<tr><td><input id="edit_rule" name="edit_rule" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['rule']; ?>" type="text" size="10" value="' + v.rule + '"></td><td><select class="application" name="edit_application" style="width:87px;"><option value="' + v.application + '">' + v.application + '</option></select></td><td><input id="edit_arg" name="edit_arg" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['args']; ?>" class="input-mini" type="text" value="' + v.args + '"></td><td><input id="edit_strip" name="edit_strip" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['strip']; ?>" type="text" size="4" value="' + v.strip + '"></td><td><input id="edit_prepend" name="edit_prepend" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['prepend']; ?>" size="6" class="input-mini" type="text" value="' + v.prepend + '"></td><td><input id="edit_filters" name="edit_filters" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['filters']; ?>" class="input-mini" type="text" value="' + v.filters + '"></td><td><span class="ruler_up"><img src="/img/up_btn_b.png"/></span><span class="ruler_down"><img src="/img/down_btn_b.png"/></span><span class="ruler_del"><button class="btn btn-danger btn-xs"><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button></span></td></tr>';
                    });
                    $.get("/js/application.json", function (result) {
                        $.each(result, function (k, v) {
                            $(".application").append("<option value='" + v.application + "'>" + v.application + "</option>");
                        });
                    }, "json");
                    $("#edit_rulers_table").html(str);
                }, 'json');
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
            function delete_dialrule(uid) {
                $("#del_com").addClass("in");
                $("#del_com").show();
                $("#confirm_del_btn").attr("filed", uid);
            }

            function cancel_del() {
                $("#del_com").hide();
            }
            function confirm_del() {
                $.post("/api/dialrules/delete", {name: $("#confirm_del_btn").attr("filed")}, function (result) {
                    if (result.state == 0) {
                        $.get("/api/conf/reload", function (result) {}, "json");
                        $("#del_com").hide();
                        $(".modal-backdrop.in").hide();
                        var trList = $("#dialrule_conf").children("tr");
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
        <!-- nice scroll -->
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/jquery.scrollTo.min.js"></script>
        <script src="/js/jquery.nicescroll.js" type="text/javascript"></script>
        <script src="/js/scripts.js"></script>
        <script type="text/javascript" src="/js/tooltipster.bundle.js"></script>
        <script>
            $(function () {
                $('.application').live("change", function () {
                    var app = $(this);

                    $.get("/js/application.json", function (result) {
                        $.each(result, function (k, v) {
                            if (app.val() == v.application) {
                                argument = v.argument;
                                app.parent().next().children().attr("placeholder", argument);
                                app.attr('title', argument);

                            }
                        });
                    }, "json");
                });

                $('.tips').tooltipster({
                    theme: 'tooltipster-shadow',
                    maxWidth: 400,
                    side: 'right'
                });

            });
        </script>
    </body>
</html>
