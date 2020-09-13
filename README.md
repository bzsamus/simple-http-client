# simple-http-client

## Usage

Using the client

```
use App\SimpleHttpClient\SimpleHttpClient;

$client = new SimpleHttpClient('http://example.com');

```
Setting headers

```
$client->setHeader([
	'Authorization' => 'Bearer xxxxxx',
	'Content-Type'	=> 'application/json',
]);
```
Get request

```
$client->get([
	'param1'	=> 'value1',
	'param2'	=> 'value2'
]);
```

Post request

```
$client->post([
	'name'	=> 'John Doe',
	'email'	=> 'johndoe@example.com',
	'url'	=> 'http://example.com'
]);
```

Options request

```
$client->options();
```

## Testing
Install phpunit

```
docker-compose run composer require --dev \
  phpunit/phpunit
```


Run unit test

```
docker-compose run phpunit tests
```
