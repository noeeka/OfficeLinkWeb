<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="James Chen">
    <title><?php echo $lang[$_COOKIE['systec_lang']]['mohconfig']; ?></title>
    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/widgets.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/style-responsive.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="/css/tooltipster.bundle.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-shadow.min.css"/>

    <link rel="stylesheet" href="/css/jquery.fileupload.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/>
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
                        <li><?php echo $lang[$_COOKIE['systec_lang']]['mohconfig']; ?></li>
                    </ol>
                </div>
            </div>
            <?php if($couldadd==true){?>
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add_moh">
                <?php echo $lang[$_COOKIE['systec_lang']]['addmoh']; ?>
            </button>
            <?php } ?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>
                        <?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>
                    </td>
                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?>
                    </td>
                </tr>
                </thead>
                <tbody id="moh_conf">
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
<!--添加MOH弹层-->
<div class="modal fade" id="add_moh" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <?php echo $lang[$_COOKIE['systec_lang']]['addmoh']; ?>
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <table>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>
                            </td>
                            <td>
                                <input id="name" name="name" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>" type="text">

                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_moh" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_moh">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_moh']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" id="wav_list"></td>
                            <input type="hidden" id="check_file_flag"/>

                        </tr>
                        <tr>
                            <td id="wav_show" colspan="2"></td>

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

<!--编辑拨号方案弹层-->
<div class="modal fade" id="edit_mohs" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <?php echo $lang[$_COOKIE['systec_lang']]['editmoh']; ?>
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <table>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>
                            </td>
                            <td>
                                <input id="edit_name" name="edit_name" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['name']; ?>" type="text" disabled="true" readonly="readonly">
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_moh" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_moh">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_moh']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" id="edit_wav_list">
                                <div style="width: 100px;" class="">
                                    <span class="btn btn-success fileinput-button" style="background-color:#007aff">
                                        <span>
                                            <?php echo $lang[$_COOKIE['systec_lang']]['moh_choose_wav']; ?>
                                        </span>
                                        <input class="edit_wav" type="file" name="files[]" accept=".wav">
                                    </span>
                                    <input type="hidden" id="edit_files"/>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" id="edit_wav_show"></td>
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

<!-- 图片上传插件 -->
<script src="/js/jquery.ui.widget.js"></script>
<script src="/js/jquery.iframe-transport.js"></script>
<script src="/js/jquery.fileupload.js"></script>
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
        $("#name").keyup(function () {
            $("#directory").val($(this).val());
        });

        $("#edit_name").keyup(function () {
            $("#edit_directory").val($(this).val());
        });
    })
    function ajaxPagination(page) {
        $.get("/api/mohs/" + page + "/20", function (result) {
            var str = "";
            var pagination = "";
            $.each(result.mohs, function (k, n) {
                str += "<tr>";
                str += "<td>" + n.name + "</td><td align='center' valign='middle'><div class='btn-group'><button type='button' class='btn btn-default' data-toggle='modal' data-target='#edit_mohs' onclick='ShowEditPanel(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['update']; ?></button><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#del_com' onclick='delete_dialplan(\"" + n.name + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button></div></td>";
                str += "</tr>";
            });
            $("#moh_conf").html(str);
            getPagiation(result.total_count,$(".pagination"));
        }, "json");
    }
</script>

<script>
    $(function () {
        $("#name").keyup(function (){
            if($("#name").val() != "" && !/.*[\u4e00-\u9fa5]+.*$/.test($("#name").val()) && $("#name").val().indexOf(" ")<0){
                $("#wav_list").html('<div style="width: 100px;" class=""><span class="btn btn-success fileinput-button" style="background-color:#007aff"><span><?php echo $lang[$_COOKIE['systec_lang']]['moh_choose_wav']; ?></span><input class="add_wav" accept=".wav" type="file" name="files[]" ></span> <input type="hidden" id="files" /></div><?php echo $lang[$_COOKIE['systec_lang']]['tips_wav_moh']; ?>');
                $("#name").removeAttr("style");
            } else {
                $("#name").css("border-color", "red");
                $("#name").focus();

                $("#wav_list").html("");
                return false;
            }
        });
        var files = [];
        var url = '/api/upload/mohs/' + $("#name").val();
        $('.add_wav').live('click', function (e) {
            $('.add_wav').fileupload({
                add: function (e, data) {
                    data.url = '/api/upload/mohs/'+$("#name").val();
                    data.submit();
                },
                dataType: 'json',
                done: function (e, data) {
                    $("#check_file_flag").val(data.result.name);
                    $("#wav_show").html(data.result.name);
                },
            });
        });

        $('.edit_wav').fileupload({
            add: function (e, data) {
                $("#edit_name").removeAttr("style");
                data.url = '/api/upload/mohs/' + $("#edit_name").val();
                data.submit();
            },
            dataType: 'json',
            done: function (e, data) {
                $("#edit_wav_show").html(data.result.name);
                alert("<?php echo $lang[$_COOKIE['systec_lang']]['moh_upload']; ?>");
            },
        });
    });
</script>
<script>
    $(function () {
        $("#add_submit").click(function () {
            var options = $("#wav_list").find(".control-group");
            var selectData = [];
            $.each(options, function (k, v) {
                var args = $(v).find("label").html();
                selectData.push(args);
            });
            if(is_not_null($("#name"),"")==false){
                return false;
            }

            if(is_repeat_val($("#name"),"/api/moh/checkname","name","")==false){
                return false;
            }

            if(is_validate_charactor($("#name"),"")==false){
                return false;
            }
            if(is_validate_length($("#name"),"",20)==false){
                return false;
            }

            if($("#check_file_flag").val()==""){
                alert("<?php echo $lang[$_COOKIE['systec_lang']]['moh_choose_wav']; ?>");
                return false;
            }
            if($("#name").val().indexOf(" ") >=0){
                $("#name").css("border-color", "red");
                $("#name").focus();
                return false;
            }else {
                $("#name").removeAttr("style");
            }

            $.post("/api/mohs/add/", {
                name: $("#name").val(),
                mode: "files",
                sort: "",
                "directory": "/var/lib/asterisk/moh/"+$("#name").val(),
                files: selectData
            }, function (result) {
                if (result.state == 0) {
                    window.location.reload();//刷新当前页面.
                }
            }, "json");
        });
        $("#edit_submit").click(function () {
            var options = $("#edit_wav_list").find(".control-group");
            var selectData = [];
            $.each(options, function (k, v) {
                var args = $(v).find("label").html();
                selectData.push(args);
            });
            $.post("/api/mohs/update/", {
                name: $("#edit_name").val(),
                mode: "files",
                sort: "",
                "directory": "/var/lib/asterisk/moh",
                files: selectData
            }, function (result) {
                if (result.state == 0) {
                    window.location.reload();//刷新当前页面.
                }
            }, "json");
        });

        $(".ruler_del").live("click", function () {
            $(this).parent().remove();
        });
        $(".fileinput-button").hover(function () {
            $(this).css("color", "#007aff");
            $(this).css("background", "transparent");
            $(this).css("border-color", "#007aff");
        }, function () {
            $(this).css("color", "#ffffff");
            $(this).css("background-color", "#007aff");
            $(this).css("border-color", "#007aff");
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
        $('#edit_mohs').show();
        $.ajax({
            type: "POST",
            url: "/api/mohs/info/?number=" + Math.random(),
            data: {name: id},
            cache: false,
            success: function (result) {
                $("#edit_name").val(result.name);
                $("#edit_mode").val(result.mode);
                $("#edit_sort").val(result.sort);
                $("#edit_directory").val(result.name);
                $("#edit_wav_show").html(result.name+".wav");
                var str = "";
                $.each(jQuery.parseJSON(result.files), function (k, v) {
                    $("#edit_wav_list").html('<div class="control-group"><label class="control-label" for="rule">' + v + '</label></div>');
                });
                $("#edit_rulers").html(basht + str);
            },
            dataType: "json"
        });
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
    function delete_dialplan(uid) {
        $("#del_com").addClass("in");
        $("#del_com").show();
        $("#confirm_del_btn").attr("filed", uid);
    }
    function cancel_del() {
        $("#del_com").hide();
    }
    function confirm_del() {
        $.post("/api/mohs/delete", {name: $("#confirm_del_btn").attr("filed")}, function (result) {
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
