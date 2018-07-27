<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang[$_COOKIE['systec_lang']]['callrecord']; ?></title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/widgets.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/style-responsive.css" rel="stylesheet"/>

    <link rel="stylesheet" href="/css/jquery.fileupload.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/>
    <script src="/js/jquery.js"></script>
    <script src="/js/jquery-1.8.3.min.js"></script>
    <script src="/js/languages.js"></script>
</head>
<body>
<section id="container" class="">
    <?php include 'header.php'; ?>
    <?php include 'navigate.php'; ?>
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><?php echo $lang[$_COOKIE['systec_lang']]['pbx']; ?></li>
                        <li><?php echo $lang[$_COOKIE['systec_lang']]['callrecord']; ?></li>
                    </ol>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>
                        <?php echo $lang[$_COOKIE['systec_lang']]['id']; ?>
                    </th>
                    <th>
                        <?php echo $lang[$_COOKIE['systec_lang']]['call_time']; ?>
                    </th>
                    <th>
                        <?php echo $lang[$_COOKIE['systec_lang']]['call_duration']; ?>
                    </th>
                    <th>
                        <?php echo $lang[$_COOKIE['systec_lang']]['callerid']; ?>
                    </th>
                    <th>
                        <?php echo $lang[$_COOKIE['systec_lang']]['calledid']; ?>
                    </th>
                    <th>
                        <?php echo $lang[$_COOKIE['systec_lang']]['action']; ?>
                    </th>

                    <th style='display:none;'>
                        <?php echo $lang[$_COOKIE['systec_lang']]['operation']; ?>
                    </th>
                </tr>
                </thead>
                <tbody id="dtRecord">
                </tbody>
            </table>
            <nav>
                <ul class="pagination">
                </ul>
            </nav>
        </section>
    </section>
    <!--main content end-->
</section>
</body>
</html>

<!-- nice scroll -->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.scrollTo.min.js"></script>
<script src="/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="/js/scripts.js"></script>
<script>
    $(function () {
        ajaxPagination(1);
    });

    function ajaxPagination(page) {
        $.get("/api/call/records/" + page + "/20", function (result) {
            var str = "";
            var pagination = "";
            var hour, minute, second, duration;
            $.each(result.records, function (k, n) {
                hour = parseInt(n.call_duration/3600);
                minute = parseInt(n.call_duration/60);
                second = n.call_duration%60;
                second = "0" + second.toString();
                second = second.substr(second.length-2);
                duration = second;
                //if(minute > 0 || hour > 0) {
                    minute = "0" + minute.toString();
                    minute = minute.substr(minute.length-2);
                    duration = minute + ":" + duration;
                //}
                if(hour > 0) {
                    hour = "0" + hour.toString();
                    hour = hour.substr(hour.length-2);
                    duration = hour + ":" + duration;
                }
                
                str += "<tr>";
                if(n.action=="NO ANSWER"){
                    var action="<?php echo $lang[$_COOKIE['systec_lang']]['noanswer']; ?>";
                }else if(n.action=="ANSWERED"){
                    var action="<?php echo $lang[$_COOKIE['systec_lang']]['answer']; ?>";
                }else if(n.action=="FAILED"){
                    var action="<?php echo $lang[$_COOKIE['systec_lang']]['failed']; ?>";
                }else{
                    var action="<?php echo $lang[$_COOKIE['systec_lang']]['busy']; ?>";
                }
                str += "<td>" + n.id + "</td><td>" + n.call_time + "</td><td>" + duration + "</td><td>" + n.callerid + "</td><td>" + n.calledid + "</td><td>" + action + "</td><td style='display:none;'><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#del_com' onclick='delete_callrecords(\"" + n.id + "\")'><?php echo $lang[$_COOKIE['systec_lang']]['delete']; ?></button></td>";
                str += "</tr>";
            });

            $("#dtRecord").html(str);
            //page分割数量
            /*var pageFor = 20;
            var pageSlipt = pageFor / 2;
            var pagination="";
            if (Math.ceil(result.total_count / 20) > pageFor) {
                if (page > pageFor) {
                    pagination = '<li><a href="#" onclick="ajaxPagination(1)">&laquo;</a></li>';
                }
                if (page > (pageFor / 2)) {
                    if (page >= (Math.ceil(result.total_count / 20) - pageSlipt)) {
                        var countPage = (((page - pageSlipt) + pageFor) - pageSlipt + 1);
                    }else{
                        var countPage = ((page - pageSlipt) + pageFor);
                    }
                    for (i=(page - pageSlipt); i<countPage;i++) {
                        if (i == page) {
                            pagination += '<li class="active"><a href="#' + i + '" onclick="ajaxPagination(' + i + ')">' + i + '</a></li>';
                        }else{
                            pagination += '<li><a href="#' + i + '" onclick="ajaxPagination(' + i + ')">' + i + '</a></li>';
                        }
                    }
                }else{
                    for (i=1;i<pageFor;i++) {
                        if (i == page) {
                            pagination += '<li class="active"><a href="#' + i + '" onclick="ajaxPagination(' + i + ')">' + i + '</a></li>';
                        }else{
                            pagination += '<li><a href="#' + i + '" onclick="ajaxPagination(' + i + ')">' + i + '</a></li>';
                        }
                    }
                }
                if ((page + pageFor) < (Math.ceil(result.total_count / 20))) {
                    pagination += '<li><a href="#" onclick="ajaxPagination(' + Math.ceil(result.total_count / 20) + ')">&raquo;</a></li>';
                }
                $(".pagination").html(pagination);
            }else{
                pagination = '<li><a href="#1" onclick="ajaxPagination(1)">&laquo;</a></li>';
                for (i = 1; i <= Math.ceil(result.total_count / 20); i++) {
                    if (window.location.href.split("#").pop() == i) {
                        pagination += '<li class="active"><a href="#' + i + '" onclick="ajaxPagination(' + i + ')">' + i + '</a></li>';
                    } else {
                        pagination += '<li><a href="#' + i + '" onclick="ajaxPagination(' + i + ')">' + i + '</a></li>';
                    }
                }
                pagination += '<li><a href="#' + Math.ceil(result.total_count / 20) + '" onclick="ajaxPagination(' + Math.ceil(result.total_count / 20) + ')">&raquo;</a></li>';
                //$(".pagination").html(pagination);
            }*/
            getPagiation(result.total_count,$(".pagination"));
        }, "json");
    }
</script>

<script type="text/javascript">
    pageShow(1,5800);
    function pageShow(ThisPage,PageCount) {
//ThisPage = 当前页
//PageCount = 总条数
//获取当前页之后，可通过Ajax进行返值。
        $(function() {
//每页条数
            var pageText = 13;
//分页总数
            var pageNumber = Math.ceil(PageCount / pageText);
//page分割数量
            var pageFor = 10;
            var pageSlipt = pageFor / 2;
            var pageHTML = new Array;
            if (pageNumber > pageFor) {
                if (ThisPage > pageFor) {
                    pageHTML += "<a href=\"javascript:pageShow(1,'"+PageCount+"');\">第一页(1)</a>";
                }
                if (ThisPage > (pageFor / 2)) {
                    if (ThisPage >= (pageNumber - pageSlipt)) {
                        countPage = (((ThisPage - pageSlipt) + pageFor) - pageSlipt + 1);
                    }else{
                        countPage = ((ThisPage - pageSlipt) + pageFor);
                    }
                    for (i=(ThisPage - pageSlipt);i<countPage;i++) {
                        if (i == ThisPage) {
                            pageHTML += "<a href=\"javascript:pageShow("+i+",'"+PageCount+"');\" class=\"this\">" +i+ "</a>";
                        }else{
                            pageHTML += "<a href=\"javascript:pageShow("+i+",'"+PageCount+"');\">" +i+ "</a>";
                        }
                    }
                }else{
                    for (i=1;i<pageFor;i++) {
                        if (i == ThisPage) {
                            pageHTML += "<a href=\"javascript:pageShow("+i+",'"+PageCount+"');\" class=\"this\">" +i+ "</a>";
                        }else{
                            pageHTML += "<a href=\"javascript:pageShow("+i+",'"+PageCount+"');\">" +i+ "</a>";
                        }
                    }
                }
                if ((ThisPage + pageFor) < pageNumber) {
                    pageHTML += "<a href=\"javascript:pageShow("+pageNumber+",'"+PageCount+"');\">最后一页("+pageNumber+")</a>";
                }
                $(".pages").html(pageHTML);
            }
        });
    }
</script>

<!--添加删除服务-->
<div class="modal fade bs-example-modal-sm" id="del_com" tabindex="-1" role="dialog" aria-labelledby="del_comLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4>确定删除吗</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_del();">取消</button>
                <button type="button" class="btn btn-danger" id="confirm_del_btn" filed="" onclick="confirm_del();">删除
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function delete_callrecords(uid) {
        $("#del_com").addClass("in");
        $("#del_com").show();
        $("#confirm_del_btn").attr("filed", uid);
    }

    function cancel_del() {
        $("#del_com").hide();
    }
    function confirm_del() {
        $.post("/api/call/records/delete", {id: $("#confirm_del_btn").attr("filed")}, function (result) {
            if (result.state == 0) {
                $.get("/api/conf/reload", function (result) {
                }, "json");
                $("#del_com").hide();
                $(".modal-backdrop.in").hide();
                var trList = $("#dtRecord").children("tr");
                for (var i = 0; i < trList.length; i++) {
                    var tdArr = trList.eq(i).find("td");
                    for (var j = 0; j < tdArr.length; j++) {
                        if (tdArr[j].innerHTML == $("#confirm_del_btn").attr("filed")) {
                            trList.eq(i).remove();
                        }
                    }
                }
            }
        }, "json");
    }
</script>
