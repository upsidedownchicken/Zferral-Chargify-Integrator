<?php
/*
Plugin Name: Zferral and Chargify Integrator 
Plugin URI: http://zippykid.com/zkcz/
Description: Generates a zferral tracking pixel using Chargify transaction data.
Author: John Gray <john@zippykid.com>
Version: 0.1
Author URI: http://zippykid.com/
*/

if( is_admin() ){
  require_once dirname( __FILE__ ) . '/admin.php';
  require_once dirname( __FILE__ ) . '/meta-box.php';
} else {
  require_once dirname( __FILE__ ) . '/page.php';
}

?>
