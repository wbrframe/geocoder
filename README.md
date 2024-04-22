# Geocoder 

The microservice that incorporates functionality for obtaining information about coordinates, IP addresses, etc.

### Development

    docker compose up -d --build
    docker compose exec php composer install

### Requirements 🧐

* PHP 7,8
* Symfony 7
* Redis

### IP-address

---

Obtaining basic information:

    GET /ip-address/{ipAddress}/info


> [!IMPORTANT]
> The {ipAddress} parameter only supports IPv4.

The basic information includes two parameters: country code and name in the 'en' locale in ISO 3166 format.

Example response:

```json
{
    "ip": "194.213.105.94",
    "country_code": "UA",
    "country_name": "Ukraine",
}
```

The service https://www.ip2location.io/ is used as the geocoder.

To connect to this geocoder, first register on their website and obtain a token through personal account.

The token needs to be set in the .env files under the parameter `IP2LOCATION_TOKEN`.

500 requests per day are available for free.

### IP-address: custom provider

---

The new provider must implement the [IpAddressInfoProviderInterface](src/Service/IpAddress/IpAddressInfoProviderInterface.php). 

Additionally, it is necessary to change the alias in [IpAddressInfoProviderCompilerPass](src/DependencyInjection/CompilerPass/IpAddressInfoProviderCompilerPass.php)

### IP-address: caching

---
The information about the IP is cached in Redis for the time specified in `REDIS_LIFETIME_IN_SECONDS`.

