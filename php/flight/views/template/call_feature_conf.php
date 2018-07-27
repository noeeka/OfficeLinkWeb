<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang[$_COOKIE['systec_lang']]['callfeatureconf']; ?></title>
    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="/css/bootstrap-theme.css" rel="stylesheet">
    <link href="/css/widgets.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/style-responsive.css" rel="stylesheet"/>

    <link rel="stylesheet" href="/css/jquery.fileupload.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/>
    <link rel="stylesheet" type="text/css" href="/css/tooltipster.bundle.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-shadow.min.css"/>
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
                        <li><?php echo $lang[$_COOKIE['systec_lang']]['callfeatureconf']; ?></li>
                    </ol>
                </div>
            </div>

            <h2 class="sub-header">
                <?php echo $lang[$_COOKIE['systec_lang']]['callfeatureconf']; ?>
            </h2>
            <div class="table-responsive">
                <table>
                    <tr>
                        <td><?php echo $lang[$_COOKIE['systec_lang']]['digit_timeout']; ?></td>
                        <td>
                            <select id="digit_timeout" name="digit_timeout">
                                <option value="500">500</option>
                                <option value="800">800</option>
                                <option value="1000">1000</option>
                                <option value="1500">1500</option>
                                <option value="2000">2000</option>
                                <option value="2500">2500</option>
                                <option value="3000">3000</option>
                            </select>
                            <?php echo $lang[$_COOKIE['systec_lang']]['msec']; ?>
                            <img src="/img/tishi.png" class="tips"
                                 data-tooltip-content="#call_feature_digital_timeout"
                                 style="padding-bottom:4px;"/>
                            <div id="call_feature_digital_timeoutd" style="display: none;">
                                <div id="call_feature_digital_timeout">
                                    <p style="text-align:left;">
                                        <?php echo $lang[$_COOKIE['systec_lang']]['call_feature_digital_timeout']; ?>
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>

                <fieldset id="parking_fieldset">
                    <div id="legend" class="">
                        <legend class=""><?php echo $lang[$_COOKIE['systec_lang']]['callparking']; ?></legend>
                    </div>

                    <table>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?>
                            </td>
                            <td>
                                <input id="extension" name="extension" class="input-mini" type="text">
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#sipphone"
                                     style="padding-bottom:4px;"/>
                                <div id="call_feature_digital_timeoutd" style="display: none;">
                                    <div id="sipphone">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['sipphone']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['parkingspace']; ?>
                            </td>
                            <td>
                                <input id="space_from" name="space_from" class="input-mini" type="text" size="8">--<input id="space_to" name="space_to" class="input-mini" type="text" size="8">
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#parkingspace"
                                     style="padding-bottom:4px;"/>
                                <div id="call_feature_digital_timeoutd" style="display: none;">
                                    <div id="parkingspace">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['parkingspace_tips']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['parkingtimeout']; ?>
                            </td>
                            <td>
                                <input id="timeout" name="timeout"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['parkingtimeout']; ?>"
                                       class="input-mini"
                                       type="text"><?php echo $lang[$_COOKIE['systec_lang']]['sec']; ?>

                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#parkingtimeout"
                                     style="padding-bottom:4px;"/>
                                <div id="call_feature_digital_timeoutd" style="display: none;">
                                    <div id="parkingtimeout">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['parkingtimeout_tips']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </table>
                </fieldset>

                <fieldset id="feature_map">
                    <div id="legend" class="">
                        <legend class=""><?php echo $lang[$_COOKIE['systec_lang']]['featuremap']; ?></legend>
                    </div>

                    <table>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['blind']; ?>
                            </td>
                            <td>
                                <input id="blind" name="blind"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['blind']; ?>"
                                       class="input-mini" type="text" onkeyup="value=value.replace(/[^0-9\#\*]/g,'')">

                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#blind_tips"
                                     style="padding-bottom:4px;"/>
                                <div id="call_feature_digital_timeoutd" style="display: none;">
                                    <div id="blind_tips">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['blind_tips']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr style="display:none;">
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['hangup']; ?>
                            </td>
                            <td>
                                <input id="hungup" name="hungup"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['hangup']; ?>"
                                       class="input-mini" type="text" onkeyup="value=value.replace(/[^0-9\#\*]/g,'')">

                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#blind_tips"
                                     style="padding-bottom:4px;"/>
                                <div id="call_feature_digital_timeoutd" style="display: none;">
                                    <div id="blind_tips">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['blind_tips']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['transfer']; ?>
                            </td>
                            <td>
                                <input id="transfer" name="transfer"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['transfer']; ?>"
                                       class="input-mini" type="text" onkeyup="value=value.replace(/[^0-9\#\*]/g,'')">

                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#transfer_tips"
                                     style="padding-bottom:4px;"/>
                                <div id="call_feature_digital_timeoutd" style="display: none;">
                                    <div id="transfer_tips">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['transfer_tips']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['parking']; ?>
                            </td>
                            <td><input id="parking" name="parking"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['parking']; ?>"
                                       class="input-mini" type="text" onkeyup="value=value.replace(/[^0-9\#\*]/g,'')">
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#parking_tips"
                                     style="padding-bottom:4px;"/>
                                <div id="call_feature_digital_timeoutd" style="display: none;">
                                    <div id="parking_tips">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['parking_tips']; ?>
                                        </p>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    </table>
                </fieldset>


                <button type="button" class="btn btn-primary" id="edit_submit">
                    <?php echo $lang[$_COOKIE['systec_lang']]['update']; ?>
                </button>

            </div>
        </section>
    </section>
    <!--main content end-->
</section>
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
        $.get("/api/call/feature/conf/", function (result) {
            $("#digit_timeout").val(result.digit_timeout);
            $("#extension").val(result.parking_res.extension);
            $("#timeout").val(result.parking_res.timeout);
            var spaces=result.parking_res.space;

            $("#space_from").val(spaces[0]);
            $("#space_to").val(spaces[1]);
            $("#blind").val(result.blind);
            $("#hungup").val(result.hungup);
            $("#transfer").val(result.transfer);
            $("#parking").val(result.parking);
        }, "json");
    });
</script>
<script>
    $(function () {
        $("#blind").keyup(function (e) {
            e = e || event;
            if ((e.which >= 48 && e.which <= 57) || (e.which == 16)) {
                $("#blind").removeAttr("style");
            } else {
                $("#blind").css("border-color", "red");
                $("#blind").focus();
                return false;
            }
        });
        $("#transfer").keyup(function (e) {
            e = e || event;
            if ((e.which >= 48 && e.which <= 57) || (e.which == 16)) {
                $("#transfer").removeAttr("style");
            } else {
                $("#transfer").css("border-color", "red");
                $("#transfer").focus();
                return false;
            }
        });

        $("#parking").keyup(function (e) {
            e = e || event;
            if ((e.which >= 48 && e.which <= 57) || (e.which == 16)) {
                $("#parking").removeAttr("style");
            } else {
                $("#parking").css("border-color", "red");
                $("#parking").focus();
                return false;
            }
        });

        $("#edit_submit").click(function () {
            var digit_timeout = parseInt($("#digit_timeout").val());

            if (digit_timeout < 200 || digit_timeout > 3000) {
                $("#digit_timeout").css("border-color", "red");
                $("#digit_timeout").focus();
                return false;
            }

            var extension = $("#extension").val();
            if (is_validate_number($("#extension"), "") == false) {
                return false;
            }

            if (is_validate_number($("#space_from"), "") == false) {
                return false;
            }

            if (is_validate_number($("#space_to"), "") == false) {
                return false;
            }

            if (($("#space_to").val() - $("#space_from").val()) > 30 || ($("#space_to").val() - $("#space_from").val()) < 5) {
                $("#space_from").css("border-color", "red");
                $("#space_to").css("border-color", "red");
                $("#space_to").focus();
                return false;
            }


            var space = [];
            space.push($("#space_from").val());
            space.push($("#space_to").val());
            var timeout = $("#timeout").val();
            parkingObj = {"extension": extension, "space": space, "timeout": timeout};


            var blind = $("#blind").val();
            var hungup = $("#hungup").val();
            var transfer = $("#transfer").val();
            var parking = $("#parking").val();
            //添加验证服务，暂缺
            $.post("/api/call/feature/conf/update/", {
                digit_timeout: digit_timeout,
                parking_res: parkingObj,
                "blind": blind, "hungup": hungup, "transfer": transfer, "parking": parking
                //app_map: app_mapObj
            }, function (result) {
                if (result.state == 0) {
                    $.get("/api/conf/reload", function (result) {
                    }, "json");
                    window.location.reload();
                }
            }, "json");
        });
    });
</script>


