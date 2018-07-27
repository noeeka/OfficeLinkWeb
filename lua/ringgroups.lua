#! /usr/bin/env lua
local json = require("json")
local x = 1
local sqlite3 = require("lsqlite3")
local db=sqlite3.open("/var/lib/asterisk/realtime.sqlite3")
for row in db:nrows("SELECT * FROM ringgroups") do
    if (row.ring_style=="inorder")
    then
        print(string.format("\n[ringroups-custom-1]\nexten = s,1,NoOp(%s)",row.name))
        local members = json.decode(row.members)
        for k,v in pairs(members) do
            print(string.format("\nexten = s,n,Dial(SIP/%s,%s,${DIALOPTIONS}i)",v,row.timeout))
        end
        print(string.format("\nexten = s,n,Hangup",row.name))
    else
        print(string.format("\n[ringroups-custom-%s]\nexten = s,%s,NoOp(%s)",row.name,row.name,row.name))
        local members = json.decode(row.members)
        local result = ""
        for k,v in pairs(members) do
            result =result.."SIP/"..v.."&"
        end
        print(string.format("\nexten = s,n,Dial(%s,%s,${DIALOPTIONS}i)",result,row.timeout))
        print(string.format("\nexten = s,n,Hangup",row.name))
    end
end
