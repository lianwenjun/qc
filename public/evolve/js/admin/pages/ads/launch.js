$(function(){

    // 分类页图片管理-编辑
    $('.jq-launchEdit').click(function(){
        var name = $(this).closest('tr').find('span').text();
        $('.jq-launchName').val(name);
        $('.jq-launchForm').attr('action', $(this).data('url'));
        $('.jq-launchModal').dialog('open');
    });

/*    $(".jq-launchForm button").plupload({
        runtimes : 'html5',
        url : 'aaa',
        chunk_size: '500kb',
        dragdrop: true,
        filters : {
            max_file_size : '50mb',
            mime_types: [
                {title : "jpg/png图片", extensions : "jpg,png"}
            ]
        },
        flash_swf_url : '/evolve-ui/js/plugins/plupload/Moxie.swf',
        init : {
            FileUploaded: function(up, file, response) {
                response
            }
        }
    });*/

});