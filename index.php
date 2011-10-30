<?php

    global $settings;
    global $user;

    require( 'models/user.php' );

    $settings = require( 'settings.php' );

    $user = User::BasicAuth( $settings[ 'users' ] );

    if ( empty( $user ) ) {
        header( 'WWW-Authenticate: Basic realm="' . $settings[ 'title' ] . '"' );
        header( 'HTTP/1.0 401 Unauthorized' );
        echo "Not authorized";
        exit;
    }
    else {
        echo $user[ 'name' ];
    }

?>
