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
- Laravel >= 4.x

<a name="install"></a>

## Install

Install the latest version by:

```
composer require inspector-apm/inspector-slim
```

### Register On Container

```php
$container->set('inspector', function () {
    $configuration = new \Inspector\Configuration('INSPECTOR_INGESTION_KEY');
	
	return new Inspector($configuration);
});
```

You can get an `INSPECTOR_INGESTION_KEY` creating a new project in your [Inspector](https://www.inspector.dev) account.

<a name="middleware"></a>

## Attach the Middleware
You can attach the middleware globally:

```php
$app->use(\Inspector\Slim\WebRequestMonitoring::class);
```

Or in specific routes:

```php
$app->get('/home', function () {
    
    // do something...
    
})->use(\Inspector\Slim\WebRequestMonitoring::class);
```

<a name="test"></a>

## Official documentation

**[Check out the official documentation](https://docs.inspector.dev/guides/slim)**

<a name="contribution"></a>

## Contributing

We encourage you to contribute to Inspector! Please check out the [Contribution Guidelines](CONTRIBUTING.md) about how to proceed. Join us!

## LICENSE

This package is licensed under the [MIT](LICENSE) license.
