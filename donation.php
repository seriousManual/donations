<?php
    require_once('classes.php');

    $purposes = Array(
        'P1' => 'Spende ABC',
        'P2' => 'Spende XYZ'
    );

    $purposeMarker = isset($_GET['purpose']) ? $_GET['purpose'] : '';
    $purpose = Purposes::getPurposeByMarker($purposeMarker) ? $purposeMarker : '';
?>

<html>
<head>
    <title>donation</title>

    <meta charset="utf-8"/>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js" type="text/javascript"></script>

    <style type="text/css">
        #sepaDetails {
            display: none;
        }

        #receipt {
            display: none;
        }

        body {
            font-family: Arial, Helvetica, sans-serif
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function() {
            $('input[name=payKind]').on('change', function(ev) {
                var type = $(this).val();

                if (type == 'SEPA') {
                    $('#sepaDetails').show();
                } else {
                    $('#sepaDetails').hide();
                }
            });

            $('input[name=receipt]').on('change', function(ev) {
                if ( $(this).val() == '1') {
                    $('#receipt').show();
                } else {
                    $('#receipt').hide();
                }
            });
        });
    </script>
</head>

<body>
<p>&nbsp;</p>
<p><strong>Danke, dass Sie die Arbeit von AVC finanziell unterst&uuml;tzen m&ouml;chten. <br /></strong></p>
<p>Wenn Sie eine &Uuml;berweisung t&auml;tigen m&ouml;chten, so verwenden Sie bitte die folgende Bankverbindung:</p>
<p>Kontoinhaber: AVC</p>
<p>IBAN: DE37 5206 0410 0004 1130 12<br />BIC: &nbsp; GENODEF1EK1</p>
<p>&nbsp;</p>
<p><strong>F&uuml;r eine Online-&Uuml;berweisung machen Sie bitte die entstprechenden Angaben und w&auml;hlen Sie die Zahlungsmethode.</strong></p>
<form action="donationDigest.php" method="post" target="_blank">
    <p><label for="name" style="float: left; width: 120px;">Name:</label> <input name="name" size="20" type="text" style="height: 16pt;" /></p>
    <p><label for="vorname" style="float: left; width: 120px;">Vorname:</label> <input name="vorname" size="20" type="text" style="height: 16pt;" /></p>
    <p><label for="mail" style="float: left; width: 120px;">E-Mail:</label> <input name="mail" size="20" type="text" style="height: 16pt;" /></p>
    <p><label for="purpose1" style="float: left; width: 120px;">Spendenzweck:</label> <input name="purpose1" size="20" type="text" style="height: 16pt;" /></p>
    <p>&nbsp;</p>
    <p>Spendenquittung erw&uuml;nscht?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ja <input name="receipt" type="radio" value="1" /> nein <input checked="checked" name="receipt" type="radio" value="0" /></p>
    <div id="receipt">
        <p><label for="street" style="float: left; width: 120px;">Stra&szlig;e:</label> <input name="street" size="20" type="text" style="height: 16pt;" /></p>
        <p><label for="plz" style="float: left; width: 120px;">PLZ:</label> <input name="plz" size="20" type="text" style="height: 16pt;" /></p>
        <p><label for="city" style="float: left; width: 120px;">Stra&szlig;e</label> <input name="city" size="20" type="text" style="height: 16pt;" /></p>
    </div>
    <p><label for="amount" style="float: left; width: 120px;">Betrag:</label> <input name="amount" size="20" type="text" style="height: 16pt;" /></p>
    <p><strong>Zahlungsmethode:</strong></p>
    <label>SEPA-Lastschrift: <input  name="payKind" type="radio" value="SEPA" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
    <label>PayPal: <input  name="payKind" type="radio" value="PP" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
    <label>Sofort&uuml;berweisung: <input checked="checked" name="payKind" type="radio" value="SOU" /></label>
    <br />
    <br />
    <div id="sepaDetails">
        <p><label for="frequency" style="float: left; width: 120px;">Frequenz</label>
            <select name="frequency" width="20" >
                <option checked="checked" value="oneTime">einmalig</option>
                <option value="monthly">monatlich</option>
                <option value="quarterly">viertelj&auml;hrlich</option>
                <option value="yearly">j&auml;hrlich</option>
            </select></p>
            <p><label for="iban" style="float: left; width: 120px;">IBAN:</label> <input name="name" size="40" type="text" style="height: 16pt;" /></p>
        <label><input name="authorization" type="checkbox" /> Ich erteile Ihnen hiermit das Mandat, den Spendenbetrag von meinem Konto einzuziehen. Ich werde meine Bank entsprechend unterrichten.</label> <br /><br /></div>
    <div>&nbsp;</div>

    <input type="hidden" name="purpose2" value="<?php echo $purpose; ?>">

    <input type="submit" value="Absenden" /></form>
</body>
</html>
