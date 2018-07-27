<?php

class AstMan {
    var $socket;
    var $error;
    var $host = "192.168.1.157";
    var $username = "systec";
    var $password = "1314";
    var $port = "5038";

    function AstMan() {
        $this->socket = FALSE;
        $this->error = "";
    }

    function Login($host = "localhost", $username = "admin", $password = "amp111") {
        $this->socket = @fsockopen($host, "5038", $errno, $errstr, 1);
        if (!$this->socket) {
            $this->error = "Could not connect - $errstr ($errno)";
            return FALSE;
        } else {
            stream_set_timeout($this->socket, 1);
            $wrets = $this->Query("Action: Login\r\nUserName: $username\r\nSecret: $password\r\nEvents: off\r\n\r\n");
            if (strpos($wrets, "Message: Authentication accepted") != FALSE) {
                return true;
            } else {
                $this->error = "Could not login - Authentication failed";
                fclose($this->socket);
                $this->socket = FALSE;
                return FALSE;
            }
        }
    }

    function GetConfigJSON($configFile) {
        $this->socket = @fsockopen($this->host, $this->port, $errno, $errstr, 1);
        if (!$this->socket) {
            $this->error = "Could not connect - $errstr ($errno)";
            return FALSE;
        } else {
            stream_set_timeout($this->socket, 1);
            $this->Query("Action: Login\r\nUserName: $this->username\r\nSecret: $this->password\r\nEvents: off\r\n\r\n");
            $wrets = $this->Query("Action: GetConfigJSON\r\nFilename: $configFile\r\nEvents: off\r\n\r\n");
            return $wrets;
        }
    }

    function GetConfig($configFile) {
        $this->socket = @fsockopen($this->host, "5038", $errno, $errstr, 1);
        if (!$this->socket) {
            $this->error = "Could not connect - $errstr ($errno)";
            return FALSE;
        } else {
            stream_set_timeout($this->socket, 1);
            $this->Query("Action: Login\r\nUserName: $this->username\r\nSecret: $this->password\r\nEvents: off\r\n\r\n");
            $wrets = $this->Query("Action:GetConfig\r\nFilename: $configFile\r\nEvents: on\r\n\r\n");
            if (strpos($wrets, "Message: Authentication accepted") != FALSE) {
                return true;
            } else {
                $this->error = "Could not login - Authentication failed";
                fclose($this->socket);
                $this->socket = FALSE;
                return FALSE;
            }
        }
    }

    function UpdateConfigFile($Par, $SrcFilename, $DstFilename) {
        $this->socket = @fsockopen($this->host, $this->port, $errno, $errstr, 1);
        if (!$this->socket) {
            $this->error = "Could not connect - $errstr ($errno)";
            return FALSE;
        } else {
            stream_set_timeout($this->socket, 1);
            $this->Query("Action: Login\r\nUserName: $this->username\r\nSecret: $this->password\r\nEvents: off\r\n\r\n");
            foreach ($Par as $k => $v) {
                $res[] = $k . ":" . $v;
            }
            $parameter = implode("\r\n", $res);
            // exit("Action:UpdateConfig\r\nSrcFilename:$SrcFilename\r\nDstFilename:$DstFilename\r\n{$parameter}Events: on\r\n\r\n");

            $wrets = $this->Query("Action:UpdateConfig\r\nSrcFilename:$SrcFilename\r\nDstFilename:$DstFilename\r\n{$parameter}\r\nEvents: on\r\n\r\n");
            if (strpos($wrets, "Message: Authentication accepted") != FALSE) {
                return true;
            } else {
                $this->error = "Could not login - Authentication failed";
                fclose($this->socket);
                $this->socket = FALSE;
                return FALSE;
            }
        }
    }

    //获取分机状态
    function ExtensionStateList() {
        $this->socket = @fsockopen($this->host, $this->port, $errno, $errstr, 1);
        if (!$this->socket) {
            $this->error = "Could not connect - $errstr ($errno)";
            return FALSE;
        } else {
            stream_set_timeout($this->socket, 1);
            $this->Query("Action: Login\r\nUserName: $this->username\r\nSecret: $this->password\r\nEvents: off\r\n\r\n");
            $wrets = $this->Query("Action: ExtensionStateList\r\nEvents: off\r\n\r\n");
            return $wrets;
        }
    }

    //获取中级状态
    function TrunkStateList() {
        //return  explode("\n", $this->Cmd("sip show registry"));
        return $this->Cmd("sip show registry");
    }

    //获取Parking状态
    function ParkedCalls() {
        return $this->Cmd("parking show");
    }

    //获取会议室状态
    function MeetmeListRooms() {
        $this->GetConfigJSON("meetme.conf");
    }

    function ConfbridgeList() {
        $this->socket = @fsockopen($this->host, $this->port, $errno, $errstr, 1);
        if (!$this->socket) {
            $this->error = "Could not connect - $errstr ($errno)";
            return FALSE;
        } else {
            stream_set_timeout($this->socket, 1);
            $this->Query("Action: Login\r\nUserName: $this->username\r\nSecret: $this->password\r\nEvents: off\r\n\r\n");
            $wrets = $this->Query("Action: MeetmeList\r\nEvents: off\r\n\r\n");
            return $wrets;
        }
    }

    function Cmd($cmd) {
            exec("asterisk -rx '".$cmd."'", $output);
            return $output;
    }

    function Logout() {
        if ($this->socket) {
            fputs($this->socket, "Action: Logoff\r\n\r\n");
            while (!feof($this->socket)) {
                $wrets .= fread($this->socket, 8192);
            }
            fclose($this->socket);
            $this->socket = "FALSE";
        }
        return;
    }

    function Query($query) {
        $wrets = "";

        if ($this->socket === FALSE)
            return FALSE;

        fputs($this->socket, $query);
        do {
            $line = fgets($this->socket, 8192);
            $wrets .= $line;
            $info = stream_get_meta_data($this->socket);
        } while ($line != "\r\n" && $info['timed_out'] == false);
        return $wrets;
    }

    function GetError() {
        return $this->error;
    }

    function GetDB($family, $key) {
        $value = "";

        $wrets = $this->Query("Action: Command\r\nCommand: database get $family $key\r\n\r\n");

        if ($wrets) {
            $value_start = strpos($wrets, "Value: ") + 7;
            $value_stop = strpos($wrets, "\n", $value_start);
            if ($value_start > 8) {
                $value = substr($wrets, $value_start, $value_stop - $value_start);
            }
        }
        return $value;
    }

    function PutDB($family, $key, $value) {
        $wrets = $this->Query("Action: Command\r\nCommand: database put $family $key $value\r\n\r\n");

        if (strpos($wrets, "Updated database successfully") != FALSE) {
            return TRUE;
        }
        $this->error = "Could not updated database";
        return FALSE;
    }

    function DelDB($family, $key) {
        $wrets = $this->Query("Action: Command\r\nCommand: database del $family $key\r\n\r\n");

        if (strpos($wrets, "Database entry removed.") != FALSE) {
            return TRUE;
        }
        $this->error = "Database entry does not exist";
        return FALSE;
    }

    function GetFamilyDB($family) {
        $wrets = $this->Query("Action: Command\r\nCommand: database show $family\r\n\r\n");
        if ($wrets) {
            $value_start = strpos($wrets, "Response: Follows\r\n") + 19;
            $value_stop = strpos($wrets, "--END COMMAND--\r\n", $value_start);
            if ($value_start > 18) {
                $wrets = substr($wrets, $value_start, $value_stop - $value_start);
            }
            $lines = explode("\n", $wrets);
            foreach ($lines as $line) {
                if (strlen($line) > 4) {
                    $value_start = strpos($line, ": ") + 2;
                    $value_stop = strpos($line, " ", $value_start);
                    $key = trim(substr($line, strlen($family) + 2, strpos($line, " ") - strlen($family) + 2));
                    $value[$key] = trim(substr($line, $value_start));
                }
            }
            return $value;
        }
        return FALSE;
    }

}
?>