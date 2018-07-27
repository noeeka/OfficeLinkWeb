<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="James Chen">
    <title><?php echo $lang[$_COOKIE['systec_lang']]['ringgroupsetting']; ?></title>
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
                        <li><?php echo $lang[$_COOKIE['systec_lang']]['ringgroupsetting']; ?></li>
                    </ol>
                </div>
            </div>
            <?php if($couldadd==true){?>
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add_ringgroup">
                <?php echo $lang[$_COOKIE['systec_lang']]['addringgroup']; ?>
            </button>
            <?php } ?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>
                        <?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>
                    </td>
                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['specifications']; ?>
                    </td>
                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?>
                    </td>
                </tr>
                </thead>
                <tbody id="ringgroup_conf">
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
<div class="modal fade" id="add_ringgroup" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <?php echo $lang[$_COOKIE['systec_lang']]['addringgroup']; ?>
                </h4>
            </div>
            <div class="modal-body">
                <table cellpadding="5">
                    <tr>
                        <td><?php echo $lang[$_COOKIE['systec_lang']]['name']; ?></td>
                        <td>
                            <input id="name" name="name" type="text" maxlength="20">
                            <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_ringgroup_name_content"
                                 style="padding-bottom:4px;"/>
                            <div id="tpl_tips_extension" style="display: none;">
                                <div id="tips_ringgroup_name_content">
                                    <p style="text-align:left;">
                                        <?php echo $lang[$_COOKIE['systec_lang']]['tips_ringgroup_name_content']; ?>
                                    </p>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?></td>
                        <td>
                            <input id="extension" name="extension" type="text" value="<?php echo $availble; ?>">
                            <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_ringgroup_extension_content"
                                 style="padding-bottom:4px;"/>
                            <div id="tpl_tips_extension" style="display: none;">
                                <div id="tips_ringgroup_extension_content">
                                    <p style="text-align:left;">
                                        <?php echo $lang[$_COOKIE['systec_lang']]['tips_ringgroup_extension_content']; ?>
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $lang[$_COOKIE['systec_lang']]['timeout']; ?>(s)</td>
                        <td>
                            <select id="timeout">
                                <option value="0"><?php echo $lang[$_COOKIE['systec_lang']]['forever']; ?></option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="60">60</option>
                                <option value="80">80</option>
                                <option value="100">100</option>
                                <option value="120">120</option>
                            </select>
                            <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_ringgroup_timeout_content"
                                 style="padding-bottom:4px;"/>
                            <div id="tpl_tips_extension" style="display: none;">
                                <div id="tips_ringgroup_timeout_content">
                                    <p style="text-align:left;">
                                        <?php echo $lang[$_COOKIE['systec_lang']]['tips_ringgroup_timeout_content']; ?>
                                    </p>
                                </div>
                            </div>

                        </td>
                    </tr>
                </table>

                <fieldset id="members">
                    <div id="legend" class="">
                        <legend class="">
                            <?php echo $lang[$_COOKIE['systec_lang']]['memberlist']; ?>
                            <button id="add_ringgroup_member"
                                    style="margin-left:<?php if ($_COOKIE['systec_lang'] == "en") { ?>280px<?php } else { ?>370px<?php } ?>;margin-bottom: 5px;"
                                    type="button"
                                    class="btn btn-default"><?php echo $lang[$_COOKIE['systec_lang']]['addmember']; ?></button>
                        </legend>
                    </div>


                    <div id="modal_rulers"
                         style="display: none; z-index: 50; width: 550px; height: 200px;margin-bottom: 60px;margin-top: -20px;">
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
                                <?php echo $lang[$_COOKIE['systec_lang']]['memberselect']; ?>
                            </h4>
                        </div>

                        <table class="rulers_table" width="100%" cellpadding="5"></table>

                        <nav>
                            <ul id="pagination_rulers" class="pagination">
                            </ul>
                        </nav>
                    </div>

                    <table id="show_extensions">
                        <thead>
                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?></td>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?></td>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </fieldset>
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

<!--编辑弹层-->
<div class="modal fade" id="edit_ringgroups" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <?php echo $lang[$_COOKIE['systec_lang']]['editringgroup']; ?>
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <table>
                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['name']; ?></td>
                            <td>
                                <input id="edit_name" name="edit_name" type="text" disabled="true" readonly="readonly">
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_ringgroup_name_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_ringgroup_name_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_ringgroup_name_content']; ?>
                                        </p>
                                    </div>
                                </div>

                            </td>
                        </tr>

                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?></td>
                            <td>
                                <input id="edit_extension" name="edit_extension" type="text" readonly="readonly" disabled="disabled">
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_ringgroup_extension_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_ringgroup_extension_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_ringgroup_extension_content']; ?>
                                        </p>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['timeout']; ?>(s)</td>
                            <td>
                                <select id="edit_timeout">
                                    <option value="0"><?php echo $lang[$_COOKIE['systec_lang']]['forever']; ?></option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                    <option value="60">60</option>
                                    <option value="80">80</option>
                                    <option value="100">100</option>
                                    <option value="120">120</option>
                                </select>

                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_ringgroup_timeout_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_ringgroup_timeout_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_ringgroup_timeout_content']; ?>
                                        </p>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    </table>

                    <fieldset id="edit_members">
                        <div id="legend" class="">
                            <legend class="">
                                <?php echo $lang[$_COOKIE['systec_lang']]['memberlist']; ?>
                                <button id="add_edit_ringgroup_member"
                                        style="margin-left:<?php if ($_COOKIE['systec_lang'] == "en") { ?>280px<?php } else { ?>370px<?php } ?>;margin-bottom: 5px;"
                                        type="button"
                                        class="btn btn-default"><?php echo $lang[$_COOKIE['systec_lang']]['addmember']; ?></button>
                            </legend>
                        </div>


                        <div id="edit_modal_rulers"
                             style="display: none; z-index: 50; width: 550px; height: 200px;margin-bottom: 60px;margin-top: -20px;">
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
                                    <?php echo $lang[$_COOKIE['systec_lang']]['memberselect']; ?>
                                </h4>
                            </div>

                            <table class="rulers_table" width="100%" cellpadding="5"></table>

                            <nav>
                                <ul id="edit_pagination_rulers" class="pagination">
                                </ul>
                            </nav>

                        </div>


                        <table id="edit_show_extensions">
                            <thead>
                            <tr>
                                <td><?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?></td>
                                <td><?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?></td>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </fieldset>
                    <input type="hidden" id="edit_member_hide" value=""/>
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
        $.get("/api/extensions/" + page + "/20", function (result) {
            var pagination = "";
            $.each(result.extensions, function (k, n) {
                if ((k + 1) % 5 == 0) {
                    str += "<td><a href='javascript:void(0)'>" + n.extension + "</a></td></tr><tr>";
                } else {
                    str += "<td><a href='javascript:void(0)'>" + n.extension + "</a></td>";
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

    function contains(arr, obj) {
        var i = arr.length;
        while(i--) {
            if(arr[i] === obj) {
                return i;
            }
        }
        return "-1";
    }

    $(function () {
        if (window.location.href.indexOf("#") > 0) {
            page = window.location.href.split("#").pop();
        } else {
            page = 1;
        }
        ajaxPagination(page);

        $(".rulers_table td a").live("click", function () {
            var selectData = [];
            var edit_selectData = [];
            $.each($("#show_extensions").find("tbody").find("tr"), function (k, v) {
                var member = $(v).find("td").find("input").val();
                selectData.push(member);
            });



            $.each($("#edit_show_extensions").find("tbody").find("tr"), function (k, v) {
                var edit_member = $(v).find("td").find("input").val();
                edit_selectData.push(edit_member);
            });
            if($("#edit_member_hide").val()!=""&&contains(jQuery.parseJSON($("#edit_member_hide").val()),$(this).html().toString())!="-1"){
                return false;
            }
            if (contains(selectData,$(this).html()) =="-1"  || contains(edit_selectData,$(this).html()) == "-1") {
                $("#show_extensions").find("tbody").append('<tr><td><input id=\"arg\" name=\"arg\" placeholder=\"<?php echo $lang[$_COOKIE['systec_lang']]['rule']; ?>\" class=\"input-mini\" type=\"text\" value=' + $(this).html() + ' disabled=\"disabled\" readonly=\"readonly\"></td><td><span class=\"ruler_up\"><img src="/img/up_btn_b.png"/><\/span><span class=\"ruler_down\"><img src="/img/down_btn_b.png"/><\/span><span class=\"ruler_del\"><button class="btn btn-danger btn-xs"><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button><\/span><\/td></tr>');

                $("#edit_show_extensions").find("tbody").append('<tr><td><input id=\"arg\" name=\"arg\" placeholder=\"<?php echo $lang[$_COOKIE['systec_lang']]['rule']; ?>\" class=\"input-mini\" type=\"text\" value=' + $(this).html() + ' disabled=\"disabled\" readonly=\"readonly\"></td><td><span class=\"ruler_up\"><img src="/img/up_btn_b.png"/><\/span><span class=\"ruler_down\"><img src="/img/down_btn_b.png"/><\/span><span class=\"ruler_del\" flag=\"edit\" uid="'+$(this).html()+'"><button class="btn btn-danger btn-xs"><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button><\/span><\/td></tr>');
            } else {
                return false;
            }
        });
        $("#add_ringgroup_member").click(function () {
            $("#modal_rulers").show();
            ajaxPaginationforRulers(1);

        });
        $("#add_edit_ringgroup_member").live("click", function () {
            $("#edit_modal_rulers").show();
            ajaxPaginationforRulers(1);

        });
        $(".ruler_del").live("click", function () {
            var selectData = [];
            var edit_selectData = [];
            var arr=[];
            $(this).parent().parent().remove();
            var uid=$(this);
            if($(this).attr("flag")=="edit"){
                $.each(jQuery.parseJSON($("#edit_member_hide").val()), function (k, v) {
                    if(v!=uid.attr("uid")){
                        arr.push(v);
                    }
                });
                console.log(arr);
                //console.log(removeByValue(jQuery.parseJSON($("#edit_member_hide").val()),$(this).attr("uid")));
                $("#edit_member_hide").val(JSON.stringify(arr));
            }

        })
        $(".ruler_up").live("click", function () {
            $(this).parent().parent().fadeOut().fadeIn();
            $(this).parent().parent().prev().before($(this).parent().parent());
        })

        function removeByValue(arr, val) {
            for(var i=0; i<arr.length; i++) {
                if(arr[i] == val) {
                    arr.splice(i, 1);
                    break;
                }
            }
            return arr;
        }

        $(".ruler_down").live("click", function () {
            $(this).parent().parent().fadeOut().fadeIn();
            $(this).parent().parent().next().after($(this).parent().parent());
        })

    })
    function ajaxPagination(page) {
        $.get("/api/ringgroups/" + page + "/20", function (result) {
            var str = "";
            var pagination = "";
            $.each(result.ringgroups, function (k, n) {
                str += "<tr>";
                str += "<td>" + n.name + "</td><td align='center' valign='middle'>" + JSONLength(n.members) + "</td><td align='center' valign='middle'><div class='btn-group'><button type='button' class='btn btn-default' data-toggle='modal' data-target='#edit_ringgroups' onclick='ShowEditPanel(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['update']; ?></button><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#del_com' onclick='delete_dialrule(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button></div></td>";
                str += "</tr>";
            });
            $("#ringgroup_conf").html(str);
            getPagiation(result.total_count,$(".pagination"));
        }, "json");
    }
</script>
<script>
    $(function () {
        $('#edit_ringgroups').on('hide.bs.modal', function() {
            window.location.reload();
        })
        $("#add_submit").click(function () {
            var selectData = [];
            $.each($("#show_extensions").find("tbody").find("tr"), function (k, v) {
                var member = $(v).find("td").find("input").val();
                selectData.push(member);
            });

            if(is_in_range($("#extension"),"ringgroup_exten","")==false){
                return false;
            }

            if(is_repeat_val($("#name"),"/api/ringgroups/checkname","name","")==false){
                return false;
            }

            if(is_repeat_val($("#extension"),"/api/ringgroups/checkextension","extension","")==false){
                return false;
            }

            if(is_not_null($("#name"),"")==false){
                return false;
            }

            if(is_not_null($("#extension"),"")==false){
                return false;
            }

            if(is_validate_length($("#name"),"",20)==false){
                return false;
            }

            if(is_validate_length($("#extension"),"",20)==false){
                return false;
            }

            if(selectData==null || selectData.length<2){
                alert("<?php echo $lang[$_COOKIE['systec_lang']]['ringgroup_mem_error']; ?>");
                return false;
            }

            $.post("/api/ringgroups/add/", {
                'name': $("#name").val(),
                'extension': $("#extension").val(),
                'ring_style': "",
                'timeout': $("#timeout").val(),
                'members': selectData
            }, function (result) {
                if (result.state == 0) {
                    $.get("/api/conf/reload", function (result) {
                    }, "json");
                    window.location.reload();//刷新当前页面.
                }
            }, "json");
        });
        $("#edit_submit").click(function () {
            var name = $("#edit_name").val();
            var selectData = [];
            $.each($("#edit_show_extensions").find("tbody").find("tr"), function (k, v) {
                var member = $(v).find("td").find("input").val();
                selectData.push(member);
            });

            if(selectData==null || selectData.length<2){
                alert("<?php echo $lang[$_COOKIE['systec_lang']]['ringgroup_mem_error']; ?>");
                return false;
            }

            
            $.post("/api/ringgroups/update/", {
                'name': $("#edit_name").val(),
                'extension': $("#edit_extension").val(),
                'ring_style': "",
                'timeout': $("#edit_timeout").val(),
                'members': selectData
            }, function (result) {
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
        $('#edit_ringgroups').show();
        $("#edit_extension").removeAttr("style");
        var extensions=[];
        $.ajax({
            url: "/api/extensions/",
            type: "GET",
            async: false,
            success: function (result){
                $.each(result.extensions, function (name, value) {
                    extensions.push(value.extension)
                });
            },
            dataType: "json"
        })
        $.post("/api/ringgroups/info/?number=" + Math.random(), {name: id}, function (data) {
            $("#edit_name").val(data.name);
            $("#edit_extension").val(data.extension);
            $("#edit_ringstyle").val(data.ring_style);
            $("#edit_timeout").val(data.timeout);
            $("#edit_member_hide").val(data.members);
            var str = "";
            console.log(jQuery.parseJSON(data.members))
            $.each(Array.intersect(jQuery.parseJSON(data.members),extensions), function (k, v) {
                str += '<tr><td><input id="rule" name="rule" placeholder="规则名称" type="text" value="' + v + '" disabled=\"disabled\" readonly=\"readonly\"></td><td><span class="ruler_up"><img src="/img/up_btn_b.png"/></span><span class="ruler_down"><img src="/img/down_btn_b.png"/></span><span class="ruler_del" flag="edit" uid="'+v+'"><button class="btn btn-danger btn-xs"><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button></span></td></tr>';
            });
            $("#edit_show_extensions").find("tbody").html(str);
        }, 'json');
    }


    Array.intersect = function () {
        var result = new Array();
        var obj = {};
        for (var i = 0; i < arguments.length; i++) {
            for (var j = 0; j < arguments[i].length; j++) {
                var str = arguments[i][j];
                if (!obj[str]) {
                    obj[str] = 1;
                }
                else {
                    obj[str]++;
                    if (obj[str] == arguments.length)
                    {
                        result.push(str);
                    }
                }//end else
            }//end for j
        }//end for i
        return result;
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
    function delete_dialrule(uid) {
        $("#del_com").addClass("in");
        $("#del_com").show();
        $("#confirm_del_btn").attr("filed", uid);
    }

    function cancel_del() {
        $("#del_com").hide();
    }
    function confirm_del() {
        $.post("/api/ringgroups/delete", {name: $("#confirm_del_btn").attr("filed")}, function (result) {
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
