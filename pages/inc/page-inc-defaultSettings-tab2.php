<div class="position-center">
	<!-- <form role="form" class="form-horizontal">  -->
<div class="form-group">

			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="videoOptinHeadline">Headline</label>

			<div class="col-xs-10 col-sm-8 col-lg-6">
				<input type="text" placeholder="Opt-in Headline" id="videoOptinHeadline"
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
				<input type="text" placeholder="Opt-in Text" id="videoOptinText"
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
					<label class="btn btn-default btn-nutral"> <input type="radio" name="optin.location" data-field-value="yes" data-field-name="optin.location" value="start">Start</label>
					<label class="btn btn-default btn-nutral active"> <input type="radio" name="optin.location" checked  data-field-value="yes" data-field-name="optin.location" value="end">End</label>
					<label class="btn btn-default btn-nutral"> <input type="radio" name="optin.location"  data-field-value="yes" data-field-name="optin.location" value="0.00">Custom
					<input type="text" placeholder="00" class="custom-time"/> sec
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

			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="optin.url">Opt-in Code</label>

			<div class="col-xs-10 col-sm-8 col-lg-6">
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
					<label class="btn btn-default btn-yes"> <input type="radio"
						 name="optin.allowskip"  data-field-value="yes" data-field-name="optin.allowskip" value="1">Yes
					</label> <label class="btn btn-default btn-no active"> <input type="radio"
						 name="optin.allowskip" checked  data-field-value="yes" data-field-name="optin.allowskip" value="0">No
					</label>
				</div>
			</div>
			<div class="col-xs-2">
				<button title="Video Allow Skipping Help Text" data-placement="bottom"
					data-toggle="tooltip" class="btn tooltips fa fa-question-circle"
					type="button"></button>
			</div>
		</div>
		<div class="form-group">

			<label class="col-lg-2 col-sm-2 control-label" for="optin.skiptext">Skip Text</label>

			<div class="col-xs-10 col-sm-8 col-lg-6">
				<input type="text" placeholder="Skip this step" id="videoOptinSkiptext"
					class="form-control"  data-field-value="yes" data-field-name="optin.skiptext">
			</div>
			<div class="col-xs-2">
				<button title="Opt-in Skip Text Headline Help Text" data-placement="bottom"
					data-toggle="tooltip" class="btn tooltips fa fa-question-circle"
					type="button"></button>
			</div>
		</div>
				<div class="form-group">
			<label class="col-lg-2 col-sm-2 control-label" for="optin.customstyle">Custom Styles</label>
			<div class="col-xs-10 col-sm-8 col-lg-6">
				<textarea id="videoOptinCustomStyles"	class="form-control"  data-field-value="yes" data-field-name="optin.customstyle" row="10"></textarea>
			</div>
			<div class="col-xs-2">
				<button title="Opt-in Custom Style Help Text" data-placement="bottom"	data-toggle="tooltip" class="btn tooltips fa fa-question-circle" type="button"></button>
			</div>
		</div>
<!-- 	</form>  -->
</div>
