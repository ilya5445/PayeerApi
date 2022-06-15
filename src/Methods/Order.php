<?php

namespace Ilya5445\PayeerApi\Methods;

trait Order {

    /**
     * Получение доступных ордеров по указанным парам.
     *
     * @param string $pair
     * @return void
     */
    public function orders(string $pair) {

        if (!$pair) {
            throw new \InvalidArgumentException(
                'Parameter `pair` must be set'
            );
        }

        return $this->request->makeRequest(
            self::API_URL_ORDERS,
            'POST',
            [
                'pair' => $pair
            ]
        );
    }

    /**
     * Создание ордера поддерживаемых типов: лимит, маркет, стоп-лимит.
     *
     * @param array $params
     * @return void
     */
    public function orderCreate(array $params) {
        return $this->request->makeRequest(
            self::API_URL_ORDER_CREATE,
            'POST',
            [
                'pair' => $params['pair'] ?? '',
                'type' => $params['type'] ?? '',
                'action' => $params['action'] ?? '',
                'amount' => isset($params['amount']) && $params['amount'] ? floatval($params['amount']) : '',
                'price' => isset($params['price']) && $params['price'] ? floatval($params['price']) : '',
                'stop_price' => isset($params['stop_price']) && $params['stop_price'] ? floatval($params['stop_price']) : ''
            ]
        );
    }

    /**
     * Получение подробной информации о своем ордере по его id.
     *
     * @param integer $order_id
     * @return void
     */
    public function orderStatus(int $order_id) {

        if (!$order_id) {
            throw new \InvalidArgumentException(
                'Parameter `order_id` must be set'
            );
        }

        return $this->request->makeRequest(
            self::API_URL_ORDER_STATUS,
            'POST',
            [
                'order_id' => $order_id,
            ]
        );
    }

    /**
     * Отмена своего ордера по его id.
     *
     * @param integer $order_id
     * @return void
     */
    public function orderCancel(int $order_id) {

        if (!$order_id) {
            throw new \InvalidArgumentException(
                'Parameter `order_id` must be set'
            );
        }

        return $this->request->makeRequest(
            self::API_URL_ORDER_CANCEL,
            'POST',
            [
                'order_id' => $order_id,
            ]
        );
    }

    /**
     * Отмена всех/части своих ордеров.
     *
     * @param array $params
     * @return void
     */
    public function ordersCancel(array $params = []) {
        return $this->request->makeRequest(
            self::API_URL_ORDERS_CANCEL,
            'POST',
            !empty($params) ? [
                'pair' => $params['pair'] ?? '',
                'action' => $params['action'] ?? '',
            ] : []
        );
    }

}