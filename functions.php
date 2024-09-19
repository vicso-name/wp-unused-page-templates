<?php

    function list_unused_page_templates() {
        // Get all page templates from the theme
        $theme = wp_get_theme();
        $templates = $theme->get_page_templates();

        // Get all templates currently used by pages
        global $wpdb;
        $used_templates = $wpdb->get_col("
            SELECT DISTINCT meta_value
            FROM $wpdb->postmeta
            WHERE meta_key = '_wp_page_template'
        ");

        // List unused templates
        $unused_templates = array_diff(array_keys($templates), $used_templates);

        if (!empty($unused_templates)) {
            echo '<div class="notice notice-warning"><p><strong>Unused Page Templates:</strong></p><ul>';
            foreach ($unused_templates as $template) {
                echo '<li>' . esc_html($template) . '</li>';
            }
            echo '</ul></div>';
        } else {
            echo '<div class="notice notice-success"><p>All page templates are in use.</p></div>';
        }
    }
    add_action('admin_notices', 'list_unused_page_templates');

?>