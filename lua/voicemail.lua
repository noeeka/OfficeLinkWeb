#! /usr/bin/env lua
local json = require("json")
local sqlite3 = require("lsqlite3")
local db=sqlite3.open("/var/lib/asterisk/realtime.sqlite3")
for row in db:nrows("SELECT * FROM configs WHERE config='voicemail'") do
    --print(row.items)
    local voicemail = json.decode(row.items)
    --print(voicemail.extension)
    --print(debug.dump(voicemail))
    --for k,v in pairs(voicemail) do
        --print(k.."="..v)
    print(string.format("maxmessage = %s\nmaxsecs = %s\nminsecs = %s",voicemail.maxmessage,voicemail.maxsec,voicemail.minsec))
    --end
end
