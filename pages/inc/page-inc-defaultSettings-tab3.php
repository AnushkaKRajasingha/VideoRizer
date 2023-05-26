<div class="position-center">
		<div class="form-group">

			<label class="col-xs-12 col-sm-2 col-lg-2 control-label"
				for="videoOptinHeadline">Button Text</label>

			<div class="col-xs-10 col-sm-8 col-lg-6">
				<input type="text" placeholder="Click Here"  data-field-value="yes" data-field-name="calltoaction.linkbutton.value"
					class="form-control">
			</div>
			<div class="col-xs-2">
				<button title="Button text Headline Help Text"
					data-placement="right" data-toggle="tooltip"
					class="btn tooltips fa fa-question-circle" type="button"></button>
			</div>
		</div>
		<div class="form-group">

			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="videoOptinText">URL</label>

			<div class="col-xs-10 col-sm-8 col-lg-6">
				<input type="url" placeholder="http://www.abc.com"
					 class="form-control"  data-field-value="yes" data-field-name="calltoaction.linkbutton.url">
			</div>
			<div class="col-xs-2">
				<button title="Call to action URL Text Help Text"
					data-placement="right" data-toggle="tooltip"
					class="btn tooltips fa fa-question-circle" type="button"></button>
			</div>
		</div>
		<div class="form-group">
			  <label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="calltoaction.btncolor">Default Button color</label>
			<div class="col-xs-8 col-md-4 col-lg-3">
				<div data-color-format="rgba" data-color="<?php if(isset($_calltoactSet)){echo $_calltoactSet->btncolor;}else{echo 'rgb(155,155,155,1)';} ?>" class="input-append colorpicker-default color">
                                        <input type="text" readonly="" value="" class="form-control" data-type="color" data-field-value="yes" data-field-name="calltoaction.btncolor" name="calltoaction.btncolor" <?php if(isset($_calltoactSet)){echo 'value="'.$_calltoactSet->btncolor.'"';} ?> <?php if(isset($_calltoactSet)){echo 'placeholder="'.$_calltoactSet->btncolor.'"';} ?>>
                                              <span class=" input-group-btn add-on">
                                                  <button class="btn btn-white" type="button" style="padding: 8px">
                                                      <i <?php if(isset($_calltoactSet)){echo 'style="background-color: '.$_calltoactSet->btncolor.';"';} ?>></i>
                                                  </button>
                                              </span>
                                    </div>
			</div>
			<div class="col-xs-2">
				<button title="Default call-to-action button color Help Text" data-placement="right"
					data-toggle="tooltip" class="btn tooltips fa fa-question-circle"
					type="button"></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-lg-2 control-label">Open Link In</label>
			<div class="col-xs-8 col-md-4 col-lg-3">
				<div data-toggle="buttons" class="btn-group">
					<label class="btn btn-default btn-nutral"> <input type="radio"  data-field-value="yes" data-field-name="calltoaction.linkbutton.target" value="_blank" name="linkbutton_target">New Window</label>
					<label class="btn btn-default btn-nutral active"> <input type="radio"  data-field-value="yes" data-field-name="calltoaction.linkbutton.target" value="_self" checked name="linkbutton_target">Self</label>
				</div>
			</div>
			<div class="col-xs-2">
				<button title="Call in action target window Help Text"
					data-placement="right" data-toggle="tooltip"
					class="btn tooltips fa fa-question-circle" type="button"></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" >Automatic	Redirect</label>
			<div class="col-xs-8 col-md-4 col-lg-3">
				<div data-toggle="buttons" class="btn-group">
					<label class="btn btn-default btn-yes"> <input type="radio"	data-field-value="yes" data-field-name="calltoaction.autoredirect" value="1" name="calltoaction_autoredirect">Yes</label>
					<label class="btn btn-default btn-no active"> <input type="radio" data-field-value="yes" data-field-name="calltoaction.autoredirect" checked value="0"  name="calltoaction_autoredirect">No</label>
				</div>
			</div>
			<div class="col-xs-2">
				<button title="Automatic Redirect Help Text" data-placement="right"
					data-toggle="tooltip" class="btn tooltips fa fa-question-circle"
					type="button"></button>
			</div>
		</div>
			<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" for="calltoaction.allowskip">Allow Skipping</label>
			<div class="col-xs-8 col-md-4 col-lg-2">
				<div data-toggle="buttons" class="btn-group">
					<label class="btn btn-default btn-yes <?php if(isset($_calltoactSet) && $_calltoactSet->allowskip == '1'){echo 'active'; }?>"> <input <?php if(isset($_calltoactSet) && $_calltoactSet->allowskip == '1'){echo 'checked'; }?> type="radio"
						 name="calltoaction.allowskip"  data-field-value="yes" data-field-name="calltoaction.allowskip" value="1">Yes
					</label> <label class="btn btn-default btn-no <?php if(isset($_calltoactSet) && $_calltoactSet->allowskip == '0' || !isset($_calltoactSet)){echo 'active'; }?>"> <input <?php if(isset($_calltoactSet) && $_optinSet->allowskip == '0' || !isset($_calltoactSet)){echo 'checked'; }?> type="radio"
						 name="calltoaction.allowskip"  data-field-value="yes" data-field-name="calltoaction.allowskip" value="0">No
					</label>
				</div>
			</div>
			<div class="col-xs-2">
				<button title="Video Allow Skipping Help Text" data-placement="bottom"	data-toggle="tooltip" class="btn tooltips fa fa-question-circle" type="button"></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-2 col-sm-2 control-label" for="calltoaction.skiptext">Skip Text</label>
			<div class="col-xs-10 col-sm-8 col-lg-6">
				<input <?php if(isset($_calltoactSet)){ echo "value='$_calltoactSet->skiptext'";}?> type="text" placeholder="Skip this step" id="calltoaction.skiptext"	class="form-control"  data-field-value="yes" data-field-name="calltoaction.skiptext">
			</div>
			<div class="col-xs-2">
				<button title="Call to action Skip Text Headline Help Text" data-placement="bottom"	data-toggle="tooltip" class="btn tooltips fa fa-question-circle" type="button"></button>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-12 col-sm-2 col-lg-2 control-label" >Location</label>
			<div class="col-xs-10 col-sm-8 col-lg-6">
				<div data-toggle="buttons" class="btn-group">
					<label class="btn btn-default btn-nutral"> <input type="radio"  data-field-value="yes" data-field-name="calltoaction.location" value="start" name="calltoaction_location">Start</label>
					<label class="btn btn-default btn-nutral active"> <input type="radio"  data-field-value="yes" data-field-name="calltoaction.location" value="end" checked name="calltoaction_location">End</label> 
					<label class="btn btn-default btn-nutral"> <input type="radio"  data-field-value="yes" data-field-name="calltoaction.location" value="0.00" name="calltoaction_location">Custom
					<input type="text" placeholder="00" class="custom-time"/> sec
					</label>
				</div>
			</div>
			<div class="col-xs-2">
				<button title="Opt-in Location Help Text" data-placement="right"
					data-toggle="tooltip" class="btn tooltips fa fa-question-circle"
					type="button"></button>
			</div>
		</div>
						<div class="form-group">
			<label class="col-lg-2 col-sm-2 control-label" for="calltoaction.customstyle">Custom Styles</label>
			<div class="col-xs-10 col-sm-8 col-lg-6">
				<textarea id="videoOptinCustomStyles"	class="form-control"  data-field-value="yes" data-field-name="calltoaction.customstyle" row="10"></textarea>
			</div>
			<div class="col-xs-2">
				<button title="Call to action Custom Style Help Text" data-placement="bottom"	data-toggle="tooltip" class="btn tooltips fa fa-question-circle" type="button"></button>
			</div>
		</div>	
</div>
