<?php

    $ppHandler = new Handler('https://www.paypal.com/cgi-bin/webscr');
    $ppHandler
        ->addParam('cmd', '_s-xclick')
        ->addParam('hosted_button_id', 'CZ2XGPARJ7BDN');

    $sofortHandler = new Handler('https://www.sofort.com/payment/start');
    $sofortHandler
        ->addParam('user_id', '105003')
        ->addParam('project_id', '215689')
        ->addParam('reason_1', 'Test-Überweisung')
        ->addParam('reason_2', '1');


    $handlers = [
        'PP' => $ppHandler,
        'SOU' => $sofortHandler
    ];

    $type = $_POST['payKind'];
    if (!isset($handlers[$type])) {
        header('Location: donation.html');
    }

    $handler = $handlers[$type];

    $url = $handler->getUrl();
    $params = http_build_query($handler->getParams());
    $completeUrl = $url . '?' . $params;

    header('Location: ' . $completeUrl);



    class Handler {
        private $url;
        private $params = [];

        function __construct ($url) {
            $this->url = $url;
        }

        /**
         * @param $key
         * @param $value
         *
         * @return Handler
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