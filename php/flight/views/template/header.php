<header class="header dark-bg">
    <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><img src="/img/more_icon.png"/></div>
    </div>
    <!--logo start-->
    <a href="#" class="logo">Office <span class="lite">Link</span></a>
    <!--logo end-->
    <div class="nav search-row" id="top_menu">
       
    </div>
    <div class="top-nav notification-row">
        <!-- notificatoin dropdown start-->
        <ul class="nav pull-right top-menu">
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle">
                    <span class="profile-ava">
                        <img alt="" src="/img/avatar1_small.png">
                    </span>
                    <span class="username"><script>document.write(getCookie("username"));</script></span>
                </a>
            </li>
            <li style="font-size: 12px; margin-top: 3px; cursor: pointer;">
                <a onclick="logout();"><i class="icon_key_alt"></i><?php echo $lang[$_COOKIE['systec_lang']]['logout']; ?></a>
            </li>
            <!-- user login dropdown end -->
        </ul>
        <!-- notificatoin dropdown end-->
    </div>
</header>