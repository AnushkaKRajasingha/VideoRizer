<?php
//var_dump($vid);
if(isset($vid)){
	if(!isset($_video)){
	$_video = new Plugin_video();
	$_video->uniqueid = $vid;
	$_video->__getVideo();
	}
	if(!isset($_defVidSettings)){
	$_defVidSettings = new Plugin_videoBase();
	$_defVidSettings->__getDefSettings();
	}

	//var_dump($_video);

?>
<div class="cvplayer video-widget">
<style type="text/css">
<!--
		<?php $_skin = Plugin_videoSkins::_getSkinImageByID($_video->playerOptions->skinid); ?>
		div.cvplayer.videoContainer{
			width:<?php echo $_video->size->width;?>px !important;
			background: url("<?php echo $_skin['url']; ?>") no-repeat scroll center center / 100% 100% rgba(0, 0, 0, 0);
			padding:<?php echo $_skin['Paddings'];?>;
		}
		#vp_modal_addNewVideo div.modal-dialog{
			width:<?php echo $_video->size->width + 40;?>px !important;
		}

		div.cvplayer.videoContainer{
		/*padding:1vw;*/
		}

-->
</style>
<h2 class="video-title"><?php echo $_video->title;?></h2>
<div class="cvplayer videoContainer" id="vidCtrl_<?php echo $vid;?>">
<?php if($_video->optin->include != 'no'){

		if($_video->optin->include == 'yes')
			$_optinSet = $_video->optin;
		else
			$_optinSet = $_defVidSettings->optin;
	?>
	<style type="text/css">
		div#vidOptin_<?php echo $vid;?>{
			width:<?php echo $_video->size->width;?>px;
			height:<?php echo $_video->size->height;?>px;
		}
		div#vidOptin_<?php echo $vid;?> input.optin-submit{
			background-color: <?php echo $_defVidSettings->playerOptions->buttonColor; ?>
		}
		div#vidOptin_<?php echo $vid;?> input.optin-submit:hover{
			background-color: <?php echo $_defVidSettings->playerOptions->hoverColor; ?>
		}
		<?php echo $_optinSet->customstyle;?>
	</style>
	<script type="text/javascript">
		(function($){
			function optinClose_<?php echo $vid;?>(){
				$("div#vidOptin_<?php echo $vid;?>").hide(); $('div#vidOptin_<?php echo $vid;?>').attr('data-skip','1');
			}
			$('document').ready(function(){
				$('a#optin_st_<?php echo $vid;?>').click(function(){ optinClose_<?php echo $vid;?>();  videojs_<?php echo $vid;?>.play();});
				});
		})(jQuery);
	</script>
	<div class="vid-optin-ctrl optin-ctrl-default" id="vidOptin_<?php echo $vid;?>" data-skip="0" >
		<h2><?php echo $_optinSet->headline;?></h2>
		<p><?php echo $_optinSet->text; ?></p>
		<div class="optin-container">
		<?php echo $_optinSet->optincode; ?>
		</div>
		<?php if($_optinSet->allowskip == '1'){?>
			<div class="element-container"><a href="#" class="skip-text" id="optin_st_<?php echo $vid;?>" ><?php echo $_optinSet->skiptext;?></a></div>
		<?php } ?>
	</div>
<?php }

if($_video->calltoaction->include != 'no'){
	if($_video->calltoaction->include == 'yes')
		$_calltoactSet = $_video->calltoaction;
	else
		$_calltoactSet = $_defVidSettings->calltoaction;
	?>
		<script type="text/javascript">
		(function($){
		function calltoactRedirect_<?php echo $vid;?>(){
			<?php
			if($_calltoactSet->linkbutton->target == '_blank'){
				?>
					window.open("<?php echo $_calltoactSet->linkbutton->url;?>");
					$("div#vidCalltoact_<?php echo $vid;?>").hide();
					videojs_<?php echo $vid;?>.play();
				<?php
			}
			else{
				?>
				window.location = "<?php echo $_calltoactSet->linkbutton->url;?>";
				<?php
			}
			?>
		}
			$('document').ready(function(){
				$('input#btn_calltoaction_<?php echo $vid;?>').click(function(){
					calltoactRedirect_<?php echo $vid;?>();
					});
				});


		})(jQuery);
		</script>
		<style type="text/css">
		<!--
		div#vidCalltoact_<?php echo $vid;?>{
			width:<?php echo $_video->size->width;?>px;
			height:<?php echo $_video->size->height;?>px;
		}

		input#btn_calltoaction_<?php echo $vid;?>{
			background-color:<?php echo $_defVidSettings->playerOptions->calltoactColor;?> !important;
		}

		<?php echo $_calltoactSet->customstyle;?>
		-->
		</style>
		<div class="vid-calltoact-ctrl calltoact-ctrl-default" id="vidCalltoact_<?php echo $vid;?>"  data-skip="0" >
			<div class="element-container"><input type="button" value="<?php echo $_calltoactSet->linkbutton->value;?>" class="calltoact-button" id="btn_calltoaction_<?php echo $vid;?>" /></div>
		</div>
	<?php
}
$controls = $_video->showtimeline == '1' ? 'true' : 'false';
$muted = $_video->enablehd == '1' ? 'true' : 'false';
$autoplay = $_video->autoplay == '1' ? is_admin() ? 'false' : 'true' : 'false';
?>
<video id='vid_<?php echo $vid;?>' class='video-js vjs-default-skin' preload='none' width='<?php echo $_video->size->width;?>' height='<?php echo $_video->size->height;?>'></video>
</div>
<p id="modalText"><?php echo $_video->description;?></p>
<script type="text/javascript">
<!--
(function($){

	$('document').ready(function(){
		videojs_<?php echo $vid;?>  = videojs('vid_<?php echo $vid;?>', {
	    	   'techOrder': ['youtube', 'html5'],
	    	    'src':'<?php echo $_video->youtubeurl;?>',
	    	    'controls': <?php echo $controls; ?>, 'autoplay': <?php echo $autoplay;?> ,'muted' : <?php echo $muted;?>
	    	  });

		videojs_<?php echo $vid;?>.on('firstplay', function() {
			<?php if(isset($_optinSet) && $_optinSet->location == 'start'){ ?>

			videojs_<?php echo $vid;?>.pause(); $('div#vidOptin_<?php echo $vid;?>').show();

			<?php }

			 if(isset($_calltoactSet) && $_calltoactSet->location == 'start'){ ?>
			 videojs_<?php echo $vid;?>.pause();
			 $('div#vidCalltoact_<?php echo $vid;?>').show();
			 <?php if($_calltoactSet->autoredirect == '1'){?>
			 $('input#btn_calltoaction_<?php echo $vid;?>').trigger('click');
			 <?php } } ?>
		});

		videojs_<?php echo $vid;?>.on('ended', function() {
			<?php if(isset($_optinSet) && $_optinSet->location == 'end') {?>
			videojs_<?php echo $vid;?>.pause(); $('div#vidOptin_<?php echo $vid;?>').show();
			<?php }
			if(isset($_calltoactSet) && $_calltoactSet->location == 'end') {?>
			videojs_<?php echo $vid;?>.pause(); $('div#vidCalltoact_<?php echo $vid;?>').show();
			 <?php if($_calltoactSet->autoredirect == '1'){?>
			 $('input#btn_calltoaction_<?php echo $vid;?>').trigger('click');
			 <?php } } ?>
			});

		videojs_<?php echo $vid;?>.on('timeupdate', function() {
			<?php if(isset($_optinSet) && $_optinSet->location != 'start' && $_optinSet->location != 'end'){ ?>
			if( $('div#vidOptin_<?php echo $vid;?>').attr('data-skip') == '0' && videojs_<?php echo $vid;?>.currentTime() > <?php echo $_optinSet->location;?> ){
				videojs_<?php echo $vid;?>.pause();
				$('div#vidOptin_<?php echo $vid;?>').show();
			}
			<?php }
			 if(isset($_calltoactSet) && $_calltoactSet->location != 'start' && $_calltoactSet->location != 'end'){ ?>
			 if( $('div#vidCalltoact_<?php echo $vid;?>').attr('data-skip') == '0' && videojs_<?php echo $vid;?>.currentTime() > <?php echo $_calltoactSet->location;?> ){
				 videojs_<?php echo $vid;?>.pause();
				 $('div#vidCalltoact_<?php echo $vid;?>').show();
				 $('div#vidCalltoact_<?php echo $vid;?>').attr('data-skip','1')
				 <?php if($_calltoactSet->autoredirect == '1'){?>
				 $('input#btn_calltoaction_<?php echo $vid;?>').trigger('click');
				 <?php } ?>

			}
			<?php } ?>
		});

		<?php if(!empty($_defVidSettings->playerOptions->playButtonText)){ ?>
				$('div#vidCtrl_<?php echo $vid;?> div.vjs-big-play-button span').html('<?php echo $_defVidSettings->playerOptions->playButtonText;?>');
				$('div#vidCtrl_<?php echo $vid;?> div.vjs-big-play-button').addClass('withText');
				$('div#vidCtrl_<?php echo $vid;?> div.vjs-big-play-button').removeClass('emptyText');
		<?php } else { ?>
				$('div#vidCtrl_<?php echo $vid;?> div.vjs-big-play-button').removeClass('withText');
				$('div#vidCtrl_<?php echo $vid;?> div.vjs-big-play-button').addClass('emptyText');
		<?php } ?>

		$('#vp_modal_addNewVideo').attr('data-autoplay',<?php echo $autoplay; ?>);

		<?php if($_video->splashimageid != 'none'){?>
			var $splashObject = $('<object/>').attr({
				'style' : 'object-fit: contain;',
				'id' : 'splash_'+ '<?php echo $_video->splashimageid; ?>',
				'class' : 'splash',
				'data' : '<?php echo admin_url( 'admin-ajax.php' ).'?action='.Plugin_Core::$current_plugin_data['TextDomain'].'_getSvgData&uniqueid='.$_video->splashimageid;?>'
				});
			$('div#vidCtrl_<?php echo $vid;?> div.vjs-poster').append($splashObject);
		<?php } ?>

		});
})(jQuery);
//-->
</script>
</div>
<?php
}
?>
