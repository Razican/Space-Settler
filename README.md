Problemas Conocidos:
====================
* Masas de los planetas muy pequeñas
* Algunos satélites con masa cero
* Las unidades de Masa no están correctas al mirar la habitabilidad de los satélites.
* Unidades en general no correctas.
* Falta el detalle del radio máximo para un planeta según su estrella.
* La máxima distancia de un satélite a su planeta debe ser calculada mediante la Esfera de Hill.
* La distancia de un satélite a su planeta debe ser calculada mediante la ley de Titius-Bode.
* Falta por traducir engine/language/english/migration_lang.php
* Ley de Titius Bode no correctamente implementada en la distancia de un planeta a su estrella (Parámetro n da valores incorrectos)
* El profiler no muestra correctamente los bordes de la sección de bases de datos.
* Validación por email del registro.
* La densidad da valores incorrectos, puede ser por problemas de unidades en otros valores.
* Solo se crean satélites que son dobles planetas.

Información de cambios:
=======================

* Se recomienda siempre usar UTF-8 en su variante *general_ci* en la base de datos y en la codificación de todos los archivos del juego.
* Necesario **PHP >= 5.2.0**
* Necesario **MySQL >= 4.1**
* También soporta MySQLi, MS SQL, Postgres, Oracle, SQLite y ODBC.

* * *

* Se decide que se borran los campos galaxy y los de system serán **star**, ahora, se mirará en la tabla stars por ID.

* * *

* Hay que incluír la masa de todo objeto (planeta, estrella, satélite u objeto como nave, orbitador, telescopio etc.
* Los planetas los creará el instalador, y se habrán creado todos cuando el universo se inicie.

Cambios en la base de datos:
----------------------------

Se borran las tablas **sps_planets** y **sps_config**

* * *

Tabla **sps_aks**:

* teilnehmer -- participant
* flotten -- fleet
* ankunft -- arrival
* eingeladen -- invited

* * *

Tabla **sps_banned**:

* theme -- reason

* * *

Tabla **sps_buddy**: --> **sps_friends**:

* * *

Tabla **sps_galaxy**:

* id_planet -- planet_id
* id_luna -- moon_id
* luna -- moon

* * *

Tabla **sps_planets**:

* destruyed -- destroyed
* misil_launcher -- missile_launcher
* interceptor_misil -- interceptor_missile
* interplanetary_misil -- interplanetary_missile
* metal_mine_porcent -- metal_mine_percent
* crystal_mine_porcent -- crystal_mine_percent
* deuterium_sintetizer_porcent -- deuterium_sintetizer_percent
* solar_plant_porcent -- solar_plant_percent
* fusion_plant_porcent -- fusion_plant_percent
* solar_satelit_porcent -- solar_satelit_percent
* mondbasis -- lunar_base
* sprungtor -- jumpgate

* * *

Tabla **sps_errors**:

* Se quitan los prefijos error_

* * *

Tabla **sps_alliance**: --> **sps_alliances**:

* Se quitan los prefijos ally_

* * *

Tabla **sps_fleets**:

* Se quitan los prefijos fleet_

* * *

Tabla **sps_message**:

* Se quitan los prefijos message_

* * *

Tabla **sps_rw**:

* Queda pendiente, ya que no sabemos su uso.

* * *

Tabla **sps_users**:

* Se borran los campos current_planet, user_agent y current_page. Se usarán sesiones para su control.
* Queda pendiente dpath, ya que no tiene un nombre significativo.
* email_2 -- reg_email
* ip_at_reg -- reg_ip
* user_lastip -- last_ip
* id_planet -- planet_id
* onlinetime -- online_time
* spio_anz -- espionage_probes
* current_luna -- current_moon
* rpg_geologue -- rpg_geologist
* rpg_amiral -- rpg_admiral
* rpg_ingenieur -- rpg_engineer
* rpg_technocrate -- rpg_technocrat
* rpg_espion -- rpg_spy
* rpg_constructeur -- rpg_constructor
* rpg_scientifique -- rpg_scientific
* rpg_commandant -- rpg_commander
* rpg_stockeur -- rpg_storekeeper
* rpg_defenseur -- rpg_defender
* rpg_destructeur -- rpg_destroyer
* rpg_raideur -- rpg_raider
* rpg_empereur -- rpg_emperor
* bana -- banned --> Pendiente de borrado: O de crear la tabla banned dentro de este campo, ya que parece innecesaria.
* banaday -- ban_finish

*Quedan pendientes, también los siguientes campos*:

* db_deaktjava
* urlaubs_until
* urlaubs_modus
* settings_rep
* settings_mis
* settings_bud
* settings_wri
* settings_esp
* spio_anz

* * *

**Cambios Generales**

* Se cambian las ID's a int(10) unsigned, para permitir 4.294.967.295 ID's, ya que no tiene sentido tener mucísimas veces más ID's que personas en el mundo.
Solo aplicado a usuarios, alianzas y planetas. Las demás serán bigint(20) unsigned, así tendrán 18.446.744.073.709.551.615 de ID's.
* Se ajustan los valires numéricos, ya que no tiene sentido un int(32).
* Se cambia la codificación a UTF-8, con la variante "general_ci".
* Se usarán los int's más pequeños posibles para almacenar datos: int(2) --> tinyint(2).
* Recursos: bigint(20) unsigned.
* Naves: bigint(20) unsigned.
* Niveles: int(10) unsigned.
* Tiempo: int(10) unsigned.
* Misiles: int(10) unsigned.
* Campos tipo galaxy: tinyint(2)
* Campos tipo system: smallint(4)
* Campos tipo planet: tinyint(2)
* Campos IP: int(10) unsigned (menos los de sesiones).

Nota:
-----

Esta no es ni mucho menos la base de datos definitiva, ya que vamos a quitar las variables de configuración y ir modificándola según avancemos.
Es probable que decidamos unir todas las tecnologías en un array, y que hagamos lo mismo con los edificios. Además, es posible que no necesitemos usar campos como ally_members etc.

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
-----
* Masa de un planeta: entre Mt/100000 y Mt*3.500.
* Masa de un satélite: planeta doble ? 0.1 - 0.5 : 1E-11 - 0.015;
* Si planeta doble, distancia mínima: r*(2M/m)^(1/3) //Límite de Roche, donde M es la masa del planeta,
m la del satélite y r el rádio del satélite.
* Radio de un planeta: entre 375.000m - 85.000.000m

Constantes:
-----------

* Luz: 299792458 m/s