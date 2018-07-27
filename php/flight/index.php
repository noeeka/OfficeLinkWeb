<?php
session_start();
require 'flight/Flight.php';
require "Asterisk.php";
require "cls_sqlite.php";
define(DATABASE, '/var/lib/asterisk/realtime.sqlite3');
define(VOICEMAIL, '/var/spool/asterisk/voicemail/default/');
define(SESSION, "sess_" . md5("username"));

//用户登录服务
Flight::route('POST /user/login', function () {
    $DB = new sqlite(DATABASE);
    $users = Flight::request()->data->getdata();
    $check_user = $DB->select('users', '*', array("name" => ($users['name']), "password" => ($users['password'])));
    if (empty($check_user) || $check_user == false) {
        echo json_encode(array("api" => "/api/user/login", "state" => "error", "msg" => "用户名或密码错误"));
        die;
    } elseif (strstr($check_user['permits'], "sip")) {
        echo json_encode(array("api" => "/api/user/login", "state" => "error", "msg" => "用户名或密码错误"));
        die;
    } else {
        echo json_encode(array("api" => "/api/user/login", "state" => 0, "msg" => "登陆成功"));
        $_SESSION['username'] = $users['name'];
        $_SESSION['useraccess'] = $users['permits'];
        die;
    }
});

//用户退出
Flight::route('POST /user/logout', function () {
    if (isset($_SESSION)) {
        unset($_SESSION['username']);
        echo json_encode(array("api" => "/api/user/logout", "state" => 0, "msg" => "退出成功"));
        die;
    } else {
        echo json_encode(array("api" => "/api/user/logout", "state" => 1, "msg" => "退出失败"));
        die;
    }
});

//分页获取分机状态服务
Flight::route('/extensions/status(/@page/@page_size)', function ($page, $page_size) {
    CheckIsLogin('api/extensions/status');
    $DB = new sqlite(DATABASE);
    $asterisk = new AstMan();

    //$tmp_raw = explode("\r\n", $asterisk->Cmd("core show hints"));
    $tmp_raw = ($asterisk->Cmd("core show hints"));
    for ($i = 2; $i < count($tmp_raw) - 1; $i++) {
        foreach (explode("   ", $tmp_raw[$i]) as $k => $v) {
            if (!empty($v)) {
                $result_raw[$i][] = $v;
            }
        }
    }

    $tmp_sippeers = ($asterisk->Cmd("sip show peers"));
    $sippeers = [];
    foreach ($tmp_sippeers as $key => $value) {
        $pattern = '/(\d+)\/(\d+) *(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}) *D? *(Yes) *(Yes) *(\d{1,10})/';
        preg_match($pattern, $value, $matches, PREG_OFFSET_CAPTURE);
        if ($matches) {
            $sippeers[$matches[2][0]] = $matches[3][0];
        }
    }

    if (!empty($result_raw)) {
        foreach ($result_raw as $k => $v) {
            if ($v[0] != "----------------") {
                $result[$k]['extension'] = current(explode("@", $v[0]));
                $result[$k]['state'] = end(explode(":", $v[2]));
                if (!array_key_exists($result[$k]['extension'], $sippeers)) {
                    $result[$k]['state'] = 'Unavailable';
                } else {
                    $result[$k]['ip'] = $sippeers[$result[$k]['extension']];
                }
                $temp = $DB->fecthall("select * from sippeers where extension='" . current(explode("@", $v[0])) . "'");
                if (!empty($temp)) {
                    $tmp = current($temp);
                    $result[$k]['nickname'] = $tmp['nickname'];
                    $result[$k]['photo'] = $tmp['photo'];
                } else {
                    $result[$k]['nickname'] = "";
                    $result[$k]['photo'] = "";
                }
                $dir = VOICEMAIL . $result[$k]['extension'] . "/INBOX";

                if (!is_dir($dir)) {
                    $result[$k]['unread_msg'] = 0;
                    if (!is_dir(VOICEMAIL . $result[$k]['extension'] . "/Old")) {
                        $result[$k]['read_msg'] = 0;
                    } else {
                        $result[$k]['read_msg'] = getoldfilecounts(VOICEMAIL . $result[$k]['extension'] . "/Old");
                    }


                } elseif (!is_dir(VOICEMAIL . $result[$k]['extension'] . "/Old")) {
                    $result[$k]['read_msg'] = 0;
                    if (!is_dir($dir)) {
                        $result[$k]['unread_msg'] = 0;
                    } else {
                        $result[$k]['unread_msg'] = getfilecounts($dir);
                    }

                } else {
                    $result[$k]['read_msg'] = getoldfilecounts(VOICEMAIL . $result[$k]['extension'] . "/Old");
                    $result[$k]['unread_msg'] = getfilecounts($dir);
                }
            }
        }
        echo json_encode(array("page" => $page, "total_count" => count($result), "extensions" => array_values(PaginationArray($page_size, $page, multi_array_sort($result, "extension"), 0))));
    } else {
        echo json_encode(array("page" => $page, "total_count" => count($result), "extensions" => array()));
    }

});


//分页获取中继状态服务
Flight::route('/providers/status(/@page/@page_size)', function ($page, $page_size) {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/providers/status');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/providers/status", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    exec('asterisk -rx "sip show registry"', $our);
    for ($i = 1; $i < count($our) - 1; $i++) {
        foreach (explode("  ", $our[$i]) as $k => $v) {
            if (!empty($v)) {
                $result_raw[$i][] = $v;
            }
        }
    }
    $i = 0;
    foreach ($result_raw as $k => $v) {
        $DB = new sqlite(DATABASE);
        $prof = current($DB->fecthall("select * from providers where user='" . $v[2] . "'"));


        $result[$i]['name'] = $prof['name'];
        $result[$i]['user'] = $v[2];
        $result[$i]['state'] = $v[3];
        $result[$i]['address'] = current(explode(":", $v[0]));
        $result[$i]['port'] = end(explode(":", $v[0]));
        $i++;
    }
    echo json_encode(array("page" => $page, "total_count" => count($result), "providers" => PaginationArray($page_size, $page, $result, 0)));
    die;
});

//分页获取停泊状态服务
Flight::route('/parkings/status(/@page/@page_size)', function ($page, $page_size) {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/parkings/status');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/parkings/status", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $asterisk = new AstMan();
    $temp = [];
    $timeout = 60;
    foreach ($asterisk->Cmd("parking show default") as $k => $v) {
        $temp_key = trim(current(explode(":", $v)));
        if ('Space' == $temp_key) {
            $temp_value = end(explode(":", $v));
            array_push($temp, array('space' => $temp_value, 'timeout' => $timeout));
        }
        if ('Parking Time' == $temp_key) {
            $temp_value = trim(end(explode(':', $v)));
            $timeout = intval($temp_value);
        }
        if ('Channel' == $temp_key) {
            $temp_value = end(explode(":", $v));
            $temp_value = end(explode("/", $temp_value));
            $temp_value = current(explode("-", $temp_value));
            $temp[count($temp) - 1]['extension'] = $temp_value;
        }
        if ('Parker Dial String' == $temp_key) {
            $temp_value = end(explode(":", $v));
            $temp_value = end(explode("/", $temp_value));
            $temp[count($temp) - 1]['parked_extension'] = $temp_value;
        }

    }
    //echo json_encode($temp);
    echo json_encode(array("page" => $page, "total_count" => count($temp), "parkings" => $temp));
    die;

    /*$result['extension'] = trim($temp['Parking Extension']);
    $result['channel'] = "";
    $result['space'] = trim($temp['Parking Spaces']);
    preg_match_all('/\d+/', trim($temp['Parking Time']), $arr);
    foreach (current($arr) as $vv) {
        if (is_numeric($vv)) {
            $to = $vv;
        }
    }
    $result['timeout'] = $to;

    echo json_encode(array("page" => $page, "total_count" => count($result), "parkings" => array($result)));
    die;*/
});

//分页获取会议室状态服务
Flight::route('/meetingrooms/status(/@page/@page_size)', function ($page, $page_size) {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/meetingrooms/status');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/meetingrooms/status", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    exec('asterisk -rx "meetme list"', $meetmelist);
    if ($meetmelist[0] == "No active MeetMe conferences.") {
        echo json_encode(array("page" => $page, "total_count" => 0, "meetingrooms" => array()));
        die;
    }
    array_pop($meetmelist);
    array_shift($meetmelist);
    foreach ($meetmelist as $k => $v) {
        $meetme_extension = array();
        $meetme_tmp = array_filter(explode("   ", $v));
        $room_no = $meetme_tmp[0];
        $result[$k]['room_extension'] = $meetme_tmp[0];
        $result[$k]['count'] = $meetme_tmp[3];
        $cmd = "asterisk" . " -rx " . "\"meetme list " . $room_no . "\"";
        exec($cmd, $meetme_extension);
        $extension_temp_array = array();
        $tem_pop = array_pop($meetme_extension);
        foreach ($meetme_extension as $kk => $vv) {
            $extensions_tmp = array_filter(explode("   ", $vv));
            $extension_temp_array[$kk]['userid'] = intval(trim(end(explode(":", current($extensions_tmp)))));
            if (empty(current(explode(" ", $extensions_tmp[3])))) {
                $extension_temp_array[$kk]['extension'] = current(explode(" ", trim($extensions_tmp[2]))) . "/" . $extension_temp_array[$kk]['userid'];
            } else {
                $extension_temp_array[$kk]['extension'] = current(explode(" ", $extensions_tmp[3])) . "/" . $extension_temp_array[$kk]['userid'];
            }
            $extension_temp_array[$kk]['channel'] = trim(end(explode(":", $extensions_tmp[8])));
            if (strstr(end($extensions_tmp), "Muted")) {
                $extension_temp_array[$kk]['mute'] = TRUE;
            } else {
                $extension_temp_array[$kk]['mute'] = FALSE;
            }
        }
        $result[$k]['extensions'] = $extension_temp_array;
    }
    echo json_encode(array("page" => $page, "total_count" => count($result), "meetingrooms" => PaginationArray($page_size, $page, $result, 0)));
    die;
});

//会议室静音操作
Flight::route('/meetingrooms/control/@operation/@confno(/@user_id)', function ($operation, $confno, $user_id) {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/system/info');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/system/info", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $cmd = "asterisk" . " -rx " . "\"meetme " . $operation . " " . $confno . " " . $user_id . "\"";
    exec($cmd, $flag);
    echo json_encode(array('api' => '/api/meetingrooms/' . $operation . '/' . $confno . '/' . $user_id, 'state' => 0));
});

//获取系统状态服务
Flight::route('/system/info', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/system/info');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/system/info", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    //匹配系统负载
    exec("uptime", $uptime);
    preg_match_all("/load average: (.*)/", $uptime[0], $loads);
    //匹配内存占用率
    exec("free", $mem_tmp);
    $mem = (explode("     ", $mem_tmp[1]));
    $mem[1] . $mem[2];
    //匹配空间占用率
    exec("df -h", $disk_tmp);
    $disk = (explode("  ", $disk_tmp[1]));
    $disk[4] . $disk[5];

    $fp = popen('df -h | grep -E "^(/)"', "r");
    exec("df -h", $df);

    $dfs = (explode("  ", end(explode("      ", $df[1]))));
    $hd_total = trim($dfs[0], 'M'); //磁盘可用空间大小 单位G
    $hd_usage = trim($dfs[2], 'M'); //挂载点 百分比


    //匹配系统版本
    exec("uname -a", $version_tmp);
    //匹配MAC地址
    $version = file_get_contents("/etc/VERSION");
    exec("ifconfig -a", $mac_tmp);
    (preg_match_all("/HWaddr (.*)/", $mac_tmp[0], $macs));
    //匹配主机名称
    exec("ifconfig eth0 | grep 'inet addr' | awk '{ print $2}' | awk -F: '{print $2}'", $output);
    $ip = $output[0];
    exec("hostname", $hostname);
    //匹配系统语言
    exec("echo \$LANG", $langs);
    $result['load'] = explode(",", $loads[1][0]);
    $result['mem'] = array($mem[1], $mem[2]);
    $result['disk'] = array($hd_total, $hd_usage);
    $result['version'] = $version;
    $result['mac'] = $macs[1][0];
    $result['ip'] = $ip;
    $result['host'] = $hostname[0];
    $result['language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    echo json_encode($result);
    die;
});

//修改密码服务
Flight::route('POST /manager/password/update', function () {
    $DB = new sqlite(DATABASE);
    $extensions = Flight::request()->data;
    //$extension = $_SESSION['extension'];
    $password = $extensions['new_password'];
    if ($extensions['new_password'] != $extensions['confirm_password']) {
        getErrorInfo("/api/manager/password/update", "两次密码不匹配");
    } else {
        $flag = true;
        if ($flag) {
            echo json_encode(array('api' => '/api/manager/password/update', 'state' => 0));
            die;
        } else {
            getErrorInfo("/api/manager/password/update", "修改密码错误");
        }
    }
});

/*
 * 分机信息API
 * 包括对分机的CURD
 * */
//获取分机列表
Flight::route('/extensions(/@page/@page_size)', function ($page, $page_size) {
    CheckIsLogin('api/extensions');
    $DB = new sqlite(DATABASE);
    $total_count = current(array_values(current($DB->fecthall('select count(*) from sippeers'))));
    if ($page == 1) {
        $offset = "";
    } elseif (!isset ($page)) {
        $offset = "1000";
    } else {
        $offset = " OFFSET " . (($page - 1) * $page_size);
    }

    foreach ($DB->fecthall('select * from sippeers order by extension LIMIT ' . $page_size . $offset) as $k => $v) {
        $result[$k]['extension'] = $v['extension'];
        $result[$k]['nickname'] = $v['nickname'];
        $result[$k]['photo'] = stripslashes($v['photo']);
        $result[$k]['dialplan'] = $v['dialplan'];
        $result[$k]['password'] = $v['password'];
        $result[$k]['transfer_days'] = $v['transfer_days'];
        $result[$k]['transfer_time'] = json_decode($v['transfer_time'], true);
        $result[$k]['transfer_style'] = $v['transfer_style'];
        $result[$k]['transfer_type'] = $v['transfer_type'];
        $result[$k]['transfer_target'] = $v['transfer_target'];
        $result[$k]['ring_timeout'] = $v['ring_tmeout'];
        $result[$k]['codecs'] = json_decode($v['codecs'], true);
        $result[$k]['email'] = $v['email'];
        $result[$k]['voicemail_pin'] = $v['voicemail_pin'];
    }
    echo(json_encode(array("page" => $page, "total_count" => $total_count, "extensions" => $result)));
    die;
});

//获取通讯录列表
Flight::route('/contacts(/@page/@page_size)', function ($page, $page_size) {
    $DB = new sqlite(DATABASE);
    $total_count = current(array_values(current($DB->fecthall('select count(*) from sippeers'))));
    $start = (empty($page)) ? 0 : ($page - 1) * $page_size;
    $end = (empty($page)) ? $total_count : $page * $page_size;
    foreach ($DB->fecthall('select * from sippeers limit ' . $start . ', ' . $end) as $k => $v) {
        $result[$k]['id'] = $v['extension'];
        $result[$k]['fullname'] = $v['nickname'];
        $result[$k]['photo'] = stripslashes($v['photo']);
        $result[$k]['email'] = $v['email'];
    }
    echo(json_encode($result));
    die;
});
//添加分机
Flight::route('POST /extensions/add', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/extensions/add');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/extensions/add", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $extensions = Flight::request()->data->getdata();
    if (!is_dir("/var/www/html/avatar/")) {
        mkdir("/var/www/html/avatar/");
    }
    if ($extensions['photo'] != "/img/avatar100.png") {
        $rename = rename("/var/www/html" . $extensions['photo'], "/var/www/html/avatar/" . $extensions['extension'] . ".png");
    }
    if ($rename) {
        $extensions['photo'] = "/avatar/" . $extensions['extension'] . ".png";
    }

    $flag = $DB->insert("sippeers", $extensions);
    if ($flag) {
        echo json_encode(array('api' => '/api/extensions/add', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/extensions/add", "分机添加错误");
    }
});
//修改分机信息服务
Flight::route('POST /extensions/update', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/extensions/update');
    $DB = new sqlite(DATABASE);
    $extensions = Flight::request()->data->getdata();

    if ($_SESSION['useraccess'] == "sip") {
        $extension = $_SESSION['username'];
    } else {
        $extension = $extensions['extension'];
    }
    if (!is_dir("/var/www/html/avatar/")) {
        mkdir("/var/www/html/avatar/");
    }

    if ($extensions['photo'] != "/img/avatar100.png") {
        exec("cp /var/www/html" . $extensions['photo'] . " /var/www/html/avatar/" . $extensions['extension'] . ".png", $rename);
        //$rename = copy("/var/www/html" . $extensions['photo'], "/var/www/html/avatar/" . $extensions['extension'] . ".png");
    } else {
        $rename = copy("/var/www/html/img/avatar100.png", "/var/www/html/avatar/" . $extensions['extension'] . ".png");
    }


    if ($rename) {
        $extensions['photo'] = "/avatar/" . $extensions['extension'] . ".png";
    }
    $flag = $DB->update("sippeers", $extensions, array('extension' => $extension));
    if ($flag) {
        echo json_encode(array('api' => '/api/extensions/update', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/extensions/update", "修改分机信息错误");
    }
});
//删除分机信息服务
Flight::route('POST /extensions/delete', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/extensions/delete');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/extensions/delete", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $flag = $DB->delete("sippeers", "extension", Flight::request()->data->getdata());
    if ($flag) {
        echo json_encode(array('api' => '/api/extensions/delete', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/extensions/delete", "删除分机信息错误");
    }
});
//获取分机信息服务
Flight::route('/extensions/info', function () {
    $DB = new sqlite(DATABASE);
    $extension = $_POST['extension'];
    echo json_encode(current($DB->fecthall("select * from sippeers where extension='{$extension}'")));
    die;
});

//验证分机号是否重复
Flight::route('/extensions/checkextension', function () {
    $DB = new sqlite(DATABASE);
    $extension = $_POST['extension'];
    if (empty(current($DB->fecthall("select * from sippeers where extension='{$extension}'")))) {
        echo json_encode(array("state" => 1));
    } else {
        echo json_encode(array("state" => 0));
    }
    die;
});

/*
 * 中继信息API
 * 包括对中继的CURD
 * */
//分页获取中继列表服务
Flight::route('/providers(/@page/@page_size)', function ($page, $page_size) {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/providers');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/providers", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $total_count = current(array_values(current($DB->fecthall('select count(*) from providers'))));
    $start = (empty($page)) ? 0 : ($page - 1) * $page_size;
    $end = (empty($page)) ? $total_count : $page * $page_size;
    echo json_encode(array("page" => $page, "total_count" => $total_count, "providers" => $DB->fecthall('select * from providers limit ' . $start . ', ' . $end)));
    die;
});
//添加中继服务
Flight::route('POST /providers/add', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/providers/add');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/providers/add", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $providers = Flight::request()->data->getdata();
    $flag = $DB->insert("providers", $providers);
    if ($flag) {
        echo json_encode(array('api' => '/api/providers/add', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/providers/add", "添加中继错误");
    }
});

//修改中继信息服务
Flight::route('POST /providers/update', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/providers/update');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/providers/update", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $providers = Flight::request()->data->getdata();
    $flag = $DB->update("providers", $providers, array('name' => $providers['name']));
    if ($flag) {
        echo json_encode(array('api' => '/api/providers/update', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/providers/update", "修改中继信息错误");
    }
});
//删除中继服务
Flight::route('POST /providers/delete', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/providers/delete');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/providers/delete", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $flag = $DB->delete("providers", "name", Flight::request()->data->getdata());
    if ($flag) {
        echo json_encode(array('api' => '/api/providers/delete', 'state' => 0));
        die;
    } else {
        getErrorInfo("/providers/delete", "删除中继信息出错");
    }
});
//获取中继信息服务
Flight::route('/providers/info', function () {
    $DB = new sqlite(DATABASE);
    $name = $_POST['name'];
    echo json_encode(current($DB->fecthall("select * from providers where name='{$name}'")));
    die;
});

//验证中继名称重复
Flight::route('/providers/checkname', function () {
    $DB = new sqlite(DATABASE);
    $name = $_POST['name'];
    if (empty(current($DB->fecthall("select * from providers where name='{$name}'")))) {
        echo json_encode(array("state" => 1));
    } else {
        echo json_encode(array("state" => 0));
    }
    die;
});


/*
 * 呼出路由信息API
 * 包括对呼出路由的CURD
 * */
//分页获取呼出路由列表服务
Flight::route('/outrouters(/@page/@page_size)', function ($page, $page_size) {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/outrouters');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/outrouters", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $total_count = current(array_values(current($DB->fecthall('select count(*) from outrouters'))));
    $start = (empty($page)) ? 0 : ($page - 1) * $page_size;
    $end = (empty($page)) ? $total_count : $page * $page_size;
    echo json_encode(array("page" => $page, "total_count" => $total_count, "outrouters" => $DB->fecthall('select * from outrouters limit ' . $start . ', ' . $end)));
    die;
});
//添加呼出路由服务
Flight::route('POST /outrouters/add', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/outrouters/add');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/providers/add", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $providers = Flight::request()->data->getdata();
    $flag = $DB->insert("outrouters", $providers);
    if ($flag) {
        echo json_encode(array('api' => '/api/outrouters/add', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/outrouters/add", "添加中继错误");
    }
});

//修改呼出路由信息服务
Flight::route('POST /outrouters/update', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/outrouters/update');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/outrouters/update", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $providers = Flight::request()->data->getdata();
    $flag = $DB->update("outrouters", $providers, array('name' => $providers['name']));
    if ($flag) {
        echo json_encode(array('api' => '/api/outrouters/update', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/outrouters/update", "修改中继信息错误");
    }
});
//删除呼出路由服务
Flight::route('POST /outrouters/delete', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/outrouters/delete');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/outrouters/delete", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $flag = $DB->delete("outrouters", "name", Flight::request()->data->getdata());
    if ($flag) {
        echo json_encode(array('api' => '/api/outrouters/delete', 'state' => 0));
        die;
    } else {
        getErrorInfo("/outrouters/delete", "删除中继信息出错");
    }
});
//获取呼出路由信息服务
Flight::route('/outrouters/info', function () {
    $DB = new sqlite(DATABASE);
    $name = $_POST['name'];
    echo json_encode(current($DB->fecthall("select * from outrouters where name='{$name}'")));
    die;
});

Flight::route('/outrouters/checkname', function () {
    $DB = new sqlite(DATABASE);
    $name = $_POST['name'];
    if (empty(current($DB->fecthall("select * from outrouters where name='{$name}'")))) {
        echo json_encode(array("state" => 1));
    } else {
        echo json_encode(array("state" => 0));
    }
    die;
});


Flight::route('/outrouters/checkrule', function () {
    $DB = new sqlite(DATABASE);
    $rule = $_POST['rule'];
    $name = $_POST['name'];
    if (empty(current($DB->fecthall("select * from outrouters where name!='{$name}' and rule='{$rule}'")))) {
        echo json_encode(array("state" => 1));
    } else {
        echo json_encode(array("state" => 0));
    }
    die;
});

/*
 * IVRS信息API 
 * 包括对IVRS的CURD
 * */
//获取IVRS列表服务
Flight::route('/ivrs(/@page/@page_size)', function ($page, $page_size) {
    CheckIsLogin('api/ivrs');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/ivrs", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $total_count = current(array_values(current($DB->fecthall('select count(*) from ivrs'))));
    if ($page == 1) {
        $offset = "";
    } else {
        $offset = " OFFSET " . (($page - 1) * $page_size);
    }
    foreach ($DB->fecthall('select * from ivrs LIMIT ' . $page_size . $offset) as $k => $v) {
        $result[$k]["name"] = $v['name'];
        $result[$k]["extension"] = $v['extension'];
        $result[$k]['rules'] = json_decode($v['rules'], true);
    }
    echo json_encode(array("page" => $page, "total_count" => $total_count, "ivrs" => $result));
    die;
});
//添加IVRS服务
Flight::route('POST /ivrs/add', function () {
    CheckIsLogin('api/ivrs/add');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/ivrs/add", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $ivrs = Flight::request()->data->getdata();
    $flag = $DB->insert("ivrs", $ivrs);
    if ($flag) {
        echo json_encode(array('api' => '/api/ivrs/add', 'state' => 0));
        die;
    } else {
        getErrorInfo("/ivrs/add", "添加IVRS出错");
    }
});

//修改IVRS信息服务
Flight::route('POST /ivrs/update', function () {
    CheckIsLogin('api/ivrs/update');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/ivrs/update", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $ivrs = Flight::request()->data->getdata();
    $flag = $DB->update("ivrs", $ivrs, array('name' => $ivrs['name']));
    if ($flag) {
        echo json_encode(array('api' => '/api/ivrs/update', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/ivrs/update", "修改IVRS出错");
    }
});

//删除IVRS服务
Flight::route('POST /ivrs/delete', function () {
    CheckIsLogin('api/ivrs/delete');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/ivrs/delete", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $flag = $DB->delete("ivrs", "name", Flight::request()->data->getdata());
    if ($flag) {
        echo json_encode(array('api' => '/api/ivrs/delete', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/ivrs/delete", "删除IVRS出错");
    }
});

//获取IVRS信息服务
Flight::route('/ivrs/info', function () {
    $DB = new sqlite(DATABASE);
    $name = addslashes($_POST['name']);
    echo json_encode(current($DB->fecthall("select * from ivrs where name='{$name}'")));
    die;
});

Flight::route('/ivrs/checkname', function () {
    $DB = new sqlite(DATABASE);
    $name = $_POST['name'];
    if (empty(current($DB->fecthall("select * from ivrs where name='{$name}'")))) {
        echo json_encode(array("state" => 1));
    } else {
        echo json_encode(array("state" => 0));
    }
    die;
});

Flight::route('/ivrs/checkextension', function () {
    $DB = new sqlite(DATABASE);
    $extension = $_POST['extension'];
    if (empty(current($DB->fecthall("select * from ivrs where extension='{$extension}'")))) {
        echo json_encode(array("state" => 1));
    } else {
        echo json_encode(array("state" => 0));
    }
    die;
});

Flight::route('/ringgroups/checkextension', function () {
    $DB = new sqlite(DATABASE);
    $extension = $_POST['extension'];
    if (empty(current($DB->fecthall("select * from ringgroups where extension='{$extension}'")))) {
        echo json_encode(array("state" => 1));
    } else {
        echo json_encode(array("state" => 0));
    }
    die;
});

Flight::route('/ringgroups/checkname', function () {
    $DB = new sqlite(DATABASE);
    $name = $_POST['name'];
    if (empty(current($DB->fecthall("select * from ringgroups where name='{$name}'")))) {
        echo json_encode(array("state" => 1));
    } else {
        echo json_encode(array("state" => 0));
    }
    die;
});

Flight::route('/ringgroups/checkextension', function () {
    $DB = new sqlite(DATABASE);
    $extension = $_POST['extension'];
    if (empty(current($DB->fecthall("select * from ringgroups where extension='{$extension}'")))) {
        echo json_encode(array("state" => 1));
    } else {
        echo json_encode(array("state" => 0));
    }
    die;
});

/*
 * 拨号方案信息API
 * 包括对拨号方案的CURD
 * */
//获取Dialplan列表服务
Flight::route('/dialplans(/@page/@page_size)', function ($page, $page_size) {
    CheckIsLogin('api/dialplans');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/dialplans", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $total_count = current(array_values(current($DB->fecthall('select count(*) from dialplans'))));
    if ($page == 1) {
        $offset = "";
    } else {
        $offset = " OFFSET " . (($page - 1) * $page_size);
    }
    foreach ($DB->fecthall('select * from dialplans LIMIT ' . $page_size . $offset) as $k => $v) {
        $result[$k]["name"] = $v['name'];
        $result[$k]['rules'] = json_decode($v['rules'], true);
    }
    echo json_encode(array("page" => $page, "total_count" => $total_count, "dialplans" => $result));
    die;
});

//添加拨号方案服务
Flight::route('POST /dialplans/add', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/dialplans/add');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/dialplans/add", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $dialplans = Flight::request()->data->getdata();
    $flag = $DB->insert("dialplans", $dialplans);
    if ($flag) {
        echo json_encode(array('api' => '/api/dialplans/add', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/dialplans/add", "添加拨号方案出错");
    }
});
//修改拨号方案信息服务
Flight::route('POST /dialplans/update', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/dialplans/update');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/dialplans/update", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $dialplans = Flight::request()->data->getdata();
    $flag = $DB->update("dialplans", $dialplans, array('name' => $dialplans['name']));
    if ($flag) {
        echo json_encode(array('api' => '/api/dialplans/update', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/dialplans/update", "修改拨号方案出错");
    }
});

//删除拨号方案信息服务
Flight::route('POST /dialplans/delete', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/dialplans/update');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/dialplans/update", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $flag = $DB->delete("dialplans", "name", Flight::request()->data->getdata());
    if ($flag) {
        echo json_encode(array('api' => '/api/dialplans/delete', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/dialplans/delete", "删除拨号方案出错");
    }
});

//获取拨号方案信息服务
Flight::route('/dialplans/info', function () {
    $DB = new sqlite(DATABASE);
    $name = $_POST['name'];
    echo json_encode(current($DB->fecthall("select * from dialplans where name='{$name}'")));
    die;
});

/*
 * 拨号规则信息API
 * 包括对拨号规则的CURD
 * */
//获取拨号规则列表服务
Flight::route('/dialrules(/@page/@page_size)', function ($page, $page_size) {
    CheckIsLogin('api/dialrules');
    $DB = new sqlite(DATABASE);
    $result = "";
    $total_count = current(array_values(current($DB->fecthall('select count(*) from dialrules'))));
    if ($page == 1) {
        $offset = "";
    } else {
        $offset = " OFFSET " . (($page - 1) * $page_size);
    }
    foreach ($DB->fecthall('SELECT * FROM dialrules LIMIT ' . $page_size . $offset) as $k => $v) {
        $result[$k]["name"] = $v['name'];
        $result[$k]['rules'] = json_decode($v['rules'], true);
    }
    echo json_encode(array("page" => $page, "total_count" => $total_count, "dialrules" => $result));
    die;
});
//添加拨号规则服务
Flight::route('POST /dialrules/add', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/dialrules/add');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/dialrules/add", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $dialrules = Flight::request()->data->getdata();
    $flag = $DB->insert("dialrules", $dialrules);
    if ($flag) {
        echo json_encode(array('api' => '/api/dialrules/add', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/dialrules/add", "添加拨号规则出错");
    }
});


//修改拨号规则服务
Flight::route('POST /dialrules/update', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/dialrules/add');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/dialrules/add", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $dialrules = Flight::request()->data->getdata();
    $flag = $DB->update("dialrules", $dialrules, array('name' => $dialrules['name']));
    if ($flag) {
        echo json_encode(array('api' => '/api/dialrules/update', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/dialrules/update", "修改拨号方案出错");
    }
});

//获取拨号规则信息服务
Flight::route('/dialrules/info', function () {
    $DB = new sqlite(DATABASE);
    $name = $_POST['name'];
    echo json_encode(current($DB->fecthall("select * from dialrules where name='{$name}'")));
    die;
});

//删除拨号规则服务
Flight::route('POST /dialrules/delete', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/dialrules/delete');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/dialrules/delete", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $flag = $DB->delete("dialrules", "name", Flight::request()->data->getdata());
    if ($flag) {
        echo json_encode(array('api' => '/api/dialrules/delete', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/dialrules/delete", "删除拨号规则出错");
    }
});


/*
 * 响铃组信息API
 * 包括对响铃组的CURD
 * */
//获取响铃组列表服务
Flight::route('/ringgroups(/@page/@page_size)', function ($page, $page_size) {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/ringgroups');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/ringgroups", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $total_count = current(array_values(current($DB->fecthall('select count(*) from ringgroups'))));
    if ($page == 1) {
        $offset = "";
    } else {
        $offset = " OFFSET " . (($page - 1) * $page_size);
    }
    foreach ($DB->fecthall('select * from ringgroups LIMIT ' . $page_size . $offset) as $k => $v) {
        $result[$k]["id"] = $v['id'];
        $result[$k]["name"] = $v['name'];
        $result[$k]["extension"] = $v['extension'];
        $result[$k]["ring_style"] = $v['ring_style'];
        $result[$k]["timeout"] = $v['timeout'];
        $result[$k]['members'] = json_decode($v['members'], true);
    }
    echo json_encode(array("page" => $page, "total_count" => $total_count, "ringgroups" => $result));
    die;
});
//添加响铃组服务
Flight::route('POST /ringgroups/add', function () {
    CheckIsLogin('api/ringgroups/add');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/ringgroups/add", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $ringgroups = Flight::request()->data->getdata();
    $flag = $DB->insert("ringgroups", $ringgroups);
    if ($flag) {
        echo json_encode(array('api' => '/api/ringgroups/add', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/ringgroups/add", "添加响铃组出错");
    }
});
//修改响铃组服务
Flight::route('POST /ringgroups/update', function () {
    CheckIsLogin('api/ringgroups/update');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/ringgroups/update", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $ringgroups = Flight::request()->data->getdata();
    $result = array();
    $result['name'] = $ringgroups['name'];
    $result['extension'] = $ringgroups['extension'];
    $result['ring_style'] = $ringgroups['ring_style'];
    $result['timeout'] = $ringgroups['timeout'];
    $result['members'] = array_unique($ringgroups['members']);
    $flag = $DB->update("ringgroups", $result, array('name' => $ringgroups['name']));
    if ($flag) {
        echo json_encode(array('api' => '/api/ringgroups/update', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/ringgroups/update", "修改响铃组出错");
    }
});

//删除响铃组服务
Flight::route('POST /ringgroups/delete', function () {
    CheckIsLogin('api/ringgroups/delete');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/ringgroups/delete", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $flag = $DB->delete("ringgroups", "name", Flight::request()->data->getdata());
    if ($flag) {
        echo json_encode(array('api' => '/api/ringgroups/delete', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/ringgroups/delete", "删除响铃组出错");
    }
});
//获取响铃组信息服务
Flight::route('/ringgroups/info', function () {
    $DB = new sqlite(DATABASE);
    $name = $_POST['name'];
    echo json_encode(current($DB->fecthall("select * from ringgroups where name='{$name}'")));
    die;
});

Flight::route('/ringgroups/checkextension', function () {
    $DB = new sqlite(DATABASE);
    $extension = $_POST['extension'];
    $name = $_POST['name'];
    if (empty(current($DB->fecthall("select * from ringgroups where extension='{$extension}' and name!='{$name}'")))) {
        echo json_encode(array("state" => 1));
    } else {
        echo json_encode(array("state" => 0));
    }
    die;
});

/*
 * 会议室信息API
 * 包括对会议室的CURD
 * */
//获取会议室列表服务
Flight::route('/meetingrooms(/@page/@page_size)', function ($page, $page_size) {
//校验用户是否登陆以及用户权限
    CheckIsLogin('api/meetingrooms');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/meetingrooms", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $total_count = current(array_values(current($DB->fecthall('select count(*) from meetme'))));
    if ($page == 1) {
        $offset = "";
    } else {
        $offset = " OFFSET " . (($page - 1) * $page_size);
    }
    foreach ($DB->fecthall('select * from meetme LIMIT ' . $page_size . $offset) as $k => $v) {
        $result[$k]['extension'] = $v['confno'];
        $result[$k]['user_pin'] = $v['pin'];
        $result[$k]['admin_pin'] = $v['adminpin'];
    }
    echo json_encode(array("page" => $page, "total_count" => $total_count, "meetingrooms" => $result));
    die;
});
//添加会议室服务
Flight::route('POST /meetingrooms/add', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/meetingrooms/add');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/meetingrooms/add", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $meetme = Flight::request()->data->getdata();

    $flag = $DB->insert("meetme", array('confno' => $meetme['extension'], 'pin' => $meetme['user_pin'], 'adminpin' => $meetme['admin_pin']));
    if ($flag) {
        echo json_encode(array('api' => '/api/meetingrooms/add', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/meetingrooms/add", "添加会议室出错");
    }
});
//修改会议室信息服务
Flight::route('POST /meetingrooms/update', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/meetingrooms/update');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/meetingrooms/update", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $meetingroms = Flight::request()->data->getdata();
    $flag = $DB->update("meetme", array('confno' => $meetingroms['extension'], 'pin' => $meetingroms['user_pin'], 'adminpin' => $meetingroms['admin_pin']), array('confno' => $meetingroms['extension']));
    if ($flag) {
        echo json_encode(array('api' => '/api/meetingrooms/update', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/meetingrooms/update", "修改会议室出错");
    }
});

//删除会议室服务
Flight::route('POST /meetingrooms/delete', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/meetingrooms/delete');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/meetingrooms/delete", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $data = Flight::request()->data->getdata();
    //exit("delete from meetme where conf
    //no = '".$data['confno']."'");
    $num = number_format($data['confno'], 0, '', '');
    $flag = $DB->query("delete from meetme where confno = '" . $num . "'");
    if ($flag) {
        echo json_encode(array('api' => '/api/meetingrooms/delete', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/meetingrooms/delete");
    }
});

//获取会议室信息服务
Flight::route('/meetingrooms/info', function () {
    $DB = new sqlite(DATABASE);
    $extension = $_POST['extension'];
    echo json_encode(current($DB->fecthall("select * from meetme where confno='{$extension}'")));
    die;
});

Flight::route('/meetingrooms/checkextension', function () {
    $DB = new sqlite(DATABASE);
    $extension = $_POST['extension'];
    if (empty(current($DB->fecthall("select * from meetme where confno='{$extension}'")))) {
        echo json_encode(array("state" => 1));
    } else {
        echo json_encode(array("state" => 0));
    }
    die;
});

//获取语音信箱配置服务
Flight::route('/voicemail/conf', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/voicemail/conf');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/voicemail/conf", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $items = current($DB->fecthall("select items from configs where config='voicemail'"));
    if (empty($items['items'])) {
        echo json_encode(array());
    } else {
        echo $items['items'];
    }
    die;
});

//修改语音信箱配置服务
Flight::route('/voicemail/conf/update', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/voicemail/conf/update');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/voicemail/conf/update", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $items = current($DB->fecthall("select items from configs where config='voicemail'"));

    if (empty($items['items'])) {
        $flag = $DB->insert("configs", array('config' => 'voicemail', 'items' => json_encode(Flight::request()->data->getdata())));
    } else {
        $flag = $DB->update('configs', array('items' => json_encode(Flight::request()->data->getdata())), array('config' => 'voicemail'));
    }
    if ($flag) {
        echo json_encode(array('api' => '/api/voicemail/conf/update', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/voicemail/conf/update");
    }
});

//获取呼叫特征信息服务
Flight::route('/call/feature/conf', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/call/feature/conf');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/call/feature/conf", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $items = current($DB->fecthall("select items from configs where config='callfeature'"));
    echo $items['items'];
    die;
});

//设置呼叫特征信息服务
Flight::route('/call/feature/conf/update', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/call/feature/conf/update');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/call/feature/conf/update", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $items = current($DB->fecthall("select items from configs where config='callfeature'"));
    if (empty($items['items'])) {
        $flag = $DB->insert('configs', array('config' => 'callfeature', 'items' => json_encode(Flight::request()->data->getdata())));
    } else {
        $flag = $DB->update('configs', array('items' => json_encode(Flight::request()->data->getdata())), array('config' => 'callfeature'));
    }


    if ($flag) {
        echo json_encode(array('api' => '/api/call/feature/conf/update', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/call/feature/conf/update");
    }
});
/*
 * MOH信息API
 * 包括对MOH的CURD
 * */
//获取MOH列表服务
Flight::route('/mohs(/@page/@page_size)', function ($page, $page_size) {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/mohs');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/mohs", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $total_count = current(array_values(current($DB->fecthall('select count(*) from musiconhold'))));
    if ($page == 1) {
        $offset = "";
    } else {
        $offset = " OFFSET " . (($page - 1) * $page_size);
    }
    foreach ($DB->fecthall('select * from musiconhold LIMIT ' . $page_size . $offset) as $k => $v) {
        $result[$k]['name'] = $v['name'];
        $result[$k]['mode'] = $v['mode'];
        $result[$k]['sort'] = $v['sort'];
        $result[$k]['directory'] = $v['directory'];
        $result[$k]['files'] = explode(",", $v['files']);
    }
    echo json_encode(array("page" => $page, "total_count" => $total_count, "mohs" => $result));
    die;
});
//添加MOH服务
Flight::route('POST /mohs/add', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/mohs/add');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/mohs/add", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $flag = $DB->insert("musiconhold", Flight::request()->data->getdata());
    if ($flag) {
        echo json_encode(array('api' => '/api/mohs/add', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/mohs/add", "添加MOHS出错");
    }
});

//修改MOH信息服务
Flight::route('/mohs/update', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/mohs/update');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/mohs/update", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $mohs = Flight::request()->data->getdata();
    $flag = $DB->update("musiconhold", $mohs, array('name' => $mohs['name']));
    if ($flag) {
        echo json_encode(array('api' => '/api/mohs/update', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/mohs/update", "修改MOH出错");
    }
});

//删除MOH服务
Flight::route('/mohs/delete', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/mohs/delete');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/mohs/delete", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $flag = $DB->delete("musiconhold", "name", Flight::request()->data->getdata());

    $aa = Flight::request()->data->getdata();
    exec("rm -r /var/lib/asterisk/moh/" . $aa['name'], $ff);
    if ($flag) {
        echo json_encode(array('api' => '/api/mohs/delete', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/mohs/delete", "删除MOH出错");
    }
});

//获取MOH信息服务
Flight::route('/mohs/info', function () {
    $DB = new sqlite(DATABASE);
    $name = $_POST['name'];
    echo json_encode(current($DB->fecthall("select * from musiconhold where name='{$name}'")));
    die;
});

Flight::route('/moh/checkname', function () {
    $DB = new sqlite(DATABASE);
    $name = $_POST['name'];
    if (empty(current($DB->fecthall("select * from musiconhold where name='{$name}'")))) {
        echo json_encode(array("state" => 1));
    } else {
        echo json_encode(array("state" => 0));
    }
    die;
});

//获取SIP配置信息
Flight::route('/sip/conf', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/sip/conf');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/sip/conf", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $items = current($DB->fecthall("select items from configs where config='sip'"));
    echo $items['items'];
    die;
});

//设置sip信息服务
Flight::route('/sip/conf/update', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/sip/conf/update');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/sip/conf/update", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $items = current($DB->fecthall("select items from configs where config='sip'"));
    if (empty($items['items'])) {
        $flag = $DB->insert("configs", array('config' => 'sip', 'items' => json_encode(Flight::request()->data->getdata())));
    } else {
        $flag = $DB->update('configs', array('items' => json_encode(Flight::request()->data->getdata())), array('config' => 'sip'));
    }
    if ($flag) {
        echo json_encode(array('api' => '/api/sip/conf/update', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/sip/conf/update");
    }
});
/*
 * 通话记录API
 * 包括对通话记录的CURD
 *  */
//获取通话记录服务
Flight::route('/call/records(/@page/@page_size)', function ($page, $page_size) {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/call/records');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/call/records", "state" => 3, "msg" => "无权限操作"));
        die;
    }

    $DB = new sqlite('/var/log/asterisk/master.db');
    $total_count = current(array_values(current($DB->fecthall('select count(*) from cdr order by AcctId DESC'))));
    if ($page == 1) {
        $offset = "";
    } else {
        $offset = " OFFSET " . (($page - 1) * $page_size);
    }
    if (empty($page) || empty($page_size)) {
        foreach ($DB->fecthall('select * from cdr order by AcctId DESC') as $k => $v) {
            $result[$k]['id'] = $v['AcctId'];
            $result[$k]['call_time'] = $v['calldate'];
            $result[$k]['call_duration'] = $v['billsec'];
            preg_match_all("/<(.*)>/", $v['clid'], $rs);
            $result[$k]['callerid'] = $rs[1][0];
            preg_match_all('/\d+/', current(explode(',', $v['lastdata'])), $arr);
            foreach (current($arr) as $vv) {
                if (is_numeric($vv)) {
                    $calledid = $vv;
                }
            }
            $result[$k]['calledid'] = $v['cldid'];
            $result[$k]['action'] = $v['disposition'];
        }
    } else {
        foreach ($DB->fecthall('select * from cdr order by AcctId DESC LIMIT ' . $page_size . $offset) as $k => $v) {
            $result[$k]['id'] = $v['AcctId'];
            $result[$k]['call_time'] = $v['calldate'];
            $result[$k]['call_duration'] = $v['billsec'];
            preg_match_all("/<(.*)>/", $v['clid'], $rs);
            $result[$k]['callerid'] = $rs[1][0];
            preg_match_all('/\d+/', current(explode(',', $v['lastdata'])), $arr);
            foreach (current($arr) as $vv) {
                if (is_numeric($vv)) {
                    $calledid = $vv;
                }
            }
            $result[$k]['calledid'] = $v['cldid'];
            $result[$k]['action'] = $v['disposition'];
        }
    }

    echo json_encode(array("page" => $page, "total_count" => $total_count, "records" => $result));
    die;
});


Flight::route('/call/records_get(/@page/@page_size)', function ($page, $page_size) {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/call/records');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/call/records", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite('/var/log/asterisk/master.db');
    $total_count = current(array_values(current($DB->fecthall('select count(*) from cdr order by AcctId DESC'))));
    if (isset($page)) {
        $page_number = filter_var($page, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
        if (!is_numeric($page_number)) {
            die('Invalid page number!');
        }
    } else {
        $page_number = 1;
    }

    if ($page == 1) {
        $offset = "";
    } else {
        $offset = " OFFSET " . (($page - 1) * $page_size);
    }
    $total_pages = ceil($total_count / $page_size);
    $page_position = (($page_number - 1) * $page_size);

    foreach ($DB->fecthall('select * from cdr order by AcctId DESC LIMIT ' . $page_size . $offset) as $k => $v) {
        preg_match_all("/<(.*)>/", $v['clid'], $rs);
        preg_match_all('/\d+/', current(explode(',', $v['lastdata'])), $arr);
        foreach (current($arr) as $vv) {
            if (is_numeric($vv)) {
                $calledid = $vv;
            }
        }
        if ($v['billsec'] < 60) {
            if ($v['billsec'] < 10) {
                $sec = "00:0" . $v['billsec'];
            } else {
                $sec = "00:" . $v['billsec'];
            }
        } else {
            if(intval($v['billsec'] / 60)<10){
                $min="0".intval($v['billsec'] / 60);
            }else{
                $min=intval($v['billsec'] / 60);
            }
            if(($v['billsec'] % 60)<10){
                $sec="0".($v['billsec'] % 60);
            }else{
                $sec=($v['billsec'] % 60);
            }
            $sec = $min . ":" . $sec;
        }
        echo "<tr><td>" . $v['AcctId'] . "</td><td>" . $v['calldate'] . "</td><td>" . $sec . "</td><td>" . $rs[1][0] . "</td><td>" . $v['cldid'] . "</td><td>" . $v['disposition'] . "</td><td><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#del_com' onclick='delete_callrecords(\"" . $v['AcctId'] . "\")'>删除</button></td></tr>";
    }
    echo '<tr align="center"><td colspan="6">';
    echo paginate_function($page_size, $page_number, $total_count, $total_pages);
    echo '</td></tr>';
});

//删除通话记录服务
Flight::route('POST /call/records/delete', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/call/records/delete');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/call/records/delete", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite('/var/log/asterisk/master.db');
    $flag = $DB->delete("cdr", "AcctId", Flight::request()->data->getdata());
    if ($flag) {
        echo json_encode(array('api' => '/api/call/records/delete', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/call/records/delete", "删除通话记录出错");
    }
});

//语言设置服务
Flight::route('/language/update', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/language/update');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/language/update", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $items = current($DB->fecthall("select items from configs where config='language'"));
    if (empty($items['items'])) {
        $flag = $DB->insert("configs", array('config' => 'language', 'items' => json_encode(Flight::request()->data->getdata())));
    } else {
        $flag = $DB->update('configs', array('items' => json_encode(Flight::request()->data->getdata())), array('config' => 'language'));
    }
    if ($flag) {
        echo json_encode(array('api' => '/api/language/update', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/language/update");
    }
});

//语言服务
Flight::route('/language', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/language');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/language", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $items = current($DB->fecthall("select items from configs where config='language'"));
    if (empty($items['items'])) {
        echo json_encode(array());
    } else {
        echo $items['items'];
    }
    die;
});

//网络服务
Flight::route('/network', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/network');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/network", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    exec("hostname", $hostname);
    exec("ifconfig -a", $ifconbfig);

    exec("route -n", $gateways);
    $arr = array_slice($gateways, -2);// 倒数2个
    $eth = array();
    $i = 0;
    foreach ($ifconbfig as $k => $v) {

        if (strstr($v, "eth")) {
            $mac = end(explode(" ", $v));
            if (!strstr($ifconbfig[$k + 1], "Mask")) {
                $ip = "";
                $mask = "";
            } else {
                $ip = end(explode(":", current(array_filter(explode("  ", $ifconbfig[$k + 1])))));
                $mask = end(explode(":", end(array_filter(explode("  ", $ifconbfig[$k + 1])))));
            }
            array_push($eth, array("mac" => $mac, "ip" => $ip, "netmask" => $mask, "gateway" => array_slice(array_filter(explode("   ", $arr[0])), 1, 1)));
            $i++;
        }
    }

    exec("ip link show", $macs);
    foreach ($macs as $v) {
        if (strstr($v, "link/ether")) {
            $mac = (array_filter(explode(" ", $v)));
            break;
        }
    }
    $dnss = array();
    foreach (array_filter(explode("\n", file_get_contents("/etc/resolv.conf"))) as $v) {
        array_push($dnss, end(explode(" ", $v)));
    }
    $as[0] = $dnss[0];
    $as[1] = $dnss[1];
    $DB = new sqlite(DATABASE);
    $items = current($DB->fecthall("select items from configs where config='networks'"));
    $item = json_decode($items['items'], true);
    echo json_encode(array("hostname" => $hostname[0], "mac" => $mac[5], "dns" => $as, "eth" => $eth, "dhcp" => $item['dhcp']));
    die;
});

//修改网络服务
Flight::route('POST /network/update', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/network/update');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/network/update", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $data = Flight::request()->data->getdata();
    $DB = new sqlite(DATABASE);
    $items = current($DB->fecthall("select items from configs where config='networks'"));
    if (empty($items['items'])) {
        $flag = $DB->insert('configs', array('config' => 'networks', 'items' => json_encode($data)));
    } else {
        $flag = $DB->update('configs', array('items' => json_encode($data)), array('config' => 'networks'));
    }
    $interface = "
    auto lo
    iface lo inet loopback
    auto eth0
    iface eth0 inet static
    address " . $data['eth'][0]['ip'] . "
    gateway " . $data['eth'][0]['gateway'] . "
    netmask " . $data['eth'][0]['netmask'] . "
    network 192.168.1.0
    broadcast 192.168.1.255 
    
    dns " . str_replace(",", " ", $data['dns']);
    $str = "";
    foreach (explode(",", $data['dns']) as $v) {
        $str .= "nameserver " . $v . "\n";
    }
    file_put_contents("/etc/resolv.conf", $str);
    //file_put_contents("/etc/hostname", $data['hostname']);
    file_put_contents("/etc/network/interfaces", $interface);
    exec('sync;sync;sync;sync;sync;sync;sync;sync;sync;sync', $flag8);

    echo json_encode(array('api' => '/api/network/update', 'state' => 0));
    if (function_exists('fastcgi_finish_request')) {
        ob_flush();
        flush();
        fastcgi_finish_request();
    }

    exec("ifconfig eth0  " . $data['eth'][0]['ip'] . " netmask " . $data['eth'][0]['netmask'] . "", $flag);
    exec("route add default gw " . $data['eth'][0]['gateway'], $gw);
    exec('/etc/init.d/network restart', $flag8);

});

//时间日期服务
Flight::route('/datetime', function () {
    $DB = new sqlite(DATABASE);
    //校验用户是否登陆以及用户权限
    exec("date", $date);
    $arr = (explode(" ", $date[0]));


    foreach ($arr as $v) {
        $preg_time = "/^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/";
        preg_match_all($preg_time, $v, $all_time);
        if (!empty($all_time[0][0])) {
            $time = $v;
        }
    }
    CheckIsLogin('api/datetime');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/datetime", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $ntp = explode("\n", file_get_contents("/etc/ntp.conf"));
    $sd = explode(":", $time);

    $items = current($DB->fecthall("select items from configs where config='datetime'"));
    $item = json_decode($items['items'], true);


    exec("ls -l  /etc/localtime", $flag);
    exec('date "+%Y.%m.%d"', $det);

    echo json_encode(array("timezone" => "Etc/" . end((explode("/", $flag[0]))), "date" => $det[0], "time" => $sd[0] . ":" . $sd[1], "ntp" => $item['ntp'], "ntpserver" => $ntp[23]), JSON_UNESCAPED_SLASHES);
    die;
});

//修改日期服务
Flight::route('/datetime/update', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/datetime/update');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/datetime/update", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $time_msc = Flight::request()->data->getdata();
    if ($time_msc['timezone'] == "Etc/GMT") {
        $gmt = "Etc/GMT+0";
    } else {
        $gmt = $time_msc['timezone'];
    }

    exec("ln -sf /usr/share/zoneinfo/" . $gmt . " /etc/localtime", $rename);


    $ntp_header = "driftfile /var/lib/ntp/ntp.drift
    statistics loopstats peerstats clockstats
    filegen loopstats file loopstats type day enable
    filegen peerstats file peerstats type day enable
    filegen clockstats file clockstats type day enable
    server 0.debian.pool.ntp.org iburst
    server 1.debian.pool.ntp.org iburst
    server 2.debian.pool.ntp.org iburst
    server 3.debian.pool.ntp.org iburst
    ";

    $ntp_tail = "restrict -4 default kod notrap nomodify nopeer noquery
    restrict -6 default kod notrap nomodify nopeer noquery
    restrict 127.0.0.1
    restrict ::1
    ";
    file_put_contents("/etc/ntp.conf", $ntp_header . "\n" . $time_msc['ntpserver'] . "\n" . $ntp_tail);
    $date_arr = str_replace('.', '-', $time_msc['date']);
    $time_str = $time_msc['time'];
    $datetime_str = "date -s \"$date_arr $time_str\"";
    echo json_encode(array('api' => '/api/datetime/update', 'state' => 0));
    if (function_exists('fastcgi_finish_request')) {
        ob_flush();
        flush();
        fastcgi_finish_request();
    }
    exec("date > /home/datetime.php.record", $flag11);
    exec($datetime_str, $dateflag);
    exec("hwclock -w", $aa);
    die;
});
//系统升级服务
Flight::route('/system/update', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/system/update');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/system/update", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    echo json_encode(array('api' => '/api/system/update', 'state' => 0));
    die;
});
//恢复出厂设置服务
Flight::route('/factory/reset', function () {
    $DB = new sqlite(DATABASE);
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/factory/reset');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/factory/reset", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    exec('rm -rf /var/lib/asterisk/moh/*', $flag1);
    exec('rm -rf /var/www/html/avatar/*', $flag2);
    exec('rm -rf /var/log/asterisk/voicemail/default/*', $flag3);
    exec('sqlite3 /var/lib/asterisk/realtime.sqlite3 < /usr/share/restore.sql', $flag4);
    exec('sqlite3 /var/log/asterisk/master.db < /usr/share/records_restore.sql', $flag5);
    exec('cp /usr/share/interfaces.restore /etc/network/interfaces', $flag6);
    exec('date > /home/restore.php.record', $flag60);
    exec('sync;sync;sync;sync;sync', $flag61);
    exec('asterisk -rx reload', $flag7);
    exec("ln -sf /usr/share/zoneinfo/Etc/GMT+8 /etc/localtime", $rename);
    exec('/etc/init.d/network restart', $flag8);
    $flag = true;
    if ($flag) {
        echo json_encode(array('api' => '/api/factory/reset', 'state' => 0));
        die;
    }
});
//重启服务
Flight::route('/system/reboot', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/system/reboot');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/system/reboot", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    exec("sync");
    echo json_encode(array('api' => '/api/system/reboot', 'state' => 0));
    exec("reboot -n");

    die;
});
//创建备份服务
Flight::route('POST /backups/create', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/backups/create');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/backups/create", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $backup = Flight::request()->data->getdata();
    $DB = new sqlite(DATABASE);
    $filename = time();
    if (!is_dir("/var/backup/")) {
        mkdir("/var/backup/");
    }
    exit("gzip /var/www/html/avatar/* /var/lib/asterisk/realtime.sqlite3  -c > /var/backup/" . $filename . ".gz");

    echo json_encode(array('api' => '/api/backups/create', 'state' => 0));
    if (function_exists('fastcgi_finish_request')) {
        ob_flush();
        flush();
        fastcgi_finish_request();
    }
    exec("gzip /var/www/html/avatar/* /var/lib/asterisk/realtime.sqlite3  -c > /var/backup/" . $filename . ".gz", $rs);

    $flag = $DB->insert("backups", array("name" => $backup['name'], "remark" => $backup['remark'], "time" => time(), "file" => "/var/backup/" . $filename . ".gz"));
});

//恢复备份服务
Flight::route('/backups/restore/', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/backups/restore');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/backups/restore", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $name = Flight::request()->data->getdata();
    //$flag = copy('/var/backup/' . $name['name'], DATABASE);
    $flag = true;
    if ($flag) {
        echo json_encode(array('api' => '/api/backups/restore', 'state' => 0));
        die;
    } else {
        echo json_encode(array('api' => '/api/backups/restore', 'state' => 'fail'));
        die;
    }
});
//获取备份列表服务
Flight::route('/backups(/@page/@page_size)', function ($page, $page_size) {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/backups');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/backups", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $total_count = current(array_values(current($DB->fecthall('select count(*) from backups'))));
    $start = (empty($page)) ? 0 : ($page - 1) * $page_size;
    $end = (empty($page)) ? $total_count : $page * $page_size;
    foreach ($DB->fecthall('select * from backups limit ' . $start . ', ' . $end) as $k => $v) {
        $result[$k]['name'] = $v['name'];
        $result[$k]['remark'] = $v['remark'];
        $result[$k]['file'] = $v['file'];
        $result[$k]['time'] = $v['time'];
    }
    echo json_encode(array("page" => $page, "total_count" => $total_count, "backups" => $result));
    die;
});

//删除备份服务
Flight::route('/backups/delete', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/backups/delete');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/backups/delete", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $flag = $DB->delete("backups", "name", Flight::request()->data->getdata());
    if ($flag) {
        echo json_encode(array('api' => '/api/backups/delete', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/backups/delete", "删除backups出错");
    }
});
/*
 * 防火墙过滤列表API
 * 包括对防火墙过滤列表的CURD
 * */
//获取防火墙过滤列表服务
Flight::route('/firewall/filters(/@page/@page_size)', function ($page, $page_size) {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/firewall/filters');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/firewall/filters", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $total_count = current(array_values(current($DB->fecthall('select count(*) from firewallfilters'))));
    $start = (empty($page)) ? 0 : ($page - 1) * $page_size;
    $end = (empty($page)) ? $total_count : $page * $page_size;
    foreach ($DB->fecthall('select * from firewallfilters limit ' . $start . ', ' . $end) as $k => $v) {
        $result[$k]['name'] = $v['name'];
        $result[$k]['ip'] = $v['ip'];
        $result[$k]['port'] = $v['port'];
        $result[$k]['proto'] = $v['proto'];
        $result[$k]['action'] = $v['action'];
    }
    echo json_encode(array("page" => $page, "total_count" => $total_count, "filters" => $result));
    die;
});
//添加防火墙服务
Flight::route('POST /firewall/filters/add', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/firewall/filters/add');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/firewall/filters/add", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $flag = $DB->insert("firewallfilters", Flight::request()->data->getdata());
    if ($flag) {
        echo json_encode(array('api' => '/api/firewall/filters/add', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/firewall/filters/add", "添加防火墙出错");
    }
});

//修改防火墙过滤列表服务
Flight::route('/firewall/filters/update', function () {
    $DB = new sqlite(DATABASE);
    $filters = Flight::request()->data->getdata();
    $flag = $DB->update("firewallfilters", $filters, array('name' => $filters['name']));
    if ($flag) {
        echo json_encode(array('api' => '/api/firewall/filters/update', 'state' => 0));
        die;
    }
});

//删除防火墙服务
Flight::route('/firewall/filters/delete', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/firewall/filters/delete');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/firewall/filters/delete", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $flag = $DB->delete("firewallfilters", "name", Flight::request()->data->getdata());
    if ($flag) {
        echo json_encode(array('api' => '/api/firewall/filters/delete', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/firewall/filters/delete", "删除firewall/filters出错");
    }
});

//获取防火墙信息
Flight::route('/firewall/filters/info', function () {
    $DB = new sqlite(DATABASE);
    $name = $_POST['name'];
    echo json_encode(current($DB->fecthall("select * from firewallfilters where name='{$name}'")));
    die;
});
//获取日至服务
Flight::route('/logs(/@year/@month/@day)', function ($year, $month, $day) {
    if (empty($year)) {
        exec("cat /var/log/asterisk/messages", $output);
        echo json_encode(array("text" => implode("\n", $output)));
        die;
    } else {
        //$date_tmp = explode("/", $date);
        $date = $month . "-" . $day;
        //$date = date("M d", mktime(0, 0, 0, $month, $day, $year));
        exec("grep /var/log/asterisk/messages -e " . '"' . $date . '"', $output);
        //exit("grep /var/log/asterisk/messages -e " . '"' . $date . '"');
        echo json_encode(array("text" => implode("\n", $output)));
        die;
    }
});

//获取用户信息服务
Flight::route('/users(/@page/@page_size)', function ($page, $page_size) {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/users');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/users", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $total_count = current(array_values(current($DB->fecthall('select count(*) from users'))));
    if ($page == 1) {
        $offset = "";
    } else {
        $offset = " OFFSET " . (($page - 1) * $page_size);
    }
    foreach ($DB->fecthall('select * from users limit ' . $page_size . $offset) as $k => $v) {
        $result[$k]['name'] = $v['name'];
        $result[$k]['password'] = $v['password'];
        $result[$k]['permits'] = $v['permits'];
    }
    echo json_encode(array("page" => $page, "total_count" => $total_count, "users" => $result));
    die;
});

//添加用户服务
Flight::route('POST /users/add', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/users/add');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/users/add", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $users = Flight::request()->data;
    $flag = $DB->insert("users", array("name" => $users['name'], "password" => $users['password'], "permits" => $users['permits']));
    if ($flag) {
        echo json_encode(array('api' => '/api/users/add', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/users/add", "分机添加错误");
    }
});

//修改用户信息服务
Flight::route('POST /users/update', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/users/update');

    $DB = new sqlite(DATABASE);
    $users = Flight::request()->data;
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/users/update", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $name = $users['name'];
    $password = $users['password'];
    $permits = $users['permits'];
    $sql = "UPDATE users set name='{$name}',password='{$password}',permits='{$permits}' where name='{$name}'";
    $flag = $DB->query($sql);
    if ($flag) {
        echo json_encode(array('api' => '/api/users/update', 'state' => 0));
        die;
    } else {
        getErrorInfo("/api/users/update", "修改分机信息错误");
    }
});
//删除用户服务
Flight::route('POST /users/delete', function () {
    //校验用户是否登陆以及用户权限
    CheckIsLogin('api/users/delete');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "/users/delete", "state" => 3, "msg" => "无权限操作"));
        die;
    }
    $DB = new sqlite(DATABASE);
    $users = Flight::request()->data->getdata();
    $flag = $DB->delete("users", "name", $users);
    if ($flag) {
        echo json_encode(array('api' => '/api/users/delete', 'state' => 0));
        die;
    } else {
        getErrorInfo("/users/delete", "删除用户信息出错");
    }
});

Flight::route('/users/info', function () {
    $DB = new sqlite(DATABASE);
    $name = $_POST['name'];
    echo json_encode(current($DB->fecthall("select * from users where name='{$name}'")));
    die;
});


Flight::route('/users/checkname', function () {
    $DB = new sqlite(DATABASE);
    $name = $_POST['username'];
    if (empty(current($DB->fecthall("select * from users where name='{$name}'")))) {
        echo json_encode(array("state" => 1));
    } else {
        echo json_encode(array("state" => 0));
    }
    die;
});
//上传头像服务
Flight::route('/uploadAvatar', function () {
    require('UploadHandler.php');
    $upload_handler = new UploadHandler();
    $tmp = $upload_handler->response;
    '/var/www/php/flight/files/' . current($tmp['files'])->name;
    $rename_file = time() . '.png';
    if (!is_dir('/var/www/html/tmp/')) {
        mkdir('/var/www/html/tmp/');
    }
    $flag = rename('/var/www/php/flight/files/' . current($tmp['files'])->name, '/var/www/html/tmp/' . $rename_file);
    if ($flag) {
        $result = array("name" => $rename_file);
    } else {
        $result = array("msg" => "remove file fail");
    }
    echo json_encode($result);
    die;
});

//剪切头像服务
Flight::route('POST /crop/avatar/@filename', function ($filename) {
    $users = Flight::request()->data->getdata();
    header('Content-type: image/jpeg');

// Get new dimensions
    list($width, $height) = getimagesize('/var/www/html/avatar/' . $filename . ".png");
    $new_width = $users['width'];
    $new_height = $users['height'];
// Resample
    $image_p = imagecreatetruecolor($new_width, $new_height);
    $image = imagecreatefrompng($filename);
    imagecopyresampled($image_p, $image, 0, 0, $users['naturalWidth'], $users['naturalHeight'], $new_width, $new_height, $new_width, $new_height);

// Output
    imagejpeg($image_p, null, 100);
});


//上传MOH文件服务
Flight::route('/upload/mohs/@dir', function ($dir) {
    require('UploadHandler.php');
    $upload_handler = new UploadHandler();
    $tmp = $upload_handler->response;

    $rename_file = $dir. '.wav';
    if (!is_dir('/var/lib/asterisk/moh/')) {
        mkdir('/var/lib/asterisk/moh/');
    }
    if (!is_dir('/var/lib/asterisk/moh/' .$dir)) {
        mkdir('/var/lib/asterisk/moh/' .$dir);
    }

    $flag = rename('/var/www/php/flight/files/' . current($tmp['files'])->name, '/var/lib/asterisk/moh/' .$dir. '/' . $rename_file);
    if ($flag) {
        $result = array("name" => $rename_file, "dir" => '/' .$dir. "/");
    } else {
        $result = array("msg" => "remove file fail");
    }
    echo json_encode($result);
    die;
});
//重载配置
Flight::route('/conf/reload(/@module)', function ($module) {
    CheckIsLogin('api/conf/reload');
    if ($_SESSION['useraccess'] == "sip") {
        echo json_encode(array("api" => "api/conf/reload", "state" => 3, "msg" => "无权限操作"));
        die;
    }

    $cmd = "asterisk" . " -rx " . "\"reload\"";
    exec($cmd, $flag);

    echo json_encode(array('api' => '/api/conf/reload', 'state' => 0));
    die;
});

Flight::start();

//输出错误信息通用方法
function getErrorInfo($url, $info)
{
    echo json_encode(array("state" => 4, "api" => $url, "msg" => $info));
    die;
}

//获取文件夹下文件数量
function getoldfilecounts($dir)
{
    exec("ls -l " . $dir . "/*.wav |grep \"^-\"|wc -l", $output);
    //exit("ls -l ".$dir."/Old"."/*.wav |grep \"^-\"|wc -l");
    $handle = opendir($dir);
    $i = 0;
    $files = array();
    while (false !== $file = (readdir($handle))) {
        if ($file !== '.' && $file != '..') {

            $files[] = $file;
        }
    }
    foreach ($files as $k => $v) {
        $aa = explode(".", $files[$k]);
        $bb = explode(".", $files[$k + 1]);
        $i++;
    }
    closedir($handle);
    return $output[0];
}

function getfilecounts($dir)
{
    exec("ls -l " . $dir . "/*.wav |grep \"^-\"|wc -l", $output);
    //exit("ls -l ".$dir."/*.wav |grep \"^-\"|wc -l");
    $handle = opendir($dir);
    $i = 0;
    $files = array();
    while (false !== $file = (readdir($handle))) {
        if ($file !== '.' && $file != '..') {

            $files[] = $file;
        }
    }
    foreach ($files as $k => $v) {
        $aa = explode(".", $files[$k]);
        $bb = explode(".", $files[$k + 1]);
        //if ($aa[0]!=$bb[0]) {
        $i++;
        //}
    }

    closedir($handle);
    return $output[0];
}

//获取数组中
function chunck_array($array, $start, $end)
{
    foreach ($array as $k => $v) {
        if (strstr($v, $start)) {
            $flag = $k + 1;
        }
        if ($flag > $k) {
            $tep[] = $array[$flag];
        }
        $flag++;
    }
    unset($tep[count($tep) - 1]);
    foreach (array_reverse($tep) as $k => $v) {
        if (strstr($v, $end)) {
            $flag_sub = $k + 1;
        }

        if ($flag_sub > $k) {
            $tep_fin[] = $tep[$flag_sub];
        }
        $flag_sub++;
    }
    return array_filter($tep_fin);
}

//数组分页封装方法
function PaginationArray($count, $page, $array, $order)
{
    global $countpage;
    $page = (empty($page)) ? '1' : $page;
    $count = (empty($count)) ? count($array) : $count;
    $start = ($page - 1) * $count;
    if ($order == 1) {
        $array = array_reverse($array);
    }
    $totals = count($array);
    $countpage = ceil($totals / $count);
    $pagedata = array();
    $pagedata = array_slice($array, $start, $count);
    return $pagedata; #返回查询数据
}

//判断用户是否登陆通用方法
function CheckIsLogin($api)
{
    if (!isset($_SESSION['username'])) {
        echo json_encode(array("api" => $api, "state" => 2, "msg" => "未登录"));
        die;
    }
}

//获取用户权限信息通用方法
function GetUserPrivilege($username)
{
    $DB = new sqlite(DATABASE);
    $user = $DB->fecthall('select * from users where name="' . $username . '"');
    if (empty($user)) {
        $temp['permits'] = "sip";
    } else {
        $temp = current($user);
    }
    return $temp['permits'];
}

//数组排序方法
function multi_array_sort($arr, $shortKey, $short = SORT_ASC, $shortType = SORT_REGULAR)
{
    foreach ($arr as $key => $data) {
        $name[$key] = $data[$shortKey];
    }
    array_multisort($name, $shortType, $short, $arr);
    return $arr;
}

function NumToStr($num)
{
    if (stripos($num, 'e') === false) return $num;
    $num = trim(preg_replace('/[=\'"]/', '', $num, 1), '"');
    $result = "";
    while ($num > 0) {
        $v = $num - floor($num / 10) * 10;
        $num = floor($num / 10);
        $result = $v . $result;
    }
    return $result;
}


function paginate_function($item_per_page, $current_page, $total_records, $total_pages){
    $pagination = '';
    if ($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) {
        $pagination .= '<ul class="pagination">';
        $right_links = $current_page + 5;
        $previous = $current_page - 5;
        $next = $current_page + 1;
        $first_link = true;
        if ($current_page > 1) {
            $previous_link = ($previous == 0) ? 1 : $previous;
            $pagination .= '<li class="first"><a href="#" data-page="1" title="First">&laquo;</a></li>';
            if (($current_page - 2)>0){
                $preh = $current_page - 2;
            }else{
                $preh = 1;
            }
            for ($i = $preh; $i < $current_page; $i++) {
                if ($i > 0) {
                    $pagination .= '<li><a href="#" data-page="' . $i . '" title="Page' . $i . '">' . $i . '</a></li>';
                }
            }
            $first_link = false;
        }
        if ($first_link) {
            $pagination .= '<li class="first active"><a>' . $current_page . '</a></li>';
        } elseif ($current_page == $total_pages) {
            $pagination .= '<li class="last active"><a>' . $current_page . '</a></li>';
        } else {
            $pagination .= '<li class="active"><a>' . $current_page . '</a></li>';
        }

        for ($i = $current_page + 1; $i < $right_links; $i++) {
            if ($i <= $total_pages && $i > 0) {
                $pagination .= '<li><a href="#" data-page="' . $i . '" title="Page ' . $i . '">' . $i . '</a></li>';
            }
        }
        if ($current_page < $total_pages) {
            $next_link = ($i > $total_pages) ? $total_pages : $i;
            $pagination .= '<li class="last"><a href="#" data-page="' . $total_pages . '" title="Last">&raquo;</a></li>';
        }
        $pagination .= '</ul>';
    }
    return $pagination;
}
?>
