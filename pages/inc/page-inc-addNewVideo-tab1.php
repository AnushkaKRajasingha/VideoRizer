<div class="position-center">	
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="title">Video Title</label>
			<div class="col-xs-10 col-sm-8 col-lg-6">
				<input value="<?php if(isset($vid)){echo $_video->title;}?>" type="text" required="required" placeholder="My Video 001" id="title" class="form-control" data-field-value="yes" data-field-name="title" name="title">
			</div>
			<div class="col-xs-2">
				<button title="Video Title Help Text" data-placement="bottom" data-toggle="tooltip" class="btn tooltips fa fa-question-circle"	type="button"></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="description">Video Description</label>
			<div class="col-xs-10 col-sm-8 col-lg-6">
				<input value="<?php if(isset($vid)){echo $_video->description;}?>" type="text" required="required" placeholder="My First Video"	id="description" class="form-control" data-field-value="yes" data-field-name="description"  name="description">
			</div>
			<div class="col-xs-2">
				<button title="Video Description Help Text" data-placement="bottom" data-toggle="tooltip" class="btn tooltips fa fa-question-circle" type="button"></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="youtubeurl">YouTube URL</label>
			<div class="col-xs-10 col-sm-8 col-lg-6">
				<input value="<?php if(isset($vid)){echo $_video->youtubeurl;}?>" type="url" required="required" placeholder="http://www.youtube.com/watch?v=asduyuiasd" id="videoURL" class="form-control" data-field-value="yes" data-field-name="youtubeurl"  name="youtubeurl">
			</div>
			<div class="col-xs-2">
				<button title="Video URL Help Text" data-placement="bottom" data-toggle="tooltip" class="btn tooltips fa fa-question-circle" type="button"></button>
			</div>
		</div>
		 <div class="form-group">
			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="splashimageid">Splash Image</label>
			<div class="col-xs-10 col-sm-8 col-lg-6">
			
				<select required="" id="splashimageid" class="form-control imageDropDown" data-field-value="yes" data-field-name="splashimageid"  name="splashimageid">											
					<option value="none">None</option>
					<?php 
					$_splash = new Plugin_splash();
					$allasplash = $_splash->__getAllsplash();
					
					foreach ($allasplash as $splash) {
						?>
						<option data-image="<?php echo admin_url( 'admin-ajax.php' ).'?action='.Plugin_Core::$current_plugin_data['TextDomain'].'_getSvgForImage&uniqueid='.$splash->uniqueid; ?>" value="<?php echo $splash->uniqueid; ?>"
						<?php if(isset($vid) && $_video->splashimageid == $splash->uniqueid){
							echo 'selected="selected"';
						}?>
						><?php echo $splash->splashName; ?></option>
						<?php
					}
					?>
				</select>
			</div>
			<div class="col-xs-2">
				<button title="Video splash Help Text" data-placement="bottom" data-toggle="tooltip" class="btn tooltips fa fa-question-circle" type="button"></button>
			</div>
		</div> 
		 <div class="form-group">
			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="playerOptionsskinid">Video Skin</label>
			<div class="col-xs-10 col-sm-8 col-lg-6">
			
				<select required="" id="playerOptionsskinid" class="form-control" data-field-value="yes" data-field-name="playerOptions.skinid"  name="playerOptions.skinid">											
					<option value="none">None</option>
					<?php 
					$_skins = new Plugin_videoSkins();
					$all_skins = $_skins->_getVideoSkins();					
					//var_dump($all_skins);
					foreach ($all_skins as $skin) {
						?>
						<option data-image="<?php echo $skin['url']; ?>" value="<?php echo $skin['ID']; ?>"
						<?php if(isset($vid) && $_video->playerOptions->skinid == $skin['ID']){
							echo 'selected="selected"';
						}?>
						><?php echo $skin['Name']; ?></option>
						<?php
					}
					?>
				</select>
			</div>
			<div class="col-xs-2">
				<button title="Video Skins Help Text" data-placement="bottom" data-toggle="tooltip" class="btn tooltips fa fa-question-circle" type="button"></button>
			</div>
		</div> 
		<div class="form-group">
			<label for="videoSize"
				class="col-xs-12 col-sm-2 col-lg-2 control-label">Video Size</label>
			<div class="col-xs-3">
				<div class="input-group m-bot15">
					<input value="<?php if(isset($vid)){echo $_video->size->width;}else if(isset($_defVidSettings)){echo $_defVidSettings->size->width;}?>" type="text" class="form-control" placeholder="width" data-field-value="yes" data-field-name="size.width"> <span
						class="input-group-addon">px</span>
				</div>
			</div>
			<span class="col-xs-1 fa fa-times "></span>
			<div class="col-xs-3 ">
				<div class="input-group m-bot15">
					<input value="<?php if(isset($vid)){echo $_video->size->height;}else if(isset($_defVidSettings)){echo $_defVidSettings->size->height;}?>" type="text" class="form-control" placeholder="height" data-field-value="yes" data-field-name="size.height"> <span
						class="input-group-addon">px</span>
				</div>
			</div>
			<div class="col-xs-1">
				<button type="button" class="btn tooltips fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Video Size Help Text"></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-lg-2 control-label"
				for="autoplay">Autoplay</label>
			<div class="col-xs-6 col-md-4 col-lg-2">
				<div data-toggle="buttons" class="btn-group">
					<label class="btn btn-default btn-yes <?php if(isset($vid) && $_video->autoplay == 1){echo 'active';}else if(!isset($vid) && isset($_defVidSettings) &&  $_defVidSettings->autoplay == 1){echo 'active';}?>"> <input <?php if(isset($vid) && $_video->autoplay == 1){echo 'checked';}else if(!isset($vid) &&  isset($_defVidSettings) &&  $_defVidSettings->autoplay == 1){echo 'checked';}?> type="radio" name="autoplay" data-field-value="yes" data-field-name="autoplay" value="1">Yes</label> 
					<label class="btn btn-default btn-no <?php if(isset($vid) && $_video->autoplay == 0){echo 'active';}else if(!isset($vid) &&  isset($_defVidSettings) &&  $_defVidSettings->autoplay == 0){echo 'active';}?>"> <input <?php if(isset($vid) && $_video->autoplay == 0){echo 'checked';}else if(!isset($vid) && isset($_defVidSettings) &&  $_defVidSettings->autoplay == 0){echo 'checked';} ?> type="radio" name="autoplay" data-field-value="yes" data-field-name="autoplay" value="0">No</label>
				</div>
			</div>
			<div class="col-xs-2">
				<button title="Video Autoplay Help Text" data-placement="bottom"
					data-toggle="tooltip" class="btn tooltips fa fa-question-circle"
					type="button"></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-lg-2 control-label"
				for="videoURL">Show Timeline</label>
			<div class="col-xs-6 col-md-4 col-lg-2">
				<div data-toggle="buttons" class="btn-group">
					<label class="btn btn-default btn-yes <?php if(isset($vid) && $_video->showtimeline == 1){echo 'active';}else if(!isset($vid) &&  isset($_defVidSettings) &&  $_defVidSettings->showtimeline == 1){echo 'active';}?>"> <input <?php if(isset($vid) && $_video->showtimeline == 1){echo 'checked';}else if(!isset($vid) &&  isset($_defVidSettings) &&  $_defVidSettings->showtimeline == 1){echo 'checked';}?> type="radio" name="showtimeline"  data-field-value="yes" data-field-name="showtimeline" value="1">Yes</label>
					<label class="btn btn-default btn-no <?php if(isset($vid) && $_video->showtimeline == 0){echo 'active';} else if(!isset($vid) &&  isset($_defVidSettings) &&  $_defVidSettings->showtimeline == 0){echo 'active';} ?>"> <input <?php if(isset($vid) && $_video->showtimeline == 0){echo 'checked';} else if(!isset($vid) &&  isset($_defVidSettings) &&  $_defVidSettings->showtimeline == 1){echo 'checked';}?> type="radio" name="showtimeline" data-field-value="yes" data-field-name="showtimeline" value="0">No</label>
				</div>
			</div>
			<div class="col-xs-2">
				<button title="Video Show Timeline Help Text"
					data-placement="bottom" data-toggle="tooltip"
					class="btn tooltips fa fa-question-circle" type="button"></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-lg-2 control-label"
				for="videoURL">Mute Audio</label>
			<div class="col-xs-6 col-md-4 col-lg-2">
				<div data-toggle="buttons" class="btn-group">
					<label class="btn btn-default btn-yes <?php if(isset($vid) && $_video->enablehd == 1){echo 'active';}else if(!isset($vid) &&  isset($_defVidSettings) &&  $_defVidSettings->enablehd == 1){echo 'active';}?>" > <input <?php if(isset($vid) && $_video->enablehd == 1){echo 'checked';}else if(!isset($vid) &&  isset($_defVidSettings) &&  $_defVidSettings->enablehd == 1){echo 'checked';}?> type="radio" name="enablehd" data-field-value="yes" data-field-name="enablehd" value="1">Yes</label>
					<label class="btn btn-default btn-no <?php if(isset($vid) && $_video->enablehd == 0){echo 'active';} else if(!isset($vid) &&  isset($_defVidSettings) &&  $_defVidSettings->enablehd == 0){echo 'active';} ?>"> <input <?php if(isset($vid) && $_video->enablehd == 0){echo 'checked';}else if(!isset($vid) &&  isset($_defVidSettings) &&  $_defVidSettings->showtimeline == 0){echo 'checked';} ?> type="radio" name="enablehd" data-field-value="yes" data-field-name="enablehd" value="0">No</label>
				</div>
			</div>
			<div class="col-xs-2">
				<button title="Video Audio Mute Help Text" data-placement="bottom"
					data-toggle="tooltip" class="btn tooltips fa fa-question-circle"
					type="button"></button>
			</div>
		</div>
	
</div>
