<?php

if (defined('WP_UNINSTALL_PLUGIN')) {
    $option_name = 'wpfront-scroll-top-options';

    delete_option($option_name);
}



//TODO: Multisite delete
//http://codex.wordpress.org/Function_Reference/register_uninstall_hook
//http://wordpress.org/support/topic/how-can-i-remove-an-option-from-all-option-tables-in-multisite

