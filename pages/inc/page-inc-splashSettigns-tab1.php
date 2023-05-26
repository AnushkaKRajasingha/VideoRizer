<div class="form">
					<div class="form-group">
									<label for="splashName" class="control-label col-lg-4">Splash Name</label>
									<div class="col-lg-8">
										<input class=" form-control" id="name" name="splashName" placeholder="Enter the splash Name "
											data-field-value="yes" data-field-name="splashName" minlength="2"
											maxlength="50" required="" type="text" value="<?php if(isset($splash)){echo $splash->splashName;} ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="splashTemlateId" class="control-label col-lg-4">Splash Template</label>
									<div class="col-lg-8">
										<select required="" id="splashTemplateId" class="form-control" data-field-value="yes" data-field-name="splashTemplateId"  name="splashTemplateId">											
					<option value="000">None</option>
								<?php $splashTemplates = new Plugin_splashTemplates();
									$templates = $splashTemplates->_getSplashTemplates();
									foreach ($templates as $key => $_template) {
										?>
										<option data-image="<?php echo $_template['url'];?>" value="<?php echo $_template['ID'];?>" <?php if(isset($splash) && ($_template['ID'] == $splash->splashTemplateId)){echo 'selected';} ?> ><?php echo $_template['Name'];?></option>
										<?php 
									}
								?>
					</select>
									</div>
								</div>							
</div>