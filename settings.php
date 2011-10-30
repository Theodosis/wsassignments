<?php

    $settings = array(
        'db' => array(
            'host' => 'localhost',
            'name' => 'name',
            'user' => 'user',
            'pass' => 'pass'
        )
    );

    $localsettings = require( 'localsettings.php' );

    foreach ( $settings as $key => $value ) {
        if ( isset( $localsettings[ $key ] ) ) {
            $settings[ $key ] = $localsettings[ $key ];
        }
    }

    return $settings;

?>
