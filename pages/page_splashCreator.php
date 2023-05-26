<?php include 'page-option-header.php'; ?>
<section class="wrapper">
<?php //include_once 'inc/plugin-inc-widget-newelem.php';?>
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<header class="panel-heading"> 	
					<h4>
						<?php echo page_title(); ?>
					</h4>
				</header>
				<div class="panel-body" id="dummy_data_table_items_container">
					<form class="form-horizontal" id="frm_createSplash"
								method="post" roal="form">					
					<!-- Left Form -->
					<div class="col-md-5 nopadding">
						<section class="panel">
							<header class="panel-heading tab-bg-dark-navy-blue">
								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#spalshSettins"> <i
											class="fa fa-cogs"></i> Spash Settings
									</a></li>
									<li class=""><a href="#splashElements" data-toggle="tab"> <i
											class="fa  fa-th-list"></i> Splash Elements
									</a></li>
								</ul>
							</header>
							<div class="panel-body nopadding">
								<div class="tab-content">
								<?php 
								if (isset($_REQUEST['uniqueid'])) {
									$splash = new Plugin_splash();
									$splash->uniqueid = $_REQUEST['uniqueid'];
									$splash->__getSplash();
								}								 
								?>
									<div class="tab-pane  active" id="spalshSettins">
                           <?php  include_once 'inc/page-inc-splashSettigns-tab1.php';?>
                        </div>
									<div class="tab-pane" id="splashElements">
                        <?php  include_once 'inc/page-inc-splashElements-tab2.php';?>
                        </div>
								</div>
							</div>
						</section>
					</div>
					<!-- Left form ends -->
					<!-- Right table -->
					<div class="col-md-7">
						<h3 class="testcls">Splash Preview</h3>
						<div class="splash-container text-center">
							<!-- <canvas id="splash" class="splash" width="640" heigth="360" ></canvas>		-->
							<object style="object-fit: contain;" id="splash" class="splash" 
							<?php if (isset($_REQUEST['uniqueid'])) {
							?>
							data="<?php echo admin_url( 'admin-ajax.php' ).'?action='.Plugin_Core::$current_plugin_data['TextDomain'].'_getSvgData&uniqueid='.$_REQUEST['uniqueid'];?>"
							<?php
							}?>
							></object>					
						</div>
						
						<!-- <div class="btn-group  pull-right">
								<a href="#" data-toggle="modal" class="btn btn-primary"
									id="btn_canvasRefresh"> Refresh Preview <i
									class="fa fa-refresh"></i></a>
							</div>  -->
						<div class="clear"></div>
					</div>
					<!-- Right table ends-->
					<!-- Action Button -->
					<div class="col-md-12 clearfix">
						<h3>&nbsp;</h3>
						<div class="row">
							<input
								class="btn btn-primary btn-lg col-md-3 col-xs-12 center-block btn-bottom btnCreateSplash"
								value="<?php if (isset($_REQUEST['uniqueid'])) { echo 'Update';}else{echo 'Save';} ?> Splash" id="btnCreateSplash" type="button" >
						</div>
					</div>
					<!-- Action Button Ends -->	
					<input type="hidden" data-field-value="yes" data-field-name="uniqueid" name="uniqueid" value="<?php if(isset($splash)){echo $splash->uniqueid;}?>"/>	
					<input value="Submit" style="display: none;" type="submit"  data-toggle="" data-target="">			
					</form>					
				</div>
			</section>
		</div>
	</div>
</section>
<?php include 'page-option-footer.php'; ?>