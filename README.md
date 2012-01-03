Requisitos Mínimos
==================

* Se recomienda siempre usar UTF-8 en su variante *general_ci* en la base de datos y en la codificación de todos los archivos del juego.
* Necesario **PHP >= 5.2.0**
* Necesario **MySQL >= 4.1**
* También soporta MySQLi, MS SQL, Postgres, Oracle, SQLite y ODBC.

Información de cambios:
=======================

Nuevo Algoritmo:
----------------

Dado que actualmente el Big Bang no tiene un algoritmo sólido, y es un problema para el cálculo de unidades etc,
se creará un nuevo algoritmo con las siguientes bases, para que todo funcione mejor:

* Se usará el sistema internacional de unidades (IS).
* La base de datos contendrá los parámetros principales de los objetos:
	* Incluso aunque los calculos como los de la densidad se puedan hacer a posteriori, se incluirán para ahorrar
	recursos.
	* La densidad no será incluida en la tabla de estrellas
* En el oveal_helper solo se incluirán las funciones de cálculo de gravedad y volumen, de momento.

Cambios en el Juego
-------------------

* Todos los nombres de usuario/alianza/planeta tendrán una máxima longitud de 20 caracteres. Los emails de 50, las webs de 100 y las imágenes externas de 150.
* Se implanta el uso de Sha-1 en vez de Md5.
* Las contraseñas deberán tener un mínimo de 6 carateres, configurable en el futuro desde el panel de administración.
* Se ha añadido un nuevo campo en la tabla planets: distance, ahora, si el planeta es 0, será el sol. Con una nueva variable, luminosidad, todavía por implantar.
* Si en la tabla planets, en id_owner es 0, es un planeta no habitado.
* 1 Campo +/- 75 km de diametro. {10 - 3250} (diametro-> mt_rand((campos-1)*75, (campos+1)*75))
* Probabilidades: mt_rand(1,100) if (<=x && >y), siendo x el mínimo de porcentaje e y el máximo.

Más Datos
---------

El sistema de plugins será adaptado a CodeIgniter, de manera que se usen librerías. Pero se debe avanzar más en el desarrollo.

Cosas por hacer
---------------

Crear una función reset_password más completa, para que el controlador haga algo como *if reset_password message else message*.

Selección de Planetas en el Registro
------------------------------------

* Se seleccionan uno entre los planetas habitables

Distancias y velocidades:
-------------------------

Para calcular las distancias entre estrellas, planetas y galaxias, se usarán las siguientes fórmulas.
Hay que tener en cuenta que con el mínimo de tecnología para viajar se considera que se viaja a la velocidad de la luz: 1UA-> 499s reales

**Distancias entre dos planetas del mismo sistema:**

* Para calcular la distancia entre planeta_origen y planeta_destino se usará la siguiente fórmula:
|(distancia del planeta_origen a la estrella)-(distancia del planeta_destino a la estrella)|
* El tiempo que se tarda en recorrer la distancia (en UA) será el siguiente: distancia*499s +/- 1%, redondeado hacia arriba.

**Distancias entre estrellas cercanas**

* La fórmula que se usará a la hora de crear un sistema cercano será la siguiente: distancia = raiz_quinta{(ID_sistema_origen-ID_sistema_destino)^2}*aleatorio(40,45)/10 (en años luz)
* la velocidad será la misma, de manera que para viajar de un planeta de un sistema a otro, se tardará
distancia*63.200 +/- (distancia del planeta origen a su estrella) +/- (distancia del planeta destino a su estrella) +/- 1%, redondeado hacia arriba, en segundos.

**Distancias entre galaxias cercanas**

* La fórmula que se usará a la hora de crear una galaxia cercana será la siguiente: distancia = raiz_cuarta{|(ID_galaxia_origen-ID_galaxia_destino)^3|}*aleatorio(225,250)/100 (en millones de años luz)
* la velocidad será la misma, de manera que para viajar de un planeta de un sistema a otro, se tardará
distancia*63.200.000.000 +/- (distancia de la estrella a la estrella 1 de la galaxia)*63200 +/- (distancia del planeta origen a su estrella) +/- (distancia del planeta destino a su estrella), redondeado hacia arriba, en segundos.

Exploración del Universo:
-------------------------

Habrá una nueva sección de exploración, donde se podrá explorar el universo. En un principio se empezará con telescopios muy simples, pero se podrá invertir en telescopios muy potentes.
A la hora de explorar, habrá ciertas probabilidades de encontrar un planeta. El jugador decidirá explorar ciertas horas diarias, y según las siguientes fórmulas se podrán encontrar nuevos planetas,
que se podrá encontrar en la sección galaxia. El diámetro no estará corréctamente determinado, a no ser que se explore mucho, ni la distancia exacta.

* Planetas: distancia*10.000/diámetro(metros) +/- 5%, en horas, estando la distancia en UAs
	* En el caso en el que estén en otras estrellas o galaxias: distancia(años)*95.000.000/diametro(metros) +/- 5%
* Estrellas: distancia(años)/luminosidad(soles) +/- 5% en minutos. Se ha de considerar que la distancia en otra galaxia es la distancia a la galaxia +/- la distancia de la estrella a la estrella 1.
* Galaxias: distancia(millones de años)/(luminosidad media) +/- 5%, en minutos

Tamaños, masas...:
------------------

* Masa de un planeta: entre Mt/100000 y Mt*3.500.
* Masa de un satélite: planeta doble ? 0.1 - 0.5 : 1E-11 - 0.015;
* Si planeta doble, distancia mínima: r*(2M/m)^(1/3) //Límite de Roche, donde M es la masa del planeta,
m la del satélite y r el rádio del satélite.
* Radio de un planeta: entre 375.000m - 85.000.000m

Constantes:
-----------

* Luz: 299792458 m/s