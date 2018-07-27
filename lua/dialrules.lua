#! /usr/bin/env lua
local json = require("json")
local sqlite3 = require("lsqlite3")
local db=sqlite3.open("/var/lib/asterisk/realtime.sqlite3")
for row in db:nrows("SELECT * FROM dialrules") do
    local dialrules = json.decode(row.rules)
    for k,v in pairs(dialrules) do
        print(string.format("\n[CallingRule_%s]\nexten = %s,1,Macro(trunkdial-failover-0.3,${80006}/%s${FILTER(%s,${EXTEN:%s})},,80006,)",row.name,v.rule,v.prepend,v.filters,v.strip))
    end
end
