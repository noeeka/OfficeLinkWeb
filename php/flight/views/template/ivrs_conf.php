<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="James Chen">
    <title><?php echo $lang[$_COOKIE['systec_lang']]['ivrs']; ?></title>
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
                        <li><?php echo $lang[$_COOKIE['systec_lang']]['ivrsetting']; ?></li>
                    </ol>
                </div>
            </div>
            <?php if($couldadd==true){?>
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add_ivrs">
                <?php echo $lang[$_COOKIE['systec_lang']]['addivrs']; ?>
            </button>
            <?php } ?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>
                        <?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>
                    </td>
                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?>
                    </td>
                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?>
                    </td>
                </tr>
                </thead>
                <tbody id="ivrs_conf">
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


<!--添加IVRS弹层-->
<div class="modal fade" id="add_ivrs" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 536px">
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
                    <?php echo $lang[$_COOKIE['systec_lang']]['ivrs']; ?>
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <table cellpadding="5">
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>
                            </td>
                            <td>
                                <input id="name" name="name" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>" type="text">
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_ivrs_name_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_ivrs_name_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_ivrs_name_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?>
                            </td>
                            <td>
                                <input id="extension" name="extension" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?>" type="text" value="<?php echo $availble; ?>" autocomplete="off">
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_ivrs_extension_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_ivrs_extension_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_ivrs_extension_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['music']; ?>
                            </td>
                            <td>
                                <select id="music" name="music">
                                    <option value='Default'>Default</option>
                                </select>
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_ivrs_welcome_prompt_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_ivrs_welcome_prompt_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_ivrs_welcome-prompt_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['waiting']; ?>
                            </td>
                            <td>
                                <select id="timeout" name="timeout">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                </select>
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_ivrs_digit_timeout_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_ivrs_digit_timeout_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_ivrs_digit-timeout_content']; ?>
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

<!--编辑IVRS弹层-->
<div class="modal fade" id="edit_ivrs" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="EditIVRLabel">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 536px;">
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
                    <?php echo $lang[$_COOKIE['systec_lang']]['ivrs']; ?>
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <table cellpadding="5">
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>
                            </td>
                            <td>
                                <input id="edit_name" name="edit_name" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>" type="text" readonly="readonly" disabled="disabled">
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_ivrs_name_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_ivrs_name_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_ivrs_name_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?>
                            </td>
                            <td>
                                <input id="edit_extension" name="edit_extension" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?>" type="text" disabled="true" readonly="true">
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_ivrs_extension_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_ivrs_extension_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_ivrs_extension_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['music']; ?>
                            </td>
                            <td>
                                <select id="edit_music" name="edit_music">
                                    <option value='Default'>Default</option>
                                </select>
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_ivrs_welcome_prompt_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_ivrs_welcome_prompt_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_ivrs_welcome-prompt_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['waiting']; ?>
                            </td>
                            <td>
                                <select id="edit_timeout" name="edit_timeout">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                </select>
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_ivrs_digit_timeout_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_ivrs_digit_timeout_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_ivrs_digit-timeout_content']; ?>
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
        if (window.location.href.indexOf("#") > 0) {
            page = window.location.href.split("#").pop();
        } else {
            page = 1;
        }
        ajaxPagination(page);
        var musics="";
        $.get("/api/mohs/1/100/", function (result) {
            if(result.mohs!=null){
                $.each(result.mohs,function(name,value) {
                    musics+="<option value='"+value.name+"'>"+value.name+"</option>";
                });
            }
            $("#music").append(musics);
            $("#edit_music").append(musics);
        }, "json");

        if (window.location.href.indexOf("#") > 0) {
            page = window.location.href.split("#").pop();
        } else {
            page = 1;
        }
    })
    function ajaxPagination(page) {
        $.ajax({
            url:"/api/ivrs/" + page + "/20",
            type: "GET",
            beforeSend: function () {
                $("#extensions_status").html("<img src='/img/ajax-loader.gif'/>");
            },
            success: function (result) {
            var str = "";
            var pagination = "";
            $.each(result.ivrs, function (k, n) {
                str += "<tr>";
                str += "<td>" + n.name + "</td><td align='center' valign='middle'>" + n.extension + "</td><td align='center' valign='middle'><div class='btn-group'><button type='button' class='btn btn-default' data-toggle='modal' data-target='#edit_ivrs' onclick='ShowEditPanel(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['update']; ?></button><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#del_com' onclick='delete_ivr(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button></div></td>";
                str += "</tr>";
            });
            $("#ivrs_conf").html(str);
            getPagiation(result.total_count,$(".pagination"));
        }, dataType: "json"});
    }
</script>
<script>
    $(function () {
        $("#add_submit").click(function () {
            if(is_not_null($("#name"),"")==false){
                return false;
            }
            if(is_validate_length($("#name"),"",20)==false){
                return false;
            }
            if(is_repeat_val($("#name"),"/api/ivrs/checkname","name","")==false){
                return false;
            }

            if(is_not_null($("#extension"),"")==false){
                return false;
            }
            if(is_validate_number($("#extension"),"")==false){
                return false;
            }
            if(is_in_range($("#extension"),"ivr_exten","")==false){
                return false;
            }
            if(is_validate_length($("#extension"),"",20)==false){
                return false;
            }
            if(is_repeat_val($("#extension"),"/api/ivrs/checkextension","extension","")==false){
                return false;
            }

            $.post("/api/ivrs/add/", {
                name: $("#name").val(),
                extension: $("#extension").val(),
                music: $("#music").val(),
                timeout: $("#timeout").val()
            }, function (result) {
                if (result.state == 0) {

                    $.get("/api/conf/reload", function (result) {
                    }, "json");
                    window.location.reload();
                }
            }, "json");
        });

        $("#edit_submit").click(function () {
            if(is_validate_length($("#edit_name"),"",20)==false){
                return false;
            }
            $.post("/api/ivrs/update/", {
                name: $("#edit_name").val(),
                extension: $("#edit_extension").val(),
                music: $("#edit_music").val(),
                timeout:$("#edit_timeout").val()
            }, function (result) {
                if (result.state == 0) {
                    $.get("/api/conf/reload", function (result) {
                    }, "json");
                    window.location.reload();
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
        $('#edit_ivrs').show();
        $.post("/api/ivrs/info", {name: id}, function (data) {
            $("#edit_name").val(data.name);
            $("#edit_extension").val(data.extension);
            $("#edit_music").val(data.music);
            $("#edit_timeout").val(data.timeout);
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
                <button type="button" class="btn btn-danger" id="confirm_del_btn" filed="" onclick="confirm_del();"><?php echo $lang[$_COOKIE['systec_lang']]['confirm']; ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    function delete_ivr(uid) {
        $("#del_com").addClass("in");
        $("#del_com").show();
        $("#confirm_del_btn").attr("filed", uid);
    }

    function cancel_del() {
        $("#del_com").hide();
    }
    function confirm_del() {
        $.post("/api/ivrs/delete", {name: $("#confirm_del_btn").attr("filed")}, function (result) {
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
