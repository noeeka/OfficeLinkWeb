<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="James">
    <title><?php echo $lang[$_COOKIE['systec_lang']]['dialplansetting']; ?></title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/widgets.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/style-responsive.css" rel="stylesheet"/>

    <link rel="stylesheet" href="/css/jquery.fileupload.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/>
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
                        <li><?php echo $lang[$_COOKIE['systec_lang']]['dialplansetting']; ?></li>
                    </ol>
                </div>
            </div>
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add_dialplan">
                <?php echo $lang[$_COOKIE['systec_lang']]['adddialplan']; ?>
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
                <tbody id="dialplan_conf">
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
<div class="modal fade" id="add_dialplan" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <?php echo $lang[$_COOKIE['systec_lang']]['adddialplan']; ?>
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <table cellpadding="5">
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>
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
                            <td>
                                <input id="name" name="name"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>" type="text">
                            </td>
                        </tr>
                    </table>

                    <fieldset id="rulers">
                        <div id="legend" class="">
                            <legend class=""><?php echo $lang[$_COOKIE['systec_lang']]['rulerlist']; ?>
                                <button id="add_dialplan_rulers" style="margin-left: 325px;margin-bottom: 5px;"
                                        type="button"
                                        class="btn btn-default"><?php echo $lang[$_COOKIE['systec_lang']]['addrulers']; ?></button>
                            </legend>
                        </div>
                        <div id="modal_rulers"
                             style="display: none; z-index: 50; width: 550px; height: 110px;margin-bottom: 150px;margin-top: -20px;">
                            <div class="modal-header">
                                <button type="button" class="close" onclick="close_rulers();">
                                            <span aria-hidden="true">
                                                &times;
                                            </span>
                                    <span class="sr-only">
                                                Close
                                            </span>
                                </button>
                                <h4 class="modal-title">
                                    <?php echo $lang[$_COOKIE['systec_lang']]['rulechoose']; ?>
                                </h4>
                            </div>

                            <table class="rulers_table" width="100%" cellpadding="5"></table>


                            <nav>
                                <ul id="pagination_rulers" class="pagination">
                                </ul>
                            </nav>
                        </div>
                    </fieldset>

                    <table width="100%" cellpadding="5" style="margin-top: -20px">
                        <thead>
                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['rule']; ?></td>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?></td>
                        </tr>
                        </thead>
                        <tbody id="show_rulers_table"></tbody>
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

<!--编辑拨号方案弹层-->
<div class="modal fade" id="edit_dialplan" tabindex="-1" aria-labelledby="edit_dialplanLabel" role="dialog"
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
                    <?php echo $lang[$_COOKIE['systec_lang']]['editdialplan']; ?>
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <table>
                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['name']; ?></td>
                            <td>
                                <input readonly="true" id="edit_name" name="edit_name" placeholder="Duial" type="text">
                            </td>
                        </tr>
                    </table>

                    <fieldset id="edit_rulers">
                        <div id="legend" class="">
                            <legend class="">
                                <?php echo $lang[$_COOKIE['systec_lang']]['rulerlist']; ?>
                                <button id="add_edit_dialplan_rulers" style="margin-left: 325px;margin-bottom: 5px;"
                                        type="button"
                                        class="btn btn-default"><?php echo $lang[$_COOKIE['systec_lang']]['addrulers']; ?></button>
                            </legend>
                        </div>

                        <div id="edit_modal_rulers"
                             style="display:none;z-index: 50; width: 550px; height: 110px;margin-bottom: 150px;margin-top: -20px;">
                            <div class="modal-header">
                                <button type="button" class="close" onclick="close_rulers();">
                                            <span aria-hidden="true">
                                                &times;
                                            </span>
                                    <span class="sr-only">
                                                Close
                                            </span>
                                </button>
                                <h4 class="modal-title">
                                    <?php echo $lang[$_COOKIE['systec_lang']]['rulechoose']; ?>
                                </h4>
                            </div>
                            <table class="rulers_table" class="rulers_table" width="100%" cellpadding="5"></table>

                            <nav>
                                <ul id="edit_pagination_rulers" class="pagination">
                                </ul>
                            </nav>
                        </div>
                    </fieldset>

                    <table width="100%" cellpadding="5">
                        <thead>
                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['rule']; ?></td>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?></td>
                        </tr>
                        </thead>
                        <tbody id="edit_show_rulers_table"></tbody>
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

    function close_rulers() {
        $("#modal_rulers").hide();
        $("#edit_modal_rulers").hide();
    }

    function ajaxPaginationforRulers(page) {
        var str = "<tr>";
        $.get("/api/dialrules/" + page + "/20", function (result) {
            var pagination = "";
            $.each(result.dialrules, function (k, n) {
                if ((k + 1) % 5 == 0) {
                    str += "<td><a href='javascript:void(0)'>" + n.name + "</a></td></tr><tr>";
                } else {
                    str += "<td><a href='javascript:void(0)'>" + n.name + "</a></td>";
                }

            });
            $(".rulers_table").html(str);
            pagination = '<li><a href="#" onclick="ajaxPaginationforRulers(1)">&laquo;</a></li>';
            for (i = 1; i <= Math.ceil(result.total_count / 20); i++) {
                pagination += '<li><a href="#" onclick="ajaxPaginationforRulers(' + i + ')">' + i + '</a></li>';
            }
            pagination += '<li><a href="#" onclick="ajaxPaginationforRulers(' + Math.ceil(result.total_count / 20) + ')">&raquo;</a></li>';
            $("#pagination_rulers").html(pagination);
            $("#edit_pagination_rulers").html(pagination);
        }, "json");
    }

    $(function () {
        $(".rulers_table td a").live("click", function () {
            $("#show_rulers_table").append('<tr><td><input id=\"arg\" name=\"arg\" placeholder=\"<?php echo $lang[$_COOKIE['systec_lang']]['rule']; ?>\" class=\"input-mini\" type=\"text\" value=' + $(this).html() + '></td><td><span class=\"ruler_up\"><img src="/img/up_btn_b.png"/><\/span><span class=\"ruler_down\"><img src="/img/down_btn_b.png"/><\/span><span class=\"ruler_del\"><button class="btn btn-danger btn-xs"><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button><\/span><\/td></tr>');

            $("#edit_show_rulers_table").append('<tr><td><input id=\"arg\" name=\"arg\" placeholder=\"<?php echo $lang[$_COOKIE['systec_lang']]['rule']; ?>\" class=\"input-mini\" type=\"text\" value=' + $(this).html() + '></td><td><span class=\"ruler_up\"><img src="/img/up_btn_b.png"/><\/span><span class=\"ruler_down\"><img src="/img/down_btn_b.png"/><\/span><span class=\"ruler_del\"><button class="btn btn-danger btn-xs"><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button><\/span><\/td></tr>');
        });
        if (window.location.href.indexOf("#") > 0) {
            page = window.location.href.split("#").pop();
        } else {
            page = 1;
        }
        $.get("/api/dialplans/" + page + "/20", function (result) {
            ajaxPagination(page);
        }, "json");


        $("#add_dialplan_rulers").click(function () {
            $("#modal_rulers").show();
            ajaxPaginationforRulers(1);

        });

        $("#add_edit_dialplan_rulers").live("click", function () {

            $("#edit_modal_rulers").show();
            ajaxPaginationforRulers(1);

        });
        $(".ruler_del").live("click", function () {
            $(this).parent().parent().remove();
        })
        $(".ruler_up").live("click", function () {
            $(this).parent().parent().fadeOut().fadeIn();
            $(this).parent().parent().prev().before($(this).parent().parent());
        })

        $(".ruler_down").live("click", function () {
            $(this).parent().parent().fadeOut().fadeIn();
            $(this).parent().parent().next().after($(this).parent().parent());
        })
    })
    function ajaxPagination(page) {
        $.get("/api/dialplans/" + page + "/20", function (result) {
            var str = "";
            var pagination = "";
            $.each(result.dialplans, function (k, n) {
                str += "<tr>";
                str += "<td>" + n.name + "</td><td>" + JSONLength(n.rules) + "</td><td><div class='btn-group'><button type='button' class='btn btn-default' data-toggle='modal' data-target='#edit_dialplan' onclick='ShowEditPanel(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['update']; ?></button><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#del_com' onclick='delete_dialplan(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button></div></td>";
                str += "</tr>";
            });
            $("#dialplan_conf").html(str);
            pagination = '<li><a href="#1" onclick="ajaxPagination(1)">&laquo;</a></li>';
            for (i = 1; i <= Math.ceil(result.total_count / 20); i++) {
                if (window.location.href.split("#").pop() == i) {
                    pagination += '<li class="active"><a href="#' + i + '" onclick="ajaxPagination(' + i + ')">' + i + '</a></li>';
                } else {
                    pagination += '<li><a href="#' + i + '" onclick="ajaxPagination(' + i + ')">' + i + '</a></li>';
                }
            }
            pagination += '<li><a href="#' + Math.ceil(result.total_count / 20) + '" onclick="ajaxPagination(' + Math.ceil(result.total_count / 20) + ')">&raquo;</a></li>';
            $(".pagination").html(pagination);
        }, "json");
    }
</script>
<script>
    $(function () {
        $("#add_submit").click(function () {
            var selectData = [];
            $.each($("#show_rulers_table").find("tr"), function (k, v) {
                var args = $(v).find("td").find("input").val();
                selectData.push(args);
            });
            //添加验证
            if ($("#name").val() == "" || $("#name").val().length > 20) {
                $("#name").css("border-color", "red");
                $("#name").focus();
                return false;
            } else {
                $("#name").removeAttr("style");
            }

            $.post("/api/dialplans/add/", {name: $("#name").val(), rules: selectData}, function (result) {
                if (result.state == 0) {
                    $.get("/api/conf/reload", function (result) {
                    }, "json");
                    window.location.reload();//刷新当前页面.
                }
            }, "json");
        });
        $("#edit_submit").click(function () {
            var selectData = [];
            $.each($("#edit_show_rulers_table").find("tr"), function (k, v) {
                var args = $(v).find("td").find("input").val();
                selectData.push(args);
            });

            //添加验证
            if ($("#edit_name").val() == "" || $("#edit_name").val().length > 20) {
                $("#edit_name").css("border-color", "red");
                $("#edit_name").focus();
                return false;
            } else {
                $("#edit_name").removeAttr("style");
            }
            $.post("/api/dialplans/update/", {name: $("#edit_name").val(), rules: selectData}, function (result) {
                if (result.state == 0) {
                    $.get("/api/conf/reload", function (result) {
                    }, "json");
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
        $('#edit_dialplan').show();
        $.post("/api/dialplans/info/", {name: id}, function (result) {
            $("#edit_name").val(result.name);
            var str = "";
            $.each(jQuery.parseJSON(result.rules), function (k, v) {
                str += '<tr><td><input id=\"edit_arg\" name=\"edit_arg\" placeholder=\"<?php echo $lang[$_COOKIE['systec_lang']]['rule']; ?>\" class=\"input-mini\" type=\"text\" value=' + v + '></td><td><span class=\"ruler_up\"><img src="/img/up_btn_b.png"/><\/span><span class=\"ruler_down\"><img src="/img/down_btn_b.png"/><\/span><span class=\"ruler_del\"><button class="btn btn-danger btn-xs"><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button><\/span><\/td></tr>';
            });
            $("#edit_show_rulers_table").html(str);
        }, "json");
    }
</script>

<!--添加删除服务-->
<div class="modal fade bs-example-modal-sm" id="del_com" tabindex="-1" role="dialog" aria-labelledby="del_comLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4>确定删除吗</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_del();">取消</button>
                <button type="button" class="btn btn-danger" id="confirm_del_btn" filed="" onclick="confirm_del();">删除
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function delete_dialplan(uid) {
        $("#del_com").addClass("in");
        $("#del_com").show();
        $("#confirm_del_btn").attr("filed", uid);
    }

    function cancel_del() {
        $("#del_com").hide();
    }
    function confirm_del() {
        $.post("/api/dialplans/delete", {name: $("#confirm_del_btn").attr("filed")}, function (result) {
            if (result.state == 0) {
                $.get("/api/conf/reload", function (result) {
                }, "json");
                $("#del_com").hide();
                $(".modal-backdrop.in").hide();
                var trList = $("#dialplan_conf").children("tr");
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
        $('.tips').tooltipster({
            theme: 'tooltipster-shadow',
            maxWidth: 400,
            side: 'right'
        });
    });
</script>
</body>
</html>
