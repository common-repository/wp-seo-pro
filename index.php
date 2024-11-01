<?php

/**
*
* Plugin Name: SEO Pro for WordPress
* Plugin URI: http://wpseopro.hdev.info
* Description: SEO Pro for WordPress | A smart SEO plugin for Wordpress and WooCommerce website or e-commerce. Powered by Neuro Linguistic SEO, http://neurolinguisticseo.hdev.info
* Version: 1.1
* Author: hdevinfo
* Author URI: http://wpseopro.hdev.info
* Text Domain: wp-seo-pro
* License: GPLv2
* SEO Pro for WordPress
* Powered by HDEV.INFO & NSR Systems | Neural System Reply
*
*
* Copyright (C) 2008-2017, hdevinfo - support@hdev.info
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
**/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'SEOPROSRCP' ) ) {
    define( 'SEOPROSRCP', basename(dirname(__FILE__)) );
}

if ( ! defined( 'SEOPROSRC' ) ) {
    define( 'SEOPROSRC', dirname( __FILE__) );
}

if ( ! defined( 'SEOPROVE' ) ) {
    define( 'SEOPROVE', "1.1" );
}

if ( ! defined( 'SEOPRODAT' ) ) {
    define( 'SEOPRODAT', "/".basename(WP_CONTENT_DIR)."/".basename(WP_PLUGIN_DIR)."/".SEOPROSRCP."/Code/Data/" );
}

if ( ! defined( 'SEOPRODSR' ) ) {
    define( 'SEOPRODSR', "/".basename(WP_CONTENT_DIR)."/".basename(WP_PLUGIN_DIR)."/".SEOPROSRCP."/Code/" );
}

if ( ! defined( 'SEOPROIMG' ) ) {
    define( 'SEOPROIMG', "/".basename(WP_CONTENT_DIR)."/".basename(WP_PLUGIN_DIR)."/".SEOPROSRCP."/images/" );
}

if ( ! class_exists( 'SEOPro' ) ) {
    require_once ( SEOPROSRC ."/Code/SEOPro.php");
}

register_activation_hook ( __FILE__  , 'wp_seo_pro_Install' );
register_uninstall_hook  ( __FILE__  , 'wp_seo_pro_Unstall' );

function wp_seo_pro_Install() {
    require_once  ( SEOPROSRC ."/Code/SEOProInstall.php");
}

function wp_seo_pro_Unstall() {
    require_once  ( SEOPROSRC ."/Code/SEOProUnstall.php");
}


$init = new SEOPro();
