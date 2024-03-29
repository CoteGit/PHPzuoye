<!DOCTYPE html>
<html>
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
        <title>jQuery+PHP+MySQL发表评论</title>
        <meta name="keywords" content="发表评论" />
        <meta name="description" content="使用PHP，MySQL和jQuery创建一个简单的留言板。您可以留言。" />
        <style type="text/css">
            #comments{
                margin:10px auto;
            }
            #post{
                margin-top:10px;
            }
            #comments p,
            #post p{
                line-height:30px;
            }
            #comments p span{
                margin:4px;
                color:#bdb8b8;
            }
            #message{
                position: absolute;
                top: 40%;
                left: 100px;
                width: 200px;
                height: 50px;
                background: #f2f2f2;
                border: 1px solid;
                border-radius: 3px;
                line-height: 50px;
                text-align: center;
                display: none;
            }
        </style>
    </head>
    <body>
        <div>
            <div>
                <div id="post">
                    <h3>文章评论</h3>
                    <p>昵称：</p>
                    <p><input type="text" class="input" id="user" /></p>
                    <p>评论内容：</p>
                    <p><textarea class="input" id="txt" style="width:100%; height:80px"></textarea></p>
                    <p><input type="submit" class='btn'value="发表" id="add" /></p>
                    <div id="message"></div>
                </div>
                <div id="comments"></div>
            </div>
        </div>
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript">
            $(function() {
                var comments = $("#comments");
                $.getJSON("data.php", function(json) {
                    $.each(json, function(index, array) {
                        var txt = "<p><strong>" + array["user"] + "</strong>：" + array["comment"] + "<span>" + array["addtime"] + "</span></p>";
                        comments.append(txt);
                    });
                });
                //将评论的内容展出
                $("#add").click(function() {
                    var user = $("#user").val();
                    var txt = $("#txt").val();
                    $.ajax({
                        type: "POST",
                        url: "comment.php",
                        data: "user=" + user + "&txt=" + txt,
                        dataType : 'JSON',
                        success: function(res) {
                            if (res.code == 1) {
                                var str = "<p><strong>" + res.user + "</strong>：" + res.txt + "<span>刚刚</span></p>";
                                comments.append(str);
                                $("#message").show().html("发表成功！").fadeOut(1000);
                                $("#txt").attr("value", "");
                            } else {
                                $("#message").show().html(res.message).fadeOut(1000);
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>

