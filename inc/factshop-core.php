<?php
/**
 * Plugin Name: هسته فکت شاپ
 * Plugin URI: https://hasanart.ir/factshop
 * Description: هسته قالب فروشگاهی فکت شاپ
 * Version: 2.0.0
 * Author: حسن آهنی
 * Author URI: https://hasanart.ir/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: fscore
 * Domain Path: /languages
 */
if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------------------------------------------------------------------------

if( ! function_exists( 'cs_framework_init' ) && ! class_exists( 'CSFramework' ) ) {

// ------------------------------------------------------------------------------------------------
    require_once 'setup.php';
  function cs_framework_init() {
    defined( 'CS_ACTIVE_FRAMEWORK' )  or  define( 'CS_ACTIVE_FRAMEWORK',  true );
    defined( 'CS_ACTIVE_METABOX'   )  or  define( 'CS_ACTIVE_METABOX',    true );
    defined( 'CS_ACTIVE_TAXONOMY'   ) or  define( 'CS_ACTIVE_TAXONOMY',   true );
    defined( 'CS_ACTIVE_SHORTCODE' )  or  define( 'CS_ACTIVE_SHORTCODE',  false );
    defined( 'CS_ACTIVE_CUSTOMIZE' )  or  define( 'CS_ACTIVE_CUSTOMIZE',  true );

    // helpers
    cs_locate_template( 'functions/deprecated.php'     );
    cs_locate_template( 'functions/fallback.php'       );
    cs_locate_template( 'functions/helpers.php'        );
    cs_locate_template( 'functions/actions.php'        );
    cs_locate_template( 'functions/enqueue.php'        );
    cs_locate_template( 'functions/sanitize.php'       );
    cs_locate_template( 'functions/validate.php'       );

    // classes
    cs_locate_template( 'classes/abstract.class.php'   );
    cs_locate_template( 'classes/options.class.php'    );
    cs_locate_template( 'classes/framework.class.php'  );
    cs_locate_template( 'classes/metabox.class.php'    );
    cs_locate_template( 'classes/taxonomy.class.php'   );
    cs_locate_template( 'classes/shortcode.class.php'  );
    cs_locate_template( 'classes/customize.class.php'  );
    
    // libraries
    cs_locate_template( 'libraries/post_types/cs-post-type.php'  );
    cs_locate_template( 'libraries/taxonomies/cs-taxonomy.php'  );

    // configs
    cs_locate_template( 'config/settings.php'  );
    cs_locate_template( 'config/metabox.config.php'    );


      add_action('admin_bar_menu', 'add_toolbar_items', 100);
      function add_toolbar_items($admin_bar){
          $admin_bar->add_menu( array(
              'id'    => 'factshop',
              'title' => 'تنظیمات فکت شاپ',
              'href'  => home_url('wp-admin/admin.php?page=factshop-options'),
              'meta'  => array(
                  'title' => __('تنظیمات فکت شاپ'),
              ),
          ));
      }

  }
  add_action( 'init', 'cs_framework_init', 10 );
}