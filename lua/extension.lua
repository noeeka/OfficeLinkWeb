#! /usr/bin/env lua
local json = require("json")
local sqlite3 = require("lsqlite3")
local db=sqlite3.open("/var/lib/asterisk/realtime.sqlite3")
for row in db:nrows("SELECT * FROM sippeers") do
        local decoded = json.decode(row.codecs)
        local result = ""
        for i,v in pairs(decoded) do
            if  v ~= "" then 
                result = result .. v ..","
            end 
        end
        print(string.format("\n[%s]\nfullname = %s\nregistersip = no\nhost = dynamic\ncallgroup = 1\nmailbox = %s\ncall-limit = 100\ntype = peer\nusername = %s\ntransfer = yes\ncallcounter = yes\ncontext = %s\ncid_number = %s\nhasvoicemail = yes\nvmsecret = %s\nemail = %s\nthreewaycalling = no\nhasdirectory = no\ncallwaiting = no\nhasmanager = no\nhasagent = no\nhassip = yes\nhasiax = no\nsecret = %s\nnat = force_rport,comedia\ncanreinvite = no\ndtmfmode = rfc2833\ninsecure = no\npickupgroup = 1\nmacaddress = %s\nautoprov = yes\nlabel = %s\nlinenumber = 1\nLINEKEYS = 1\ndisallow = all\nallow = %s",row.extension,row.nickname,row.extension,row.extension,row.dialplan,row.extension,row.voicemail_pin,row.email,row.password,row.extension,row.extension,result))
end
for row in db:nrows("select * from providers") do
    print(string.format("[%s]\nhost = %s\nusername = %s\nsecret = %s\ntrunkname = %s\ncontext = %s\nhasexten = no\nhasiax = no\nhassip = yes\nregisteriax = no\nregistersip = yes\ntrunkstyle = voip\ndisallow = all\nallow = all\nkeepalive = 10",row.user,row.address,row.user,row.password,row.name,row.dialplan))
end




