<!-- 

Code snippets courtesy of PHP Jabbers
https://www.phpjabbers.com/measuring-php-page-load-time-php17.html 

-->

<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
?>

<html>
  <head>
    
  </head>
  <body>
    <?php
    $time = microtime();
    $time = explode(' ', $time);
    $time = $time[1] + $time[0];
    $finish = $time;
    $total_time = round(($finish - $start), 4);
    
    echo 'Page generated in '.$total_time.' seconds.<br><br>';
    echo 'IP Address: '.$_SERVER['SERVER_ADDR'];
    ?>
  </body>
</html>