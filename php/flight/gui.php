<?php
require 'flight/Flight.php';
define("WEBSITE", "http://192.168.1.157/views/template/");
//登录页面
Flight::route('/', function () {

    if (!isset($_SESSION['username'])) {
        header("Location:/login");
        exit();
    } else {
        header("Location:/extensions/status");
        exit();
    }
});
Flight::route('/login', function () {
    require 'langs.php';
    Flight::render('template/login.php', array('lang' => $lang));
});

Flight::route('/test', function () {
    require 'langs.php';
    Flight::render('template/test.php', array('lang' => $lang));
});
//分机状态页面
Flight::route('/extensions/status', function () {
    require 'langs.php';
    Flight::render('template/extension_status.php', array('lang' => $lang));
});

//中级状态页面
Flight::route('/providers/status', function () {
    require 'langs.php';
    Flight::render('template/provider_status.php', array('lang' => $lang));
});

//呼叫停泊状态页面
Flight::route('/parking/status', function () {
    require 'langs.php';
    Flight::render('template/parking_status.php', array('lang' => $lang));
});

//会议室状态页面
Flight::route('/meetingrooms/status', function () {
    require 'langs.php';
    Flight::render('template/meetingrooms_status.php', array('lang' => $lang));
});

//获取系统状态
Flight::route('/system/status', function () {
    require 'langs.php';
    Flight::render('template/system_status.php', array('lang' => $lang));
});

//分机设置页面
Flight::route('/extensions/conf', function () {
    $arr = array();
    require 'langs.php';
    require "cls_sqlite.php";
    define(DATABASE, '/var/lib/asterisk/realtime.sqlite3');
    $DB = new sqlite(DATABASE);
    $extension = $DB->getOne("select extension from sippeers");
    foreach ($extension as $k => $v) {
        array_push($arr, $v['extension']);
    }
    sort($arr);
    $min = $arr[0];
    $item = end($DB->getOne("select items from configs where config='sip'"));
    $range = json_decode($item['items'], true);
    $max = $range['user_exten'][1];
    for ($i=$range['user_exten'][0];$i<= $max;$i++) {
        if (!in_array($i, $arr)) {
            $res_availble[] = $i;
        }
    }
    $extension_num = $DB->getOne("select count(*) as cnt from sippeers");
    if($extension_num[0]['cnt']<100){
        $couldadd=true;
    }else{
        $couldadd=false;
    }
    Flight::render('template/extensions_conf.php', array('lang' => $lang, 'availble' => $res_availble[0],"couldadd"=>$couldadd));
});
//中继设置页面
Flight::route('/providers/conf', function () {
    require 'langs.php';
    require 'langs_yy.php';
    require "cls_sqlite.php";
    define(DATABASE, '/var/lib/asterisk/realtime.sqlite3');
    $DB = new sqlite(DATABASE);
    $extension = $DB->getOne("select count(*) as cnt from providers");
    if($extension[0]['cnt']<10){
        $couldadd=true;
    }else{
        $couldadd=false;
    }

    Flight::render('template/providers_conf.php', array('lang' => $lang,"couldadd"=>$couldadd));
});

//呼出路由设置页面
Flight::route('/outrouter/conf', function () {
    require 'langs.php';
    require "cls_sqlite.php";
    define(DATABASE, '/var/lib/asterisk/realtime.sqlite3');
    $DB = new sqlite(DATABASE);
    $extension = $DB->getOne("select count(*) as cnt from outrouters");
    if($extension[0]['cnt']<10){
        $couldadd=true;
    }else{
        $couldadd=false;
    }
    Flight::render('template/outrouter_conf.php', array('lang' => $lang,"couldadd"=>$couldadd));
});

//IVR设置页面
Flight::route('/ivrs/conf', function () {
    $arr = array();
    $res_availble = array();
    require 'langs.php';
    require "cls_sqlite.php";
    define(DATABASE, '/var/lib/asterisk/realtime.sqlite3');
    $DB = new sqlite(DATABASE);
    $extension = $DB->getOne("select extension from ivrs");
    foreach ($extension as $k => $v) {
        array_push($arr, $v['extension']);
    }
    sort($arr);
    $min = $arr[0];
    $item = end($DB->getOne("select items from configs where config='sip'"));
    $range =json_decode($item['items'], true);
    $max = $range['ivr_exten'][1];
    for ($i = $range['ivr_exten'][0]; $i <= $max; $i++) {
        if (!in_array($i, $arr)) {
            $res_availble[] = $i;
        }
    }

    $could_check = $DB->getOne("select count(*) as cnt from ivrs");
    if($could_check[0]['cnt']<10){
        $couldadd=true;
    }else{
        $couldadd=false;
    }
    Flight::render('template/ivrs_conf.php', array('lang' => $lang, 'availble' => $res_availble[0],"couldadd"=>$couldadd));
});

//拨号规则设置页面
Flight::route('/dialplans/conf', function () {
    require 'langs.php';
    Flight::render('template/dialplans_conf.php', array('lang' => $lang));
});

//拨号方案设置页面
Flight::route('/dialrules/conf', function () {
    require 'langs.php';
    Flight::render('template/dialrules_conf.php', array('lang' => $lang));
});

//响铃组设置页面
Flight::route('/ringgroups/conf', function () {
    $arr = array();
    $res_availble = array();
    require 'langs.php';
    require "cls_sqlite.php";
    define(DATABASE, '/var/lib/asterisk/realtime.sqlite3');
    $DB = new sqlite(DATABASE);
    $extension = $DB->getOne("select extension from ringgroups");
    foreach ($extension as $k => $v) {
        array_push($arr, $v['extension']);
    }
    sort($arr);
    $min = $arr[0];

    $item = end($DB->getOne("select items from configs where config='sip'"));
    $range =json_decode($item['items'], true);
    $max = $range['ringgroup_exten'][1];
    for ($i = $range['ringgroup_exten'][0]; $i <= $max; $i++) {
        if (!in_array($i, $arr)) {
            $res_availble[] = $i;
        }
    }

    $could_check = $DB->getOne("select count(*) as cnt from ringgroups");
    if($could_check[0]['cnt']<20){
        $couldadd=true;
    }else{
        $couldadd=false;
    }
    Flight::render('template/ringgroups_conf.php', array('lang' => $lang, 'availble' => $res_availble[0],"couldadd"=>$couldadd));
});

//会议室设置页面
Flight::route('/meetingrooms/conf', function () {
    $arr = array();
    $res_availble = array();
    require 'langs.php';
    require 'langs_gx.php';
    require "cls_sqlite.php";
    define(DATABASE, '/var/lib/asterisk/realtime.sqlite3');
    $DB = new sqlite(DATABASE);
    $extension = $DB->getOne("select confno from meetme");
    foreach ($extension as $k => $v) {
        array_push($arr, $v['confno']);
    }
    sort($arr);
    $min = $arr[0];
    $item = end($DB->getOne("select items from configs where config='sip'"));
    $range =json_decode($item['items'], true);
    $max = $range['conference_exten'][1];
    for ($i = $range['conference_exten'][0]; $i <= $max; $i++) {
        if (!in_array($i, $arr)) {
            $res_availble[] = $i;
        }
    }

    $could_check = $DB->getOne("select count(*) as cnt from meetme");
    if($could_check[0]['cnt']<10){
        $couldadd=true;
    }else{
        $couldadd=false;
    }
    Flight::render('template/meetingrooms_conf.php', array('lang' => $lang, 'availble' => $res_availble[0],"couldadd"=>$couldadd));
});

//语音信箱设置页面
Flight::route('/voicemail/conf', function () {
    require 'langs.php';
    require 'langs_gx.php';
    Flight::render('template/voicemail_conf.php', array('lang' => $lang));
});

//呼叫特征设置页面
Flight::route('/call/feature/conf', function () {
    require 'langs.php';
    Flight::render('template/call_feature_conf.php', array('lang' => $lang));
});

//MOH设置页面
Flight::route('/mohs/conf', function () {
    require 'langs.php';
    require "cls_sqlite.php";
    define(DATABASE, '/var/lib/asterisk/realtime.sqlite3');
    $DB = new sqlite(DATABASE);
    $could_check = $DB->getOne("select count(*) as cnt from musiconhold");
    if($could_check[0]['cnt']<10){
        $couldadd=true;
    }else{
        $couldadd=false;
    }
    Flight::render('template/mohs_conf.php', array('lang' => $lang,"couldadd"=>$couldadd));
});
//SIP设置页面
Flight::route('/sip/conf', function () {
    require 'langs.php';
    require 'langs_gx.php';
    Flight::render('template/sip_conf.php', array('lang' => $lang));
});

//通话记录页面
Flight::route('/call/records', function () {
    require 'langs.php';
    require 'langs_gx.php';
    Flight::render('template/call_records.php', array('lang' => $lang));
});

//语言设置
Flight::route('/language/conf', function () {
    require 'langs.php';
    Flight::render('template/language_conf.php', array('lang' => $lang));
});

//网络设置
Flight::route('/network/conf', function () {
    require 'langs.php';
    Flight::render('template/network_conf.php', array('lang' => $lang));
});

//时间日期设置
Flight::route('/datetime/conf', function () {
    require 'langs.php';
    Flight::render('template/datetime_conf.php', array('lang' => $lang));
});

//系统升级设置
Flight::route('/system/update', function () {
    require 'langs.php';
    Flight::render('template/system_update.php', array('lang' => $lang));
});

//恢复出厂设置
Flight::route('/factory/reset', function () {
    require 'langs.php';
    Flight::render('template/factory_reset.php', array('lang' => $lang));
});
//重启页面
Flight::route('/system/reboot', function () {
    require 'langs.php';
    Flight::render('template/system_reboot.php', array('lang' => $lang));
});

//备份还原设置
Flight::route('/backups/', function () {
    require 'langs.php';
    Flight::render('template/backup.php', array('lang' => $lang));
});

//防火墙设置
Flight::route('/firewall/conf', function () {
    require 'langs.php';
    Flight::render('template/firewall_conf.php', array('lang' => $lang));
});

//用户设置
Flight::route('/users/conf', function () {
    require 'langs.php';
    require "cls_sqlite.php";
    define(DATABASE, '/var/lib/asterisk/realtime.sqlite3');
    $DB = new sqlite(DATABASE);
    $could_check = $DB->getOne("select count(*) as cnt from users");
    if($could_check[0]['cnt']<10){
        $couldadd=true;
    }else{
        $couldadd=false;
    }
    Flight::render('template/users_conf.php', array('lang' => $lang,"couldadd"=>$couldadd));
});

//系统日志
Flight::route('/logs', function () {
    require 'langs.php';
    Flight::render('template/logs.php', array('lang' => $lang));
});

//设置cookie服务
Flight::route('/common/setCookie/@name', function ($name) {
    $flag = setcookie("systec_lang", $name, 3600);
    if ($flag) {
        echo json_encode(array("state" => 0));
    }
});
Flight::start();
