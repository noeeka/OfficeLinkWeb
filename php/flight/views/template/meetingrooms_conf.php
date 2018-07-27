<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="James Chen">
        <title><?php echo $lang[$_COOKIE['systec_lang']]['meetingroomsconf']; ?></title>
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/widgets.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">
        <link href="/css/style-responsive.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="/css/tooltipster.bundle.min.css"/>
        <link rel="stylesheet" type="text/css" href="/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-shadow.min.css"/>
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
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['pbx']; ?></li>
                                <li><i class="fa fa-laptop"></i><?php echo $lang[$_COOKIE['systec_lang']]['meetingroomsconf']; ?></li>
                            </ol>
                        </div>
                    </div>
                    <?php if($couldadd==true){?>
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#AddMeeting">
                        <?php echo $lang[$_COOKIE['systec_lang']]['addmeetingrooms']; ?>
                    </button>
                    <?php } ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?>
                                </td>
                                <td align='center' valign='middle'>
                                    <?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?>
                                </td>
                            </tr>
                        </thead>
                        <tbody id="meeting_conf">
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
        <div class="modal fade" id="AddMeeting" tabindex="-1" role="dialog" aria-labelledby="AddUserLabel" aria-hidden="true">
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
                            <?php echo $lang[$_COOKIE['systec_lang']]['addmeetingrooms']; ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <table>
                                <tr>
                                    <td><?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?></td>
                                    <td>
                                        <input style="display: none" type="text" />
                                        <input style="display: none" type="password"/>
                                        <input id="extension" name="extension" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?>" class="input-mini" type="text" value="<?php echo $availble; ?>" autocomplete="false">
                                        <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_meeting_room_extension_content" style="padding-bottom:4px;"/>
                                        <div id="tpl_tips_extension" style="display: none;">
                                            <div id="tips_meeting_room_extension_content">
                                                <p style="text-align:left;">
                                                    <?php echo $lang[$_COOKIE['systec_lang']]['tips_meeting_room_extension_content']; ?>
                                                </p>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo $lang[$_COOKIE['systec_lang']]['user_pin']; ?></td>
                                    <td>
                                        <input style="display: none" type="password"/>
                                        <input id="user_pin" name="user_pin" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['user_pin']; ?>" class="input-small" type="password" maxlength="20" autocomplete="false">
                                        <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_meeting_room_password_content"
                                             style="padding-bottom:4px;"/>
                                        <div id="tpl_tips_extension" style="display: none;">
                                            <div id="tips_meeting_room_password_content">
                                                <p style="text-align:left;">
                                                    <?php echo $lang[$_COOKIE['systec_lang']]['tips_meeting_room_password_content']; ?>
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

        <!--modify弹层-->
        <div class="modal fade" id="UpdateMeeting" tabindex="-1" role="dialog" aria-labelledby="EditUserLabel" aria-hidden="true">
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
                            <?php echo $lang[$_COOKIE['systec_lang']]['updatemeetingrooms']; ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <table>
                                <tr>
                                    <td><?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?></td>
                                    <td>
                                        <input id="edit_extension" readonly="readonly" disabled="true" name="extension" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?>" class="input-mini" type="text">
                                        <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_meeting_room_extension_content" style="padding-bottom:4px;"/>
                                        <div id="tpl_tips_extension" style="display: none;">
                                            <div id="tips_meeting_room_extension_content">
                                                <p style="text-align:left;">
                                                    <?php echo $lang[$_COOKIE['systec_lang']]['tips_meeting_room_extension_content']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo $lang[$_COOKIE['systec_lang']]['user_pin']; ?></td>
                                    <td><input id="edit_user_pin" name="user_pin" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['user_pin']; ?>" class="input-small" maxlength="20" type="password">
                                        <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_meeting_room_password_content" style="padding-bottom:4px;"/>
                                        <div id="tpl_tips_extension" style="display: none;">
                                            <div id="tips_meeting_room_password_content">
                                                <p style="text-align:left;">
                                                    <?php echo $lang[$_COOKIE['systec_lang']]['tips_meeting_room_password_content']; ?>
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
                        <button type="button" class="btn btn-primary" id="update_submit">
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
            var extension = $("#extension").val();
            var user_pin = $("#user_pin").val();
            var admin_pin = "";

            if(is_not_null($("#extension"),"")==false){
                return false;
            }

            if(is_validate_length($("#extension"),"",10)==false){
                return false;
            }

            if(is_validate_number($("#extension"),"")==false){
                return false;
            }

            if(is_repeat_val($("#extension"),"/api/meetingrooms/checkextension","extension","")==false){
                return false;
            }

            if(is_in_range($("#extension"),"conference_exten","")==false){
                return false;
            }

            if(is_validate_number($("#user_pin"),"")==false){
                return false;
            }

            if(is_not_null($("#user_pin"),"")==false){
                return false;
            }


            $.post("/api/meetingrooms/add/", {"extension": extension, "user_pin": user_pin, "admin_pin": admin_pin}, function (result) {
                if (result.state == 0) {
                    $.get("/api/conf/reload", function (result) {}, "json");
                   window.location.reload();
                }
            }, "json");
        });

        $("#update_submit").click(function () {
            var extension = $("#edit_extension").val();
            var user_pin = $("#edit_user_pin").val();
            var admin_pin = "";

            if(is_validate_number($("#edit_user_pin"),"")==false){
                return false;
            }
            if(is_not_null($("#edit_user_pin"),"")==false){
                return false;
            }
            $.post("/api/meetingrooms/update/", {"extension": extension, "user_pin": user_pin, "admin_pin": admin_pin}, function (result) {
                if (result.state == 0) {
                    $.get("/api/conf/reload", function (result) {}, "json");
                    window.location.reload();
                }
            }, "json");
        });
    });

    function ShowEditPanel(uid) {
        $('#UpdateMeeting').show();
        $.post("/api/meetingrooms/info", {"extension": uid}, function (data) {
            $("#edit_extension").val(data.confno);
            $("#edit_user_pin").val(data.pin);
        }, 'json');
    }

    function ajaxPagination(page) {
        $.get("/api/meetingrooms/" + page + "/20", function (result) {
            var str = "";
            var pagination = "";
            $.each(result.meetingrooms, function (k, n) {
                str += "<tr>";
                str += "<td>" + n.extension + "</td><td align='center' valign='middle'><div class='btn-group'><button type='button' class='btn btn-default' data-toggle='modal' data-target='#UpdateMeeting' onclick='ShowEditPanel(" + n.extension + ")'><?php echo $lang[$_COOKIE['systec_lang']]['update']; ?></button><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#del_com' onclick='Delete(" + n.extension + ")'><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button></div></td>";
                str += "</tr>";
            });

            $("#meeting_conf").html(str);
            getPagiation(result.total_count,$(".pagination"));
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
        $.post("/api/meetingrooms/delete", {confno: ($("#confirm_del_btn").attr("filed"))}, function (result) {
            if (result.state == 0) {
                $.get("/api/conf/reload", function (result) {}, "json");
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
