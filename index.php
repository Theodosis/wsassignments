<?php
    //error_reporting( E_ALL );
    global $settings;
    global $user;
    global $controller;
    global $method;

    $settings = require( 'settings.php' );
    date_default_timezone_set( $settings[ 'timezone' ] );

    clude( 'models/db.php' );
    clude( 'controllers/controller.php' );


    clude( 'models/user.php' );

    $controllerWhitelist = array( 'submission', 'session', 'dashboard', 'adminpanel' );
    $methodWhitelist = array( 'view', 'listing', 'create', 'update', 'delete' );
    
    $controller = @$_GET[ 'resource' ] or 'dashboard';
    $method = @$_GET[ 'method' ] or 'view';
    if ( !in_array( $controller, $controllerWhitelist ) ) {
        $controller = 'dashboard';
    }
    if ( !in_array( $method, $methodWhitelist ) ) {
        $method = 'view';
    }
    
    if ( !isset( $_SESSION[ 'user' ] ) ) {
        $user = User::GetCookieData();
        if ( $user !== false ) {
            $_SESSION[ 'user' ] = $user;
        }
        else{
            $controller = "session";
            $method == "create" or $method = "view";
        }
    }
	if ( $method == 'create' || $method == 'delete' || $method == 'update' ) {
        if( $_SERVER[ 'REQUEST_METHOD' ] != 'POST' ){
            header( "Location: /" );
            die( 'Non-idempotent REST method cannot be applied with the idempotent HTTP request method "' . $_SERVER[ 'REQUEST_METHOD' ] . '". Redirecting to home...' );
        }

		// check http referer
		if ( !isset( $_SERVER['HTTP_REFERER' ] ) ) {
            // allow
		}
		else {
			$referer = $_SERVER[ 'HTTP_REFERER' ];
			$pieces = explode( "/", $referer );
			if ( isset( $pieces[ 2 ] ) ) {
                if ( $pieces[ 2 ][ strlen( $pieces[ 2 ] ) - 1 ] == '#' ) {
                    // remove possible # suffix
                    $pieces[ 2 ] = substr( $pieces[ 2 ], 0, -1 );
                }
                $domain = $pieces[ 2 ];
				if ( ( $domain !== $settings[ 'domain' ] ) && $referer !== "" ) {
					throw New Exception( 'Not Valid Post Referer - ' . $domain  );
				}
			}
		}
	}
    
    $params = array_merge( $_GET, $_POST, $_FILES );
    
    function clude( $path ) {
        static $included = array();
        if ( !isset( $included[ $path ] ) ) {
            $included[ $path ] = true;
            return include $path;
        }
        return true;
    }
    
    clude( "controllers/$controller.php" );
    call_user_func( array( $controller . "controller", $method ), $params );
?>
