/*
*    “添加”，“编辑”，“取消”，“确认”按钮事件
*    ”添加“，”编辑”，“删除”弹窗
*    评论管理---用户反馈---详情弹窗
*    文本框限制只输入数字
*/

function btnEvent() {
    
    //分类标签管理---”添加“按钮
    $(".jq-add-sort-tag").click( function(){
        var gameCategory = $(".jq-game-category").val();
        var id = $("tr").length;
        var text= $(".add-text").val();
        var btns ='<input type="button" class="button red-button jq-delete" value="删除">';
        var newRow = "<tr>" + 
                                "<td>"+(id++)+"</td>" + 
                                "<td>"+text+"</td>" + 
                                "<td></td>" + 
                                "<td>"+gameCategory+"</td>" + 
                                "<td></td>" + 
                                "<td>"+btns+"</td>" + 
                                "</tr>";
        $(".jq-table").append(newRow);
        $(".jq-red").html($("tr").length-1);
        deleteModal();
    });


    //标签库管理---“添加”按钮
    $(".jq-add-tag").click( function(){
        var id = $("tr").length;
        var text= $(".add-text").val();
        var btns ='<input type="button" class="button jq-edit" value="编辑"> ' + 
                           '<input type="button" class="button red-button jq-delete" value="删除">';
        var newRow = "<tr>" + 
                                "<td>"+(id++)+"</td>" + 
                                "<td>"+text+"</td>" + 
                                "<td></td><td></td><td class='jq-edit1 check-num'></td><td></td><td></td>" + 
                                "<td class='btns'>"+btns+"</td>" + 
                                "</tr>";
        $(".jq-table").append(newRow);
        $(".jq-red").html($("tr").length-1);
        systemEdit();
        deleteModal();
        checkNum();
    });


    //屏蔽词管理---”添加“按钮
    $(".jq-add-shield").click( function() {
        var id = $("tr").length;
        var text= $(".add-text").val();
        var btns ='<input type="button" class="button jq-edit" value="编辑"> ' + 
                           '<input type="button" class="button red-button jq-delete" value="删除">';
        var newRow = "<tr>" + 
                                "<td>"+(id++)+"</td>" + 
                                "<td class='jq-edit1'>"+text+"</td>" + 
                                "<td class='jq-edit2'>***</td>" + 
                                "<td></td><td></td><td></td><td></td>" + 
                                "<td class='btns'>"+btns+"</td>" + 
                                "</tr>";
        $(".jq-table").append(newRow);
        $(".jq-red").html($("tr").length-1);
        systemEdit();
        deleteModal();
    });


    //标签库管理/关键字管理/屏蔽词管理---“编辑”按钮
    systemEdit();
    function systemEdit() {
        var btns ='<input type="button" class="button jq-edit" value="编辑"> ' + 
                           '<input type="button" class="button red-button jq-delete" value="删除">';
        var changeBtns ='<input type="button" class="button green-button jq-confirm" value="确认"> ' + 
                                          '<input type="button" class="button red-button jq-cancel" value="取消">';
        var currentEdit1 = "", currentEdit2="";

        //点击”编辑“按钮事件
        $(".jq-edit").click( function() {
            currentEdit1 = $(this).parent().siblings(".jq-edit1").html(); 
            currentEdit2=  $(this).parent().siblings(".jq-edit2").html();
            $(this).parent().siblings(".jq-edit1").html('<input class="edit-input input1" maxlength="8em" type="text" value="' + currentEdit1 + '">');
            $(this).parent().siblings(".jq-edit2").html('<input class="edit-input input2" maxlength="8em" type="text" value="' + currentEdit2 + '">');
            $(this).parent(".btns").html(changeBtns);

            //点击”确认“按钮事件
            $(".jq-confirm").click( function() {
                $(this).parent().siblings(".jq-edit1").html($(this).parent().siblings(".jq-edit1").find(".input1").val());
                $(this).parent().siblings(".jq-edit2").html($(this).parent().siblings(".jq-edit2").find(".input2").val());
                $(this).parent(".btns").html(btns);
                systemEdit();
                deleteModal();
            });

            //点击”取消“按钮事件
            $(".jq-cancel").click( function() {
                $(this).parent().siblings(".jq-edit1").text(currentEdit1);
                $(this).parent().siblings(".jq-edit2").text(currentEdit2);
                $(this).parent(".btns").html(btns);
                systemEdit();
                deleteModal();
            });
        });
    }


    //游戏评分管理/游戏评论管理---“编辑”按钮
    commentEdit();
    function commentEdit() {
        var btns ='<input type="button" class="button jq-comment-edit" value="编辑">';
        var changeBtns ='<input type="button" class="button green-button jq-confirm" value="确认">';
        var currentEdit1 = "";

        //点击”编辑“按钮事件
        $(".jq-comment-edit").click( function() {
            currentEdit1 = $(this).parent().siblings(".jq-edit1").html(); 
            $(this).parent().siblings(".jq-edit1").html('<input class="edit-input input1" type="text" value="' + currentEdit1 + '">');
            $(this).parent(".btns").html(changeBtns);

            //点击”确认“按钮事件
            $(".jq-confirm").click( function() {
                $(this).parent().siblings(".jq-edit1").html($(this).parent().siblings(".jq-edit1").find(".input1").val());
                $(this).parent(".btns").html(btns);
                commentEdit();
            });
        });
    }


    //供应商管理
    $(function() {

        //供应商管理---“添加”弹出框
        $('.jq-add-supplier-modal').dialog({
            autoOpen: false,
            modal: true,
            minWidth: 420,
            minHeight: 200,
            buttons: {
                确认添加: function() {
                    $(this).dialog("close");
                    var id = $("tr").length;
                    var input28 = $(".input28").val();
                    var input8 = $(".input8").val();
                    var btns ='<input type="button" class="button jq-edit-supplier" value="编辑"> ' + 
                                       '<input type="button" class="button red-button jq-delete" value="删除">';
                    var newRow = "<tr>" + 
                                            "<td>"+(id++)+"</td>" + 
                                            "<td class='jq-input1'>"+input28+"</td>" + 
                                            "<td class='jq-input2'>"+input8+"</td>" + 
                                            "<td></td><td></td>" + 
                                            "<td class='btns'>"+btns+"</td>" + 
                                            "</tr>";
                    $(".jq-table").append(newRow);
                    $(".jq-red").html($("tr").length-1);
                    editSupplier();
                    deleteModal();
                },
                取消: function() {
                    $(this).dialog("close");
                }
            }
        });
        $(".jq-add-supplier").click(function() {
            $(".jq-add-supplier-modal").dialog("open");
        });
    });


    //渠道商管理
    $(function() {

        //渠道商管理---“添加”弹出框
        $('.jq-add-channel-modal').dialog({
            autoOpen: false,
            modal: true,
            minWidth: 420,
            minHeight: 200,
            buttons: {
                确认添加: function() {
                    $(this).dialog("close");
                    var id = $("tr").length;
                    var input28 = $(".input28").val();
                    var input8 = $(".input8").val();
                    var btns ='<input type="button" class="button jq-edit-channel" value="编辑"> ' + 
                                       '<input type="button" class="button red-button jq-delete" value="删除">';
                    var newRow = "<tr>" + 
                                            "<td>"+(id++)+"</td>" + 
                                            "<td class='jq-input1'>"+input28+"</td>" + 
                                            "<td class='jq-input2'>"+input8+"</td>" + 
                                            "<td></td><td></td><td></td>" + 
                                            "<td class='btns'>"+btns+"</td>" + 
                                            "</tr>";
                    $(".jq-table").append(newRow);
                    $(".jq-red").html($("tr").length-1);
                    editChannel();
                    deleteModal();
                },
                取消: function() {
                    $(this).dialog("close");
                }
            }
        });
        $(".jq-add-channel").click(function() {
            $(".jq-add-channel-modal").dialog("open");
        });
    });


    //关键字管理---“添加”弹出框
    $(function() {
        $('.jq-add-keywords-modal').dialog({
            autoOpen: false,
            modal: true,
            minWidth: 420,
            minHeight: 200,
            buttons: {
                确认添加: function() {
                    $(this).dialog("close");
                    var id = $("tr").length;
                    var input28 = $(".input28").val();
                    var btns ='<input type="button" class="button jq-edit" value="编辑"> ' + 
                                       '<input type="button" class="button red-button jq-delete" value="删除">';
                    var newRow = "<tr>" + 
                                            "<td>"+(id++)+"</td>" + 
                                            "<td>"+input28+"</td>" + 
                                            "<td></td><td></td>" + 
                                            "<td class='jq-edit1 check-num'></td>" + 
                                            "<td></td><td></td><td></td>" + 
                                            "<td class='btns'>"+btns+"</td>" + 
                                            "</tr>";
                    $(".jq-table").append(newRow);
                    $(".jq-red").html($("tr").length-1);
                    systemEdit();
                    deleteModal();
                    checkNum();
                },
                取消: function() {
                    $(this).dialog("close");
                }
            }
        });
        $(".jq-add-keywords").click(function() {
            $(".jq-add-keywords-modal").dialog("open");
        });
    });


    // “删除”弹出框
    deleteModal();
    function deleteModal() {
        var delObj;
        $('.jq-deleteModal').dialog({
            autoOpen: false,
            modal: true,
            buttons: {
                确定: function() {
                    $(this).dialog("close");
                    $(".jq-red").html($("tr").length-2);
                    delObj.remove();
                },
                取消: function() {
                    $(this).dialog("close");
                }
            }
        });
        $(".jq-delete").click(function() {
            delObj = $(this).parent().parent();
            $(".jq-deleteModal").dialog("open");
        });
    }

    //评论管理---用户反馈---“详情”弹窗
    detailModal();
    function detailModal() {
        $(".jq-detailModal").dialog( {
            autoOpen: false,
            modal: true,
            minWidth: 700,
            buttons: {
                返回列表: function() {
                    $(this).dialog("close");
                },
                结束反馈单: function() {
                    $(this).dialog("close");
                }
            }
        });
        $(".jq-detial").click(function() {
            $(".jq-detailModal").dialog("open");
        });
    }


    //管理员管理
    $(function() {

        //管理员管理---“添加”弹窗
        $('.jq-add-admin-modal').dialog({
            autoOpen: false,
            modal: true,
            minWidth: 420,
            minHeight: 200,
            buttons: {
                确认添加: function() {
                    $(this).dialog("close");
                },
                放弃添加: function() {
                    $(this).dialog("close");
                }
            }
        });
        $(".jq-add-admin").click(function() {
            $(".jq-add-admin-modal").dialog("open");
        });
    });


    //管理员管理---”编辑“弹窗
    editAdmin();
    function editAdmin() {
        $('.jq-edit-admin-modal').dialog({
            autoOpen: false,
            modal: true,
            minWidth: 420,
            minHeight: 200,
            buttons: {
                确认添加: function() {
                    $(this).dialog("close");
                },
                放弃添加: function() {
                    $(this).dialog("close");
                }
            }
        });
        $(".jq-edit-admin").click(function() {
            $(".jq-edit-admin-modal").dialog("open");
        });
    }


    //只允许输入数字和小数点
    checkNum();
    function checkNum() {
        $(".check-num").keypress(function(event) {
            var keyCode = event.which;
            if (keyCode == 46 || (keyCode >= 48 && keyCode <=57)) {
                return true;
            } else {
                return false;
            }
        }).focus(function() {
            this.style.imeMode='disabled';
        });
    }

}
