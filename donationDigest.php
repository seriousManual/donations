<?php

error_reporting(E_ALL);

require_once('./classes.php');

$payKind = $_POST['payKind'];

if ($payKind == 'SEPA') {
    sendMail($_REQUEST);
} else if ($payKind == 'SOU') {
    runExternal(new SofortDestination());
} else if ($payKind == 'PP') {
    runExternal(new PPDestination());
}

echo "Vielen Dank für Ihren Einsatz!";

function runExternal(Destination $destination) {
    $destination->setAmount($_POST['amount']);
    $destination->setPurpose($_POST['purpose']);

    $url = $destination->getUrl();
    $params = http_build_query($destination->getParams());
    $completeUrl = $url . '?' . $params;

    header('Location: ' . $completeUrl);
}

function sendMail(Array $data) {
    $text = '';

    foreach ($data as $key => $value) {
        $text .= $key . ": \n";
        $text .= $value;
        $text .= "\n\n";
    }

    mail('f.ernst@nehemia.org', 'spende', $text);
}