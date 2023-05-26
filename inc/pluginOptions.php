<?php
if (!defined('WPCVP')) {
	define('WPCVP', 'WPCVP');
}
require_once 'classes/plugin-init_var.php';
$plugin_var = new init_var();
$plugin_var->_initVar();
require_once WPCVP_CLS_DIR.'/plugin-core.php';
$_pluginCore = new Plugin_Core();

/*echo '<code>';
var_dump(Plugin_Core::$instances_array);
echo '</code>';*/