<?php

    error_reporting(E_ALL);

    require_once('./classes.php');

    $payKind = $_POST['payKind'];
    $purposeMarker = $_POST['purpose2'];

    $purpose = Purposes::getPurposeByMarker($purposeMarker) ?: Purposes::$DEFAULTPURPOSE;

    $_POST['purpose1'] = str_replace('iran', 'morgenland', $_POST['purpose1']);
    $_POST['purpose1'] = str_replace('kuba', 'insel', $_POST['purpose1']);

    if ($payKind == 'SEPA') {
        sendMail($_POST);
        header("Location: donationThankyou.html");
    } else if ($payKind == 'SOU') {
        runExternal(new SofortDestination(), $purpose);
        sendMail($_POST);
    } else if ($payKind == 'PP') {
        runExternal(new PPDestination(), $purpose);
        sendMail($_POST);
    }

    function runExternal(Destination $destination, $purpose) {
        $destination->setAmount($_POST['amount']);
        $destination->setPurpose1($purpose);
        $destination->setPurpose2($_POST['purpose1']);

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
?>
