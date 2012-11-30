<?php
    $cssversion = 8;
    $jsversion = 10;
    $currentpresentation = 18;
    $currentassignment = 6;
    
    $agent = isset( $_SERVER[ "HTTP_USER_AGENT" ] ) ? $_SERVER[ "HTTP_USER_AGENT" ] : "";
    if (
        stristr($agent, "Windows CE") or
        stristr($agent, "iPad") or
        stristr($agent,"iPod") or
        stristr($agent,"iPhone") or
        stristr($agent,"Android") or
        stristr($agent,"Nokia") or
        stristr($agent,"Samsung") or
        stristr($agent,"Sony") or
        stristr($agent, "Mobile") or
        stristr($agent,"Blackberry")
    ) {
        header( 'Location: mobile/' );
    }
    $D = intval( date( 'd' ) );
    $M = intval( date( 'n' ) );
    
    $h = intval( date( 'G' ) );
    $m = intval( date( 'i' ) );
    $s = intval( date( 's' ) );

    $sunrise = array( 7, 27 );
    $sunset  = array( 18, 58 );

    $date = new DateTime('2011-10-6');
    $now = new DateTime();
    $interval = $date->diff( $now );
    $diff = intval( $interval->format('%a') );
    
    $sunrise[ 1 ] += $diff;
    while( $sunrise[ 1 ] >= 60 ){
        $sunrise[ 1 ] -= 60;
        $sunrise[ 0 ] += 1;
    }
    $sunset[ 1 ] -= $diff;
    while( $sunset[ 1 ] < 0 ){
        $sunset[ 1 ] += 60;
        $sunset[ 0 ] -= 1;
    }
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="el" lang="el">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Ανάπτυξη Web και Mobile Εφαρμογών</title>
        <link rel="stylesheet" href="css/style.css?<?php
            echo $cssversion;
        ?>" /><?php
        if( strpos( $agent, 'facebookexternalhit' ) !== false ){
            ?>
            <meta name="title" content="Ανάπτυξη Web και Mobile Εφαρμογών" />
            <meta name="description" content="Ένα σεμινάριο στις σύγχρονες τεχνικές ανάπτυξης μεγάλων εφαρμογών στο σημερινό ιστό, στο ΑΠΘ." />
            <meta property="og:url" content="http://webseminars.ee.auth.gr/" />
            <meta property="og:image" content="http://webseminars.ee.auth.gr/images/logo.png" />
            <?php
        }
        ?>
        
        <!--
        Ενδιαφέρεσαι για τον κώδικα; Μπορείς να μάθεις πως να φτιάχνεις σελίδες και εφαρμογές όπως αυτή και πολλά άλλα στο σεμινάριο.
        Θα σε περιμένουμε!
        
        This code is valid HTML5. Verify it: http://validator.w3.org/
        If not, e-mail us. HTML5 is an experimental standard. We'd love to fix any problems you've found.

        The BSD License.

        Developer: Theodosis "ted" Sourgkounis <thsourg@gmail.com>
        Copyright (c) 2011, Theodosis Sourgkounis

        All rights reserved.

        Redistribution and use in source and binary forms, with or without
        modification, are permitted provided that the following conditions are met:
            * Redistributions of source code must retain the above copyright
              notice, this list of conditions and the following disclaimer.
            * Redistributions in binary form must reproduce the above copyright
              notice, this list of conditions and the following disclaimer in the
              documentation and/or other materials provided with the distribution.
            * Neither the name of Theodosis Sourgkounis nor the names of its contributors 
              may be used to endorse or promote products derived from this software 
              without specific prior written permission.

        THIS SOFTWARE IS PROVIDED BY THEODOSIS SOURGKOUNIS ``AS IS'' AND ANY
        EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
        WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
        DISCLAIMED. IN NO EVENT SHALL THEODOSIS SOURGKOUNIS BE LIABLE FOR ANY
        DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
        (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
        LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
        ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
        (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
        SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
        -->
        <!--[if lt IE 9]><script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js">IE7_PNG_SUFFIX = ".png";</script><link rel="stylesheet" href="css/cmode.css" /><![endif]--><!--[if IE 9]><link rel="stylesheet" href="css/ie9.css?2" /><![endif]--><!--[if lte IE 8]><link rel="stylesheet" href="css/ie6.css?2" /><![endif]-->
    </head>
    <body class="<?php 
        if( ( 
                $h < $sunrise[ 0 ] || // 0:00 - 7:00
                ( $h == $sunrise[ 0 ] && $m < $sunrise[ 1 ] ) // 7:00 - 7:27
            ) || (
                $h > $sunset[ 0 ] || // 19:00 - 24:00
                ( $h == $sunset[ 0 ] && $m >= $sunset[ 1 ] ) // 18:58 - 18:59
            ) ){
            echo "night";
        }
        else{
            echo "in";
        }
        if( isset( $_COOKIE[ 'size' ] ) && $_COOKIE[ 'size' ] == 'small' ){
            echo " small";
        }
    ?>">
        <div class="modal">
            <div id="init">
                <h1>Ανάπτυξη Web και Mobile Εφαρμογών</h1>
                <p class="sub">Ένα σεμινάριο στις σύγχρονες τεχνικές ανάπτυξης μεγάλων εφαρμογών στο σημερινό ιστό.</p>
                <h2>Ανακοινώσεις</h2>
                <ul>
                    <li>
                            <span class="date">5/1</span>
                            <span class="text">
                                Μετά από το αίτημα αρκετών, η προθεσμία της τελευταίας εργασίας μεταφέρεται στις 23/1. Όσοι χρειάζονται τη βεβαίωση άμεσα ας επικοινωνήσουν μαζί μας.
                            </span>
                    </li>  <?php
                    $curl = curl_init('http://twitter.com/statuses/user_timeline.json?id=webseminarTHMMY');
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
                    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($curl, CURLOPT_TIMEOUT_MS, "2000" );
                    $twitter = json_decode( curl_exec($curl) );
                    if( !$twitter ){
                        $twitter = array();
                    }
                    $counter = 0;
                    $url_mapping = array(
                        "http://t.co/zYWO0bzt" => "#lectures",
                        "http://t.co/Oh9NKXAC" => "#lectures-2",
                        "http://t.co/f4C3mg38" => "#assignments-3"
                    );
                    foreach ( $twitter as $twitt ) {
                        
                        if( preg_match( '/(@|#|\.\.\.)/', $twitt->text ) ){ //skip mentions, hash tags and big twits
                            continue;
                        }
                        if( $counter++ >= 1 ){
                            break;
                        }
                        $twitt->text = preg_replace( '#(http\://[a-z0-9.-]++/[a-zA-Z0-9./+?=&\(\)_;\#~%-]*)#', '<a href="\1">\1</a>', $twitt->text );
                        foreach( $url_mapping as $from => $to ){
                            $twitt->text = preg_replace( "#$from#", $to, $twitt->text );
                        }
                        ?>
                        <li>
                            <span class="date"><?php echo date( "d/n", strtotime( $twitt->created_at) + 2 * 3600 ) ?></span>
                            <span class="text"><?php echo $twitt->text ?></span>
                        </li>
                        <?php
                    }
                ?>
                </ul>
                <h2>Ωράριο των σεμιναρίων</h2>
                <p>
                    Οι διαλέξεις θα γίνονται κάθε Δευτέρα και Τετάρτη, 19:00-21:00<br />
                    στο <a href="http://maps.google.com/maps/ms?ie=&amp;TF&amp;msa=0&amp;msid=206490038609743910214.0004ae8efcf533a6caca0">μικρό αμφιθέατρο του πολυτεχνείου.</a> <a class="qm" href="#faq-2">(?)</a>
                </p>
            </div>
        </div>
        <div class="navcont">
            <ul class="nav">
                <li><a href="#about" class="about" title="Οργανωτικά"></a></li>
                <li><a href="#reference" class="reference" title="Βιβλιογραφία"></a></li>
                <li><a href="#lectures-<?php
                    echo $currentpresentation;
                ?>" class="lectures" title="Διαλέξεις"></a></li>
                <li><a href="#assignments-<?php
                    echo $currentassignment;
                ?>" class="assignments" title="Εργασίες"></a></li>
                <li><a href="#faq" class="faq" title="FAQ"></a></li>
                <li><a href="https://www.thmmy.gr/smf/index.php?topic=47229.0" class="forum" title="Thmmy.gr"></a></li>
                <li><a href="https://www.facebook.com/WebseminarTHMMY" class="facebook" title="Facebook"></a></li>
                <li><a href="https://twitter.com/webseminarTHMMY" class="twitter" title="Twitter"></a></li>
                <li><a href="http://www.youtube.com/user/webseminarTHMMY" class="youtube" title="YouTube"></a></li>
            </ul>
        </div>
        <?php
            $bbs = array( 
                'about', 
                'reference', 
                'lectures', 
                'assignments', 
                'faq' 
            );
            foreach( $bbs as $bb ){
                ?><div class="blackboard <?php echo $bb; ?>">
                    <div class="content">
                        <a href="#" class="exit"></a>
                        <div class="scroll">
                        <?php
                            echo file_get_contents( "$bb.html" );
                        ?>
                        </div>
                    </div>
                </div><?php
            }
        ?>
        <div class="nightoverlay"></div>
        <div class="sky"></div>
        <div class="ground"></div>
        <div class="doorlight"></div>
        <div class="icons">
            <img class="sun" src="images/icons/sun.png" alt="Sun" />
            <img class="moon" src="images/icons/half-moon.png" alt="Moon" />
            <div class="stars"></div>
            <div class="clouds"><?php
                $clouds = array(
                '<img class="travel cloud1 a9 d4" src="images/clouds/cloud7.png" alt="cloud" />',
                '<img class="travel cloud2 a11 d1" src="images/clouds/cloud7.png" alt="cloud" />',
                '<img class="travel cloud3 a6 d1" src="images/clouds/cloud4.png" alt="cloud" />',
                '<img class="travel cloud4 a8 d1" src="images/clouds/cloud4.png" alt="cloud" />',
                '<img class="travel cloud5 a12 d7" src="images/clouds/cloud5.png" alt="cloud" />',
                '<img class="travel cloud6 a21 d7" src="images/clouds/cloud6.png" alt="cloud" />',
                '<img class="travel cloud7 a17 d16" src="images/clouds/cloud6.png" alt="cloud" />',
                '<img class="travel cloud8 a19 d13" src="images/clouds/cloud5.png" alt="cloud" />',
                '<img class="travel cloud9 a14 d7" src="images/clouds/cloud7.png" alt="cloud" />' );
                shuffle( $clouds );
                for( $i = 0; $i < 4; ++$i ){
                    echo $clouds[ $i ];
                }
                ?></div>
            <div class="smogs"></div>
        </div>
        
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery.overscroll.min.js"></script>
        <script type="text/javascript" src="js/global.js?<?php
            echo $jsversion;
        ?>"></script>
        <script type="text/javascript">var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-25785515-1']);_gaq.push(['_trackPageview', location.pathname + location.search + location.hash]);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script>
        <script type="text/javascript"><?php
        if( $h == $sunrise[ 0 ] && $m < $sunrise[ 1 ] ){
            ?>setTimeout( function(){ $( 'body' ).removeClass( 'night' ); }, <?php
            echo ( ( $sunrise[ 1 ] - $m ) * 60 - $s ) * 1000;
            ?> );<?php
        }
        if( $h == $sunset[ 0 ] && $m < $sunset[ 1 ] ){
            ?>setTimeout( function(){ $( 'body' ).addClass( 'night' ); }, <?php
            echo ( ( $sunset[ 1 ] - $m ) * 60 - $s ) * 1000;
            ?> );<?php
        }
        ?></script>
    </body>
</html>
