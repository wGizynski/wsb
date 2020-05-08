<?php

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

$sql = ("SELECT Title, create_date, Contents  FROM news order by create_date limit 3");
$result = mysqli_query($link, $sql);

echo "<div class='col-md-6 offset-md-3' style='float: left; width: 50%; margin: 0em;  padding: 1em; max-height: 100%; '>
<div class='container mt-5 mb-5'>
  <h4>komunikaty</h4>
  <ul class='timeline'>";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_row($result)) {
        echo "<li>";
        foreach ($row as $field => $value) {
            if ($field == 0) {
                echo "<a href='#' href='#'> $value </a>";
            } else if ($field == 1) {
                echo "<a href='#' class='float-right'> $value </a>";
            } else if ($field == 2) {
                $substring = substr($value, 0, 200);
                echo "<p> $substring..... </p>";
            } else {
            };
        }
        echo "</li>";
    }
}

echo "</ul> </div> </div>";
