<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $lang[$_COOKIE['systec_lang']]['networkk']; ?></title>
        <!-- Bootstrap CSS -->    
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <!-- bootstrap theme -->
        <link href="/css/bootstrap-theme.css" rel="stylesheet">

        <link href="/css/widgets.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">
        <link href="/css/style-responsive.css" rel="stylesheet" />

        <link rel="stylesheet" href="/css/jquery.fileupload.css">
        <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/>


        <script src="/js/jquery.js"></script>
        <script src="/js/jquery-1.8.3.min.js"></script>
        <script src="/js/languages.js"></script>
        <script src="/js/bootstrap.min.js"></script>
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
                                <li><?php echo $lang[$_COOKIE['systec_lang']]['networkk']; ?></li>
                            </ol>
                        </div>
                    </div>

                    <h2 class="sub-header">
                        <?php echo $lang[$_COOKIE['systec_lang']]['networkk']; ?>
                    </h2>
                    <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['hostname']; ?>：</td>
                            <td id="hostname"></td>
                        </tr>
                        <tr>
                            <td><?php echo $lang[$_COOKIE['systec_lang']]['eth']; ?>:</td>
                            <td id="eth"></td>
                        </tr>
                        <tr>
                            <td>DNS:</td>
                            <td>
                                <p>
                                    <input type="text" id="dns1" />
                                </p>
                                <p>
                                    <input type="text" id="dns2" />
                                </p>
                            </td>
                        </tr>

                        </table>

                        <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#del_com' id="edit_submit">
                            <?php echo $lang[$_COOKIE['systec_lang']]['update']; ?>
                        </button>

                    </div>
                </section>
            </section>
            <!--main content end-->
        </section> 
    </body>
</html>
<script src="/js/jquery.scrollTo.min.js"></script>
<script src="/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="/js/scripts.js"></script>
        <script>
        $(function() {
            $.get("/api/network", function(result){
                $("#hostname").html(result.hostname);
                $("#mac").val(result.mac);
                var dnss=result.dns;
                $("#dns1").val(dnss[0]);
                $("#dns2").val(dnss[1]);
                $("#dhcp").val(result.dhcp);
                var table='';
                //对OfficeLink网卡配置
                /*
                $.each(result.eth,function(k,v){
                     table += "eth"+k+"<table><tr><td>MAC:</td><td>"+v.mac+"</td></tr><tr><td>IP:</td><td><input id='ip"+k+"' type='text' value='"+v.ip+"'/></td></tr><tr><td><?php echo $lang[$_COOKIE['systec_lang']]['gateway']; ?></td><td><input id='gateway"+k+"' type='text' value='"+v.gateway+"'/></td></tr><tr><td><?php echo $lang[$_COOKIE['systec_lang']]['netmask']; ?></td><td><input id='netmask"+k+"' type='text' value='"+v.netmask+"'/></td></tr><tr><td><?php echo $lang[$_COOKIE['systec_lang']]['dhcpenable']; ?>:</td><td><select id='dhcp'><option value='true'><?php echo $lang[$_COOKIE['systec_lang']]['enable']; ?></option><option value='false'><?php echo $lang[$_COOKIE['systec_lang']]['disable']; ?></option></select></td> </tr></table>";
                });
                */

                //对Homelink网卡配置
                if(result.dhcp=="true"){
                    var dhcp_select="<select id='dhcp'><option selected ='selected'  value='true'><?php echo $lang[$_COOKIE['systec_lang']]['enable']; ?></option><option value='false'><?php echo $lang[$_COOKIE['systec_lang']]['disable']; ?></option></select>";
                }else{
                    var dhcp_select="<select id='dhcp'><option value='true'><?php echo $lang[$_COOKIE['systec_lang']]['enable']; ?></option><option selected ='selected' value='false'><?php echo $lang[$_COOKIE['systec_lang']]['disable']; ?></option></select>";
                }
                table += "<table><tr><td>MAC:</td><td>"+result.eth[0].mac+"</td></tr><tr><td>IP:</td><td><input id='ip0' type='text' value='"+result.eth[0].ip+"'/></td></tr><tr><td><?php echo $lang[$_COOKIE['systec_lang']]['gateway']; ?></td><td><input id='gateway0' type='text' value='"+result.eth[0].gateway+"'/></td></tr><tr><td><?php echo $lang[$_COOKIE['systec_lang']]['netmask']; ?></td><td><input id='netmask0' type='text' value='"+result.eth[0].netmask+"'/></td></tr><tr style='display:none;'><td><?php echo $lang[$_COOKIE['systec_lang']]['dhcpenable']; ?>:</td><td>"+dhcp_select+"</td></tr></table>";
                $("#eth").html(table);
                },"json");
            })
        </script>

        
        
        
        <!--添加删除服务-->
<div class="modal fade bs-example-modal-sm" id="del_com" tabindex="-1" role="dialog" aria-labelledby="del_comLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4>确定此操作？</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_del();">取消</button>
                <button type="button" class="btn btn-success" id="confirm_del_btn" onclick="confirm_del();">确认</button>
            </div>
        </div>
    </div>
</div>
<script>
    function cancel_del() {
        $("#del_com").hide();
    }
    function confirm_del() {
        var eth =new Array();
        $.each($("#eth").find("table"),function(k,v){
            var myhash ={};
            $.each($(this).find("tbody"),function(kk,vv){
                 myhash={'ip':$(this).find("tr").eq(1).find("td").find("input").val(),'gateway':$(this).find("tr").eq(2).find("td").find("input").val(),'netmask':$(this).find("tr").eq(3).find("td").find("input").val()}
            });
            eth.push(myhash);
        });
        $.post("/api/network/update", {"hostname": $("#hostname").innerHTML,"eth":eth,"mac":$("#mac").val(),"dns":$("#dns1").val()+','+$("#dns2").val(), "dhcp":$("#dhcp").val()},function (result){
            $.get("/api/conf/reload", function (result) {}, "json");
            window.location ="http://"+eth[0]['ip'];
        }, "json");
    }
</script>

<script>
    function isIP(ip)
    {
        var reSpaceCheck = /^(\d+)\.(\d+)\.(\d+)\.(\d+)$/;
        if (reSpaceCheck.test(ip))
        {
            ip.match(reSpaceCheck);
            if (RegExp.$1<=255&&RegExp.$1>=0
                &&RegExp.$2<=255&&RegExp.$2>=0
                &&RegExp.$3<=255&&RegExp.$3>=0
                &&RegExp.$4<=255&&RegExp.$4>=0)
            {
                return true;
            }else
            {
                return false;
            }
        }else
        {
            return false;
        }
    }


    function arrayToJson(o) {
        var r = [];
        if (typeof o == "string") return "\"" + o.replace(/([\'\"\\])/g, "\\$1").replace(/(\n)/g, "\\n").replace(/(\r)/g, "\\r").replace(/(\t)/g, "\\t") + "\"";
        if (typeof o == "object") {
            if (!o.sort) {
                for (var i in o)
                    r.push(i + ":" + arrayToJson(o[i]));
                if (!!document.all && !/^\n?function\s*toString\s*\{\n?\s*\[native code\]\n?\s*\}\n?\s*$/.test(o.toString)) {
                    r.push("toString:" + o.toString.toString());
                }
                r = "{" + r.join() + "}";
            } else {
                for (var i = 0; i < o.length; i++) {
                    r.push(arrayToJson(o[i]));
                }
                r = "[" + r.join() + "]";
            }
            return r;
        }
        return o.toString();
    }
    $(function () {
        $("#ip0").live("blur",function(){
           if(!isIP($(this).val())){
               $(this).css("border-color", "red");
               $(this).focus();
               return false;
           }else {
               $(this).removeAttr("style");
           }
        });

        $("#gateway0").live("blur",function(){
            if(!isIP($(this).val())){
                $(this).css("border-color", "red");
                $(this).focus();
                return false;
            }else {
                $(this).removeAttr("style");
            }
        });

        $("#netmask0").live("blur",function(){
            if(!isIP($(this).val())){
                $(this).css("border-color", "red");
                $(this).focus();
                return false;
            }else {
                $(this).removeAttr("style");
            }
        });

        $("#edit_submit").click(function () {
            if(!isIP($("#ip0").val())){
                alert("IP输入错误");
                return false;
            }
            if(!isIP($("#gateway0").val())){
                alert("网关输入错误");
                return false;
            }
            if(!isIP($("#netmask0").val())){
                alert("子网掩码输入错误");
                return false;
            }

            var ip_pre1=$("#eth").find("table").eq(0).find("tr").eq(0).find("input").val().split(".");
            var ip_pre2=$("#eth").find("table").eq(1).find("tr").eq(0).find("input").val().split(".");
            if(ip_pre1[0]+"."+ip_pre1[1]+"."+ip_pre1[2]==ip_pre2[0]+"."+ip_pre2[1]+"."+ip_pre2[2]){
                alert("两个网卡IP不能再同一网段");
                return false;
            }else{
                $("#del_com").addClass("in");
                $("#del_com").show();
                $("#confirm_del_btn").attr("filed", uid);
            }

        });
    });
</script>

