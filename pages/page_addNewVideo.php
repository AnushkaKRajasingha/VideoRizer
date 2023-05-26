<?php include 'page-option-header.php'; ?>
<?php 
$_defVidSettings = new Plugin_videoBase();
if($_defVidSettings->__getDefSettings()){

if(isset($_REQUEST['uniqueid'])){ $vid = $_REQUEST['uniqueid']; } 
//var_dump($vid);
if(isset($vid)){
	$_video = new Plugin_video();
	$_video->uniqueid = $vid;
	$_video->__getVideo();
	//var_dump($_video);
}

include 'inc/plugin-inc-video-preview.php'; ?>
<section class="wrapper">
	<form id="from_addNewVideo" method="post" role="form"
		class="form-horizontal">
		<input type="hidden" data-field-value="yes" data-field-name="uniqueid" name="uniqueid" value="<?php if(isset($vid))echo $vid;?>"/>
		<div class="row">
			<div class="col-md-12">
				<section class="panel">
					<header class="panel-heading tab-bg-dark-navy-blue">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#home-2"> <i class="fa fa-play-circle"></i> Video</a></li>
							<li class=""><a href="#about-2" data-toggle="tab"> <i class="fa fa-list-alt"></i> Opt-in</a></li>
							<li class=""><a href="#contact-2" data-toggle="tab"> <i	class="fa fa-bolt"></i> Call to Action</a></li>
						</ul>
					</header>
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane  active" id="home-2">
                           <?php  include_once 'inc/page-inc-addNewVideo-tab1.php';?>
                        </div>
							<div class="tab-pane" id="about-2">
                        <?php  include_once 'inc/page-inc-addNewVideo-tab2.php';?>
                        </div>
							<div class="tab-pane " id="contact-2">
                        <?php  include_once 'inc/page-inc-addNewVideo-tab3.php';?>
                        </div>
						</div>
					</div>
					<div class="panel-heading tab-bg-dark-navy-blue">
						<div class="form-group">
							<div class="col-lg-offset-2 col-lg-10 btn-container">
								<div class="col-xs-12 col-sm-4 col-lg-3">
									<button type="button" class="btn btn-success col-xs-12" id="btn_addNewVideo" ><?php if(isset($vid)){echo 'Update';}else echo 'Save New';?> Video</button>
								</div>
								<div class="col-xs-12 col-sm-4 col-lg-3">
									<?php $_date = new DateTime();?>
									<button data-toggle="modal" data-remote="<?php if(isset($vid)){ echo admin_url( 'admin-ajax.php' ).'?action='.Plugin_Core::$current_plugin_data['TextDomain'].'_getideoPreviewDialog&uniqueid='.$vid.'&timestamp='.$_date->getTimestamp();} ?>" data-target="#vp_modal<?php echo page_key();?>" type="button" class="btn btn-primary col-xs-12" id="btn_previewVideo" <?php if(!isset($vid)){echo 'disabled="disabled"';} ?>>Preview Video</button>
								</div>
								<div class="col-xs-12 col-sm-4 col-lg-3">
									<button type="button" class="btn btn-info col-xs-12" id="btn_backToVideo">Back to Videos</button>
								</div>

							</div>
							<div class="clear"></div>
						</div>
					</div>
				</section>

			</div>
		</div>
		<input type="submit" value="" style="display: none;">
	</form>
</section>
<?php include 'page-option-footer.php'; ?>
<?php } else {echo "<div class='cvplayer-error'>You must setup the default options first.</error>"; } ?>