check_cookie();

function getByteLen(val) {
    var len = 0;
    for (var i = 0; i < val.length; i++) {
        var length = val.charCodeAt(i);
        if (length >= 0 && length <= 128) {
            len += 1;
        }
        else {
            len += 2;
        }
    }
    return len;
}

function initializeJS() {
    //for html
    //jQuery("html").niceScroll({styler: "fb", cursorcolor: "#007AFF", cursorwidth: '6', cursorborderradius: '10px', background: '#F7F7F7', cursorborder: '', zindex: '1000'});
    //for sidebar
    jQuery("#sidebar").niceScroll({styler: "fb", cursorcolor: "#007AFF", cursorwidth: '3', cursorborderradius: '10px', background: '#F7F7F7', cursorborder: ''});
    // for scroll panel
   // jQuery(".scroll-panel").niceScroll({styler: "fb", cursorcolor: "#007AFF", cursorwidth: '3', cursorborderradius: '10px', background: '#F7F7F7', cursorborder: ''});

    //sidebar dropdown menu
    jQuery('#sidebar .sub-menu > a').click(function () {
        var last = jQuery('.sub-menu.open', jQuery('#sidebar'));
        jQuery('.menu-arrow').removeClass('arrow_carrot-right');
        jQuery('.sub', last).slideUp(200);
        var sub = jQuery(this).next();
        if (sub.is(":visible")) {
            jQuery('.menu-arrow').addClass('arrow_carrot-right');
            sub.slideUp(200);
        } else {
            jQuery('.menu-arrow').addClass('arrow_carrot-down');
            sub.slideDown(200);
        }
        var o = (jQuery(this).offset());
        diff = 200 - o.top;
        /*
        if (diff > 0)
            jQuery("#sidebar").scrollTo("-=" + Math.abs(diff), 500);
        else
            jQuery("#sidebar").scrollTo("+=" + Math.abs(diff), 500);
            */
    });

    // sidebar menu toggle
    jQuery(function () {
        function responsiveView() {
            var wSize = jQuery(window).width();
            if (wSize <= 768) {
                jQuery('#container').addClass('sidebar-close');
                jQuery('#sidebar > ul').hide();
            }

            if (wSize > 768) {
                jQuery('#container').removeClass('sidebar-close');
                jQuery('#sidebar > ul').show();
            }
        }
        jQuery(window).on('load', responsiveView);
        jQuery(window).on('resize', responsiveView);


    });

    jQuery('.toggle-nav').click(function () {
        if (jQuery('#sidebar > ul').is(":visible") === true) {
            jQuery('#main-content').css({
                'margin-left': '0px'
            });
            jQuery('#sidebar').css({
                'margin-left': '-180px'
            });
            jQuery('#sidebar').hide();
            jQuery('#sidebar > ul').hide();
            jQuery("#container").addClass("sidebar-closed");
        } else {
            jQuery('#main-content').css({
                'margin-left': '220px'
            });
            jQuery('#sidebar').show();
            jQuery('#sidebar > ul').show();
            jQuery('#sidebar').css({
                'margin-left': '0'
            });
            jQuery("#container").removeClass("sidebar-closed");
        }
    });

    //bar chart
    if (jQuery(".custom-custom-bar-chart")) {
        jQuery(".bar").each(function () {
            var i = jQuery(this).find(".value").html();
            jQuery(this).find(".value").html("");
            jQuery(this).find(".value").animate({
                height: i
            }, 2000)
        })
    }

}

jQuery(document).ready(function () {
    initializeJS();
});

$("li > a").each(function () {
    if (window.location.href.indexOf($(this).attr("href")) > 0) {
        $(this).parent().addClass('active');
        $(this).parent().parent().show();
    }
});
function logout() {
    $.post("/api/user/logout/", {}, function (result) {
        if (result.state == 0) {
            //window.location.reload();//刷新当前页面.
            location.href = "/login";//location.href实现客户端页面的跳转  
        }
    }, "json");

}

function check_cookie() {
    $.get("/api/extensions/1/20", function (result) {
        if(result.state==2){
             logout();
        }
    }, "json");
}
//通用分页方法
function getPagiation(total,obj){
    if(total>20){
        pagination_left = '<li><a href="#1" onclick="ajaxPagination(1)">&laquo;</a></li>';
        pagination = '';
        var pageIndex = parseInt(window.location.href.split("#").pop());
        pageIndex = pageIndex?pageIndex:1;
        pageFirst = pageIndex-4;
        console.log('pageIndex', pageIndex);
        var pageCount = 0;
        for (i = pageIndex-4; i <= Math.ceil(total / 20); i++) {
            if(i <= 0) {
                continue;
            }
            if(pageFirst <= 0) {
                pageFirst = i;
            }
            if(pageCount >= 9) {
                break;
            }
            if (pageIndex == i) {
                pagination += '<li class="active"><a href="#' + i + '" onclick="ajaxPagination(' + i + ')">' + i + '</a></li>';
            } else {
                pagination += '<li><a href="#' + i + '" onclick="ajaxPagination(' + i + ')">' + i + '</a></li>';
            }
            ++pageCount;
        }
        for(i = pageFirst-1; i > 0;--i) {
            if(pageCount >= 9) {
                break;
            }
            pagination = '<li><a href="#' + i + '" onclick="ajaxPagination(' + i + ')">' + i + '</a></li>' + pagination;
            ++pageCount;
        }
        pagination += '<li><a href="#' + Math.ceil(total / 20) + '" onclick="ajaxPagination(' + Math.ceil(total / 20) + ')">&raquo;</a></li>';
        pagination = pagination_left + pagination;
        obj.html(pagination);
    }
}

//统一验证
//验证不能为空
function is_not_null(obj,msg){
    if(obj.val() == "" || obj.val()==null){
        obj.css("border-color", "red");
        obj.focus();
        obj.attr("placeholder", msg);
        return false;
    }else {
        obj.removeAttr("style");
    }
}
//验证长度超过范围
function is_validate_length(obj,msg,leng){
    var len = 0;
    for (var i = 0; i < obj.val().length; i++) {
        var length = obj.val().charCodeAt(i);
        if (length >= 0 && length <= 128) {
            len += 1;
        }
        else {
            len += 2;
        }
    }


    if(len > leng){
        obj.css("border-color", "red");
        obj.focus();
        obj.attr("placeholder", msg);
        return false;
    }else {
        obj.removeAttr("style");
    }
}

//验证不能为中文
function is_validate_charactor(obj,msg){
    if(/.*[\u4e00-\u9fa5]+.*$/.test(obj.val())){
        obj.css("border-color", "red");
        obj.focus();
        obj.attr("placeholder", msg);
        return false;
    }else {
        obj.removeAttr("style");
    }
}

//验证只能是数字
function is_validate_number(obj,msg){
    if(/[^\d]/.test(obj.val())){
        obj.css("border-color", "red");
        obj.focus();
        obj.attr("placeholder", msg);
        return false;
    }else {
        obj.removeAttr("style");
    }
}

//验证重复
function is_repeat_val(obj,url,field,msg){
    var flag=true;
    var stringJson ='{"'+ field +'": "'+obj.val()+'"}';
    var json = JSON.parse(stringJson);
    $.ajax({
        type:"post",
        url: url,
        data: json,
        async: false,
        success: function (result) {
            if (result.state == 0) {
                flag = false;
            }
        },
        dataType: "json"
    });
    if(flag==false){
        obj.css("border-color", "red");
        obj.focus();
        obj.attr("placeholder",msg);
        return false;
    } else {
        obj.removeAttr("style");
    }
}

function is_repeat_val_by_condiftion(obj1,obj2,url,field1,field2,msg){
    var flag=true;
    var stringJson ='{"'+ field1 +'": "'+obj1.val()+'","'+field2 +'": "'+obj2.val()+'"}';
    var json = JSON.parse(stringJson);
    $.ajax({
        type:"post",
        url: url,
        data: json,
        async: false,
        success: function (result) {
            if (result.state == 0) {
                flag = false;
            }
        },
        dataType: "json"
    });
    if(flag==false){
        obj2.css("border-color", "red");
        obj2.focus();
        obj2.attr("placeholder",msg);
        return false;
    } else {
        obj2.removeAttr("style");
    }
}

//验证分机号是否在指定范围
function is_in_range(obj,field,msg){
    var flag = true;
    $.ajax({
        type:"get",url: "/api/sip/conf",async: false, success: function (result) {
            if(field=="user_exten"){
                user_exten = result.user_exten;
            }else if(field=="conference_exten"){
                user_exten = result.conference_exten;
            }else if(field=="ivr_exten"){
                user_exten = result.ivr_exten;
            }else if(field=="ringgroup_exten"){
                user_exten = result.ringgroup_exten;
            }
            if (parseInt(obj.val()) > parseInt(user_exten[1]) || parseInt(obj.val()) < parseInt(user_exten[0])) {
                flag = false;
            }
        }, dataType: "json"
    });
    if (!flag) {
        obj.css("border-color", "red");
        obj.focus();
        obj.attr("placeholder",msg);
        return false;
    } else {
        obj.removeAttr("style");
    }



}





