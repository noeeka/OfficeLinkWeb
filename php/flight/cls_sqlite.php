<?php

class sqlite extends SQLite3 {

    public $url;

    function __construct($url) {
        $this->url = $url;
        $this->open($url);
        $this->busyTimeout(5000); // 10 seconds
    }

    function check_input($value) {
        if (get_magic_quotes_gpc()) {
            $value = sqlite_escape_string($value);
        }
        return $value;
    }

    function create($table, $name, $type = null) {
        $sql = 'CREATE TABLE ' . $table . '(';
        if ($type == null) {
            $arrname = array_keys($name);
            $arrtype = array_values($name);
        } else {
            $arrname = explode("|", $name);
            $arrtype = explode("|", $type);
        }
        for ($i = 0; $i < count($arrname); $i++) {
            if ($i == count($arrname) - 1) {
                $sql = $sql . $arrname[$i] . "   " . $arrtype[$i] . "";
            } else {
                $sql = $sql . $arrname[$i] . "   " . $arrtype[$i] . ",";
            }
        }
        $sql = $sql . ');';
        $re = $this->query($sql);
        if ($re) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function drop($table) {
        $sql = 'DROP TABLE ' . $table . ';';
        $re = $this->query($sql);
        if ($re) {
            return true;
        } else {
            return false;
        }
    }

    function insert($table, $name, $value = null) {
        $sql = "INSERT INTO " . $table . '(';
        if ($value == null) {
            $arrname = array_keys($name);
            $arrvalue = array_values($name);
        } else {
            $arrname = explode('|', $name);
            $arrvalue = explode('|', $value);
        }
        for ($i = 0; $i < count($arrname); $i++) {
            if ($i == count($arrname) - 1) {
                $sql = $sql . $arrname[$i];
            } else {
                $sql = $sql . $arrname[$i] . ",";
            }
        }
        $sql = $sql . ")VALUES(";
        for ($i = 0; $i < count($arrvalue); $i++) {
            if ($i == count($arrvalue) - 1) {
                if (is_array($arrvalue[$i])) {
                    $sql = $sql . "'" . json_encode($arrvalue[$i]) . "'";
                } else {
                    $sql = $sql . "'" . $arrvalue[$i] . "'";
                }
            } else {
                if (is_array($arrvalue[$i])) {
                    $sql = $sql . "'" . json_encode($arrvalue[$i]) . "',";
                } else {
                    $sql = $sql . "'" . $arrvalue[$i] . "',";
                }
            }
        }
        $sql .= ");";
        if ($debug) {
            echo $sql;
        }
        try {
            $re = $this->query($sql);
        } catch (Exception $ex) {
            echo json_encode(array("state" => 5, "api" => "", "msg" => "插入数据错误"));
            die;
        }
        $this->close();
        if ($re) {
            return true;
        } else {
            return false;
        }
    }

    function delete($table, $column, $values) {
        $where = '';
        foreach ($values as $value) {
            $where .= "'" . $value . "'" . ",";
        }
        $sql = "delete from " . $table . " where " . $column . " in (" . rtrim($where, ",") . ")";
        try {
            $re = $this->query($sql);
        } catch (Exception $ex) {
            echo json_encode(array("state" =>5, "api" => "", "msg" => "删除数据错误"));
            die;
        }
        $this->close();
        if ($re) {
            return true;
        } else {
            return false;
        }
    }

    function select($table, $name, $Conditionsname, $Conditionsvalue = null) {
        if ($Conditionsvalue != null) {
            $sql = "SELECT " . $name . " FROM " . $table . " WHERE " . $Conditionsname . "='" . $Conditionsvalue . "';";
        } else {
            $sql = "SELECT " . $name . " FROM " . $table . " WHERE ";
            $arrname = array_keys($Conditionsname);
            $arrvalue = array_values($Conditionsname);
            for ($i = 0; $i < count($arrname); $i++) {
                if ($i == count($arrname) - 1) {
                    $sql .= $arrname[$i] . '=' . "'" . $arrvalue[$i] . "'";
                } else {
                    $sql .= $arrname[$i] . '=' . "'" . $arrvalue[$i] . "' and ";
                }
            }
            $sql .= ';';
        }
        //exit(addslashes($sql));
        $ret = $this->query($sql);
        $row = $ret->fetchArray(SQLITE3_ASSOC);
        return $row;
    }

    function getOne($sql) {
        $return = array();
        $ret = $this->query($sql);
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            array_push($return, $row);
        }
        return $return;
    }

    function update($table, $value, $Conditionsname, $Conditionsvalue = null) {
        $sql = "UPDATE " . $table . " SET ";
        $arrname = array_keys($value);
        $arrvalue = array_values($value);
        for ($i = 0; $i < count($arrname); $i++) {
            if (is_array($arrvalue[$i])) {
                $sql .= $arrname[$i] . '=' . "'" . json_encode($arrvalue[$i]) . "',";
            } else {
                $sql .= $arrname[$i] . '=' . "'" . $arrvalue[$i] . "',";
            }
        }
        $sql = rtrim($sql, ',');
        $sql .= ' WHERE ';
        $arrname_where = array_keys($Conditionsname);
        $arrvalue_where = array_values($Conditionsname);
        for ($i = 0; $i < count($arrname_where); $i++) {
            if ($i == count($arrname_where) - 1) {
                $sql .= $arrname_where[$i] . '=' . "'" . $arrvalue_where[$i] . "'";
            } else {
                $sql .= $arrname_where[$i] . '=' . "'" . $arrvalue_where[$i] . "' and ";
            }
        }
        $sql .= ';';
        try {
            $re = $this->query($sql);
        } catch (Exception $ex) {
            echo json_encode(array("state" => 5, "api" => "", "msg" => "更改数据错误"));
            die;
        }
        $this->close();
        if ($re) {
            return true;
        } else {
            return false;
        }
    }

    function group($table, $name) {
        $sql = "SELECT " . $name . " FROM " . $table . ";";
        $return = array();
        $ret = $this->query($sql);
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            array_push($return, $row[$name]);
        }
        return $return;
    }

    function fecthall($sql) {
        $return = array();

        try {
            $ret = $this->query($sql);
        } catch (Exception $ex) {
            echo json_encode(array("state" => 5, "api" => "", "msg" => "读取数据错误"));
            die;
        }
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            array_push($return, $row);
        }
        //$this->close();
        return $return;
    }

}
