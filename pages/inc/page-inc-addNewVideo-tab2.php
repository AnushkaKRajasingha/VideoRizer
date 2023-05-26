<div class="position-center">
	<div class="form-group">
			<label for="optin.include" class="col-xs-12 col-sm-2 col-lg-2 control-label">Include Opt-in Box</label>
			<div class="col-xs-8 col-md-4 col-lg-3">
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-default btn-yes <?php if(isset($vid) && $_video->optin->include == 'yes'){echo 'active'; }?>"> <input type="radio" <?php if(isset($vid) && $_video->optin->include == 'yes'){echo 'checked';} else if(!isset($vid)){echo 'checked';}?>  data-field-value="yes" data-field-name="optin.include" name="optin.include" value="yes">Yes</label>
					<label class="btn btn-default btn-no <?php if(isset($vid) && $_video->optin->include == 'no'){echo 'active';}?>"> <input <?php if(isset($vid) && $_video->optin->include == 'no'){echo 'checked';}?> type="radio"  id="option3" data-field-value="yes" data-field-name="optin.include" name="optin.include" value="no">No</label>
					<label class="btn btn-default btn-nutral <?php if(isset($vid) && $_video->optin->include == 'default'){echo 'active'; }elseif (!isset($vid)){echo 'active';}?>"> <input <?php if(isset($vid) && $_video->optin->include == 'default'){echo 'checked';}elseif (!isset($vid)){echo 'checked';}?> type="radio"  data-field-value="yes" data-field-name="optin.include" name="optin.include" value="default">Default</label>
				</div>
			</div>
			<div class="col-xs-2">
				<button type="button" class="btn tooltips fa fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Video Opt-in Help Text"></button>
			</div>
		</div>
		<?php 
		$_optinSet = $_defVidSettings->optin;
		if(isset($vid) && $_video->optin->include != 'no'){
			if($_video->optin->include == 'yes') $_optinSet = $_video->optin; 
		}
		?>
		<div class="form-group">

			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="videoOptinHeadline">Headline</label>

			<div class="col-xs-10 col-sm-8 col-lg-6">
				<input <?php if(isset($_optinSet)){ echo "value='$_optinSet->headline'";}?> type="text" placeholder="Opt-in Headline" id="videoOptinHeadline"
					class="form-control" data-field-value="yes" data-field-name="optin.headline">
			</div>
			<div class="col-xs-2">
				<button title="Video opt-in Headline Help Text" data-placement="bottom"
					data-toggle="tooltip" class="btn tooltips fa fa-question-circle"
					type="button"></button>
			</div>
		</div>
		<div class="form-group">

			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="videoOptinText">Text</label>

			<div class="col-xs-10 col-sm-8 col-lg-6">
				<input <?php if(isset($_optinSet)){ echo "value='$_optinSet->text'";}?> type="text" placeholder="Opt-in Text" id="videoOptinText"
					class="form-control" data-field-value="yes" data-field-name="optin.text">
			</div>
			<div class="col-xs-2">
				<button title="Video Opt-in Text Help Text" data-placement="bottom"
					data-toggle="tooltip" class="btn tooltips fa fa-question-circle"
					type="button"></button>
			</div>
		</div>
				<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="optin.location">Location</label>
			<div class="col-xs-10 col-sm-8 col-lg-6">
				<div data-toggle="buttons" class="btn-group">
					<label class="btn btn-default btn-nutral <?php if(isset($_optinSet) && $_optinSet->location == 'start'){echo 'active'; }?>"> <input <?php if(isset($_optinSet) && $_optinSet->location == 'start'){echo 'checked'; }?> type="radio" name="optin.location" data-field-value="yes" data-field-name="optin.location" value="start">Start</label>
					<label class="btn btn-default btn-nutral <?php if(isset($_optinSet) && $_optinSet->location == 'end' || !isset($_optinSet)){echo 'active'; }?>"> <input <?php if(isset($_optinSet) && $_optinSet->location == 'end' || !isset($_optinSet)){echo 'checked'; }?> type="radio" name="optin.location"  data-field-value="yes" data-field-name="optin.location" value="end">End</label>
					<label class="btn btn-default btn-nutral <?php if(isset($_optinSet) && $_optinSet->location != 'start' && $_optinSet->location != 'end' ) {echo 'active'; }?>"> <input <?php if(isset($_optinSet) && $_optinSet->location != 'start' && $_optinSet->location != 'end' ) {echo 'checked'; }?> type="radio" name="optin.location"  data-field-value="yes" data-field-name="optin.location" <?php if(isset($_optinSet) && $_optinSet->location != 'start' && $_optinSet->location != 'end' ) {echo "value='$_optinSet->location'"; }else{echo "value='0.00'";}?>>Custom
					<input type="text" placeholder="00" class="custom-time" <?php if(isset($_optinSet) && $_optinSet->location != 'start' && $_optinSet->location != 'end' ) {echo "value='$_optinSet->location'"; }?>/> sec
					</label>
				</div>
			</div>
			<div class="col-xs-2">
				<button title="Opt-in Location Help Text" data-placement="bottom"
					data-toggle="tooltip" class="btn tooltips fa fa-question-circle"
					type="button"></button>
			</div>
		</div>
				<div class="form-group">

			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="optin.optincode">Opt-in Code</label>

			<div class="col-xs-10 col-sm-8 col-lg-6">
				<!--  <input <?php if(isset($_optinSet)){ echo "value='$_optinSet->url'";}?> type="url" placeholder="http://www.google.com" 
					class="form-control"  data-field-value="yes" data-field-name="optin.url"> -->
				<textarea id="videoOptinOptinCode"	class="form-control"  data-field-value="yes" data-field-name="optin.optincode" row="10"><?php if(isset($_optinSet)){ echo  $_optinSet->optincode;}?></textarea>
			</div>
			<div class="col-xs-2">
				<button title="Opt-in URL Headline Help Text" data-placement="bottom"
					data-toggle="tooltip" class="btn tooltips fa fa-question-circle"
					type="button"></button>
			</div>
		</div>
				<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="optin.upoif">Use Plugin Opt-in Form with the Opt-in Code.</label>
			<div class="col-xs-8 col-md-4 col-lg-2">
				<div data-toggle="buttons" class="btn-group">
					<label class="btn btn-default btn-yes <?php if(isset($_optinSet) && $_optinSet->upoif == '1'){echo 'active'; }?>"> <input <?php if(isset($_optinSet) && $_optinSet->upoif == '1'){echo 'checked'; }?> type="radio"
						 name="optin.upoif"  data-field-value="yes" data-field-name="optin.upoif" value="1">Yes
					</label> <label class="btn btn-default btn-no <?php if(isset($_optinSet) && $_optinSet->upoif == '0' || !isset($_optinSet)){echo 'active'; }?>"> <input <?php if(isset($_optinSet) && $_optinSet->upoif == '0' || !isset($_optinSet)){echo 'checked'; }?> type="radio"
						 name="optin.upoif"  data-field-value="yes" data-field-name="optin.upoif" value="0">No
					</label>
				</div>
			</div>
			<div class="col-xs-2">
				<button title="Use Plugin Opt-in form with the Opt-in code Help Text" data-placement="bottom"	data-toggle="tooltip" class="btn tooltips fa fa-question-circle" type="button"></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="optin.eefonly">Extract Email Field Only</label>
			<div class="col-xs-8 col-md-4 col-lg-2">
				<div data-toggle="buttons" class="btn-group">
					<label class="btn btn-default btn-yes <?php if(isset($_optinSet) && $_optinSet->eefonly == '1'){echo 'active'; }?>"> <input <?php if(isset($_optinSet) && $_optinSet->eefonly == '1'){echo 'checked'; }?> type="radio"
						 name="optin.eefonly"  data-field-value="yes" data-field-name="optin.eefonly" value="1">Yes
					</label> <label class="btn btn-default btn-no <?php if(isset($_optinSet) && $_optinSet->eefonly == '0' || !isset($_optinSet)){echo 'active'; }?>"> <input <?php if(isset($_optinSet) && $_optinSet->eefonly == '0' || !isset($_optinSet)){echo 'checked'; }?> type="radio"
						 name="optin.eefonly"  data-field-value="yes" data-field-name="optin.eefonly" value="0">No
					</label>
				</div>
			</div>
			<div class="col-xs-2">
				<button title="Video Allow Skipping Help Text" data-placement="bottom"	data-toggle="tooltip" class="btn tooltips fa fa-question-circle" type="button"></button>
			</div>
		</div>
		<div class="form-group">
			  <label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="optin.btncolor">Default Button color</label>
			<div class="col-xs-8 col-md-4 col-lg-3">
				<div data-color-format="rgba" data-color="<?php if(isset($_optinSet)){echo $_optinSet->btncolor;}else{echo 'rgb(155,155,155,1)';} ?>" class="input-append colorpicker-default color">
                                        <input type="text" readonly="" class="form-control" data-type="color" data-field-value="yes" data-field-name="optin.btncolor" name="optin.btncolor" <?php if(isset($_optinSet)){echo 'value="'.$_optinSet->btncolor.'"';} ?> <?php if(isset($_optinSet)){echo 'placeholder="'.$_optinSet->btncolor.'"';} ?>>
                                              <span class=" input-group-btn add-on">
                                                  <button class="btn btn-white" type="button" style="padding: 8px">
                                                      <i <?php if(isset($_optinSet)){echo 'style="background-color: '.$_optinSet->btncolor.';"';} ?>></i>
                                                  </button>
                                              </span>
                                    </div>
			</div>
			<div class="col-xs-2">
				<button title="Default Opt-in button color Help Text" data-placement="right"
					data-toggle="tooltip" class="btn tooltips fa fa-question-circle"
					type="button"></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="optin.allowskip">Allow Skipping</label>
			<div class="col-xs-8 col-md-4 col-lg-2">
				<div data-toggle="buttons" class="btn-group">
					<label class="btn btn-default btn-yes <?php if(isset($_optinSet) && $_optinSet->allowskip == '1'){echo 'active'; }?>"> <input <?php if(isset($_optinSet) && $_optinSet->allowskip == '1'){echo 'checked'; }?> type="radio"
						 name="optin.allowskip"  data-field-value="yes" data-field-name="optin.allowskip" value="1">Yes
					</label> <label class="btn btn-default btn-no <?php if(isset($_optinSet) && $_optinSet->allowskip == '0' || !isset($_optinSet)){echo 'active'; }?>"> <input <?php if(isset($_optinSet) && $_optinSet->allowskip == '0' || !isset($_optinSet)){echo 'checked'; }?> type="radio"
						 name="optin.allowskip"  data-field-value="yes" data-field-name="optin.allowskip" value="0">No
					</label>
				</div>
			</div>
			<div class="col-xs-2">
				<button title="Video Allow Skipping Help Text" data-placement="bottom"	data-toggle="tooltip" class="btn tooltips fa fa-question-circle" type="button"></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-2 col-sm-2 control-label" for="optin.skiptext">Skip Text</label>
			<div class="col-xs-10 col-sm-8 col-lg-6">
				<input <?php if(isset($_optinSet)){ echo "value='$_optinSet->skiptext'";}?> type="text" placeholder="Skip this step" id="videoOptinSkiptext"	class="form-control"  data-field-value="yes" data-field-name="optin.skiptext">
			</div>
			<div class="col-xs-2">
				<button title="Opt-in Skip Text Headline Help Text" data-placement="bottom"	data-toggle="tooltip" class="btn tooltips fa fa-question-circle" type="button"></button>
			</div>
		</div>		
		<div class="form-group">
			<label class="col-lg-2 col-sm-2 control-label" for="optin.customstyle">Custom Styles</label>
			<div class="col-xs-10 col-sm-8 col-lg-6">
				<textarea id="videoOptinCustomStyles"	class="form-control"  data-field-value="yes" data-field-name="optin.customstyle" row="10"><?php if(isset($_optinSet)){ echo  $_optinSet->customstyle;}?></textarea>
			</div>
			<div class="col-xs-2">
				<button title="Opt-in Custom Style Help Text" data-placement="bottom"	data-toggle="tooltip" class="btn tooltips fa fa-question-circle" type="button"></button>
			</div>
		</div>
</div>
