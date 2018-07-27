<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="James Chen">
    <title><?php echo $lang[$_COOKIE['systec_lang']]['outroutersetting']; ?></title>
    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/widgets.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/style-responsive.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="/css/tooltipster.bundle.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-shadow.min.css"/>
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
                        <li><?php echo $lang[$_COOKIE['systec_lang']]['outroutersetting']; ?></li>
                    </ol>
                </div>
            </div>
            <?php if($couldadd==true){?>
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#AddOutrouter">
                <?php echo $lang[$_COOKIE['systec_lang']]['addoutrouter']; ?>
            </button>
            <?php } ?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>
                        <?php echo $lang[$_COOKIE['systec_lang']]['router_name']; ?>
                    </td>
                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['rule']; ?>
                    </td>
                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['provider_name']; ?>
                    </td>
                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['filters']; ?>
                    </td>
                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?>
                    </td>
                </tr>
                </thead>
                <tbody id="routers_conf">
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
<div class="modal fade" id="AddOutrouter" tabindex="-1" role="dialog" aria-labelledby="AddOutrouterLabel"
     aria-hidden="true">
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
                    <?php echo $lang[$_COOKIE['systec_lang']]['addoutrouter']; ?>
                </h4>
            </div>
            <div class="modal-body">
                <table cellpadding="5">
                    <tr>
                        <td>
                            <input style="display: none" type="text"/>
                            <input style="display: none" type="password"/>
                            <?php echo $lang[$_COOKIE['systec_lang']]['router_name']; ?>
                        </td>
                        <td>
                            <input id="router_name" name="router_name"
                                   placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['router_name']; ?>"
                                   class="input-mini" type="text" autocomplete="off">
                            <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_router_name_content"
                                 style="padding-bottom:4px;"/>
                            <div id="tpl_tips_extension" style="display: none;">
                                <div id="tips_router_name_content">
                                    <p style="text-align:left;">
                                        <?php echo $lang[$_COOKIE['systec_lang']]['tips_call-route_name_content']; ?>
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <input style="display: none" type="text"/>
                            <input style="display: none" type="password"/>
                            <?php echo $lang[$_COOKIE['systec_lang']]['rule']; ?>
                        </td>
                        <td>
                            <input id="router_rule" name="router_rule" autocomplete="off"/>
                            <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_router_rule_content"
                                 style="padding-bottom:4px;"/>
                            <div id="tpl_tips_extension" style="display: none;">
                                <div id="tips_router_rule_content">
                                    <p style="text-align:left;">
                                        <?php echo $lang[$_COOKIE['systec_lang']]['tips_call-route_patern_content']; ?>
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <?php echo $lang[$_COOKIE['systec_lang']]['provider_name']; ?>
                        </td>
                        <td>
                            <select id="provider_name" name="provider_name">

                            </select>
                            <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_provider_user_content"
                                 style="padding-bottom:4px;"/>
                            <div id="tpl_tips_extension" style="display: none;">
                                <div id="tips_provider_user_content">
                                    <p style="text-align:left;">
                                        <?php echo $lang[$_COOKIE['systec_lang']]['tips_provider_name_content']; ?>
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $lang[$_COOKIE['systec_lang']]['filters']; ?></td>
                        <td>
                            <select id="filter" name="filter">
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                            <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_provider_filter_content"
                                 style="padding-bottom:4px;"/>
                            <div id="tpl_tips_extension" style="display: none;">
                                <div id="tips_provider_filter_content">
                                    <p style="text-align:left;">
                                        <?php echo $lang[$_COOKIE['systec_lang']]['tips_call-route_strip_content']; ?>
                                    </p>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr>
                        <td>
                            <?php echo $lang[$_COOKIE['systec_lang']]['prepend']; ?>
                        </td>
                        <td>
                            <input id="append" name="append" type="text" autocomplete="off">
                            <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_provider_addr_content"
                                 style="padding-bottom:4px;"/>
                            <div id="tpl_tips_extension" style="display: none;">
                                <div id="tips_provider_addr_content">
                                    <p style="text-align:left;">
                                        <?php echo $lang[$_COOKIE['systec_lang']]['tips_call-route_prepend_content']; ?>
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
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
<div class="modal fade" id="EditOutrouter" tabindex="-1" role="dialog" aria-labelledby="EditOutrouterLabel"
     aria-hidden="true">
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
                    <?php echo $lang[$_COOKIE['systec_lang']]['editrouter']; ?>
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <table cellpadding="5">
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['router_name']; ?>
                            </td>
                            <td>
                                <input id="edit_router_name" name="edit_router_name"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['router_name']; ?>"
                                       type="text" disabled="true" readonly="true">
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_provider_name_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_provider_name_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_call-route_name_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>


                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['rule']; ?>
                            </td>
                            <td>
                                <input id="edit_rule" name="edit_rule" type="text">
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_provider_type_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_provider_type_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_call-route_patern_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['provider_name']; ?>
                            </td>
                            <td>
                                <select id="edit_provider_name" name="edit_provider_name">

                                </select>
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
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['filters']; ?></td>
                            <td>
                                <select id="edit_filter" name="edit_filter">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_provider_filter_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_provider_filter_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_call-route_strip_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['prepend']; ?>
                            </td>
                            <td>
                                <input id="edit_append" name="edit_append" type="text">
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_provider_addr_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_provider_addr_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_call-route_prepend_content']; ?>
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
        var providers = "";
        $.get("/api/providers/", function (result) {
            $.each(result.providers, function (name, value) {
                providers += "<option value='" + value.name + "'>" + value.name + "</option>";
            });
            $("#provider_name").html(providers);
            $("#edit_provider_name").html(providers);
        }, "json");
        $("#add_submit").click(function () {
            var router_name = $("#router_name").val();
            var router_rule = $("#router_rule").val();
            var provider_name = $("#provider_name").val();
            var filter = $("#filter").val();
            var append = $("#append").val();
            var data = {
                name: router_name,
                rule: router_rule,
                provider: provider_name,
                filter: filter,
                append: append
            };
            //添加验证
            if (is_not_null($("#router_name"), "") == false) {
                return false;
            }
            if (is_validate_length($("#router_name"), "", 20) == false) {
                return false;
            }
            if(is_validate_charactor($("#router_name"), "") == false) {
                return false;
            }

            if(is_repeat_val($("#router_name"),"/api/outrouters/checkname","name","<?php echo $lang[$_COOKIE['systec_lang']]['outrouter_name_repeat_tips']; ?>")==false){
                return false;
            }

            if (is_not_null($("#router_rule"), "") == false) {
                return false;
            }
            if(is_repeat_val($("#router_rule"),"/api/outrouters/checkrule","rule","")==false){
                return false;
            }
            if(is_validate_number($("#router_rule"),"")==false){
                return false;
            }
            if(is_validate_length($("#router_rule"),"",10)==false){
                return false;
            }

            if(is_not_null($("#filter"),"")==false){
                return false;
            }

            if(is_validate_number($("#filter"),"")==false){
                return false;
            }

            if(is_validate_length($("#filter"),"",10)==false){
                return false;
            }

            if(is_validate_number($("#append"),"")==false){
                return false;
            }

            if(is_validate_length($("#append"),"",10)==false){
                return false;
            }

            $.post("/api/outrouters/add/", data, function (result) {
                if (result.state == 0) {
                    $.get("/api/conf/reload", function (result) {
                    }, "json");
                    window.location.reload();//刷新当前页面.
                }
            }, "json");
        });


        $("#edit_submit").click(function () {
            var router_name = $("#edit_router_name").val();
            var rule = $("#edit_rule").val();
            var provider_name = $("#edit_provider_name").val();
            var filter = $("#edit_filter").val();
            var append = $("#edit_append").val();
            var data = {
                name: router_name,
                rule: rule,
                provider: provider_name,
                filter: filter,
                append: append
            };

            //添加验证
            if(is_validate_length($("#edit_router_name"),"",20)==false){
                return false;
            }
            if(is_not_null($("#edit_rule"),"")==false){
                return false;
            }
            if(is_validate_number($("#edit_rule"),"")==false){
                return false;
            }
            if(is_validate_length($("#edit_rule"),"",10)==false){
                return false;
            }

            if(is_repeat_val_by_condiftion($("#edit_router_name"),$("#edit_rule"),"/api/outrouters/checkrule","name","rule","")==false){
                return false;
            }

            if(is_not_null($("#edit_filter"),"")==false){
                return false;
            }
            if(is_validate_number($("#edit_filter"),"")==false){
                return false;
            }
            if(is_validate_length($("#edit_filter"),"",10)==false){
                return false;
            }

            if(is_validate_number($("#edit_append"),"")==false){
                return false;
            }
            if(is_validate_length($("#edit_append"),"",10)==false){
                return false;
            }
            $.post("/api/outrouters/update/", data, function (result) {
                if (result.state == 0) {
                    $.get("/api/conf/reload", function (result) {
                    }, "json");
                    window.location.reload();
                }
            }, "json");
        });
    });

    function ajaxPagination(page) {
        $.get("/api/outrouters/" + page + "/20", function (result) {
            var str = "";
            var pagination = "";
            $.each(result.outrouters, function (i, n) {
                str += "<tr>";
                str += "<td>" + n.name + "</td><td align='center' valign='middle'>" + n.rule + "</td><td align='center' valign='middle'>" + n.provider + "</td><td align='center' valign='middle'>" + n.filter + "</td><td align='center' valign='middle'><div class='btn-group'><button type='button' class='btn btn-default' data-toggle='modal' data-target='#EditOutrouter' onclick='ShowEditPanel(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['update']; ?></button><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#del_com' onclick='DeleteSip(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button></div></td>";
                str += "</tr>";
            });
            $("#routers_conf").html(str);
            getPagiation(result.total_count, $(".pagination"));
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
        $.post("/api/outrouters/info", {name: uid},
            function (data) {
                $("#edit_router_name").val(data.name);
                $("#edit_rule").val(data.rule);
                $("#edit_provider_name").val(data.provider);
                $("#edit_filter").val(data.filter);
                $("#edit_append").val(data.append);
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
        $.post("/api/outrouters/delete", {name: $("#confirm_del_btn").attr("filed")}, function (result) {
            if (result.state == 0) {
                $.get("/api/conf/reload", function (result) {
                }, "json");
                if ($("body").find("table").eq(0).find("tr").length == 2) {
                    var urls = window.location.href.split("#");
                    window.location.href = urls[0];
                } else {
                    window.location.reload();//刷新当前页面.
                }

            }
        }, "json");
    }
</script>
<!-- nice scroll -->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.scrollTo.min.js"></script>
<script src="/js/jquery.nicescroll.js" type="text/javascript"></script>
<!-- jquery knob -->
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
