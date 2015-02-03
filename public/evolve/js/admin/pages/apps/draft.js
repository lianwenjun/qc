$(function(){


    // 上传游戏apk
    $('.jq-uploadApk').click(function(){
        $('.jq-uploadModal').dialog("open");
    });

    $('.jq-uploadModal').dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        width: 550,
        height: 330
    });

    var apkUploader = $(".jq-uploadModal").pluploadQueue({
        runtimes : 'html5',
        url : 'aaa',
        chunk_size: '1mb',
        dragdrop: true,
        filters : {
            max_file_size : '2048mb',
            mime_types: [
                {title : "apk文件", extensions : "apk"}
            ]
        },
        flash_swf_url : '/evolve-ui/js/plugins/plupload/Moxie.swf',
        init : {
            FileUploaded: function(up, file, response) {

            }
        }
    });

});