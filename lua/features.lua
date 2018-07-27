#! /usr/bin/env lua
local json = require("json")
local sqlite3 = require("lsqlite3")
local db=sqlite3.open("/var/lib/asterisk/realtime.sqlite3")
for row in db:nrows("SELECT * FROM configs WHERE config='callfeature'") do
    local features = json.decode(row.items)
    print(string.format("\nparkext =%s\nparkingtime=%s\nparkpos=%s",features.parking.extension,features.parking.timeout,features.parking.space))
    print(string.format("\nfeaturedigittimeout =%s",features.digit_timeout))
    print(string.format("[applicationmap]\n%s=%s,%s,%s,%s",features.app_map.name,features.app_map.digit,features.app_map.channel,features.app_map.application,features.app_map.args))
    print(string.format("\n[featuremap]\nblind=%s\ndisconnect=%s\natxfer=%s\nparkcall=%s",features.feature_map.blind,features.feature_map.hungup,features.feature_map.transfer,features.feature_map.parking))
end