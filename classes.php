<?php

class PPDestination extends Destination {
    function __construct() {
        parent::__construct('https://www.paypal.com/cgi-bin/webscr');

        $this
            ->addParam('cmd', '_s-xclick')
            ->addParam('hosted_button_id', 'CZ2XGPARJ7BDN');
    }

    function setAmount($amount) {}
    function setPurpose($amount) {}
}

class SofortDestination extends Destination {
    function __construct() {
        parent::__construct('https://www.sofort.com/payment/start');

        $this
            ->addParam('user_id', '105003')
            ->addParam('project_id', '215689')
            ->addParam('reason_1', 'Spende Nehemia');
    }

    function setPurpose($purpose) {
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
    abstract function setPurpose($purpose);

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