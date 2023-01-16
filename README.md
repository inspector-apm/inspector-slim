# Inspector | Code Execution Monitoring Tool


Simple code execution monitoring for Slim framework based applications.

- [Requirements](#requirements)
- [Install](#install)
- [Middleware](#middleware)
- [Official Documentation](https://docs.inspector.dev/guides/slim)
- [Contribution Guidelines](#contribution)

<a name="requirements"></a>

## Requirements

- PHP >= 7.2.0
- Slim >= 4.x

<a name="install"></a>

## Install

Install the latest version by:

```
composer require inspector-apm/inspector-slim
```

### Register On Container

```php
$container->set('inspector', function () {
    $configuration = new \Inspector\Slim\Configuration('INSPECTOR_INGESTION_KEY');
	
	return new Inspector($configuration);
});
```

If you are using a Slim 4 skeleton you can add a new container definition in `app/dependencies.php` file:

```php
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        // Other services definitions...
    
        'inspector' => function (ContainerInterface $container) {
            $configuration = new \Inspector\Slim\Configuration('INSPECTOR_INGESTION_KEY');
            return new Inspector\Inspector($configuration);
        }
        
    ]);
}
```

You can get an `INSPECTOR_INGESTION_KEY` creating a new project in your [Inspector](https://www.inspector.dev) account.

<a name="middleware"></a>

## Attach the Middleware
You can attach the middleware globally:

```php
$app->add(\Inspector\Slim\WebRequestMonitoring::class);
```

Or in specific routes:

```php
$app->get('/home', function () {
    
    // do something...
    
})->add(\Inspector\Slim\WebRequestMonitoring::class);
```

<a name="segment"></a>

## Add Segment

You can add segments to the transaction's timeline from route functions:

```php
$app->get('/', function (Request $request, Response $response) {
    /*
     * Retrieve the inspector instance from the container.
     */
    $this->get('inspector')->addSegment(function () {
        sleep(1);
    }, 'sleep');
        
    return $response;
});
```

If your routes are managed by controller you have to inject the container in the controller constructor:

```php
namespace App\Controllers;


use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TestController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response)
    {
        $this->container->get('inspector')->addSegment(function () {
            sleep(1);
        }, 'sleep');

        $response->getBody()->write('Test route.');

        return $response;
    }
}
```

## Official documentation

**[Check out the official documentation](https://docs.inspector.dev/guides/slim)**

<a name="contribution"></a>

## Contributing

We encourage you to contribute to Inspector! Please check out the [Contribution Guidelines](CONTRIBUTING.md) about how to proceed. Join us!

## LICENSE

This package is licensed under the [MIT](LICENSE) license.
