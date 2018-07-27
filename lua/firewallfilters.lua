#! /usr/bin/env lua
local json = require("json")
local sqlite3 = require("lsqlite3")
local db=sqlite3.open("/var/lib/asterisk/realtime.sqlite3")
for row in db:nrows("SELECT * FROM firewallfilters") do
    print(string.format("%s       %s  --  %s          0.0.0.0/0",row.action,row.proto,row.ip))
end