<?php

include_once('sql.php');
$sql = new sql();

const allowedKeys = array(
    "Alzheimers",
    "Arthritis",
    "Asperger",
    "Blind",
    "Cancer",
    "Cerebral_palsy",
    "Dementia",
    "Diabetes_type_2",
    "Down_syndrome"
);

$result = array_diff(array_keys($_POST), allowedKeys);

if ($result) {
    die("Incorrect request.");
} else {
    // sort out this!!
    // print_r($_POST);
    echo json_encode($sql->getIllness($_POST));
    // echo json_encode($sql->test());
}
