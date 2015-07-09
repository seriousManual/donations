<?php

    error_reporting(E_ALL);

    $ppHandler = new Destination('https://www.paypal.com/cgi-bin/webscr');
    $ppHandler
        ->addParam('cmd', '_s-xclick')
        ->addParam('hosted_button_id', 'CZ2XGPARJ7BDN');

    $sofortHandler = new Destination('https://www.sofort.com/payment/start');
    $sofortHandler
        ->addParam('user_id', '105003')
        ->addParam('project_id', '215689')
        ->addParam('reason_1', 'Test-Überweisung')
        ->addParam('reason_2', '1');


    $destinations = Array(
        'PP' => $ppHandler,
        'SOU' => $sofortHandler
    );

    $payKind = $_POST['payKind'];

    if ($payKind == 'SEPA') {
        sendMail($_REQUEST);
    } else if ($payKind == 'SOU' || $payKind == 'PP') {
        sendMail($_REQUEST);
        runExternal($destinations[$payKind]);
    } else {
        header('Location:donation.html');
    }

    function runExternal(Destination $destination) {
        $destination->addParam('amount', $_POST['amount']);
        $url = $destination->getUrl();
        $params = http_build_query($destination->getParams());
        $completeUrl = $url . '?' . $params;

        header('Location: ' . $completeUrl);
    }

    function sendMail(Array $data) {
        $text = '';

        foreach($data as $key => $value) {
            $text .= $key . ": \n";
            $text .= $value;
            $text .= "\n\n";
        }

        mail('mnlrnst@gmail.com', 'spende', $text);
        header('Location:donation.html');
    }

    class Destination {
        private $url;
        private $params = Array();

        function __construct ($url) {
            $this->url = $url;
        }

        /**
         * @param $key
         * @param $value
         *
         * @return Destination
         */
        function addParam($key, $value) {
            $this->params[$key] = $value;

            return $this;
        }

        /**
         * @return array
         */
        function getParams() {
            return $this->params;
        }

        /**
         * @return mixed
         */
        public function getUrl () {
            return $this->url;
        }

    }