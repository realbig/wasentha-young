<?php

if ( ! class_exists( 'Foundation_Nav_Walker' ) ) {

    class Foundation_Nav_Walker extends Walker_Nav_Menu {   
    /*
	 * Add vertical menu class and submenu data attribute to sub menus
	 */

        function start_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat( "\t", $depth );
            $output .= "\n$indent<ul class=\"vertical menu\" data-submenu>\n";
        }

    }

}