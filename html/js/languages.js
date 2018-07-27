            $(document).ready(function () {
                if (getCookie("systec_lang") == '' || getCookie("systec_lang") == undefined || getCookie("systec_lang") == null) {
                    setCookie("systec_lang", "cn");
                }
                $("#langSelect").change(function () {
                    setCookie("systec_lang", $(this).val());
                    location.reload();
                });
                $("#langSelect").val(getCookie("systec_lang"));
            });

            function setCookie(name, value) {
                //  $.get("/common/setCookie/"+value, function(result){ });
                 document.cookie = name + "=" + escape(value)+";path=/";
            }

            function getCookie(c_name) {
                if (document.cookie.length > 0) {
                    c_start = document.cookie.indexOf(c_name + "=")
                    if (c_start != -1) {
                        c_start = c_start + c_name.length + 1
                        c_end = document.cookie.indexOf(";", c_start)
                        if (c_end == -1)
                            c_end = document.cookie.length
                        return unescape(document.cookie.substring(c_start, c_end))
                    }
                }
                return ""
            }