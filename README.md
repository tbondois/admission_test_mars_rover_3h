ADMISSION TEST
=================


INSTRUCTIONS
-----------------



PRÉREQUIS
-----------------

- PHP >= 7.4 (devrait fonctionner avec PHP 8)

UTILISATION
-----------------

```
composer install
symfony server:start --no-tls --port=8000 -d
```

Instructions have to be sent in Json format in HTTP POSt, throught POSTMAN or Curl

Here's an example of format :

````

curl -X POST http://127.0.0.1:8000/explore -H "Content-Type: application/json" -H "accept: application/json" -d "
{
    "plateau": "9 9",
    "rovers": [
        {
            "position": "1 1 N",
            "moveset": "MMMLMM"
        },
        {
            "position": "7 7",
            "moveset": "MMMRMML"
        },
        {
            "position": "7 7",
            "moveset": "MMRMMLMMM"
        }
    ]
}
"
````



NOTES
-----------------


