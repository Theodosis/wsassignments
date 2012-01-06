<ul>
<?php
    $curl = curl_init('http://twitter.com/statuses/user_timeline.json?id=webseminarTHMMY');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    $twitter = json_decode( curl_exec($curl) );
    foreach ( $twitter as $twitt ) {
       if( strpos( $twitt->text, '@' ) !== false ||    // skip mentions
            strpos( $twitt->text, '#' ) !== false       // skip twitts that have hash tags
        ){
            continue;
        }
        ?>
        <li>
            <span class="date"><?php echo date( "d/n", strtotime( $twitt->created_at) + 2 * 3600 ) ?></span>
            <span class="text"><?php echo htmlspecialchars( $twitt->text ) ?></span>
        </li>
        <?php
    }
?>
</ul>
