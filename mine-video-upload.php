<?php
/*
Plugin Name: Mine Video Player - Upload
Plugin URI: https://www.zwtt8.com/plugins/2020-12-05/mine-video-player-upload/
Description: 本插件需结合Mine Video Player使用，可直接将本地视频上传至网站，并配合主插件实现播放。
Version: 1.0.3
Author: mine27
Author URI: https://www.zwtt8.com/
*/
if(!defined('ABSPATH'))exit;


function mine_video_tinymce_form_upload(){
?><button type="button" class="layui-btn" id="mvupload" style="position: absolute;top: 58px;left: 360px;"><i class="layui-icon"></i>上传视频</button>
<script>
layui.use(['jquery'], function(){
	var $ = layui.jquery;
	var upload_frame;   
	var value_id;
	$('#mvupload').click(function(e){
		event.preventDefault();
		if( upload_frame ){
			upload_frame.open();
			return;
		}
		upload_frame = parent.wp.media({
			title: '上传/选择视频',
			button: {
				text: '完成',
			},
			multiple: false
		});
		upload_frame.on('select',function(){
            var curtabid = $('.layui-this').attr('lay-id');
			attachment = upload_frame.state().get('selection').first().toJSON();
			var aurl = attachment.url;
			if(attachment.mode == 'alivod' || attachment.mode == 'tcvod' ) aurl = attachment.id;
			if($('#mvurl'+curtabid).val()=='')
				$('#mvurl'+curtabid).val($('#mvurl'+curtabid).val()+aurl);
			else
				$('#mvurl'+curtabid).val($('#mvurl'+curtabid).val()+"\n"+aurl);
			});
		upload_frame.open(); 
	});
	});
</script>
<?php
}
add_filter('mine_video_tinymce_form', 'mine_video_tinymce_form_upload', 10, 1);

function mine_video_no_active_notice_upload(){
	include_once(ABSPATH . 'wp-admin/includes/plugin.php' );
	if (!is_plugin_active( 'mine-video/mine-video.php' ) ) {
		echo '<tr class="plugin-update-tr active"><td colspan="3" class="plugin-update colspanchange"><div class="notice-error notice inline notice-warning notice-alt"><p>请先安装并启用主插件 <a href="'.esc_url(admin_url('plugin-install.php')).'?tab=plugin-information&plugin=mine-video&TB_iframe=true&width=772&height=909" class="thickbox open-plugin-details-modal" aria-label="关于Mine Video Player的更多信息" data-title="Mine Video Player">Mine Video Player</a>。</p></div></td></tr>';
	}
}
add_action( "after_plugin_row_mine-video-upload/mine-video-upload.php", 'mine_video_no_active_notice_upload', 10, 2 );


?>