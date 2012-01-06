
var platform = "moz";
if( window.navigator.userAgent.indexOf( 'WebKit' ) != -1 ){
    platform = "webkit";
}
if( window.navigator.userAgent.indexOf( 'MSIE' ) != -1 ){
    platform = "MSIE";
    var version = parseInt( window.navigator.userAgent.split( 'MSIE ' )[ 1 ] );
}
if( window.navigator.userAgent.indexOf( 'Opera' ) != -1 ){
    platform = "Opera";
}
if( platform == "moz" ){
    var version = window.navigator.userAgent.split( 'Firefox/' )[ 1 ].split( '.' );
    if( version[ 0 ] <= 3 && version[ 1 ] <= 20 ){
        $( '.navcont .nav li a' ).css({
            width: '50px',
            height: '50px'
        });
    }
}
function smog( i ){
    var img = document.createElement( 'img' );
    img.src = 'images/icons/smog.png';
    img.className = "smog smog" + i;
    $( img ).appendTo( '.smogs' );
}
function navigate(){
    
    platform == "MSIE" && version <=7 && $( '.blackboard' ).css( 'bottom', '100%' );
    $( '.blackboard' ).removeClass( 'more' );
    var hash = window.location.hash.substr( 1 );
    
    if( window._gat ){
        var pageTracker = _gat._getTracker("UA-25785515-1");
        pageTracker._trackPageview( '/#' + hash );
    }
    if( hash && hash != '' ){
        $( '#' + hash ).removeClass( 'hidden' );
        var panel = hash.split( '-' );
        if( platform == "MSIE" && version <= 7 ){
            $( '.blackboard.' + panel[ 0 ] ).css( 'bottom', 0 );
        }
        else{
            $( '.blackboard.' + panel[ 0 ] ).addClass( 'more' ).find( '.scroll' ).scrollTop( 0 );
        }
        if( panel[ 1 ] ){
            $( '.blackboard.more .scroll' ).scrollTop( $( '#' + hash ).addClass( 'open' ).position().top );
            //.stop().animate({
            //    "scrollTop": $( '#' + hash ).addClass( 'open' ).position().top
            //});
        }
    }
    
}

$( function(){
    setTimeout( function(){
        $( '.in, body' ).addClass( 'load' );
    }, 500 );
    $( '.blackboard .content .scroll' ).overscroll({
        cursor: "auto",
        direction: "vertical",
        wheelDelta: 80
    });
    // disable image dragging
	$( 'img' ).mousedown( function(){
		return false;
	} );
    
    // open / close blackboard
    $( '#init .links a' ).click( function(){
        window.location.hash = this.className;
        platform == 'moz' && $( '.smog' ).css( '-moz-animation-play-state', 'paused' );
    } );
    $( '.blackboard .exit' ).click( function(){
        window.location.hash = "";
        platform == 'moz' && $( '.smog' ).css( '-moz-animation-play-state', 'running' );
    } );


    // counter on lectures
    if( platform == "MSIE" && version <= 7 ){
        $( '.blackboard ol' ).addClass( 'compatibility' ).children().each( function( i ){
            $( this ).find( 'h3' ).prepend( "<span>Παρουσίαση " + ( i + 1 ) + "η.</span>" );
        } );
        
    }
    
    // FAQ
    $( 'ul.questionlist li h3' ).click( function(){
        $( this ).parent().toggleClass( 'open' );
    } );
    
    
    // smog
    if( platform != "MSIE" && platform != "Opera" ){
        for( var i = 0; i < 10; ++i ){
            setTimeout( function( i ){ 
                return function(){
                    smog( i ) 
                }
            }( i ), i * 300 + 4000 );
        }
    }
    
    //stars
    for( var i = 0; i < 20; ++i ){
        var star = $( '<img class="star" src="images/icons/star.png" alt="" />' ).css({
            "width": Math.ceil( Math.random() * 5 ) / 10 + "%",
            "top": Math.ceil( Math.random() * 60 ) + "%",
            "left": Math.ceil( Math.random() * 99 ) + "%"
        });
        star.appendTo( '.stars' );
        ( Math.random() < 0.2 ) && star.addClass( 'flickr' );
    }
    setTimeout( function(){ $( '.stars' ).addClass( 'delay' ); }, 10000 );
    
    // scrolling correction
    $( window ).scroll( function(){
        $( this ).scrollTop( 0 ).scrollLeft( 0 );
    } );
    
    // navigate through hash tags
    window.onhashchange = navigate;
    if( platform == "MSIE" && version <= 7 ){
        window.hash = window.location.hash;
        setInterval( function(){
            if( window.hash != window.location.hash ){
                window.hash = window.location.hash;
                navigate();
            }
        }, 500 );
    }
    navigate();
    $( '.blackboard.about a[href^=#about-]' ).click( function(){
        window.location.hash = $( this ).attr( 'href' ).substr( 1 );
        navigate();
        return false;
    });
    // send external links to new tab
    $( 'a:not([href^=#])' ).each( function(){
        $( this ).attr( 'target', '_blank' );
    } ).click( function(){
        if( window._gat ){
            var pageTracker = _gat._getTracker("UA-25785515-1");
            pageTracker._trackPageview( $( this ).attr( 'href' ) );
        }
    } );
    if( window.innerHeight < 700 ){
        document.cookie = "size=small";
        $( 'body' ).addClass( 'small' );
    }
    else{
        document.cookie = "size=normal";
        $( 'body' ).removeClass( 'small' );
    }
    
    $( '.blackboard' ).mousedown( function(){ return false; } );
    if( window.location.href.indexOf( '?' ) != -1 && 
        window.location.href.split( '?' )[ 1 ].split( '#' )[ 0 ] == 'gh9734t9' ){
        $( '.blackboard ol > li' ).show();
    }
    $( '.blackboard ol li h3' ).click( function(){
        $( this ).parent().toggleClass( 'hidden' );
    } );
} );
