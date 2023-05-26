<form class="form-horizontal"  id="frm_createSplashElement" method="post" roal="form">
<input type="hidden" data-field-value="yes" data-field-name="elemuniqueid" name="elemuniqueid" value=""/>
<input value="Submit" style="display: none;" type="submit"  data-toggle="" data-target="">	
<!-- Model Dialog -->
<div class="modal fade" id="modal_newelem" tabindex="-2" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h4 class="modal-title">
					<span id="modalTitle"></span>Add New Element - <?php echo page_title(); ?></h4>
			</div>
			<div class="modal-body">
				<section class="panel" id="newElement">
					<div class="panel-body">
						<!-- Form start -->
						<div class="form-group">
							<label for="name" class="control-label col-lg-3">Element Name</label>
							<div class="col-lg-8">
								<input class=" form-control" id="elemName" name="name"
									data-field-value="yes" data-field-name="name" minlength="2"
									maxlength="50" required="required" type="text">
							</div>
						</div>
						<div class="form-group">
							<label for="name" class="control-label col-lg-3">Element Text</label>
							<div class="col-lg-8">
								<input class=" form-control" id="elemtext" name="value"
									data-field-value="yes" data-field-name="value" minlength="2"
									maxlength="50" required="required" type="text">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3" for="splashimageid">Type</label>
							<div class="col-lg-8">
								<select required="" id="elemTag" class="form-control"
									data-field-value="yes" data-field-name="tag" name="tag">
									<option value="text">Text</option>
									<option value="image">Image</option>
									<option value="line">Line</option>
									<option value="rect">Rectangle</option>
									<option value="circle">Circle</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3" for="position.x">Position</label>
							<div class="col-xs-4">
								<div class="input-group m-bot15">
									<input required="required" type="number" class="form-control" placeholder="0"  data-field-value="yes" data-field-name="position.x" name="position.x"> <span
										class="input-group-addon">X</span>
								</div>
							</div>
							<span class="col-xs-1 fa fa-times "></span>
							<div class="col-xs-4 ">
								<div class="input-group m-bot15">
									<input required="required" type="number" class="form-control" placeholder="0"  data-field-value="yes" data-field-name="position.y" name="position.y"> <span
										class="input-group-addon">Y</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3" for="size.width">Size</label>
							<div class="col-xs-4">
								<div class="input-group m-bot15">
									<input required="required" type="number" class="form-control" placeholder="Width" data-field-value="yes" data-field-name="size.width" name="size.width"> <span
										class="input-group-addon">px</span>
								</div>
							</div>
							<span class="col-xs-1 fa fa-times "></span>
							<div class="col-xs-4 ">
								<div class="input-group m-bot15">
									<input required="required" type="number" class="form-control" placeholder="Height" data-field-value="yes" data-field-name="size.height" name="size.height"> <span
										class="input-group-addon">px</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3" for="font.fontsize">Font Size / stroke-width</label>
							<div class="col-md-5">
								<div class="input-group m-bot15">
									<input required="required" type="number" class="form-control" data-field-value="yes" data-field-name="font.fontsize" name="font.fontsize"> <span
										class="input-group-addon" >px</span>
								</div>
							</div>

						</div>
						<div class="form-group">
							<label class="control-label col-xs-12 col-md-3 sm-left" for="fontcolor">Color</label>
							<div class="col-xs-6 col-md-5">
								<div data-color-format="rgba" data-color="rgba(154,194,222,1)"
									class="input-append colorpicker-default color">
									<input required="required" readonly="" value="" class="form-control"
										data-field-value="yes" data-type="color"
										data-field-name="fontcolor" type="text"> <span
										class=" input-group-btn add-on">
										<button class="btn btn-white" type="button"
											style="padding: 8px">
											<i style="background-color: rgb(154, 194, 222);"></i>
										</button>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3" for="font.fontweight">Weight</label>
							<div class="col-lg-8">
								<select required="" id="fontweight" class="form-control"
									data-field-value="yes" data-field-name="font.fontweight" name="font.fontweight">
									<option value="normal">Normal</option>
									<option value="bold">Bold</option>
									<option value="bolder">Bolder</option>
									<option value="lighter">Lighter</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3" for="textanchor">Align</label>
							<div class="col-lg-8">
								<select required="" id="textanchor" class="form-control"
									data-field-value="yes" data-field-name="textanchor" name="textanchor">
									<option value="start">Start</option>
									<option value="middle">Middle</option>
									<option value="end">End</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3" for="border">Border (optional)</label>
							<div class="col-lg-8">
								<select required="" id="elemBorder" class="form-control"
									data-field-value="yes" data-field-name="border" name="border">
									<option value="solid">none</option>
									<option value="solid">Solid</option>
									<option value="dotted">Dotted</option>
									<option value="dashed">Dashed</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="xlinkhref" class="control-label col-lg-3">Url (optional)</label>
							<div class="col-lg-8">
								<input class=" form-control" id="xlinkhref" name="xlinkhref"
									data-field-value="yes" data-field-name="xlinkhref" minlength="2"
									  type="url">
							</div>
						</div>
						<div class="form-group">
							<label for="class" class="control-label col-lg-3">Class (optional)</label>
							<div class="col-lg-8">
								<input class=" form-control" id="class" name="class"
									data-field-value="yes" data-field-name="class" minlength="2"
									  type="text">
							</div>
						</div>
						<div class="form-group">
							<label for="style" class="control-label col-lg-3">Style (optional)</label>
							<div class="col-lg-8">
								<textarea id="videoOptinCustomStyles" name="style"	class="form-control"  data-field-value="yes" data-field-name="style" row="10"></textarea>
							</div>
						</div>
						<!-- form ends -->
						<div class="todo-action-bar"></div>
					</div>
				</section>
			</div>
			<div class="modal-footer">
				<h3 style="display:none;">Please wait ...</h3>
				<button class="btn btn-primary" type="button" id="btn_splasheleAdd">Add</button>
				<button data-dismiss="modal" class="btn btn-primary" type="button" id="btn_secancle">Cancle</button>
			</div>
		</div>
	</div>
</div>
<!-- Model Dialog -->
</form>