#! /usr/bin/env lua
local json = require("json")
local sqlite3 = require("lsqlite3")
local db=sqlite3.open("/var/lib/asterisk/realtime.sqlite3")
for row in db:nrows("SELECT * FROM ivrs") do
    print(string.format("exten = %s,1,Goto(voicemenu-custom-%s,s,1)",row.extension,row.id))
end