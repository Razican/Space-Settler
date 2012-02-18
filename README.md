Requisitos Mínimos
==================

* Se recomienda siempre usar UTF-8 en su variante *general_ci* en la base de datos y en la codificación de todos los archivos del juego.
* Necesario **PHP >= 5.2.0**
* Necesario **MySQL >= 4.1**
* También soporta MySQLi, MS SQL, Postgres, Oracle, SQLite y ODBC.

* El programa ofrecerá un poco más de exactitud al usar un sistema operativo de 64 bits, ya que se ueden usar números más grandes.

Instalación:
============

* El programa está preparado para instalarse en localhost/space_settler
* Necesita habilitado el mod_rewrite de Apache, y AllowOverride All en el directorio de instalación.
* Para cambiar los parámetros de la base de datos se debe editar el archivo /space-settler/config/database.php
* No se debe cambiar el prefijo de las tablas, ya que está preparado para sps_
* El archivo SQL hay que importarlo a la base de datos.
* Si se quiere usar sin cambiar nada, se debe usar una base de datos con usuario root y contraseña 12345.
* Para cambiar la ruta del programa, se debe cambiar el archivo /space-settler/config/config.php y el .htaccess

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
* En el overal_helper solo se incluirán las funciones de cálculo de gravedad y volumen, de momento.
* Habrá un a media de entre 8 y 10 planetas en el sistema solar. con una probabilidad del 10% de que en una posición dada no haya planeta.
En una versión posterior esos huevos tendrán una probabilidad del 50% de contener un cinturon de asteroides.
* Este algoritmo creará una media de 100.000 estrellas y 76.400 planetas por galaxia. No obstante, en un futuro
se añadirán más planetas pequeños al final de cada sistema solar, sin cumplir la ley de Titius-Bode, y se crearán cinturones de asteroides.
Con las lunas pasará lo mismo.
* Falta para un futuro la temperatura superficial del planeta/luna.

Cosas por hacer:
----------------

* Que en la creación de estrellas se cree la matriz $this->star_p.
* Cálculo de distancias con el nuevo algoritmo.
* Satélites.

Más Datos
---------

El sistema de plugins será adaptado a CodeIgniter, de manera que se usen librerías. Pero se debe avanzar más en el desarrollo.

Cosas por hacer
---------------

* Crear una función reset_password más completa, para que el controlador haga algo como *if reset_password message else message*.
* El registro, si no se envía el email, muestra un mensaje en el que el link te devuelve al registro, en lugar de a la página principal.
Hay que tener en cuenta que el usuario ya se ha registrado, así que no debería volver al registro.

Distancias y velocidades:
-------------------------

Para calcular las distancias entre estrellas, planetas y galaxias, se usarán las siguientes fórmulas.
Hay que tener en cuenta que con el mínimo de tecnología para viajar se considera que se viaja a la velocidad de la luz: 1UA-> 499s reales

**Distancias entre dos planetas del mismo sistema:**

* Para calcular la distancia entre planeta_origen y planeta_destino se usará la siguiente fórmula:
|(distancia del planeta_origen a la estrella)-(distancia del planeta_destino a la estrella)|

**Distancias entre estrellas cercanas**

* La fórmula que se usará a la hora de crear un sistema cercano será la siguiente: distancia = raiz_quinta{(ID_sistema_origen-ID_sistema_destino)^2}*aleatorio(40,45)/10 (en años luz)

**Distancias entre galaxias cercanas**

* La fórmula que se usará a la hora de crear una galaxia cercana será la siguiente: distancia = raiz_cuarta{|(ID_galaxia_origen-ID_galaxia_destino)^3|}*aleatorio(225,250)/100 (en millones de años luz)

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

* Masa de un satélite: planeta doble ? 0.1 - 0.5 : 1E-11 - 0.015;
* Si planeta doble, distancia mínima: r*(2M/m)^(1/3) //Límite de Roche, donde M es la masa del planeta,
m la del satélite y r el rádio del satélite.

Tiempo:
-------

Para que el juego sea "jugable", se debe comprimir el tiempo. La tasa de compresión será 1:100.000
(1s en el juego equivale a 100,000s en la realidad). Con esto, la luz tardaría lo siguiente:
* Del sol a la Tierra: Real -> 499 segundos, en el juego -> 0.0049 segundos (0).
* Del sol a la estrella más cercana: Real -> 133,081,920 segundos (4.22 años), en el juego -> 1330.8192 segundos (1331) (22m 11s).
* Del sol a la galaxia más cercana: Real -> 3.3638E+12 segundos, en el juego -> 33638400 segundos (33638400) (1 año 24 días 8h).

* NOTA: Se usará la función time, así que se redondeará al segundo más cercano.
* Será la velocidad de transmisión de mensajes, por ejemplo.
* Será la velocidad máxima que podrá alcanzar la materia, aunque es muy probable que se desarrollen
tecnologías de motores Warp, que permitirían viajes superlumínicos, comprimiendo el espacio.
* Es por esto último que se considera que dos galaxias no tendrán interacción entre ellas, aunque podría haber mensajes entre ellas, pero tardarían muchísimo en llegar.
Se considerarían casi dos universos separados. También es verdad que se podrá usar tecnología subespacial para las comunicaciones, que permitiran hacerlas en un muy corto tiempo, casi equiparable
a la comunicación con una estrella de la misma galaxia.

Sistema de Soporte:
-------------------

Se ha creado un nuevo sistema de soporte, en el que se deben especificar algunas cosas:

**Tipo de incidencia**:
* 1->Error/Bug
* 2->Mejora
* 3->Nueva Característica/Proposición

**Estado de la incidencia**:
* 1->Nueva
* 2->Aceptada (Proposición/Mejora)
* 3->Confirmada (Error)
* 4->En proceso
* 5->Duplicado
* 6->No es una incidencia (Error)
* 7->No se implantará (Proposición/Mejora)
* 8->Implantado (Proposición/Mejora)
* 9->Solucionado (Error)