<?php
/**
 * Plugin Name: Arabic Stopwords
 * Plugin URI: http://ar.wordpress.org
 * Description: A simple plugin to manage the Arabic stopwords.
 * Author: ArWP Team
 * Author URI: http://ar.wordpress.org
 * Version: 0.1
 *
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Copyright (c) 2013 - 2014 Nashwan Doaqan.  All rights reserved.
 */

/*
 * TODO:
 * 1- Allow the users to add/remove the stopwords.
 * 2- Allow the user to enable/disable stopwords in WP search.
 * 3- Remove the Arabic stopwords from the post slugs.
 * ...etc
 *
 * THIS PLUGIN IS IN DEVELOPMENT.
 */

//*** Define Constant *********************************************************/

define( 'ArSWs_PATH', plugin_dir_path( __file__ ) );


//*** Load Functions **********************************************************/

require ArSWs_PATH . 'includes/functions.php';
require ArSWs_PATH . 'includes/stopwords.php';