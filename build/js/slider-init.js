jQuery( document ).ready( function( $ ) {

    $( '.realbig-slider' ).each( function( index ) {

        $( this ).addClass( 'slider-' + index );

    } );

    $( '.realbig-slider.default' ).each( function() {
        // Uses default settings. Set default_js = false in the shortcode to provide a custom instantiation

        $( this ).RealBigSlider();

    } );
    
    $( '#home-slider .realbig-slider' ).RealBigSlider( {
        slideDuration: '7000',
        speed: 500,
        arrowRight: '#home-slider .realbig-slider .arrow-right',
        arrowLeft: '#home-slider .realbig-slider .arrow-left',
    } );

} );