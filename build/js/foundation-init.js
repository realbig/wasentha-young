function alternate_nested_list( parent, target, index = 0 ) {
    
    var flip = ( ( index % 2 ) == 0 ? 'even' : 'odd' );
    
    index++;
    
    var nextUl = $( parent ).find( target );
    
    $( nextUl ).find( 'li' ).addClass( flip );
    
    alterate_nested_list( nextUl, target, index );
    
}

jQuery( function( $ ) {
    
    $( document ).foundation(); 
    
} );