<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$streets = array('Sadovaya', 'Moskovskaya', 'Kievskaya', 'Chehova');
echo json_encode($streets);
