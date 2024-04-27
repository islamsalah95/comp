<?php
function myQuery($query){
  $mysqli = new mysqli("localhost", "root", "", "techsupf_flex_time");
  $result = $mysqli->query($query);
  $result = $result->fetch_all(MYSQLI_ASSOC);
  return $result;
}


