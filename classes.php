<?php

class Purposes {
    private static $purposes = Array(
        'P1' => 'Spende ABC',
        'P2' => 'Spende XYZ'
    );

    static $DEFAULTPURPOSE = 'Spende allgemein';

    static function getPurposeByMarker($marker) {
        if (isset(self::$purposes[$marker])) {
            return self::$purposes[$marker];
        }

        return null;
    }
}

class PPDestination extends Destination {
    function __construct() {
        parent::__construct('https://www.paypal.com/cgi-bin/webscr');

        $this
            ->addParam('cmd', '_donations')
            ->addParam('business', '9ZF86AF36GG7S')
            ->addParam('item_name', 'Projekt')
            ->addParam('item_number', 'Test')
            ->addParam('currency_code', 'EUR');
    }

    function setAmount($amount) {
        $this->addParam('amount', $amount);
    }
    function setPurpose1($purpose) {}
    function setPurpose2($purpose) {}
}

class SofortDestination extends Destination {
    function __construct() {
        parent::__construct('https://www.sofort.com/payment/start');

        $this
            ->addParam('user_id', '113524')
            ->addParam('project_id', '235565');
    }

    function setPurpose1($purpose) {
        $this->addParam('reason_1', $purpose);
    }

    function setPurpose2($purpose) {
        $this->addParam('reason_2', $purpose);
    }

    function setAmount($amount) {
        $this->addParam('amount', $amount);
    }
}

abstract class Destination {
    private $url;
    private $params = Array();

    abstract function setAmount($amount);
    abstract function setPurpose1($purpose);
    abstract function setPurpose2($purpose);

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
