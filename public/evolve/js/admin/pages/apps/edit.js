
$(function() {
    
    // 修改（弹窗）
    $('.jq-dialog').dialog({
        autoOpen: false,
        modal: true,
        width: "60%",
        buttons: {
            确认: function() {
                $(this).dialog("close");

                // 确认游戏分类
                var hideSort = ",";
                var sort = "";
                $(".jq-sortClick").each(function(){
                    if (this.checked == true) {
                        hideSort += this.value + ",";
                        sort += $(this).parent().text() + "，";
                    } else {
                        
                    }
                    $(".jq-initCate").html(sort.substring(0, sort.length-1));
                    $(".jq-gameCate").val(hideSort);
                });

                // 确认游戏标签
                var hideTag = ",";
                var tag = "";
                $(".jq-tagClick").each(function(){
                    if (this.checked == true) {
                        hideTag += this.value + ",";
                        tag += '<li class="gametag fl"><i>'+ this.value + '</i><span class="jq-deleteTag">×</span></li>';
                    }
                    $(".jq-initTag").html(tag);
                    $(".jq-gameTag").val(hideTag);
                    deleteMethod();
                });
            },
            取消: function() {
                $(this).dialog("close");
            }
        }
    });

    // 修改（弹窗） -- 默认勾选的游戏分类/标签
    $(".jq-editSort").click(function() {
        $(".jq-dialog").dialog("open");
        var selectSort = $(".jq-gameCate").val();
        var selectTag = $(".jq-gameTag").val();

        // 默认游戏分类
        $(".jq-sortClick").each(function(){
            if (-1 != selectSort.indexOf("," + this.value + ",")) {
                this.checked = true;
                $(".jq-dialog").find('#sort_' + this.value).show();
            }
        });

        // 默认游戏标签
        $(".jq-tagClick").each(function(){
            if (-1 != selectTag.indexOf("," + this.value + ",")) {
                this.checked = true;
            }
        });
    });

    // 修改（弹窗） -- 游戏分类选择
    $(".jq-sortClick").click(function() {
        if(this.checked == true) {
            $(".jq-dialog").find('#sort_' + this.value).show();
        } else {
            $(".jq-dialog").find('#sort_' + this.value).hide();
            $('#sort_' + this.value).find(".jq-tagClick").each(function(){
                this.checked = false;
            });
        }
    });

    // 修改（弹窗） -- 删除游戏标签
    deleteMethod();
    function deleteMethod() {
        $(".jq-deleteTag").click( function() {
            var hideTag = ",";
            $(this).parent().fadeOut('500', function(){
                $(this).remove();
                if ($(".gametag").size() >= 1) {
                    $(".gametag").each(function(){
                        hideTag += $(this).find("i").text() + ",";
                        $(".jq-gameTag").val(hideTag);
                    });
                }else{
                    $(".jq-gameTag").val("");
                }
                var gametagVal = $(this).find("i").text();
                $(".jq-tagClick").each(function(){
                    if (gametagVal == $(this).val()) {
                        this.checked = false;
                    }
                });
            });
        });
    }


/*    // 游戏关键字（select2）
    $('.jq-keyword').select2({
        tags: ["我叫MT online"],
        maximumInputLength: 10,
        tokenSeparators: [",", " "],
    });*/


    // 富文本编辑
    var editor = new Simditor({
      textarea: $('.jq-intro, .jq-features'),
      toolbar: ['title', 'bold', 'italic', 'underline', 'strikethrough', 'color', '|', 'ol', 'ul', 'blockquote', 'code', 'table', '|', 'link', 'image', 'hr', '|', 'indent', 'outdent'],
      pasteImage: true,
      defaultImage: 'images/image.png',
      upload: location.search === '?upload' ? {
        url: '/upload'
      }: false
    });

    var summary = $('.jq-summary').prev().find('.simditor-body').html();
    if (summary == '<p></br></p>'){
        $('.jq-summary').val('');
    } else {
        $('.jq-summary').val(summary);
    }



    // 截图预览图片拖动排序
    $(".jq-sortable").sortable({
        items: 'li'
    });


    // 删除截图预览
    $(".jq-picDelete").on('click', function() {
        $(this).parent().fadeOut('500', function(){ $(this).remove(); });
    });
    

    
    // 截图预览图片上传
    var imgList = '<li class="pic-preview">' +
                        '<img src="${img}" class="icon110x185" />' +
                        '<input type="button" value="删除" class="button red-button jq-picDelete" />' +
                        '<input type="hidden" name="images[]" value="${img}" />' +
                    '</li>';
    $.template('imgTemplate', imgList);

    var picUpload = new plupload.Uploader({
        runtimes: 'html5',
        browse_button : 'picUpload',
        chunk_size: '200kb',
        url : '/evolve-ui/js/pages/others/signin.json',
        filters : {
            max_file_size : '10mb',
            mime_types: [
                {title : "Image files", extensions : "jpg,gif,png"}
            ]
        }
    });

    picUpload.init(); //初始化

    picUpload.bind('FilesAdded',function(uploader, files){
        picUpload.start(); 
    });

    picUpload.bind('FileUploaded',function(uploader, files, object){
        $.tmpl('imgTemplate', object.response).appendTo(".jq-sortable");
    });
    $(".jq-uploadIcon").click(function() {
        $.ajax({
            type: "GET", // 此处应用POST
            url: "/js/pages/apps/edit.json",
            dataType: "json",
            success: function (data) {
                if ( data.success == "true" ) {
                    $(".upload-icon").attr("src", data.data.img)
                } else {
                    alert(data.msg);
                }
            },
            error: function() {
                alert("加载数据错误！");
            }
        });
    });


    // 截图预览图片张数必须在1-6之间
    jQuery.validator.addMethod("minImages", function(value, element) {
        return $('input[name="images[]"]').length > 0;
    }, "图片必须上传！");

    jQuery.validator.addMethod("maxImages", function(value, element) {
        return $('input[name="images[]"]').length < 7;
    }, "图片必须少于6张！");

    // 游戏分类验证
    jQuery.validator.addMethod("checkCate", function(value, element) {
        var val = $(".jq-gameCate").val();
        if (val == "," || val == "") {
            return false;
        } else {
            return true;
        }
    }, "游戏分类为必填！");

    // 游戏标签验证
    jQuery.validator.addMethod("checkTag", function(value, element) {
        var val = $(".jq-gameTag").val();
        if (val == "," || val == "") {
            return false;
        } else {
            return true;
        }
    }, "游戏标签为必填！");

    // 游戏介绍验证
    jQuery.validator.addMethod("simditor", function(value, element) {
        summary = editor.getValue();
        if (summary == "") {
            return false;
        } else {
            return true;
        }
    }, "游戏介绍为必填！");


    // 表单验证
    $(".jq-editForm").validate({
        ignore: "",
        rules: {
            keyword: 'required',
            checkCate: 'required',
            checkTag: 'required',
            author: 'required',
            supplier: "required",
            "os_version": 'required',
            summary: {
                required: true,
                simditor: true
            },
            "images[]":{ 
                minImages: true,
                maxImages: true    
            }
        },
        messages: {
            keyword: { required: '游戏关键字为必填！' },
            checkCate: { required: '游戏分类为必填！' },
            checkTag: { required: '游戏标签为必填！' },
            author: { required: '游戏作者为必填！' },
            supplier: { required: '供应商为必选！' },
            "os_version": { required: '系统要求为必选！' },
            summary: {
                required: '游戏介绍为必填！',
                simditor: '游戏介绍为必填！'
            }
        },
        errorPlacement: function(error, element) { 
            error.appendTo(element.closest('td')); 
        },
        errorElement: "em",
        onkeyup: false,
        submitHandler: function(form) {  
            form.submit();
        }
    });


});