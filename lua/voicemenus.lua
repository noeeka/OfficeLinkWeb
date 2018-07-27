#! /usr/bin/env lua
local json = require("json")
local sqlite3 = require("lsqlite3")
local db=sqlite3.open("/var/lib/asterisk/realtime.sqlite3")
for row in db:nrows("SELECT * FROM ivrs") do
    print(string.format("[voicemenu-custom-%s]",row.id))
    print(string.format("exten = s,1,NoOp(%s)",row.name))
    local rules = json.decode(row.rules)
    for k,v in pairs(rules) do
        print(string.format("exten = s,%s,%s(%s)",k,v.application,v.args))
    end
    --print(string.format("\nexten = s,n,Hangup",row.name))
end
