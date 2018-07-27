<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="James Chen">
    <title><?php echo $lang[$_COOKIE['systec_lang']]['extensionsetting']; ?></title>
    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/widgets.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/style-responsive.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/css/jquery.fileupload.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.timepicker.css"/>
    <link rel="stylesheet" type="text/css" href="/css/tooltipster.bundle.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-shadow.min.css"/>
    <style>
        .img-container img {
            max-width: 100%;
        }
    </style>
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
                        <li><?php echo $lang[$_COOKIE['systec_lang']]['extensionsetting']; ?></li>
                    </ol>
                </div>
            </div>
            <?php if($couldadd==true){?>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#AddSip">
                    <?php echo $lang[$_COOKIE['systec_lang']]['addextension']; ?>
                </button>
            <?php } ?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>
                        <?php echo $lang[$_COOKIE['systec_lang']]['avatar']; ?>
                    </td>
                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?>
                    </td>
                    <td align='center' valign='middle'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['nickname']; ?>
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


<!-- Modal -->
<div class="modal fade" id="avatar_crop" tabindex="1" role="dialog" aria-labelledby="avatar_crop">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="close_image_processer();" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Nicer Processer</h4>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="image_crop_raw" src="" alt="Picture">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="crop_finish">Save changes</button>
            </div>
        </div>
    </div>
</div>


<!--添加分机弹层-->
<div class="modal fade" id="AddSip" tabindex="-1" role="dialog" aria-labelledby="AddUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 740px;">
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
                    <?php echo $lang[$_COOKIE['systec_lang']]['addextension']; ?>
                </h4>
            </div>
            <div class="modal-body">
                    <table cellpadding="5">
                        <tr>
                            <td><img width="100" height="100" id="AddAAvaterPreview" src="/img/avatar100.png"/></td>
                            <td>
                                        <span class="btn btn-primary fileinput-button" style="background-color:#007aff;">
                                            <span>
                                                <?php echo $lang[$_COOKIE['systec_lang']]['chooseavatar']; ?>
                                            </span>
                                            <input id="AddSipAvatar" type="file" name="files[]">
                                        </span>

                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_extension_avatar_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_extension_avatar_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tip_avatar']; ?>
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
                                <input id="extension" name="extension"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?>"
                                       class="input-mini" type="text" value="<?php echo $availble; ?>" autocomplete="off">
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_extension_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_extension_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tip_extension']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['nickname']; ?>
                            </td>
                            <td>
                                <input id="nickname" name="nickname"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['nickname']; ?>"
                                       class="input-small" type="text" autocomplete="off">
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_nickname_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_nickname_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tip_nickname']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['password']; ?>
                            </td>
                            <td>
                                <input style="display: none" type="text" />
                                <input style="display: none" type="password"/>
                                <input id="password" name="password" type="password"
                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['password']; ?>" autocomplete="off">
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_password_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_password_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tip_password']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['emailpin']; ?>
                            </td>
                            <td>
                                <input style="display: none" type="text" />
                                <input style="display: none" type="password"/>
                                <input id="voicemail_pin" name="voicemail_pin" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['emailpin']; ?>"  type="password">
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_emailpin_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_emailpin_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tip_emailpin']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['encode']; ?>
                            </td>
                            <td>
                                <input type="checkbox" id="video_support" name="video_support">
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_encode_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_encode_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tip_encode']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['timeout']; ?>(s)
                            </td>
                            <td>
                                <select id="ring_tmeout">
                                    <option value="0"><?php echo $lang[$_COOKIE['systec_lang']]['forever']; ?></option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                    <option value="60">60</option>
                                    <option value="80">80</option>
                                    <option value="100">100</option>
                                    <option value="120">120</option>
                                </select>
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_timeout_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_timeout_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_timeout_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['transferday']; ?>
                            </td>
                            <td>
                                <ul id="transferday" style="list-style:none;margin:0;padding-left: 0px;">
                                    <li style="display:inline">
                                        <input tabindex="1" type="checkbox" id="transferday1" name="transfer_day"
                                               value="1" checked="checked">
                                        <label for="transferday1">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['monday']; ?>
                                        </label>
                                    </li>
                                    <li style="display:inline">
                                        <input tabindex="2" type="checkbox" id="transferday2" name="transfer_day"
                                               value="2" checked="checked">
                                        <label for="transferday2">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tuesday']; ?>
                                        </label>
                                    </li>
                                    <li style="display:inline">
                                        <input tabindex="3" type="checkbox" id="transferday3" name="transfer_day"
                                               value="3" checked="checked">
                                        <label for="transferday3">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['wednesday']; ?>
                                        </label>
                                    </li>
                                    <li style="display:inline">
                                        <input tabindex="4" type="checkbox" id="transferday4" name="transfer_day"
                                               value="4" checked="checked">
                                        <label for="transferday4">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['thursday']; ?>
                                        </label>
                                    </li>
                                    <li style="display:inline">
                                        <input tabindex="5" type="checkbox" id="transferday5" name="transfer_day"
                                               value="5" checked="checked">
                                        <label for="transferday5">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['friday']; ?>
                                        </label>
                                    </li>
                                    <li style="display:inline">
                                        <input tabindex="6" type="checkbox" id="transferday6" name="transfer_day"
                                               value="6">
                                        <label for="transferday6">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['saturday']; ?>
                                        </label>
                                    </li>
                                    <li style="display:inline">
                                        <input tabindex="7" type="checkbox" id="transferday7" name="transfer_day"
                                               value="7">
                                        <label for="transferday7">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['sunday']; ?>
                                        </label>
                                    </li>
                                    <img src="/img/tishi.png" class="tips"
                                         data-tooltip-content="#tips_transferday_content"
                                         style="padding-bottom:4px;"/>
                                </ul>

                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_transferday_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_transferday_content']; ?>
                                        </p>
                                    </div>
                                </div>
                                <input type="hidden" id="transferDayHide" value=""/>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['transfertime']; ?>
                            </td>
                            <td>
                                <input type="text" id="fromTime" name="fromTime" value="08:30"/>-<input type="text" id="endTime"
                                                                                          name="endTime" value="17:30"/>
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_transfertime_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_transfertime_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_transfertime_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['transferway']; ?>
                            </td>
                            <td>
                                <select id="transfer_style" name="transfer_style">
                                    <option value="absent"><?php echo $lang[$_COOKIE['systec_lang']]['absent']; ?></option>
                                    <option value="direct"><?php echo $lang[$_COOKIE['systec_lang']]['direct']; ?></option>
                                </select>
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_transferway_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_transferway_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_transferway_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['transfertype']; ?>
                            </td>
                            <td>
                                <select id="transfer_type" name="transfer_type">
                                    <option value="voicemail"><?php echo $lang[$_COOKIE['systec_lang']]['voicemail']; ?></option>
                                    <option value="dial"><?php echo $lang[$_COOKIE['systec_lang']]['dial']; ?></option>
                                </select>
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_transfertype_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_transfertype_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_transfertype_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['transfertarget']; ?>
                            </td>
                            <td>
                                <input id="transfer_target" name="transfer_target" value="" readonly="readonly"/><span style="cursor: pointer" onclick="clear_transfer_target();">&times;</span>
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_transfertarget_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_transfertarget_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_transfertarget_content']; ?>
                                        </p>
                                    </div>
                                </div>
                                <script>
                                    function clear_transfer_target(){
                                    $("#transfer_target").val("");
$("#edit_transfer_target").val("");
                                    }
                                </script>

                                <div id="modal_transfertarget" style="display: none; z-index: 50; height: 110px;margin-bottom: 115px;">
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
                                            <?php echo $lang[$_COOKIE['systec_lang']]['choosetarget']; ?>
                                        </h4>
                                    </div>
                                    <table class="transfertarget_table" width="100%" cellpadding="5"></table>
                                    <nav>
                                        <ul id="pagination_transfertarget" class="pagination">
                                        </ul>
                                    </nav>
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
<div class="modal fade" id="EditUser" tabindex="-1" role="dialog" aria-labelledby="EditUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 740px;">
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
                    <?php echo $lang[$_COOKIE['systec_lang']]['updatesipinfo']; ?>
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <table cellpadding="5">
                        <tr>
                            <td><img src="" width="100" height="100" id="EditAvaterPreview"/></td>
                            <td>
                                        <span class="btn btn-success fileinput-button" style="background-color:#007aff">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>
                                                <?php echo $lang[$_COOKIE['systec_lang']]['chooseavatar']; ?>
                                            </span>
                                            <input id="EditSipAvatar" type="file" name="files[]"></span>

                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_extension_avatar_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_extension_avatar_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tip_avatar']; ?>
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
                                <input id="edit_extension" readonly="true" name="edit_extension" placeholder="分机号码"
                                       type="text" disabled="true">
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_extension_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_extension_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tip_extension']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['nickname']; ?>
                            </td>
                            <td>
                                <input id="edit_nickname" name="edit_nickname" type="text">
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_nickname_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_nickname_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tip_nickname']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['password']; ?>
                            </td>
                            <td>
                                <input id="edit_password" name="edit_password" type="password">
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_password_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_password_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tip_password']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['emailpin']; ?>
                            </td>
                            <td>
                                <input style="display: none" type="text" />
                                <input style="display: none" type="password"/>
                                <input id="edit_voicemail_pin" name="edit_voicemail_pin" type="password">
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_emailpin_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_emailpin_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tip_emailpin']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['encode']; ?>
                            </td>

                            <td>
                                <input type="checkbox" id="edit_video_support" name="edit_video_support" value="h263,h263p,h264">
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_encode_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_encode_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tip_encode']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>


                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['timeout']; ?>(s)
                            </td>
                            <td>
                                <select id="edit_ring_tmeout">
                                    <option value="0"><?php echo $lang[$_COOKIE['systec_lang']]['forever']; ?></option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                    <option value="60">60</option>
                                    <option value="80">80</option>
                                    <option value="100">100</option>
                                    <option value="120">120</option>
                                </select>
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_timeout_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_timeout_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_timeout_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['transferday']; ?>
                            </td>
                            <td>
                                <ul id="edit_transferday" style="list-style:none;margin:0;padding-left: 0px;">
                                    <li style="display:inline">
                                        <input tabindex="1" type="checkbox" id="edit_transferday1"
                                               name="edit_transfer_day" value="1">
                                        <label for="edit_transferday1">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['monday']; ?>
                                        </label>
                                    </li>
                                    <li style="display:inline">
                                        <input tabindex="2" type="checkbox" id="edit_transferday2"
                                               name="edit_transfer_day" value="2">
                                        <label for="edit_transferday2">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tuesday']; ?>
                                        </label>
                                    </li>
                                    <li style="display:inline">
                                        <input tabindex="3" type="checkbox" id="edit_transferday3"
                                               name="edit_transfer_day" value="3">
                                        <label for="edit_transferday3">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['wednesday']; ?>
                                        </label>
                                    </li>
                                    <li style="display:inline">
                                        <input tabindex="4" type="checkbox" id="edit_transferday4"
                                               name="edit_transfer_day" value="4">
                                        <label for="edit_transferday4">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['thursday']; ?>
                                        </label>
                                    </li>
                                    <li style="display:inline">
                                        <input tabindex="5" type="checkbox" id="edit_transferday5"
                                               name="edit_transfer_day" value="5">
                                        <label for="edit_transferday5">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['friday']; ?>
                                        </label>
                                    </li>
                                    <li style="display:inline">
                                        <input tabindex="6" type="checkbox" id="edit_transferday6"
                                               name="edit_transfer_day" value="6">
                                        <label for="edit_transferday6">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['saturday']; ?>
                                        </label>
                                    </li>
                                    <li style="display:inline">
                                        <input tabindex="7" type="checkbox" id="edit_transferday7"
                                               name="edit_transfer_day" value="7">
                                        <label for="edit_transferday7">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['sunday']; ?>
                                        </label>
                                    </li>
                                    <img src="/img/tishi.png" class="tips"
                                         data-tooltip-content="#tips_transferday_content"
                                         style="padding-bottom:4px;"/>
                                </ul>

                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_transferday_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_transferday_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['transfertime']; ?>
                            </td>
                            <td>
                                <input type="text" id="edit_fromTime" name="edit_fromTime"/>
                                -
                                <input type="text" id="edit_endTime" name="edit_endTime"/>
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_transfertime_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_transfertime_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_transfertime_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['transferway']; ?>
                            </td>
                            <td>
                                <select id="edit_transfer_style" name="edit_transfer_style">
                                    <option value="absent"><?php echo $lang[$_COOKIE['systec_lang']]['absent']; ?></option>
                                    <option value="direct"><?php echo $lang[$_COOKIE['systec_lang']]['direct']; ?></option>
                                </select>
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_transferway_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_transferway_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_transferway_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['transfertype']; ?>
                            </td>
                            <td>
                                <select id="edit_transfer_type" name="edit_transfer_type">
                                    <option value="dial"><?php echo $lang[$_COOKIE['systec_lang']]['dial']; ?></option>
                                    <option value="voicemail"><?php echo $lang[$_COOKIE['systec_lang']]['voicemail']; ?></option>
                                </select>
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_transfertype_content"
                                     style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_transfertype_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_transfertype_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['transfertarget']; ?>
                            </td>
                            <td>
                                <input id="edit_transfer_target" name="edit_transfer_target" readonly="readonly"/><span style="cursor: pointer" onclick="clear_transfer_target();">&times;</span>
                                <img src="/img/tishi.png" class="tips"
                                     data-tooltip-content="#tips_transfertarget_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_transfertarget_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_transfertarget_content']; ?>
                                        </p>
                                    </div>
                                </div>

                                <div id="edit_modal_transfertarget"
                                     style="display: none; z-index: 50; height: 110px;margin-bottom: 115px;">
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
                                            <?php echo $lang[$_COOKIE['systec_lang']]['choosetarget']; ?>
                                        </h4>
                                    </div>
                                    <table class="transfertarget_table" width="100%" cellpadding="5"></table>
                                    <nav>
                                        <ul id="edit_pagination_transfertarget" class="pagination">
                                        </ul>
                                    </nav>
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


<!-- 图片上传插件 -->
<script src="/js/jquery.min.js"></script>
<script src="/js/jquery.ui.widget.js"></script>
<script src="/js/jquery.iframe-transport.js"></script>
<script src="/js/jquery.fileupload.js"></script>
<script src="/js/jquery.timepicker.full.min.js"></script>

<script>
    $('#fromTime').datetimepicker({
        datepicker: false,
        format: 'H:i',
        step: 3
    });

    $('#endTime').datetimepicker({
        datepicker: false,
        format: 'H:i',
        step: 3
    });

    $('#edit_fromTime').datetimepicker({
        datepicker: false,
        format: 'H:i',
        step: 3
    });

    $('#edit_endTime').datetimepicker({
        datepicker: false,
        format: 'H:i',
        step: 3
    });
</script>

<!--转移联动操作-->
<script>
    function showtargettransfer(name) {
        $("#transfer_target").val(name);
        $("#modal_transfertarget").hide();

        $("#edit_transfer_target").val(name);
        $("#edit_modal_transfertarget").hide();
    }

    function ajaxPaginationforTargets(page) {
        var str = "<tr>";
        $.get("/api/extensions/" + page + "/20", function (result) {
            var pagination = "";
            if(result.extensions!=null) {
                $.each(result.extensions, function (k, n) {
                    if ((k + 1) % 5 == 0) {
                        str += "<td><a href='javascript:void(0)' onclick='showtargettransfer(\"" + n.extension + "\")' >" + n.extension + "</a></td></tr><tr>";
                    } else {
                        str += "<td><a href='javascript:void(0)' onclick='showtargettransfer(\"" + n.extension + "\")' >" + n.extension + "</a></td>";
                    }
                });
            }
            $(".transfertarget_table").html(str);
            pagination = '<li><a href="javascript:void(0)" onclick="ajaxPaginationforTargets(1)">&laquo;</a></li>';
            for (i = 1; i <= Math.ceil(result.total_count / 20); i++) {
                pagination += '<li><a href="javascript:void(0)" onclick="ajaxPaginationforTargets(' + i + ')">' + i + '</a></li>';
            }
            pagination += '<li><a href="javascript:void(0)" onclick="ajaxPaginationforTargets(' + Math.ceil(result.total_count / 20) + ')">&raquo;</a></li>';
            $("#pagination_transfertarget").html(pagination);
            $("#edit_pagination_transfertarget").html(pagination);
        }, "json");
    }

    function close_rulers() {
        $("#modal_dailplans").hide();
        $("#modal_transfertarget").hide();
        $("#edit_modal_dailplans").hide();
        $("#edit_modal_transfertarget").hide();
    }


    $(function () {
        $("#transfer_target").click(function () {
            $("#modal_transfertarget").show();
            ajaxPaginationforTargets(1);
        });

        $("#edit_transfer_target").click(function () {

            $("#edit_modal_transfertarget").show();
            ajaxPaginationforTargets(1);
        });
        $.get("/api/extensions/", function (result) {
            if(result.extensions!=null){
                $.each(result.extensions, function (i, n) {
                    $('#edit_transfer_target').append('<option value=' + n.extension + '>' + n.extension + '</option>')
                });
                $.each(result.extensions, function (i, n) {
                    $('#transfer_target').append('<option value=' + n.extension + '>' + n.extension + '</option>')
                })
            }

        }, "json");
    });
</script>
<script>
    $(function () {
        var image = document.getElementById('image_crop_raw');
        var cropBoxData;
        var canvasData;
        var cropper;

        $('#AddSipAvatar').fileupload({
            url: '/api/uploadAvatar',
            dataType: 'json',
            done: function (e, data) {
                $('#AddAAvaterPreview').attr('src', '/tmp/' + data.result.name);
            },
        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');


        $('#EditSipAvatar').fileupload({
            url: '/api/uploadAvatar',
            dataType: 'json',
            done: function (e, data) {
                $('#EditAvaterPreview').attr('src', '/tmp/' + data.result.name);
            },
        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>
<script>
    $(function () {
        $('#EditUser').on('hide.bs.modal', function() {
            window.location.reload();
        });
        if (window.location.href.indexOf("#") > 0) {
            page = window.location.href.split("#").pop();
        } else {
            page = 1;
        }
        ajaxPagination(page);
        $("#add_submit").click(function () {
            var extension = $("#extension").val();
            var nickname = $("#nickname").val();
            var photo = $("#AddAAvaterPreview").attr("src");
            var dialplan = $("#dialplan").val();
            var password = $("#password").val();
            var email = $("#email").val();
            var voicemail_pin = $("#voicemail_pin").val();
            var transfer_days = new Array();
            $("input[name='transfer_day']:checkbox:checked").each(function () {
                transfer_days.push($(this).val());
            });
            var video=0;
            if($('#video_support').is(':checked')){
                video=1;
            }else{
                video=0;
            }

            var transfer_time = "['" + $("#fromTime").val() + "','" + $("#endTime").val() + "']";
            var transfer_time = strToJson(transfer_time);
            var transfer_style = $("#transfer_style").val();
            var transfer_type = $("#transfer_type").val();
            var transfer_target = $("#transfer_target").val();
            var ring_tmeout = $("#ring_tmeout").val();

            //添加验证
            if(is_not_null($("#extension"),"")==false){
                return false;
            }
            if(is_validate_length($("#extension"),"",10)==false){
                return false;
            }
            if(is_validate_number($("#extension"),"")==false){
                return false;
            }
            if(is_in_range($("#extension"),"user_exten","")==false){
                return false;
            }
            if(is_validate_length($("#nickname"),"",20)==false){
                return false;
            }
            if(is_validate_charactor($("#password"),"")==false){
                return false;
            }
            if(is_validate_length($("#password"),"",20)==false){
                return false;
            }
            if(is_not_null($("#password"),"",20)==false){
                return false;
            }
            if(is_validate_charactor($("#voicemail_pin"),"")==false){
                return false;
            }

            if(is_validate_number($("#voicemail_pin"),"")==false){
                return false;
            }

            if(is_validate_length($("#voicemail_pin"),"",10)==false){
                return false;
            }
            if(is_not_null($("#voicemail_pin"),"",20)==false){
                return false;
            }
            if(is_repeat_val($("#extension"),"/api/extensions/checkextension","extension","")==false){
                return false;
            }

            if($("#fromTime").val()>$("#endTime").val()){
                $("#fromTime").css("border-color", "red");
                $("#endTime").css("border-color", "red");
                $("#fromTime").focus();
                return false;
            }else{
                $("#fromTime").removeAttr("style");
                $("#endTime").removeAttr("style");
            }

            $.post("/api/extensions/add/", {
                extension: extension,
                nickname: nickname,
                photo: photo,
                dialplan:'dialplan',
                password: password,
                voicemail_pin: voicemail_pin,
                codecs: "",
                transfer_days: transfer_days,
                transfer_time: transfer_time,
                transfer_style: transfer_style,
                transfer_type: transfer_type,
                transfer_target: transfer_target,
                email:'email',
                ring_timeout: ring_tmeout,
                video:video
            }, function (result) {
                if (result.state == 0) {
                    $.get("/api/conf/reload", function (result) {
                    }, "json");
                    window.location.reload();
                }
            }, "json");
        });


        $("#edit_submit").click(function () {
            var extension = $("#edit_extension").val();
            var nickname = $("#edit_nickname").val();
            var photo = $("#EditAvaterPreview").attr("src");
            var dialplan = 'dialplan';
            var password = $("#edit_password").val();
            var email = 'email';
            var voicemail_pin = $("#edit_voicemail_pin").val();
            var video=0;
            if($('#edit_video_support').is(':checked')){
                video=1;
            }else{
                video=0;
            }
            var transfer_days = new Array();
            $("input[name='edit_transfer_day']:checkbox:checked").each(function () {
                transfer_days.push($(this).val());
            });
            var transfer_time = '["' + $("#edit_fromTime").val() + '","' + $("#edit_endTime").val() + '"]';
            var transfer_time = strToJson(transfer_time);
            var transfer_style = $("#edit_transfer_style").val();
            var transfer_type = $("#edit_transfer_type").val();
            var transfer_target = $("#edit_transfer_target").val();
            var ring_tmeout = $("#edit_ring_tmeout").val();
            //添加验证
            if(is_validate_length($("#edit_nickname"),"",20)==false){
                return false;
            }

            if(is_validate_charactor($("#edit_password"),"")==false){
                return false;
            }

            if(is_not_null($("#edit_password"),"")==false){
                return false;
            }

            if(is_validate_length($("#edit_password"),"",20)==false){
                return false;
            }

            if(is_validate_charactor($("#edit_voicemail_pin"),"")==false){
                return false;
            }

            if(is_validate_number($("#edit_voicemail_pin"),"")==false){
                return false;
            }

            if(is_validate_length($("#edit_voicemail_pin"),"",10)==false){
                return false;
            }

            if(is_not_null($("#edit_voicemail_pin"),"")==false){
                return false;
            }

            if($("#edit_fromTime").val()>$("#edit_endTime").val()){
                $("#edit_fromTime").css("border-color", "red");
                $("#edit_endTime").css("border-color", "red");
                $("#edit_fromTime").focus();
                return false;
            }else{
                $("#edit_fromTime").removeAttr("style");
                $("#edit_endTime").removeAttr("style");
            }

            $.post("/api/extensions/update/", {
                extension: extension,
                nickname: nickname,
                photo: photo,
                dialplan: "",
                password: password,
                email: "",
                voicemail_pin: voicemail_pin,
                codecs: "",
                transfer_days: JSON.stringify(transfer_days),
                transfer_time: transfer_time,
                transfer_style: transfer_style,
                transfer_type: transfer_type,
                transfer_target: transfer_target,
                ring_timeout: ring_tmeout,
                video:video
            }, function (result) {
                if (result.state == 0) {
                    $.get("/api/conf/reload", function (result) {
                    }, "json");
                    window.location.reload();
                }
            }, "json");

        });
    });

    function ajaxPagination(page) {
        $.ajax({
            url: "/api/extensions/" + page + "/20",
            type: "GET",
            beforeSend: function (xhr) {
                if(!xhr){
                    $("#extensions_conf").html("<img src='/img/ajax-loader.gif'/>");
                }
            },
            success: function (result) {
                if(result.extensions!=null){
                    var str = "";
                    var pagination = "";
                    $.each(result.extensions, function (k, n) {
                        str += "<tr>";
                        if (n.photo == "") {
                            photo = "/img/avatar100.png";
                        } else {
                            photo = n.photo;
                        }
                        str += "<td><img alt='" + n.nickname + "' src='" + photo + "#<?php echo time(); ?>'+ width='50' height='50'/></td><td align='center' valign='middle'>" + n.extension + "</td><td align='center' valign='middle'>" + n.nickname + "</td><td align='center' valign='middle'><div class='btn-group'><button type='button' class='btn btn-default' data-toggle='modal' data-target='#EditUser' onclick='ShowEditPanel(" + n.extension + ")'><?php echo $lang[$_COOKIE['systec_lang']]['update']; ?></button><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#del_com' onclick='DeleteSip(" + n.extension + ")'><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button></div></td>";
                        str += "</tr>";
                    });
                    $("#extensions_conf").html(str);
                    getPagiation(result.total_count,$(".pagination"));
                }
            }, dataType: "json"
        });
    }

    function strToJson(str) {
        var json = eval('(' + str + ')');
        return json;
    }
</script>
<!--添加编辑服务-->
<script>
    function ShowEditPanel(uid) {
        $("#EditUser").show();
        $.post("/api/extensions/info", {extension: uid}, function (data) {
            if (data.photo == "") {
                photo = "/img/avatar100.png";
            } else {
                photo = data.photo;
            }
            $("#EditAvaterPreview").attr("src", photo);
            $("#edit_extension").val(data.extension);
            $("#edit_nickname").val(data.nickname);
            $("#edit_password").val(data.password);
            $("#edit_ring_tmeout").val(data.ring_timeout);
            $("#edit_voicemail_pin").val(data.voicemail_pin);
            if (data.transfer_days) {
                $.each(eval(data.transfer_days), function (name, value) {
                    $("#edit_transferday" + value).attr("checked", true);
                });
            }
            var result_edit_transfer_time = eval(data.transfer_time);
            $("#edit_transferDayHide").val(data.transfer_days);
            $("#edit_fromTime").val(result_edit_transfer_time[0]);
            $("#edit_endTime").val(result_edit_transfer_time[1]);
            $("#edit_transfer_style").val(data.transfer_style);
            $("#edit_transfer_target").val(data.transfer_target);
            $("#edit_voicemail_pin").val(data.voicemail_pin);
            $("#edit_dialplan").val(data.dialplan);
            $("#edit_transfer_type").val(data.transfer_type);

            $("#edit_encodec").val(data.codecs);
            if(data.video=="1"){
                $("#edit_video_support").attr("checked",true);
            }else{
                $("#edit_video_support").attr("checked",false);
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
                <button type="button" class="btn btn-danger" id="confirm_del_btn" filed="" onclick="confirm_del();"><?php echo $lang[$_COOKIE['systec_lang']]['confirm']; ?></button>
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
        $.post("/api/extensions/delete", {extension: $("#confirm_del_btn").attr("filed")}, function (result) {
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

    function convertCanvasToImage(canvas) {
        var image = new Image();
        image.src = canvas.toDataURL("image/png");
        return image;
    }
    function close_image_processer() {
        $("#avatar_crop").hide();
        $("#AddSip").css("z-index", "1032");
    }
</script>
</body>
</html>
