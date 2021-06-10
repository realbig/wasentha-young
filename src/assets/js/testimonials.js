jQuery( function( $ ) {
    
    if ( $( '#wasentha_testimonial-shortcode' ).length > 0 ) {
        
        $.ajax( {
			
            type : 'POST',
            url : wasentha_theme_data.ajaxUrl,  
            data : {

                testimonial_category: $( '#wasentha_testimonial-shortcode' ).data( 'category' ),
                action: 'get_testimonial' // The name of the action hook. It uses the function named "get_wasentha_testimonial_callback"

            },

            success: function( response ) {

                var options = JSON.parse( response ); // Parses JSON from the AJAX response
                
                options = options[ Math.floor( Math.random() * options.length ) ]; // Choose One at Random

                if ( options.name !== '' && options.body !== '' ) {

                    $( '#wasentha_testimonial-shortcode .author span' ).html( options.name );
                    $( '#wasentha_testimonial-shortcode .testimonials-text' ).html( options.body );
                    
                    $( '#wasentha_testimonial-shortcode .testimonial-loading' ).hide();
                    $( '#wasentha_testimonial-shortcode .testimonials-content' ).show();

                }

            }

        } );
    
    }
    
} );