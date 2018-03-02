<?php
  define('WEATHER_APIKEY', '');
  define('WEATHER_LOCATION', '51.508530, -0.076132');
  define('WEATHER_JSON', 'data/weather.json');
  
  function getWeather()
  {
    $cutoff = time() - 300;
    $data = null;
    if (!file_exists(WEATHER_JSON) || (filemtime(WEATHER_JSON) < $cutoff)) {
      $data = file_get_contents('https://api.darksky.net/forecast/' . WEATHER_APIKEY . '/' . urlencode(WEATHER_LOCATION) . '?units=uk2');
      file_put_contents(WEATHER_JSON, $data);
    } elseif (file_exists(WEATHER_JSON)) {
      $data = file_get_contents(WEATHER_JSON);
    }
    return json_decode($data);
  }
  
  $weather = getWeather();
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode($weather);
    die();
  }
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Weather</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> 
        <link rel="stylesheet" href="styles.css">
        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script
          src="https://code.jquery.com/jquery-3.3.1.min.js"
          integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
          crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
        <script src="scripts.js"></script>
    </head>
    <body>
        <div id="footer">
            <div id="clock"></div>
            <div id="summary"><?php echo htmlentities($weather->minutely->summary); ?></div>
            <div id="temperature">
                <?php echo htmlentities(round($weather->currently->temperature, 0)); ?>&deg;C
            </div>
            <div id="date"></div>
            <div id="text">Weather powered by DarkSky, music from Pretzel</div>
            <div id="feels">Feels <?php echo htmlentities(round($weather->currently->apparentTemperature, 0)); ?>&deg;C</span></div>
        </div>
    </body>
</html>

