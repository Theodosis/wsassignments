<?php

    global $settings;
    global $user;

    $settings = require( 'settings.php' );
    require( 'models/user.php' );

    $controllerWhitelist = array( 'submission' );
    $methodWhitelist = array( 'view', 'listing', 'update', 'delete' );

    $user = User::BasicAuth( $settings[ 'users' ] );

    if ( empty( $user ) ) {
        header( 'WWW-Authenticate: Basic realm="' . $settings[ 'title' ] . '"' );
        header( 'HTTP/1.0 401 Unauthorized' );
        echo "Not authorized";
        exit;
    }

    $controller = @$_GET[ 'controller' ] or 'submission';

    if ( !in_array( $controller, $controllerWhitelist ) ) {
        $controller = 'submission';
    }

    $method = @$_GET[ 'method' ] or 'listing';
    if ( !in_array( $method, $methodWhitelist ) ) {
        $method = 'listing';
    }

    $params = array_merge( $_GET, $_POST );
    
    require( "controllers/$controller.php" );
    call_user_func( array( $controller, $method ), $params )
?>
