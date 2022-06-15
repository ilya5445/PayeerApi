<?php

namespace Ilya5445\PayeerApi\Methods;

trait PublicMethods {

    /**
     * Проверка соединения, получение времени сервера.
     *
     * @return void
     */
    public function time() {
        return $this->request->makeRequest(
            self::API_URL_TIME,
            "GET"
        );
    }

    /**
     * Получение лимитов, доступных пар и их параметров.
     *
     * @param string|null $pair
     * @return void
     */
    public function info(string $pair = null) {

        $method = !$pair ? "GET" : 'POST';

        return $this->request->makeRequest(
            self::API_URL_INFO,
            $method,
            [
                'pair' => $pair
            ]
        );
    }

    /**
     * Получение статистики цен и их колебания за последние 24 часа.
     *
     * @param string|null $pair
     * @return void
     */
    public function ticker(string $pair = null) {

        $method = !$pair ? "GET" : 'POST';

        return $this->request->makeRequest(
            self::API_URL_TICKER,
            $method,
            [
                'pair' => $pair
            ]
        );
    }

    /**
     * Получение истории сделок по указанным парам.
     *
     * @param string $pair
     * @return void
     */
    public function trades(string $pair) {

        if (!$pair) {
            throw new \InvalidArgumentException(
                'Parameter `pair` must be set'
            );
        }

        return $this->request->makeRequest(
            self::API_URL_TRADES,
            'POST',
            [
                'pair' => $pair
            ]
        );
    }

}