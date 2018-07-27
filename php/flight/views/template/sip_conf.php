<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang[$_COOKIE['systec_lang']]['sipconf']; ?></title>
    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="/css/bootstrap-theme.css" rel="stylesheet">
    <link href="/css/widgets.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/style-responsive.css" rel="stylesheet"/>

    <link rel="stylesheet" href="/css/jquery.fileupload.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/>
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
                        <li><?php echo $lang[$_COOKIE['systec_lang']]['sipconf']; ?></li>
                    </ol>
                </div>
            </div>
            <fieldset>
                <legend><?php echo $lang[$_COOKIE['systec_lang']]['sip_port_setting']; ?></legend>
                <table class="table">
                    <tr>
                        <td><?php echo $lang[$_COOKIE['systec_lang']]['sip_port']; ?></td>
                        <td style="padding-left: 10%;"><input type="text" id="sipport" placeholder="SIP <?php echo $lang[$_COOKIE['systec_lang']]['sip_port']; ?>" size="50"/></td>
                    </tr>
                    <tr>
                        <td><?php echo $lang[$_COOKIE['systec_lang']]['rtp_port_range']; ?></td>
                        <td style="padding-left: 10%;"><input type="text" id="rtp_port_from"
                                   placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['rtp_port_range']; ?> From"
                                   size="23"> - <input type="text"
                                                       id="rtp_port_to"
                                                       placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['rtp_port_range']; ?> To"
                                                       size="23"></td>
                    </tr>
                </table>
            </fieldset>

            <fieldset>
                <legend><?php echo $lang[$_COOKIE['systec_lang']]['sip_extension_setting']; ?></legend>
            <table class="table">
                <tr>
                    <td>
                        <?php echo $lang[$_COOKIE['systec_lang']]['user_exten']; ?>
                    </td>
                    <td>
                        <input type="text" id="user_exten_from" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['user_exten']; ?>" size="23">
                        -
                        <input type="text" id="user_exten_to" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['user_exten']; ?>" size="23">
                    </td>
                </tr>
                <tr>
                    <td><?php echo $lang[$_COOKIE['systec_lang']]['conference_exten']; ?></td>
                    <td>
                        <input type="text" id="conference_exten_from" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['conference_exten']; ?>" size="23">
                        -
                        <input type="text" id="conference_exten_to" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['conference_exten']; ?>" size="23">
                    </td>
                </tr>
                <tr>
                    <td><?php echo $lang[$_COOKIE['systec_lang']]['ivr_exten']; ?></td>
                    <td>
                        <input type="text" id="ivr_exten_from" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['ivr_exten']; ?>" size="23">
                        -
                        <input type="text" id="ivr_exten_to" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['ivr_exten']; ?>" size="23">
                    </td>
                </tr>
                <tr>
                    <td><?php echo $lang[$_COOKIE['systec_lang']]['ringgroup_exten']; ?></td>
                    <td><input type="text" id="ringgroup_exten_from" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['ringgroup_exten']; ?>" size="23">
                        -
                        <input type="text" id="ringgroup_exten_to" placeholder="<?php echo $lang[$_COOKIE['systec_lang']]['ringgroup_exten']; ?>" size="23"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button id="btnSave" type="submit" class="btn btn-primary"><?php echo $lang[$_COOKIE['systec_lang']]['update']; ?></button>
                    </td>
                </tr>
            </table>
            </fieldset>
        </section>
    </section>
    <!--main content end-->



    <div class="modal fade bs-example-modal-sm" id="del_com" tabindex="-1" role="dialog" aria-labelledby="del_comLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4><?php echo $lang[$_COOKIE['systec_lang']]['success']; ?></h4>
                </div>
            </div>
        </div>
    </div>
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
        $.get("/api/sip/conf", function (result) {
            $("#sipport").val(result.sip_port);
            rtp_port = result.rtp_port_range
            $("#rtp_port_from").val(rtp_port[0]);
            $("#rtp_port_to").val(rtp_port[1]);

            user_exten = result.user_exten;
            $("#user_exten_from").val(user_exten[0]);
            $("#user_exten_to").val(user_exten[1]);

            conference_exten = result.conference_exten;
            $("#conference_exten_from").val(conference_exten[0]);
            $("#conference_exten_to").val(conference_exten[1]);


            ivr_exten = result.ivr_exten;
            $("#ivr_exten_from").val(ivr_exten[0]);
            $("#ivr_exten_to").val(ivr_exten[1]);

            ringgroup_exten = result.ringgroup_exten;
            $("#ringgroup_exten_from").val(ringgroup_exten[0]);
            $("#ringgroup_exten_to").val(ringgroup_exten[1]);

        }, "json");
    });

    $("#btnSave").click(function () {

        if(is_not_null($("#sipport"),"")==false){
            return false;
        }

        if(is_validate_length($("#sipport"),"",10)==false){
            return false;
        }

        if(is_validate_number($("#sipport"),"")==false){
            return false;
        }


        if(is_not_null($("#rtp_port_from"),"")==false){
            return false;
        }
        if(is_validate_length($("#rtp_port_from"),"",10)==false){
            return false;
        }

        if(is_validate_number($("#rtp_port_from"),"")==false){
            return false;
        }


        if(is_not_null($("#rtp_port_to"),"")==false){
            return false;
        }
        if(is_validate_length($("#rtp_port_to"),"",10)==false){
            return false;
        }

        if(is_validate_number($("#rtp_port_to"),"")==false){
            return false;
        }


        if(is_not_null($("#user_exten_from"),"")==false){
            return false;
        }
        if(is_validate_length($("#user_exten_from"),"",10)==false){
            return false;
        }

        if(is_validate_number($("#user_exten_from"),"")==false){
            return false;
        }


        if(is_not_null($("#user_exten_to"),"")==false){
            return false;
        }
        if(is_validate_length($("#user_exten_to"),"",10)==false){
            return false;
        }

        if(is_validate_number($("#user_exten_to"),"")==false){
            return false;
        }

        if(is_not_null($("#conference_exten_from"),"")==false){
            return false;
        }
        if(is_validate_length($("#conference_exten_from"),"",10)==false){
            return false;
        }

        if(is_validate_number($("#conference_exten_from"),"")==false){
            return false;
        }

        if(is_not_null($("#conference_exten_to"),"")==false){
            return false;
        }
        if(is_validate_length($("#conference_exten_to"),"",10)==false){
            return false;
        }

        if(is_validate_number($("#conference_exten_to"),"")==false){
            return false;
        }

        if(is_not_null($("#ivr_exten_from"),"")==false){
            return false;
        }
        if(is_validate_length($("#ivr_exten_from"),"",10)==false){
            return false;
        }
        if(is_validate_number($("#ivr_exten_from"),"")==false){
            return false;
        }

        if(is_not_null($("#ivr_exten_to"),"")==false){
            return false;
        }
        if(is_validate_length($("#ivr_exten_to"),"",10)==false){
            return false;
        }
        if(is_validate_number($("#ivr_exten_to"),"")==false){
            return false;
        }

        if(is_not_null($("#ringgroup_exten_from"),"")==false){
            return false;
        }
        if(is_validate_length($("#ringgroup_exten_from"),"",10)==false){
            return false;
        }
        if(is_validate_number($("#ringgroup_exten_from"),"")==false){
            return false;
        }

        if(is_not_null($("#ringgroup_exten_to"),"")==false){
            return false;
        }
        if(is_validate_length($("#ringgroup_exten_to"),"",10)==false){
            return false;
        }
        if(is_validate_number($("#ringgroup_exten_to"),"")==false){
            return false;
        }

        var rtp_port_from = parseInt($("#rtp_port_from").val());
        var rtp_port_to = parseInt($("#rtp_port_to").val());
        var sipport = parseInt($("#sipport").val());
        if(rtp_port_from <= 1000 || rtp_port_to >= 60000 || rtp_port_from > rtp_port_to || rtp_port_from + 1000 >= rtp_port_to) {
            alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_rtp_tip']; ?>");
            window.location.reload();
            return false;
        }
        if(parseInt($("#rtp_port_from").val())>=parseInt($("#rtp_port_to").val())){
            alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_rtp_tip']; ?>");
            window.location.reload();
            return false;
        }

        if(sipport <= 1000 || sipport >= 60000) {
            alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_sip_tip']; ?>");
            window.location.reload();
            return false;
        }

        if(parseInt($("#user_exten_from").val())>=parseInt($("#user_exten_to").val())){
            alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_extension_tip']; ?>");
            window.location.reload();
            return false;
        }

        if(parseInt($("#conference_exten_from").val())>=parseInt($("#conference_exten_to").val())){
            alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_meetme_tip']; ?>");
            window.location.reload();
            //return false;
        }

        if(parseInt($("#ivr_exten_from").val())>=parseInt($("#ivr_exten_to").val())){
            alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_ivr_tip']; ?>");
            window.location.reload();
            //return false;
        }
        if(parseInt($("#ringgroup_exten_from").val())>=parseInt($("#ringgroup_exten_to").val())){
            alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_ringgroup_tip']; ?>");
            window.location.reload();
            //return false;
        }


        if($("#rtp_port_from").val()=="" || $("#rtp_port_to").val()==""){
            alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_rtp_tip']; ?>");
            window.location.reload();
            return false;
        }

        if($("#user_exten_from").val()=="" || $("#user_exten_to").val()==""){
            alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_extension_tip']; ?>");
            window.location.reload();
            return false;
        }

        if($("#conference_exten_from").val()=="" || $("#conference_exten_to").val()==""){
            alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_meetme_tip']; ?>");
            window.location.reload();
            return false;
        }

        if($("#ivr_exten_from").val()=="" || $("#ivr_exten_to").val()==""){
            alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_ivr_tip']; ?>");
            window.location.reload();
            return false;
        }
        if($("#ringgroup_exten_from").val()=="" || $("#ringgroup_exten_to").val()==""){
            alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_ringgroup_tip']; ?>");
            window.location.reload();
            return false;
        }

        var trix = new Array();
        trix[0]=[parseInt($("#user_exten_from").val()),parseInt($("#user_exten_to").val())];
        trix[1]=[parseInt($("#conference_exten_from").val()),parseInt($("#conference_exten_to").val())];
        trix[2]=[parseInt($("#ivr_exten_from").val()),parseInt($("#ivr_exten_to").val())];
        trix[3]=[parseInt($("#ringgroup_exten_from").val()),parseInt($("#ringgroup_exten_to").val())];
        console.log(trix);
        for(i=0;i<trix.length;i++){
            if(trix[i][1]<=trix[i][0]){
                return false;
            }
        }
        for(i=0;i<trix.length;i++){
            for(j=i+1;j<trix.length;j++){
                if(trix[j][1] >= trix[i][0] && trix[i][1] >= trix[j][0]) {
                    if(i==0 && j==1){
                        alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_extension_meeting_conflict']; ?>");
                        window.location.reload();
                    }else if(i==1 && j==2){
                        alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_extension_meeting_conflict']; ?>");
                        window.location.reload();
                    }else if(i==2 && j==3){
                        alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_ivr_ringgroup_conflict']; ?>");
                        window.location.reload();
                    }else if(i==0 && j==3){
                        alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_extension_ringgroup_conflict']; ?>");
                        window.location.reload();
                    }else if(i==0 && j==2){
                        alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_extension_ivrs_conflict']; ?>");
                        window.location.reload();
                    }else if(i==1 && j==3){
                        alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_meet_ringgroup_conflict']; ?>");
                        window.location.reload();
                    }else if(i==2 && j==3){
                        alert("<?php echo $lang[$_COOKIE['systec_lang']]['sip_ringgroup_ivrs_conflict']; ?>");
                        window.location.reload();
                    }
                    return false;
                }
            }
        }
        $.post("/api/sip/conf/update", {
                "sip_port": $("#sipport").val(),
                "rtp_port_range": [$("#rtp_port_from").val(), $("#rtp_port_to").val()],
                "user_exten": [$("#user_exten_from").val(), $("#user_exten_to").val()],
                "conference_exten": [$("#conference_exten_from").val(), $("#conference_exten_to").val()],
                "ivr_exten": [$("#ivr_exten_from").val(), $("#ivr_exten_to").val()],
                "ringgroup_exten": [$("#ringgroup_exten_from").val(), $("#ringgroup_exten_to").val()]
            },
            function (result) {
                if (result.state == 0) {
                    $.get("/api/conf/reload", function (result) {
                    }, "json");
                    //window.location.reload();
                    //$("#btnSave").addClass("btn btn-default")
                    $("body").append('<div class="modal-backdrop fade in"></div>');
                    $("#del_com").addClass("in");
                    $("#del_com").show();

                    setTimeout(function(){
                        $(".modal-backdrop").remove();
                        $("#del_com").removeClass("in");
                        $("#del_com").hide();

                    },1000);
                }
            }, "json");
    });
</script>
