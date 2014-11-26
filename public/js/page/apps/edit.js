
$(function(){

    // 输入框标签
    $('.jq-tag').select2({
        tags: ["卡牌", "战争", "回合"],
        maximumInputLength: 10,
        tokenSeparators: [",", " "]
    });
    $('.jq-key').select2({
        tags: ["我叫MT online"],
        maximumInputLength: 10,
        tokenSeparators: [",", " "]
    });


    //富文本编辑
    var editor, mobileToolbar, toolbar;
    toolbar = ['title', 'bold', 'italic', 'underline', 'strikethrough', 'color', '|', 'ol', 'ul', 'blockquote', 'code', 'table', '|', 'link', 'image', 'hr', '|', 'indent', 'outdent'];
    var editor = new Simditor({
      textarea: $('.jq-richtext'),
      placeholder: '这里输入文字...',
      toolbar: toolbar,
      pasteImage: true,
      defaultImage: 'assets/images/image.png',
      upload: location.search === '?upload' ? {
        url: '/upload'
      } : false
    });


    //拖动排序
    $( ".jq-sortable" ).sortable();
    $( ".jq-sortable" ).disableSelection();


    //删除截图预览中的图片
    $('.jq-delete').click(function() {
        $(this).parent('li').remove();
    });


    // 验证
    $('.jq-form').validate({
        ignore: '',
        rules: {
            gamesort: "required",
            gametag: "required",
            author: "required",
            version: "required",
            bagname: "required",
            sort: "required",
            download_manual: "required",
            summary: "required"
        },
        messages: {
            gamesort: {required: '分类为必填!'},
            gametag: {required: '标签为必填!'},
            author: {required: '游戏作者为必填!'},
            version: {required: '游戏版本为必填!'},
            bagname: {required: '包名为必填!'},
            sort: {required: '排序为必填!'},
            download_manual: {required: '下载次数为必填!'},
            summary: {required: '简介为必填!'}
        },
        errorPlacement: function(error, element) { 
          error.appendTo(element.closest('td').append()); 
        },
        errorElement: "em",
        onkeyup: false,
        submitHandler:function(form) {  
            form.submit();
        }
    });

});
