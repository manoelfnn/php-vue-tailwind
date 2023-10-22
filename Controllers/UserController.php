<?php

include "../Services/ContactsService.php";
include "../Data/RandomDataAPI.php";

header('Content-Type: application/json; charset=utf-8');

$randomDataAPI = new RandomDataAPI();

$contact = new ContactsService($randomDataAPI);
echo json_encode($contact->getUser(100));