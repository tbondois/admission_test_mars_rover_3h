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

Instructions have to be sent in Json format in HTTP POST, through POSTMAN or Curl :

Here's an example of format :

````
curl -X POST http://127.0.0.1:8000/explore -H "Content-Type: text/plain" -H "accept: text/plain" -d "
9 9
1 2 N
LMLMLMLMM
3 3 E
MMRMMRMRRM
0 0 N
MMMRMM
7 7 S
RRMMRMML
4 4 E
MMRMMLMMM
"
````



NOTES
-----------------


