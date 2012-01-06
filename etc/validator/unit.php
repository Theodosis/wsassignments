<?php
    $sandbox = new Runkit_Sandbox();
    $sandbox->foo = 'bar';
    $sandbox->eval( 'echo $foo\n"; $bar = $foo . "baz";' );
    echo "{$sandbox->bar}\n";
?>
