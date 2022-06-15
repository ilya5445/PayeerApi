<?php

namespace Ilya5445\PayeerApi\Methods;

trait Account {

    /**
     * Получение баланса пользователя.
     *
     * @return void
     */
    public function account() {
        return $this->request->makeRequest(
            self::API_URL_ACCOUNT,
            'POST',
        );
    }

    /**
     * Получение своих открытых ордеров с воможностью фильтрации.
     *
     * @param array $params
     * @return void
     */
    public function accountOrders(array $params = []) {
        return $this->request->makeRequest(
            self::API_URL_MY_ORDERS,
            'POST',
            !empty($params) ? [
                'pair' => $params['pair'] ?? '',
                'action' => $params['action'] ?? '',
            ] : []
        );
    }

    /**
     * Получение истории своих ордеров с возможностью фильтрации и постраничной загрузки.
     *
     * @param array $params
     * @return void
     */
    public function accountHistory(array $params = []) {
        return $this->request->makeRequest(
            self::API_URL_MY_HISTORY,
            'POST',
            !empty($params) ? [
                'pair' => $params['pair'] ?? '',
                'action' => $params['action'] ?? '',
                'status' => $params['status'] ?? '',
                'date_from' => isset($params['date_from']) && $params['date_from'] ? strtotime($params['date_from']) : '',
                'date_to' => isset($params['date_to']) && $params['date_to'] ? strtotime($params['date_to']) : '',
                'append' => isset($params['append']) && $params['append'] ? intval($params['append']) : '',
                'limit' => isset($params['limit']) && $params['limit'] ? intval($params['limit']) : '',
            ] : []
        );
    }

    /**
     * Получение своих сделок с возможностью фильтрации и постраничной загрузки.
     *
     * @param array $params
     * @return void
     */
    public function accountTrades(array $params = []) {
        return $this->request->makeRequest(
            self::API_URL_MY_TRADES,
            'POST',
            !empty($params) ? [
                'pair' => $params['pair'] ?? '',
                'action' => $params['action'] ?? '',
                'date_from' => isset($params['date_from']) && $params['date_from'] ? strtotime($params['date_from']) : '',
                'date_to' => isset($params['date_to']) && $params['date_to'] ? strtotime($params['date_to']) : '',
                'append' => isset($params['append']) && $params['append'] ? intval($params['append']) : '',
                'limit' => isset($params['limit']) && $params['limit'] ? intval($params['limit']) : '',
            ] : []
        );
    }

}