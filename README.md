# API-клиент для работы с сервисом Payeer

Пример использования:

```
require_once 'vendor/autoload.php';

use Ilya5445\PayeerApi\Client;

$api_id = '';
$secret_key = '';

$client = new Client($api_id, $secret_key);

$client->time();
$client->info('BTC_USD');
$client->ticker();

$client->orderCreate(
    [
        'pair' => 'BTC_USD', 
        'type' => 'limit', 
        'action' => 'buy', 
        'amount' => '10', 
        'price' => 0.5
    ]
)

```