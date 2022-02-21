<?php
session_start();
$con = mysqli_connect('localhost','root','');
$db = mysqli_select_db($con,'events_around_db');
?>