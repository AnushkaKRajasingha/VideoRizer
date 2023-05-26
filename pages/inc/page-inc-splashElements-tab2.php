<!--todolist start-->
<section class="panel" id="elemList">	
	<div class="panel-body">
		<div class="form">			
			<div id="paramList">
			<?php if(isset($splash)){
				$splash->__getParmFields();
			}else{
				?><p id="emptyMsg"><code> Please select a splash template.</code></p><?php 
			}?>
			</div>
		</div>
	</div>
</section>
<!--todolist end-->