<?php include 'page-option-header.php'; ?>
<section class="wrapper">
<form id="from_defVideoSettings" method="post" role="form" class="form-horizontal">
	<div class="row">
		<div class="col-md-12">			
			<section class="panel">
				<header class="panel-heading tab-bg-dark-navy-blue">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#home-2"> <i
								class="fa fa-play-circle"></i> Video
						</a></li>
						<li class=""><a href="#about-2" data-toggle="tab"> <i
								class="fa fa-list-alt"></i> Opt-in
						</a></li>
						<li class=""><a href="#contact-2" data-toggle="tab"> <i
								class="fa fa-bolt"></i> Call to Action
						</a></li>
						<li class=""><a href="#playersettings" data-toggle="tab"> <i
								class="fa fa-gears"></i> Player options
						</a></li>
					</ul>
				</header>
				<div class="panel-body">
					<div class="tab-content">
						<div class="tab-pane  active" id="home-2">
                           <?php  include_once 'inc/page-inc-defaultSettings-tab1.php';?>
                        </div>
						<div class="tab-pane" id="about-2">
                        <?php  include_once 'inc/page-inc-defaultSettings-tab2.php';?>
                        </div>
						<div class="tab-pane " id="contact-2">
                        <?php  include_once 'inc/page-inc-defaultSettings-tab3.php';?>
                        </div>
						<div class="tab-pane" id="playersettings">
                        <?php  include_once 'inc/page-inc-defaultSettings-tab4.php';?>
                        </div>
					</div>
				</div>
				<div class="panel-heading tab-bg-dark-navy-blue">
					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10 btn-container">
							<div class="col-xs-12 col-sm-4 col-lg-3">
								<button type="button" class="btn btn-success col-xs-12"
									id="btn_save_defsettings">Save Settings</button>
							</div>
						</div>
						<div class="clear"></div>
					</div>

				</div>
			</section>
			<input type="submit" value="" style="display: none;">
			</form>
		</div>
	</div>
	</form>
</section>
<?php include 'page-option-footer.php'; ?>