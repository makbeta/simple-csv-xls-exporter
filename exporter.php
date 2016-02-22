<?php
global $ccsve_export_check;

function ccsve_export(){
    global $ccsve_export_check;

    $ccsve_export_check = isset($_REQUEST['export']) ? $_REQUEST['export'] : '';
    if ($ccsve_export_check == 'csv' || $ccsve_export_check == 'xls') {
        echo ccsve_generate();
        exit;
    }
    //add_action('wp_loaded','ccsve_generate');
}

function ccsve_generate(){
    global $ccsve_export_check, $ccsve_export_check2;

    // Get the custom post type that is being exported
    // get post type from url var
    $post_type_var = isset($_REQUEST['post_type']) ? $_REQUEST['post_type'] : '';
    if(empty($post_type_var)) {
        $ccsve_generate_post_type = get_option('ccsve_post_type');
    } else {
        $ccsve_generate_post_type = $post_type_var;
    }
    
    // Get the custom fields (for the custom post type) that are being exported
    $ccsve_generate_custom_fields = get_option('ccsve_custom_fields');
    $ccsve_generate_std_fields = get_option('ccsve_std_fields');
    $ccsve_generate_tax_terms = get_option('ccsve_tax_terms');
    
    // Query the DB for all instances of the custom post type
    $ccsve_generate_query = get_posts(array(
        'post_type' => $ccsve_generate_post_type,
        'post_status' => 'publish',
        'posts_per_page' => -1
    ));

    // Count the number of instances of the custom post type
    $ccsve_count_posts = count($ccsve_generate_query);

    // Build an array of the custom field values
    $ccsve_generate_value_arr = array();
    $i = 0;

    foreach ($ccsve_generate_query as $post): setup_postdata($post);

        $post->permalink = get_permalink($post->ID);
        $post->post_thumbnail = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
        
        // get the standard wordpress fields for each instance of the custom post type
        foreach($post as $key => $value) {
            if(in_array($key, $ccsve_generate_std_fields['selectinput'])) {
                // Prevent SYLK format issue
                if($key == 'ID') {
                    // add an apostrophe before ID
                    //$ccsve_generate_value_arr["'".$key][$i] = $post->$key;
                    // or make it lower-case
                    $ccsve_generate_value_arr[strtolower($key)][$i] = $post->$key;
                } else {
                    $ccsve_generate_value_arr[$key][$i] = $post->$key;
                }
            }
        }

        // get custom taxonomy information
        foreach($ccsve_generate_tax_terms['selectinput'] as $tax) {
            $names = array();
            $terms = wp_get_object_terms($post->ID, $tax);
            /*$terms = get_the_terms($post->ID, 'brand');
            echo '<pre>';
            var_dump($terms); // error is here
            echo '</pre>';*/
            
            if (!empty($terms)) {
                if (!is_wp_error( $terms ) ) {
                    foreach($terms as $t) {
                        //echo $t->name;
                        $names[] = $t->name;
                    }
                } else {
                    $names[] = '- error -';
                }
            } else {
                $names[] = '';
            }
            
            $ccsve_generate_value_arr[$tax][$i] = implode(',', $names);

            //echo implode(',', $names);
        }
        
        // get the custom field values for each instance of the custom post type
        $ccsve_generate_post_values = get_post_custom($post->ID);
        foreach ($ccsve_generate_custom_fields['selectinput'] as $key) {
            // check if each custom field value matches a custom field that is being exported
            if (array_key_exists($key, $ccsve_generate_post_values)) {
                // if the the custom fields match, save them to the array of custom field values
                $ccsve_generate_value_arr[$key][$i] = $ccsve_generate_post_values[$key]['0'];
           }
        }

        $i++;

    endforeach;

    //exit;

    // create a new array of values that reorganizes them in a new multidimensional array where each sub-array contains all of the values for one custom post instance
    $ccsve_generate_value_arr_new = array();
    
    foreach($ccsve_generate_value_arr as $value) {
        $i = 0;
        while ($i <= ($ccsve_count_posts-1)) {
            $ccsve_generate_value_arr_new[$i][] = $value[$i];
            $i++;
        }
    }

    /*var_dump($ccsve_generate_value_arr );
    die;*/
    
    // CSV

    if ($ccsve_export_check == 'csv') {
        
        // build a filename based on the post type and the data/time
        $ccsve_generate_csv_filename = $ccsve_generate_post_type.'-'.date('dMY_Hi').'-export.csv';

        //output the headers for the CSV file
        header('Content-Encoding: UTF-8');
        header("Content-type: text/csv; charset=utf-8");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-Disposition: attachment; filename={$ccsve_generate_csv_filename}");
        header("Expires: 0");
        header("Pragma: public");

        //open the file stream
        $fh = @fopen( 'php://output', 'w' );

        $headerDisplayed = false;

        foreach ( $ccsve_generate_value_arr_new as $data ) {
            // Add a header row if it hasn't been added yet -- using custom field keys from first array
            if ( !$headerDisplayed ) {
                fputcsv($fh, array_keys($ccsve_generate_value_arr));
                $headerDisplayed = true;
            }

            // Replace tabs, linebreaks and pipes
            /*$data = preg_replace("/\t/", "\\t", $data);
            $data = preg_replace("/\r?\n/", "\\n", $data);
            $data = preg_replace("/|/", "", $data);
            if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';*/

            // Put the data from the new multi-dimensional array into the stream
            fputcsv($fh, $data, '|');
        }

        // Close the file stream
        fclose($fh);
        // Make sure nothing else is sent, our file is done
        exit;

    }

        // PHP

    if ($ccsve_export_check == 'xls') {

        function cleanData(&$str)  {
            $str = preg_replace("/\t/", "\\t", $str);
            $str = preg_replace("/\r?\n/", "\\n", $str);
            
            // replace commas with nothing
            //$str = preg_replace("/,/", "", $str);

            if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            
        }
        
        // EXCEL .xls - Raises an unavoidable warning http://blogs.msdn.com/b/vsofficedeveloper/archive/2008/03/11/excel-2007-extension-warning.aspx
        $filename = $ccsve_generate_post_type.'-'.date('dMY_Hi').'-export.xls';
        header("Content-Disposition: Attachment; Filename=\"$filename\"");
        header("Content-Type: Application/vnd.ms-excel");

        // EXCEL .xlsx - not working
        /*$filename = $ccsve_generate_post_type.'-'.date('dMY_Hi').'-export.xlsx';
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");*/

        $flag = false;

        foreach ( $ccsve_generate_value_arr_new as $data ) {
            if(!$flag) {
              // display field/column names as first row
              echo implode("\t", array_keys($ccsve_generate_value_arr)) . "\r\n";
              $flag = true;
            }
            array_walk($data, 'cleanData');
            echo implode("\t", array_values($data)) . "\r\n";
        }
        exit;

    }




}

