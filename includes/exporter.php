<?php
/**
 * (C) 2018 by Kolja Nolte
 * kolja.nolte@gmail.com
 * http://www.koljanolte.com
 *
 * All information contained herein is,
 * and remains the property of Kolja Nolte.
 * The intellectual and technical concepts contained.
 * Dissemination of this information or reproduction
 * of this material is strictly forbidden unless prior
 * written permission is obtained from the author.
 */

global  $ccsve_export_check,
        //$custom_query_check,
        $export_only;

function ccsve_export(){
    global  $ccsve_export_check,
            $export_only;

    $ccsve_export_check = isset($_REQUEST['export']) ? $_REQUEST['export'] : '';
    // Parents or Children
    $export_only = isset($_REQUEST['only']) ? $_REQUEST['only'] : '';
    // Backend Only?
    $admin_only = get_option('ccsve_admin_only');
    if($admin_only == 'Yes') {
        $admin_only = true;
    } else {
        $admin_only = false;
    }

    // Custom Query - Not implemented
    //$custom_query_check = isset($_REQUEST['custom_query']) ;

    //if ($custom_query_check == false) {
        if($admin_only && !current_user_can('read')) {
            wp_die(__('You do not have sufficient permissions to do this.'));
             exit;
        } else {
            require_once(SIMPLE_CSV_XLS_EXPORTER_PROCESS."simple_csv_xls_exporter_csv_xls.php");
            simple_csv_xls_exporter_csv_xls();
        }
    /*} elseif ($custom_query_check == true) {
        require_once(SIMPLE_CSV_XLS_EXPORTER_PROCESS."simple_csv_xls_exporter_custom_csv_xls.php");
        simple_csv_xls_exporter_custom_csv_xls();
    }*/
    exit;
}
