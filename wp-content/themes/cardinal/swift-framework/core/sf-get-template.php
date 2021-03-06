<?php

    /*
    *
    *	Template Function
    *	------------------------------------------------
    *	Swift Framework v3.0
    * 	Copyright Swift Ideas 2014 - http://www.swiftideas.net
    *
    *	sf_get_template()
    *
    */

    if ( ! function_exists( 'sf_get_template' ) ) {
        function sf_get_template( $template, $type = "" ) {
            get_template_part( 'swift-framework/layout/' . $template, $type );
        }
    }

?>