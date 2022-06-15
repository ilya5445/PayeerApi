<?php

namespace Ilya5445\PayeerApi;

use Ilya5445\PayeerApi\Http\Request;
use Ilya5445\PayeerApi\Methods\{PublicMethods, Order, Account};

class Client {
    
    use PublicMethods, Order, Account;

    const DEFAULT_URL = "https://payeer.com/api/trade/";

    const API_URL_TIME = "time";
    const API_URL_INFO = "info";
    const API_URL_TICKER = "ticker";
    const API_URL_TRADES = "trades";
    const API_URL_ORDERS = "orders";

    const API_URL_ACCOUNT = "account";
    const API_URL_ORDER_CREATE = "order_create";
    const API_URL_ORDER_STATUS = "order_status";
    const API_URL_ORDER_CANCEL = "order_cancel";
    const API_URL_ORDERS_CANCEL = "orders_cancel";

    const API_URL_MY_ORDERS = "my_orders";
    const API_URL_MY_HISTORY = "my_history";
    const API_URL_MY_TRADES = "my_trades";

    private $request;
    
    public function __construct($api_id = null, $secret_key = null) {
        $this->request = new Request(self::DEFAULT_URL, $api_id, $secret_key);
    }

}