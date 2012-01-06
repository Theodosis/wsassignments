<!DOCTYPE html>
<?php
    $agent = $_SERVER[ "HTTP_USER_AGENT" ];
    if( !stristr( $agent, "WebKit" ) ) {
        echo "We currently support only WebKit enabled browsers. Plese, use Safari, Chrome or come back later.";
        exit();
    }
        
?>
<html lang="el">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Web Seminar</title>
    <link rel="stylesheet" href="resources/css/apple.css" />
    <link rel="stylesheet" href="resources/css/ws.css" />
    <style type="text/css">
        #loading{
            margin: auto;
            margin-top: 50px;
            background: rgba(0,0,0,0.6);
            color: white;
            font-weight: bold;
            border-radius: 10px;
            height: 100px;
            width: 100px;
            line-height: 100px;
            text-align: center;
        }
    </style>
    <link rel="apple-touch-startup-image" media="screen and (resolution: 326dpi)" href="resources/img/splash.640.png" />
    <link rel="apple-touch-startup-image" media="screen and (resolution: 163dpi)" href="resources/img/splash.320.png" />
    <link rel="apple-touch-icon" media="screen and (max-resolution: 325dpi)" href="resources/img/logo.57.png" />
    <link rel="apple-touch-icon" media="screen and (min-resolution: 326dpi)" href="resources/img/logo.114.png" />
    <link rel="apple-touch-icon-precomposed" media="screen and (max-resolution: 325dpi)" href="resources/img/logo.57.png" />
    <link rel="apple-touch-icon-precomposed" media="screen and (min-resolution: 326dpi)" href="resources/img/logo.114.png" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
</head>
<body>
    <div id="loading">Loading...</div>

    <script type="text/javascript" src="src/sencha-touch.js"></script>
    <script type="text/javascript" src="src/Models.js?1"></script>
    <script type="text/javascript" src="src/index.js?1"></script>
    <script type="text/javascript" src="src/App.js?1"></script>
    <script type="text/javascript" src="src/HtmlPage.js?1"></script>
    <script type="text/javascript" src="src/FAQ.js?1"></script>
    <script type="text/javascript" src="src/More.js?1"></script>
    <script type="text/javascript" src="src/VideoList.js?1"></script>
    <script type="text/javascript" src="src/TweetList.js?1"></script>
    <script type="text/javascript" src="src/LocationMap.js?1"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript">var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-25785515-1']);_gaq.push(['_trackPageview']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script>
</body>
</html> 
