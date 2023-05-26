<?php
function page_key(){
	global $p_set,$p_data;
	if(array_key_exists('_key', $p_set))
		return $p_set['_key'];
}

function page_title(){
	global $p_set,$p_data;
	return $p_set['Title'];
}

function page_css_class(){
	global $p_set,$p_data;	
	if(array_key_exists('cls', $p_set))return $p_set['cls'];
	return '';	
}

function getPluginShortName(){
	global $p_set,$p_data;
	if (array_key_exists('TextDomain',$p_data )) {
		return $p_data['TextDomain'];
	}
	return '';
}

function setUnderConstruction(){
	?>
	Will be back soon..
		<img src="<?php echo WPCVP_PLUGIN_PGDIR_URL; ?>/images/under-construction.gif" alt="under Construction" />
	<?php
}

function getFileName(){
	global $p_set,$p_data,$f_name;
	return $f_name; 
}