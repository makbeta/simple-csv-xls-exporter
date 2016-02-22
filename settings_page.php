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