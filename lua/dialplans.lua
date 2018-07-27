#! /usr/bin/env lua
local json = require("json")
local sqlite3 = require("lsqlite3")
local db=sqlite3.open("/var/lib/asterisk/realtime.sqlite3")
for row in db:nrows("SELECT * FROM dialplans") do
    local dialrules = json.decode(row.rules)
    print(string.format("[DLPN_%s]",row.name))
    for k,v in pairs(dialrules) do
    	print("\ninclude = "..v)
    end
end
