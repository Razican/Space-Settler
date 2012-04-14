Requisitos Mínimos
==================

* Se recomienda siempre usar UTF-8 en su variante *general_ci* en la base de datos y en la codificación de todos los archivos del juego.
* Necesario **PHP >= 5.3.0**.
* Soporta MySQL (5.1+), MySQLi, MS SQL, SQLSRV, Oracle, PostgreSQL, SQLite, CUBRID, Interbase, ODBC y PDO.

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

Distancias y velocidades:
-------------------------

Para calcular las distancias entre estrellas, planetas y galaxias, se usarán las siguientes fórmulas.
Hay que tener en cuenta que con el mínimo de tecnología para viajar se considera que se viaja a la velocidad de la luz: 1UA-> 499s reales

**Distancias entre dos planetas del mismo sistema:**

* Para calcular la distancia entre planeta_origen y planeta_destino se usará la siguiente fórmula:
|(distancia del planeta_origen a la estrella)-(distancia del planeta_destino a la estrella)|
* Es muy probable que esto cambie en un futuro, cuando hagamos un universo 3D, en el que las distancias cambiarán
en el tiempo. Además, es muy posible que los trayectos, al ser orbitales, tarden más que si fueran en línea recta,
siempre teniendo en cuenta el Dv disponible.

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

* Este algoritmo está abierto a cambios, ya que es muy preliminar, y todavía no está claro como será el universo.

Fórmulas no implementadas:
------------------

* Hay que tener en cuenta las esferas de Hill de los cuerpos, y la excentricidad de las órbitas, para que no se salgan: 
* Muy importante el límite de roche, para que no se rompan los cuerpos: r*(2M/m)^(1/3) //Donde M es la masa del planeta,
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

* **Tipo de ticket**:
	* 1->Error/Bug
	* 2->Mejora
	* 3->Nueva Característica/Proposición

* **Estado del ticket**:
	* 0->Nuevo
	* 1->Aceptado (Proposición/Mejora)
	* 2->Confirmado (Error)
	* 3->En proceso
	* 4->Duplicado
	* 5->No es un error (Error)
	* 6->No se implantará (Proposición/Mejora)
	* 7->Implantado (Proposición/Mejora)
	* 8->Solucionado (Error)

Cosas por Hacer:
================

* Contadores para no poder cambiar la contraseña tras haber cambiado el email en los últimos días
* Contadores para evitar cambios fraudulentos en la configuración en general

Tipos de Objetos:
=================

* Estrella: Tabla stars y type = Char(tipo de estrella)
* Estrella de neutrones: Tabla stars y type = 0 (Char)
* Agujero negro: Tabla stars y type = 1 (Char)
* Planeta: Tabla bodies y type = 0
* Planeta enano: Tabla bodies y type = 1
* Luna: Tabla bodies y type = 2
* Cinturón de asteroides: Tabla bodies y type = 3

Datos sobre las estrellas:
==========================

* Los radios de las que no sean estrellas normales serán en metros
	* En el caso de las enanas blancas será en kilometros
* La luminosidad de las estrellas se inserta en la base de datos en el orden de 1E+12
* La densidad de las estrellas se inserta en la base de datos del orden de 10¹
* La masa y el radio de las estrellas se inserta en la base de datos en el orden de 10²
* Si la densidad de una estrella es cero, se considera densidad infinita (∞), es un agujero negro
