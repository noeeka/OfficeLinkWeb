<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $lang[$_COOKIE['systec_lang']]['voicemailconf']; ?></title>
        <!-- Bootstrap CSS -->    
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <!-- bootstrap theme -->
        <link href="/css/bootstrap-theme.css" rel="stylesheet">
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
        <section id="container" class="">
            <?php include 'header.php'; ?> 
            <?php include 'navigate.php'; ?>
            <section id="main-content">
                <section class="wrapper">   
                    <div class="row">
                        <div class="col-lg-12">
                            <ol class="breadcrumb">
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['pbx']; ?></li>
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['voicemailconf']; ?></li>
                            </ol>
                        </div>
                    </div>
                    <table width="50%" style="line-height: 35px;">
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?>

                            </td>
                            <td>
                                <input type="text" id="tbextension" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['extension']; ?>"  />

                            </td>
                            <td align="left">
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_voicemail_extension_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_voicemail_extension_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_voicemail_extension_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['maxmessage']; ?>

                            </td>
                            <td>
                                <select id="tbmaxmessage">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                </select>

                            </td>
                            <td>
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_voicemail_maxmessage_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_voicemail_maxmessage_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_voicemail_maxmessage_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['maxsec']; ?>(s)
                            </td>
                            <td>
                                <select id="tbmaxsec">
                                    <option value="30">30</option>
                                    <option value="60">60</option>
                                    <option value="90">90</option>
                                </select>
                            </td>
                            <td>
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_voicemail_maxmessagetime_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_voicemail_maxmessagetime_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_voicemail_maxmessagetime_content']; ?>
                                        </p>
                                    </div>
                                </div>

                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['minsec']; ?>(s)

                            </td>
                            <td>
                                <select id="tbminsec">
                                    <option value="2">2</option>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                </select>

                            </td>
                            <td>
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_voicemail_minmessagetime_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_voicemail_minmessagetime_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_voicemail_minmessagetime_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['dial_voicemail']; ?>

                            </td>
                            <td>
                                <input type="checkbox" id="ckdial_voicemail">

                            </td>
                            <td>
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_voicemail_dialmessage_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_voicemail_dialmessage_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_voicemail_dial-directly_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <?php echo $lang[$_COOKIE['systec_lang']]['greating']; ?>
                            </td>
                            <td>
                                <input type="checkbox" id="ckgreating">
                            </td>
                            <td>
                                <img src="/img/tishi.png" class="tips" data-tooltip-content="#tips_voicemail_Play-envelope_content" style="padding-bottom:4px;"/>
                                <div id="tpl_tips_extension" style="display: none;">
                                    <div id="tips_voicemail_Play-envelope_content">
                                        <p style="text-align:left;">
                                            <?php echo $lang[$_COOKIE['systec_lang']]['tips_voicemail_Play-envelope_content']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr><td colspan="3"><button id="btnSave" type="submit" class="btn btn-primary"><?php echo $lang[$_COOKIE['systec_lang']]['update']; ?></button></td></tr>
                    </table>
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
<script>
    $(function () {
        $.get("/api/voicemail/conf", function (result) {
            $("#tbextension").val(result.extension);
            if (result.dial_voicemail=="true"){
                $("#ckdial_voicemail").attr("checked",true);
            }else{
                $("#ckdial_voicemail").attr("checked",false);
            }
            $("#tbmaxmessage").val(result.maxmessage);
            $("#tbmaxsec").val(result.maxsec);
            $("#tbminsec").val(result.minsec);
            if (result.greating=="true"){
                $("#ckgreating").attr("checked",true);
            }else{
                $("#ckgreating").attr("checked",false);
            }
        }, "json");
    });

    $("#btnSave").click(function () {
        var tbvm = false;
        var tbgreating = false;
        var tbextension = $("#tbextension").val();
        if ($("#ckdial_voicemail").is(':checked')) {
            tbvm = true;
        } else {
            tbvm = false;
        }


        if(is_not_null($("#tbextension"),"")==false){
            return false;
        }

        if(is_validate_length($("#tbextension"),"",20)==false){
            return false;
        }

        if(is_validate_number($("#tbextension"),"")==false){
            return false;
        }


        var tbmaxmessage = $("#tbmaxmessage").val();
        var tbmaxsec = $("#tbmaxsec").val();
        var tbminsec = $("#tbminsec").val();
        if ($("#ckgreating").is(':checked')) {
            tbgreating = true;
        } else {
            tbgreating = false;
        }
        var range_flag = true;
        $.ajax({type:"get",url:"/api/sip/conf",async : false,success : function(result){
            conference_exten = result.conference_exten;
            user_exten = result.user_exten;
            ivr_exten = result.ivr_exten;
            ringgroup_exten = result.ringgroup_exten;
            if ($("#tbextension").val() < conference_exten[1] && $("#tbextension").val() > conference_exten[0]) {
                range_flag = false;
            }else if ($("#tbextension").val() < user_exten[1] && $("#tbextension").val() > user_exten[0]){
                range_flag = false;
            }else if ($("#tbextension").val() < ivr_exten[1] && $("#tbextension").val() > ivr_exten[0]){
                range_flag = false;
            }else if($("#tbextension").val() < ringgroup_exten[1] && $("#tbextension").val() > ringgroup_exten[0]){
                range_flag = false;
            }else{
                range_flag = true;
            }
        },dataType:"json"
        });

        if (!range_flag) {
            $("#tbextension").css("border-color", "red");
            $("#tbextension").focus();
            $("#tbextension").val("");
            return false;
        } else {
            $("#extension").removeAttr("style");
        }

        $.post("/api/voicemail/conf/update",
                {"extension": tbextension, "dial_voicemail": tbvm, "maxmessage": tbmaxmessage, "maxsec": tbmaxsec, "minsec": tbminsec, "greating": tbgreating},
                function (result) {
                    if (result.state == 0) {
                        $.get("/api/conf/reload", function (result) {}, "json");
                        alert("<?php echo $lang[$_COOKIE['systec_lang']]['success']; ?>");
                    }
                }, "json");
    });
</script>
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