<?php
if(!class_exists('WP_CCSVE_Settings')) {
    class WP_CCSVE_Settings  {
        /**
         * Construct the plugin object
         */
        public function __construct()        {
            // register actions
            add_action('admin_init', array(&$this, 'admin_init'));
            add_action('admin_menu', array(&$this, 'add_menu'));
        } // END public function __construct

        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init()    {
            register_setting('wp_ccsve-group', 'ccsve_post_type');
            register_setting('wp_ccsve-group', 'ccsve_std_fields');
            register_setting('wp_ccsve-group', 'ccsve_tax_terms');
            register_setting('wp_ccsve-group', 'ccsve_custom_fields');

            add_settings_section(
                'wp_ccsve_template-section',
                'CSV/XLS Export Settings',
                array(&$this, 'settings_section_wp_ccsve_template'),
                'wp_ccsve_template'
            );

            add_settings_field(
                'ccsve_post_type',
                'Custom Post Type to Export',
                array(&$this, 'settings_field_select_post_type'),
                'wp_ccsve_template',
                'wp_ccsve_template-section'
            );

            add_settings_field(
                'ccsve_std_fields',
                'Standard WP fields to Export',
                array(&$this, 'settings_field_select_std_fields'),
                'wp_ccsve_template',
                'wp_ccsve_template-section'
            );

            add_settings_field(
                'ccsve_custom_fields',
                'Custom Fields to Export',
                array(&$this, 'settings_field_select_custom_fields'),
                'wp_ccsve_template',
                'wp_ccsve_template-section'
            );

            add_settings_field(
                'ccsve_tax_terms',
                'Taxonomy Terms to Export',
                array(&$this, 'settings_field_select_tax_terms'),
                'wp_ccsve_template',
                'wp_ccsve_template-section'
            );

        } // END public static function activate

        public function settings_section_wp_ccsve_template()  {
          echo '<p>From this page you can add the default post type with its connected taxonomies and custom fields, that you wish to export.<br>After that, anytime you will use the urls <strong>'.get_bloginfo('url').'/?export=csv</strong> for a CSV file, or <strong>'.get_bloginfo('url').'/?export=xls</strong>, you will get that post type data.</p>';
          echo '<p>At the bottom of this page you can export right away what you just selected, after saving first.</p>';
          echo '<p>You must choose the post type and save the settings <strong>before</strong> you can see the taxonomies or custom fields for a custom post type. Once the page reloads, you will see the connected taxonomies and custom fields for the post type.</p>';
          echo '<hr>';
          echo '<p>If you want to export from a different post type than the one saved in these settings, also from frontend, use the url <strong>'.get_bloginfo('url').'/?export=csv&post_type=your_post_type_slug</strong> for a CSV file, or <strong>'.get_bloginfo('url').'/?export=xls&post_type=your_post_type_slug</strong> to get a XLS.</p>';
           echo '<hr>';
           echo '<p><i>When opening the exported xls, Excel will prompt the user with a warning, but the file is perfectly fine and can then be opened. <strong>Unfortunately this can\'t be avoided</strong>, <a href="http://blogs.msdn.com/b/vsofficedeveloper/archive/2008/03/11/excel-2007-extension-warning.aspx" target="_blank">read more here</a>.</i></p>';
        }

        /**
         * This function provides text inputs for settings fields
         */
        public function settings_field_select_post_type() {

            $args = array(
                'public'   => true,
            );

            // Get the field name from the $args array
            $items = get_post_types($args);

            // Get the value of this setting
            $options = get_option('ccsve_post_type');
            
            // echo a proper input type="text"
            foreach ($items as $item) {
                $checked = ($options == $item) ? ' checked="checked" ' : '';
                // radio buttons, 1 post type per time
                echo '<input type="radio" id="post_type"'.$item.' name="ccsve_post_type" value="'.$item.'" '.$checked.'" />';
                // checkboxes dont work
                //echo '<input type="checkbox" name="ccsve_post_type['.$item.']" value="'.$item.'" '.$checked.' />';
                echo '<label for=post_type'.$item.'> '.$item.'</label>';
                echo ' <br />';

            }
        } // END public function settings_field_input_text($args)

        public function settings_field_select_std_fields()       {
          $ccsve_post_type = get_option('ccsve_post_type');
          $fields = generate_std_fields($ccsve_post_type);
          $ccsve_std_fields =get_option('ccsve_std_fields');
          $ccsve_std_fields_num = count($fields);
          echo '<select multiple="multiple" size="'.$ccsve_std_fields_num.'" name="ccsve_std_fields[selectinput][]">';
          foreach ($fields as $field) {
            if (in_array($field, $ccsve_std_fields['selectinput'])){
              echo '\n\t<option selected="selected" value="'. $field . '">'.$field.'</option>';
            } else {
              echo '\n\t\<option value="'.$field .'">'.$field.'</option>'; }
            } // END public function settings_field_input_text($args)
        } // END public function settings_field_Select_std_fields()

        public function settings_field_select_tax_terms()  {
          $ccsve_post_type = get_option('ccsve_post_type');
          $object_tax = get_object_taxonomies($ccsve_post_type, 'names');
          $ccsve_tax_terms =get_option('ccsve_tax_terms');
          $ccsve_tax_terms_num = count($object_tax);
          echo '<select multiple="multiple" size="'.$ccsve_tax_terms_num.'" name="ccsve_tax_terms[selectinput][]">';
          foreach ($object_tax as $tax) {
            if (in_array($tax, $ccsve_tax_terms['selectinput'])){
              echo '\n\t<option selected="selected" value="'. $tax . '">'.$tax.'</option>';
            } else {
              echo '\n\t\<option value="'.$tax .'">'.$tax.'</option>'; }
            } // END public function settings_field_input_text($args)
        } // END public function settings_field_Select_std_fields()

        public function settings_field_select_custom_fields()   {
          $ccsve_post_type = get_option('ccsve_post_type');
          $meta_keys = get_post_meta_keys($ccsve_post_type);
          $ccsve_custom_fields =get_option('ccsve_custom_fields');
          //var_dump($ccsve_custom_fields);
          $ccsve_meta_keys_num = count($meta_keys);
          echo '<select multiple="multiple" size="'.$ccsve_meta_keys_num.'" name="ccsve_custom_fields[selectinput][]">';
          foreach ($meta_keys as $meta_key) {
            if (in_array($meta_key, $ccsve_custom_fields['selectinput'])){
              echo '\n\t<option selected="selected" value="'. $meta_key . '">'.$meta_key.'</option>';
            } else {
              echo '\n\t\<option value="'.$meta_key .'">'.$meta_key.'</option>';
          }
        } // END public function settings_field_input_text($args)

    }

    // ADD MENU
    public function add_menu() {
        // Add a page to manage this plugin's settings
        add_submenu_page(
            'tools.php',
            'CSV/XLS Export Settings',
            'CSV/XLS Export',
            'manage_options',
            'wp_ccsve_template',
            array(&$this, 'plugin_settings_page')
        );
    } // END public function add_menu()

    // MENU CALLBACK
    public function plugin_settings_page() {
        if(!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        // Render the settings template
        //include(sprintf("%s/settings_page.php", dirname(__FILE__)));
        ?>
        <div class="wrap">
        <h2>CSV/XLS Exporter Settings</h2>
        <form method="post" action="options.php">
          <?php @settings_fields('wp_ccsve-group'); ?>
          <?php @do_settings_fields('wp_ccsve-group'); ?>

          <?php do_settings_sections('wp_ccsve_template'); ?>

          <?php @submit_button(); ?>

          <a class="ccsve_button button button-success" href="options-general.php?page=wp_ccsve_template&export=csv">Export to CSV</a>

          <a class="ccsve_button button button-success" href="options-general.php?page=wp_ccsve_template&export=xls">Export to XLS</a>

        </form>
      </div>
    <?php
    } // END public function plugin_settings_page()

    } // END class wp_ccsve_template_Settings

} // END if(!class_exists('wp_ccsve_template_Settings'))

function generate_post_meta_keys($post_type){
  global $wpdb;
  $query = "
  SELECT DISTINCT($wpdb->postmeta.meta_key)
  FROM $wpdb->posts
  LEFT JOIN $wpdb->postmeta
  ON $wpdb->posts.ID = $wpdb->postmeta.post_id
  WHERE $wpdb->posts.post_type = '%s'
  AND $wpdb->postmeta.meta_key != ''
  AND $wpdb->postmeta.meta_key NOT RegExp '(^[_0-9].+$)'
  AND $wpdb->postmeta.meta_key NOT RegExp '(^[0-9]+$)'
  ";
  $meta_keys = $wpdb->get_col($wpdb->prepare($query, $post_type));
    set_transient($post_type.'post_meta_keys', $meta_keys, 60*60*24); # 1 Day Expiration
    return $meta_keys;
  }

  function generate_std_fields($post_type){
    $fields = array('permalink', 'post_thumbnail');
    $q = new WP_Query(array('post_type' => $post_type, 'post_status' => 'publish', 'posts_per_page' => 1));
    $p = $q->posts[0];

    foreach($p as $f => $v) {
      $fields[] = $f;
    }
    return $fields;
  }

  function get_post_meta_keys($post_type){
    $cache = get_transient($post_type.'post_meta_keys');
    $meta_keys = $cache ? $cache : generate_post_meta_keys($post_type);
    return $meta_keys;
  }

  function ccsve_checkboxes_fix($input) {
   $options = get_option('ccsve_custom_fields');
   $merged = $options;
   $merged[] = $input;
 }