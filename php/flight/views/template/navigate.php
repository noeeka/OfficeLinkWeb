<!--sidebar start-->
<aside>
    <div id="sidebar"  class="nav-collapse" <?php if($_COOKIE['systec_lang']=="en"){ ?>style="width:200px;"<?php } ?>>
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">                
            <li class="sub-menu">
                <a href="javascript:;">
                    <img src="/img/nav_status_w.png" style="padding-bottom: 3px;"/>
                    <span class="menu-arrow arrow_carrot-right"></span>
                    <span><?php echo $lang[$_COOKIE['systec_lang']]['statusinfo']; ?></span>
                </a>
                <ul class="sub">                          
                    <li><a class="" href="/extensions/status"><?php echo $lang[$_COOKIE['systec_lang']]['extensionststus']; ?></a></li>
                    <li><a class="" href="/providers/status"><?php echo $lang[$_COOKIE['systec_lang']]['providerststus']; ?></a></li>
                    <li><a class="" href="/parking/status"><?php echo $lang[$_COOKIE['systec_lang']]['parkingstatus']; ?></a></li>
                    <li><a class="" href="/meetingrooms/status"><?php echo $lang[$_COOKIE['systec_lang']]['meetingroomststus']; ?></a></li>
                    <li><a class="" href="/system/status"><?php echo $lang[$_COOKIE['systec_lang']]['systemstatus']; ?></a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <img src="/img/nav_PBX_w.png" style="padding-bottom: 3px;"/>
                    <span><?php echo $lang[$_COOKIE['systec_lang']]['pbx']; ?></span>
                    <span class="menu-arrow arrow_carrot-right"></span>
                </a>

                <ul class="sub">                          
                    <li><a class="" href="/extensions/conf"><?php echo $lang[$_COOKIE['systec_lang']]['extensionsetting']; ?></a></li>
                    <li><a class="" href="/providers/conf"><?php echo $lang[$_COOKIE['systec_lang']]['providersetting']; ?></a></li>
                    <li><a class="" href="/outrouter/conf"><?php echo $lang[$_COOKIE['systec_lang']]['outrouter']; ?></a></li>
                    <li><a class="" href="/ivrs/conf"><?php echo $lang[$_COOKIE['systec_lang']]['ivr']; ?></a></li>
                    <!--<li><a class="" href="/dialplans/conf"><?php echo $lang[$_COOKIE['systec_lang']]['dialplansetting']; ?></a></li>
                    <li><a class="" href="/dialrules/conf"><?php echo $lang[$_COOKIE['systec_lang']]['dialrulesetting']; ?></a></li>-->
                    <li><a class="" href="/ringgroups/conf"><?php echo $lang[$_COOKIE['systec_lang']]['ringgroupsetting']; ?></a></li>
                    <li><a class="" href="/meetingrooms/conf"><?php echo $lang[$_COOKIE['systec_lang']]['meetingroomsetting']; ?></a></li>
                    <li><a class="" href="/voicemail/conf"><?php echo $lang[$_COOKIE['systec_lang']]['voicemailsetting']; ?></a></li>
                    <li><a class="" href="/call/feature/conf"><?php echo $lang[$_COOKIE['systec_lang']]['callfeaturesetting']; ?></a></li>
                    <li><a class="" href="/mohs/conf"><?php echo $lang[$_COOKIE['systec_lang']]['mohsetting']; ?></a></li>
                    <li><a class="" href="/sip/conf"><?php echo $lang[$_COOKIE['systec_lang']]['sipsetting']; ?></a></li>
                    <li><a class="" href="/call/records"><?php echo $lang[$_COOKIE['systec_lang']]['callrecordsetting']; ?></a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a href="javascript:;">
                    <img src="/img/nav_setting_w.png" style="padding-bottom: 3px;"/>
                    <span><?php echo $lang[$_COOKIE['systec_lang']]['systemcong']; ?></span>
                    <span class="menu-arrow arrow_carrot-right"></span>
                </a>

                <ul class="sub">                          
                    <li><a class="" href="/language/conf"><?php echo $lang[$_COOKIE['systec_lang']]['lang']; ?></a></li>
                    <li><a class="" href="/network/conf"><?php echo $lang[$_COOKIE['systec_lang']]['networkk']; ?></a></li>
                    <li><a class="" href="/datetime/conf"><?php echo $lang[$_COOKIE['systec_lang']]['datetime']; ?></a></li>
                     <li><a class="" href="/users/conf/"><?php echo $lang[$_COOKIE['systec_lang']]['userconf']; ?></a></li>
                    <!--<li><a class="" href="/system/update"><?php echo $lang[$_COOKIE['systec_lang']]['sysupdate']; ?></a></li>-->
                    <li><a class="" href="/factory/reset"><?php echo $lang[$_COOKIE['systec_lang']]['reset']; ?></a></li>
                    <li><a class="" href="/system/reboot"><?php echo $lang[$_COOKIE['systec_lang']]['reboot']; ?></a></li>
                    <!--<li><a class="" href="/backups/"><?php echo $lang[$_COOKIE['systec_lang']]['backups']; ?></a></li>-->
                    <!--<li><a class="" href="/firewall/conf/"><?php echo $lang[$_COOKIE['systec_lang']]['firewallconf']; ?></a></li>-->
                    <li><a class="" href="/logs/"><?php echo $lang[$_COOKIE['systec_lang']]['logs']; ?></a></li>
                </ul>
            </li>      
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
