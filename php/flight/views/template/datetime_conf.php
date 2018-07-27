<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $lang[$_COOKIE['systec_lang']]['datetime']; ?></title>
        <!-- Bootstrap CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/widgets.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">
        <link href="/css/style-responsive.css" rel="stylesheet"/>
        <link rel="stylesheet" type="text/css" href="/css/jquery.timepicker.css"/>
        <script src="/js/jquery.js"></script>
        <script src="/js/jquery-1.8.3.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
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
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['systemcong']; ?></li>
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['datetime']; ?></li>
                            </ol>
                        </div>
                    </div>
                    <h2 class="sub-header">
                        <?php echo $lang[$_COOKIE['systec_lang']]['datetime']; ?>
                    </h2>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td><?php echo $lang[$_COOKIE['systec_lang']]['timezone']; ?>：</td>
                                <td>
                                    <select id="timezone" name="timezone">
                                        <option value="Etc/GMT"><?php echo $lang[$_COOKIE['systec_lang']]['utc']; ?></option>
                                        <option value="Etc/GMT+1"><?php echo $lang[$_COOKIE['systec_lang']]['utc+1']; ?></option>
                                        <option value="Etc/GMT+2"><?php echo $lang[$_COOKIE['systec_lang']]['utc+2']; ?></option>
                                        <option value="Etc/GMT+3"><?php echo $lang[$_COOKIE['systec_lang']]['utc+3']; ?></option>
                                        <option value="Etc/GMT+4"><?php echo $lang[$_COOKIE['systec_lang']]['utc+4']; ?></option>
                                        <option value="Etc/GMT+5"><?php echo $lang[$_COOKIE['systec_lang']]['utc+5']; ?></option>
                                        <option value="Etc/GMT+6"><?php echo $lang[$_COOKIE['systec_lang']]['utc+6']; ?></option>
                                        <option value="Etc/GMT+7"><?php echo $lang[$_COOKIE['systec_lang']]['utc+7']; ?></option>
                                        <option value="Etc/GMT+8"><?php echo $lang[$_COOKIE['systec_lang']]['utc+8']; ?></option>
                                        <option value="Etc/GMT+9"><?php echo $lang[$_COOKIE['systec_lang']]['utc+9']; ?></option>
                                        <option value="Etc/GMT+10"><?php echo $lang[$_COOKIE['systec_lang']]['utc+10']; ?></option>
                                        <option value="Etc/GMT+11"><?php echo $lang[$_COOKIE['systec_lang']]['utc+11']; ?></option>
                                        <option value="Etc/GMT+12"><?php echo $lang[$_COOKIE['systec_lang']]['utc+12']; ?></option>
                                        <option value="Etc/GMT-12"><?php echo $lang[$_COOKIE['systec_lang']]['utc-12']; ?></option>
                                        <option value="Etc/GMT-11"><?php echo $lang[$_COOKIE['systec_lang']]['utc-11']; ?></option>
                                        <option value="Etc/GMT-10"><?php echo $lang[$_COOKIE['systec_lang']]['utc-10']; ?></option>
                                        <option value="Etc/GMT-9"><?php echo $lang[$_COOKIE['systec_lang']]['utc-9']; ?></option>
                                        <option value="Etc/GMT-8"><?php echo $lang[$_COOKIE['systec_lang']]['utc-8']; ?></option>
                                        <option value="Etc/GMT-7"><?php echo $lang[$_COOKIE['systec_lang']]['utc-7']; ?></option>
                                        <option value="Etc/GMT-6"><?php echo $lang[$_COOKIE['systec_lang']]['utc-6']; ?></option>
                                        <option value="Etc/GMT-5"><?php echo $lang[$_COOKIE['systec_lang']]['utc-5']; ?></option>
                                        <option value="Etc/GMT-4"><?php echo $lang[$_COOKIE['systec_lang']]['utc-4']; ?></option>
                                        <option value="Etc/GMT-3"><?php echo $lang[$_COOKIE['systec_lang']]['utc-3']; ?></option>
                                        <option value="Etc/GMT-2"><?php echo $lang[$_COOKIE['systec_lang']]['utc-2']; ?></option>
                                        <option value="Etc/GMT-1"><?php echo $lang[$_COOKIE['systec_lang']]['utc-1']; ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang[$_COOKIE['systec_lang']]['date']; ?>:</td>
                                <td><input type="text" id="date"/></td>
                            </tr>
                            <tr>
                                <td><?php echo $lang[$_COOKIE['systec_lang']]['time']; ?>:</td>
                                <td><select id="hours"></select>:<select id="mins"></select></td>
                            </tr>
                            <tr style='display:none;'>
                                <td><?php echo $lang[$_COOKIE['systec_lang']]['ntpenable']; ?>:</td>
                                <td><select id="ntp">
                                        <option value="false"><?php echo $lang[$_COOKIE['systec_lang']]['disable']; ?></option>
                                        <option value="true"><?php echo $lang[$_COOKIE['systec_lang']]['enable']; ?></option>
                                    </select></td>
                            </tr>
                            <tr style='display:none;'>
                                <td><?php echo $lang[$_COOKIE['systec_lang']]['ntpserver']; ?>:</td>
                                <td><input type="text" id="ntpserver" disabled="disabled"/></td>
                            </tr>
                        </table>

                        <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#del_com'
                                id="edit_submit">
                                    <?php echo $lang[$_COOKIE['systec_lang']]['update']; ?>
                        </button>

                    </div>
                </section>
            </section>
            <!--main content end-->
        </section>

        <div class="modal fade bs-example-modal-sm" id="success" tabindex="-1" role="dialog" aria-labelledby="del_comLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h4><?php echo $lang[$_COOKIE['systec_lang']]['success']; ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<!-- nice scroll -->
<script src="/js/jquery.timepicker.full.min.js"></script>
<script>
    $('#date').datetimepicker({
        autoclose: true,
        timepicker: false,
        format: 'Y.m.d',
    });

</script>

<script src="/js/jquery.scrollTo.min.js"></script>
<script src="/js/jquery.nicescroll.js" type="text/javascript"></script>
<!-- jquery knob 
<script src="/assets/jquery-knob/js/jquery.knob.js"></script>-->
<script src="/js/scripts.js"></script>
<script>
    $(function () {
        $.get("/api/datetime", function (result) {
            $("#timezone").val(result.timezone);
            $("#date").val(result.date);
            time = result.time.split(":");
            $("#ntp").val(result.ntp);
            $("#ntpserver").val(result.ntpserver);
        }, "json");
    })
</script>
<script>
    $(function () {
        $.get("/api/datetime", function (result) {
            $("#timezone").val(result.timezone);
            time = result.time.split(":");
            var h = "";
            for (var hour = 00; hour <= 23; hour++) {
                if (hour == time[0]) {
                    h += "<option value='" + hour + "' selected ='selected'>" + hour + "</option>"
                } else {
                    h += "<option value='" + hour + "'>" + hour + "</option>"
                }
            }
            $("#hours").html(h);
            var m = "";
            for (var min = 00; min <= 59; min++) {
                if (min == time[1]) {
                    m += "<option value='" + min + "' selected ='selected'>" + min + "</option>"
                } else {
                    m += "<option value='" + min + "'>" + min + "</option>"
                }
            }
            $("#mins").html(m);
            if(result.ntp=="true"){
                $("#timezone").attr("disabled", "disabled");
                $("#date").attr("disabled", "disabled");
                $("#hours").attr("disabled", "disabled");
                $("#mins").attr("disabled", "disabled");
                $("#ntpserver").removeAttr("disabled");
            }else{
                $("#timezone").removeAttr("disabled");
                $("#date").removeAttr("disabled");
                $("#hours").removeAttr("disabled");
                $("#mins").removeAttr("disabled");
                $("#ntpserver").attr("disabled", "disabled");
            }

            $("#ntp").change(function () {
                if ($(this).val() == "true") {
                    $("#timezone").attr("disabled", "disabled");
                    $("#date").attr("disabled", "disabled");
                    $("#hours").attr("disabled", "disabled");
                    $("#mins").attr("disabled", "disabled");
                    $("#ntpserver").removeAttr("disabled");
                } else {
                    $("#timezone").removeAttr("disabled");
                    $("#date").removeAttr("disabled");
                    $("#hours").removeAttr("disabled");
                    $("#mins").removeAttr("disabled");
                    $("#ntpserver").attr("disabled", "disabled");
                }
            });
            $("#timezone").change(function () {
                var chg = $(this);
                $.get("/api/datetime", function (result) {
                    if (chg.val() == "Etc/GMT") {
                        var sv = 0;
                    } else {
                        var s = new Array();
                        s = chg.val().split("T");
                        var sv = s[1];

                    }
                    if(result.timezone=="Etc/localtime"){
                        var dt=0;
                    }else{
                        var tft=result.timezone.split("T");
                        var dt=tft[1];
                    }
                    console.log(parseInt(sv));
                    console.log(parseInt(dt))
                    var sd=parseInt(sv)-parseInt(dt);
                    console.log(sd)
                    var value=new Date(result.date+" "+result.time);
                    value=value.valueOf();
                    var newdate=value+sd*3600*1000;
                    var dd=new Date(newdate);
                    $("#date").val(dd.getFullYear()+"."+charLeftAll(dd.getMonth()+1)+"."+charLeftAll(dd.getDate()));
                    $("#hours").val(dd.getHours());
                    $("#mins").val(dd.getMinutes());
                }, "json");
            });
        }, "json");
    });
    function charLeftAll(n){
        if(n<10)
            return "0" + n;
        else
            return n;
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
                <button type="button" class="btn btn-success" id="confirm_del_btn" onclick="confirm_del();"><?php echo $lang[$_COOKIE['systec_lang']]['confirm']; ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    function cancel_del() {
        $("#del_com").hide();
    }
    function confirm_del() {
        $.post("/api/datetime/update", {
            timezone: $("#timezone").val(),
            date: $("#date").val(),
            time: $("#hours").val() + ":" + $("#mins").val(),
            ntp: $("#ntp").val(),
            ntpserver: $("#ntpserver").val()
        }, function (result) {
            if (result.state == 0) {
                $.get("/api/conf/reload", function (result) {}, "json");
                $("body").append('<div class="modal-backdrop fade in"></div>');
                $("#success").addClass("in");
                $("#success").show();
                $("#del_com").hide();

                setTimeout(function(){
                    $(".modal-backdrop").remove();
                    $("#success").removeClass("in");
                    $("#success").hide();


                },1000);
            }
        }, "json");
    }
</script>

<script>
    $(function () {
        $("#edit_submit").click(function () {
            $("#del_com").addClass("in");
            $("#del_com").show();
        });
    });
</script>
