<?php
    error_reporting( E_ALL );
    global $settings;
    global $user;
    global $controller;
    global $method;

    $settings = require( 'settings.php' );
    $settings[ 'debug' ] = ( isset( $_GET[ 'debugkey' ] ) && $_GET[ 'debugkey' ] == 'ec456175b0f06473e2fdbef8720fbfa6' );
    date_default_timezone_set( $settings[ 'timezone' ] );

    require( 'models/db.php' );
    require( 'controllers/controller.php' );


    require( 'models/user.php' );

    $controllerWhitelist = array( 'submission', 'session', 'dashboard' );
    $methodWhitelist = array( 'view', 'listing', 'create', 'update', 'delete' );
    
    $controller = @$_GET[ 'resource' ] or 'session';
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
        $_SERVER[ 'REQUEST_METHOD' ] == 'POST' or die( 'Non-idempotent REST method cannot be applied with the idempotent HTTP request method "' . $_SERVER[ 'REQUEST_METHOD' ] . '"' );

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
    
    require( "controllers/$controller.php" );
    call_user_func( array( $controller . "controller", $method ), $params );
?>
