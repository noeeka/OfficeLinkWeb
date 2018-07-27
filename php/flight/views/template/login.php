<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $lang[$_COOKIE['systec_lang']]['loginpage']; ?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="/js/jquery-1.8.3.min.js"></script>
    <script src="/js/languages.js"></script>
    <style>
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background: #333;
        }
        .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }
        .form-signin .form-signin-heading, .form-signin .checkbox {
            margin-bottom: 10px;
        }

        .form-signin .checkbox {
            font-weight: normal;
        }

        .bgimg {
            margin-left: 55px;
            height: 510px;
            width: 510px;
            float: left;
            z-index: 99;
            background: url("/img/11.png") no-repeat scroll transparent;
        }

        @-webkit-keyframes fadeIn {
            0% {
                opacity: 0.2;
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 0.2;
            }
        }

        #oval {
        }

        .bgimg_circle {
            height: 80px;
            width: 160px;
            border: #135bc8 solid 5px;
            background: none;
            -moz-border-radius: 100px / 50px;
            -webkit-border-radius: 100px / 50px;
            border-radius: 100px / 50px;
        }

        .bgimg_circle {
            -webkit-animation: infinite;
            -webkit-animation-name: fadeIn;
            -webkit-animation-duration: 6s;
            -webkit-animation-delay: 0s;
            -webkit-animation-timing-function: linear;
        }

        @media screen and (max-width: 768px) {
            .bgimg_circle {
                height: 80px;
                width: 160px;
                border: #135bc8 solid 5px;
                background: none;
                -moz-border-radius: 100px / 50px;
                -webkit-border-radius: 100px / 50px;
                border-radius: 100px / 50px;
            }

            .bgimg_circle {
                -webkit-animation: infinite;
                -webkit-animation-name: fadeIn;
                -webkit-animation-duration: 6s;
                -webkit-animation-delay: 0s;
                -webkit-animation-timing-function: linear;

            }
        }
    </style>
</head>

<body>
<div class="container">
    <?php if (is_mobile()) {
    } else { ?>
        <div class="bgimg"><div class="bgimg_circle" style="margin-top: 200px; margin-left: 200px;"></div></div>

    <?php } ?>

    <form class="form-signin" role="form" style="<?php if (!is_mobile()) { ?>margin-left:60px; float:left; margin-top:120px; <?php } ?> width:300px">
        <img src="/img/officelink_logo.png" width="<?php if (is_mobile()) { ?>30<?php } else { ?>50<?php } ?>" height="<?php if (is_mobile()) { ?>30<?php } else { ?>50<?php } ?>" style="float: left;<?php if (is_mobile()) { ?> margin-top: 15px;  <?php } ?>"/>
        <h1 style="float:left;margin-left: 45px;margin-bottom: 25px;line-height: 20px;color: #EBEBEB;">OfficeLink</h1>
        <?php if (is_mobile()) { ?>
            <input type="text" class="form-control" id="username" placeholder="<?php if (empty($_COOKIE['systec_lang'])) {
                       echo "用户名";
                   } else {
                       echo $lang[$_COOKIE['systec_lang']]['username'];
                   } ?>">
        <?php } else { ?>
            <input class="form-control input-sm"  type="text"  id="username"
                   placeholder="<?php if (empty($_COOKIE['systec_lang'])) {
                       echo "用户名";
                   } else {
                       echo $lang[$_COOKIE['systec_lang']]['username'];
                   } ?>">
        <?php } ?>

        <br>
        <?php if (is_mobile()) { ?>
            <input class="form-control" id="password" type="password" style="width:100%;margin-top: -10px;" placeholder="<?php if (empty($_COOKIE['systec_lang'])) {
                       echo "密码";
                   } else {
                       echo $lang[$_COOKIE['systec_lang']]['password'];
                   } ?>">
        <?php } else { ?>
            <input class="form-control input-sm" id="password" type="password" style="width:100%;margin-top: -10px;"
                   placeholder="<?php if (empty($_COOKIE['systec_lang'])) {
                       echo "密码";
                   } else {
                       echo $lang[$_COOKIE['systec_lang']]['password'];
                   } ?>">
        <?php } ?>
        <br>
        <select class="form-control" id="langSelect"  style="width:100%;margin-top: -10px;">
            <option value="cn">简体中文</option>
            <option value="en">English</option>
        </select>

        <button style="width:100%;margin-top: 15px;font-size: 14px; font-family: 微软雅黑" type="button" id="submit" class="btn btn-primary btn-block">
            <?php
            if (empty($lang[$_COOKIE['systec_lang']]['login'])) {
                echo "登";
                echo "&nbsp;";
                echo "录";
            } else {
                echo $lang[$_COOKIE['systec_lang']]['login'];
            }
            ?>
        </button>
    </form>
</div>
<!-- /container -->
</body>
</html>
<script>
    $(document).ready(function () {
        $("#submit").click(function () {
            if ($("#username").val().indexOf("'=") > 0 || $("#password").val().indexOf("'=") > 0) {
                alert("用户名密码错误");
                return false;
            } else {
                $.post("<?php echo $lang['url']; ?>/api/user/login", {
                        name: $("#username").val(),
                        password: $("#password").val()
                    },
                    function (data, status) {
                        if (data.state == 0) {
                            document.cookie = "username=" + escape($("#username").val()) + ";path=/";
                            window.location.href = "/extensions/status";
                        } else {
                            alert(data.msg);
                        }
                    }, 'json');
            }

        });


        $(document).keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                if ($("#username").val().indexOf("'=") > 0 || $("#password").val().indexOf("'=") > 0) {
                    alert("<?php echo $lang[$_COOKIE['systec_lang']]['login_tips']; ?>");
                    return false;
                } else {
                    $.post("<?php echo $lang['url']; ?>/api/user/login", {
                            name: $("#username").val(),
                            password: $("#password").val()
                        },
                        function (data, status) {
                            if (data.state == 0) {
                                document.cookie = "username=" + escape($("#username").val()) + ";path=/";
                                window.location.href = "/extensions/status";
                            } else {
                                alert(data.msg);
                            }
                        }, 'json');
                }
            }
        });
    });
</script>


<?php
//判断是否是手机
function is_mobile()
{
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $is_pc = (strpos($agent, 'windows nt')) ? true : false;
    $is_mac = (strpos($agent, 'mac os')) ? true : false;
    $is_iphone = (strpos($agent, 'iphone')) ? true : false;
    $is_android = (strpos($agent, 'android')) ? true : false;
    $is_ipad = (strpos($agent, 'ipad')) ? true : false;


    if ($is_pc) {
        return false;
    }

    if ($is_mac) {
        return true;
    }

    if ($is_iphone) {
        return true;
    }

    if ($is_android) {
        return true;
    }

    if ($is_ipad) {
        return true;
    }
}

?>
