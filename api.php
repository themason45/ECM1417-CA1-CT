<?php
$request = $_SERVER['REQUEST_URI'];
$op = null;

// Match loc delete
include_once "support/Location.php";
preg_match("^/api/location/(?P<pk>[0-9]*)/delete$^", $request, $op, PREG_OFFSET_CAPTURE);
$pk = $op["pk"][0];
$location = Location::getLocationById($pk);

if ($location !== null) {
    $location->delete();
    print "Deleted";
    http_response_code(200);
}

