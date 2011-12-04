Información de cambios:
=======================

***Por Traducir: engine/language/english/migration_lang.php***

El proyecto, a falta de un instalador, se entrega con un usuario predefinido:

**Usuario**: admin

**Contraseña**: 12345

* * *

* Se recomienda siempre usar UTF-8 en su variante *general_ci* en la base de datos y en la codificación de todos los archivos del juego.
* Necesario **PHP >= 5.2.0**
* Necesario **MySQL >= 4.1**
* También soporta MySQLi, MS SQL, Postgres, Oracle, SQLite y ODBC.

* * *

* Se decide que se borran los campos galaxy y los de system serán **star**, ahora, se mirará en la tabla stars por ID.

Cambios en la base de datos:
----------------------------

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

Es muy probable la supresión de la tabla config, y puede que la de plugins, ya que se pueden usar archivos para gestionar dichas opciones.
Aún así, queda mucho por ver. El sistema de plugins será adaptado a CodeIgniter, de manera que se usen librerías. Pero se debe avanzar más en el desarrollo.

Cosas por hacer
---------------

Crear una función reset_password más completa, para que el controlador haga algo como *if reset_password message else message*.

Selección de Planetas en el Registro
------------------------------------

* Se seleccionan todos los planetas: única query
* Entre las galaxias, se selecciona la galaxia en tres pasos (es obligatorio que haya un planeta habitable disponible [1 - 7, según estrella]):
	* Primero: se seleccionan las galaxias con media de planetas por debajo del 33,33% y que no estén vacías.
	* Segundo: si no se ha seleccionado nada, se selecciona la galaxia vacía de ID mínima.
	* Tercero: si seguimos sin haber seleccionado nada, se selecciona la de menor densidad.
	* En el caso en el que todos los planetas centrales estén ocupados, se mostrará una alerta en la administración, y no se podrán registrar nuevos usuarios.
		En caso contrario, se seleccionará aleatóriamente entre las seleccionadas.
* Entre los sistemas de la galaxia, primero se eligen todos los sistemas de la galaxia en cuestión:
	* Se selecciona uno aleatóriamente entre los que tengan una densidad de planetas por debajo del 33,33% y al menos un planeta habitable deshabitado.
	* Se añaden a la selección 10 sistemas vacíos, si los hay, proferíblemente entre los de ID más baja.
	* Si no se ha elegido ninguno, se elije el de menor media.
* A la hora de elegir la posición, se toma como probabilidad la siguiente, para ser habitable:
	* (1/5 - 5) Sol -> pos 3 +- 1(90%) +- 2 (10%) (distancia entre 0.40 y 5.50 UA)
	* (1/50 - 1/5) Sol -> pos 1(90%) 2(10%) (distancia entre 0.10 y 0.50 UA)
	* (5 - 50) Sol -> pos 6 +- 1 (distancia entre 5.00 y 20 UA)
	* Fuera de ese rango no puede existir planeta -> se añade como requisito.
* Los planetas en el registro tendrán una aleatoriedad de campos del +/-5% del tamaño predefinido, con variaciones de 1 campo, siempre con redondeo.

Cómo Serán los Planetas? (con el nuevo juego, una vez encontrado un planeta no podrá ser cambiado)
--------------------------------------------------------------------------------------------------

**Distancias al sol:**

* Posición 1: 0.05 - 0.40 UA
* Posición 2: 0.20 - 0.65 UA
* Posición 3: 0.50 - 1.25 UA
* Posición 4: 1.20 - 2.50 UA
* Posición 5: 2.25 - 6.00 UA
* Posición 6: 5.00 - 15.00 UA
* Posición 7: 13.50 - 25.00 UA
* Posición 8: 22.50 - 35.00 UA
* Posición 9: 27.50 - 50.00 UA
* Posición 10: 40.00 - 65.00 UA
* Posición 11: 60.00 - 80.00 UA
* Posición 12: 75.00 - 100.00 UA

* * *

* Posición 13: 90.00 - 125.00 UA
* Posición 14: 110.00 - 150.00 UA
* Posición 15: 130.00 - 175.00 UA
* Posición 16: 165.00 - 200.00 UA
* Posición 17: 190.00 - 250.00 UA
* Posición 18: 225.00 - 300.00 UA
* Posición 19: 275.00 - 400.00 UA
* Posición 20: 350.00 - 650.00 UA

**Habitabilidad:**

* Entre 75 y 300 campos: habitable
* Más de 500 campos: Gigante de gas (puede ser usado para mejorar la carrera científica)
* Menos de 30 campos: Planeta enano (puede ser usado para mejorar la carrera científica)
* El resto: conquistable
* Para que una estrella sea habitable, su luminosidad y diámetro deberán estar entre 0.02 y 50, y la relación entre ellos
no puede ser mayor de 10.
* Posición mínima habitable:

**Luminosidad:**

* Sol = 3.827E26 W
* Max = 10.000.000*Sol (por facilidad, y para que haya más planetas habitables pondremos un máximo de 100*Sol)
* Min = 0,00125*Sol (por facilidad, y para que haya más planetas habitables se usará un mínimo de Sol/100)

**Cantidades:**

* Planetas por sistema: 15 - 20
* Sistemas por galaxia: 100 - 1.000
* Galaxias por Universo: 1 - 20

**Mínimo de campos para un planeta:** 10
**Máximo de campos para un planeta:** raiz_sexta(diametro_estrella(soles))*2.000, en campos.
**Máximo de campos para una luna:** 100
**Campos de una luna:** ((Entre 300 y 300.000)/1.000.000)*(campos del planeta origen)

**El Primer Planeta:**

* 10% de probabilidades de tener menos de 50 campos.
* 15% de probabilidades de tener entre 50 y 100 campos.
* 3% de probabilidades de entre 100 y 150 campos.
* 2% de probabilidades de tener entre 150 y 300 campos.
* 70% de probabilidades de tener entre 300 y 3250 campos.
	* En el último caso no habrá planetas en las posiciones 2, 3, y 4.

**El Segundo Planeta:**

* 5% de probabilidades de tener menos de 50 campos.
* 25% de probabilidades de tener entre 50 y 100 campos.
* 10% de probabilidades de entre 100 y 150 campos.
* 15% de probabilidades de tener entre 150 y 300 campos.
* 45% de probabilidades de tener entre 300 y 2100 campos.
	* En el último caso no habrá planetas en las posiciones 1, 3, 4 y 5.

**El Tercer Planeta:**

* 1% de probabilidades de tener entre 10 y 50 campos.
* 30% de probabilidades de tener entre 50 y 100 campos.
* 19% de probabilidades de entre 100 y 150 campos.
* 15% de probabilidades de tener entre 150 y 300 campos.
* 35% de probabilidades de tener entre 300 y 2000 campos.
	* En el último caso no habrá planetas en las posiciones 1, 2, 4 y 5.

**El Cuarto Planeta:**
* 10% de probabilidades de tener menos de 50 campos.
* 25% de probabilidades de tener entre 50 y 100 campos.
* 30% de probabilidades de entre 100 y 150 campos.
* 10% de probabilidades de tener entre 150 y 300 campos.
* 25% de probabilidades de tener entre 300 y 2250 campos.
	* En el último caso no habrá planetas en las posiciones 2, 3 y 5.

**El Quinto Planeta:**

* 2% de probabilidades de tener menos de 50 campos.
* 3% de probabilidades de tener entre 50 y 100 campos.
* 20% de probabilidades de entre 100 y 150 campos.
* 25% de probabilidades de tener entre 150 y 300 campos.
* 50% de probabilidades de tener entre 300 y 1750 campos.
	* En el último caso no habrá planetas en las posiciones 4 y 6.

**El Sexto Planeta:**

* 5% de probabilidades de tener menos de 50 campos.
* 10% de probabilidades de tener entre 50 y 100 campos.
* 10% de probabilidades de entre 100 y 150 campos.
* 20% de probabilidades de tener entre 150 y 300 campos.
* 55% de probabilidades de tener entre 300 y 2000 campos.
	* En el último caso no habrá planetas en las posiciones 5 y 7.

**El Séptimo Planeta:**

* 10% de probabilidades de tener menos de 50 campos.
* 20% de probabilidades de tener entre 50 y 100 campos.
* 10% de probabilidades de entre 100 y 150 campos.
* 20% de probabilidades de tener entre 150 y 300 campos.
* 40% de probabilidades de tener entre 300 y 1500 campos.
	* En el último caso no habrá planeta en la posición 6.

**El Octavo Planeta:**

* 20% de probabilidades de tener menos de 50 campos.
* 25% de probabilidades de tener entre 50 y 100 campos.
* 10% de probabilidades de entre 100 y 150 campos.
* 15% de probabilidades de tener entre 150 y 300 campos.
* 30% de probabilidades de tener entre 300 y 1000 campos.

**El Noveno Planeta:**

* 30% de probabilidades de tener menos de 50 campos.
* 25% de probabilidades de tener entre 50 y 100 campos.
* 15% de probabilidades de entre 100 y 150 campos.
* 10% de probabilidades de tener entre 150 y 300 campos.
* 20% de probabilidades de tener entre 300 y 600 campos.

**El Décimo Planeta:**

* 40% de probabilidades de tener menos de 50 campos.
* 30% de probabilidades de tener entre 50 y 100 campos.
* 10% de probabilidades de entre 100 y 150 campos.
* 5% de probabilidades de tener entre 150 y 300 campos.
* 15% de probabilidades de tener entre 300 y 500 campos.

**El Undécimo Planeta:**

* 50% de probabilidades de tener menos de 50 campos.
* 33% de probabilidades de tener entre 50 y 100 campos.
* 5% de probabilidades de entre 100 y 150 campos.
* 2% de probabilidades de tener entre 150 y 300 campos.
* 10% de probabilidades de tener entre 300 y 500 campos.

**El Duodécimo Planeta:**

* 60% de probabilidades de tener menos de 50 campos.
* 30% de probabilidades de tener entre 50 y 100 campos.
* 3% de probabilidades de entre 100 y 150 campos.
* 2% de probabilidades de tener entre 150 y 250 campos.
* 5% de probabilidades de tener entre 250 y 400 campos.

**El Decimotercer Planeta:**

* 65% de probabilidades de tener menos de 50 campos.
* 30% de probabilidades de tener entre 50 y 100 campos.
* 2% de probabilidades de entre 100 y 150 campos.
* 1% de probabilidades de tener entre 150 y 300 campos.
* 2% de probabilidades de tener entre 300 y 500 campos.

**El Decimocuarto Planeta:**

* 70% de probabilidades de tener menos de 50 campos.
* 27% de probabilidades de tener entre 50 y 100 campos.
* 1% de probabilidades de entre 100 y 150 campos.
* 1% de probabilidades de tener entre 150 y 250 campos.
* 1% de probabilidades de tener entre 250 y 400 campos.

**El Decimoquínto Planeta:**

* 75% de probabilidades de tener menos de 50 campos.
* 20% de probabilidades de tener entre 50 y 100 campos.
* 1% de probabilidades de entre 100 y 150 campos.
* 1% de probabilidades de tener entre 150 y 250 campos.
* 3% de probabilidades de tener entre 250 y 400 campos.

**El Decimosexto Planeta:**

* 80% de probabilidades de tener menos de 50 campos.
* 13% de probabilidades de tener entre 50 y 100 campos.
* 1% de probabilidades de entre 100 y 150 campos.
* 1% de probabilidades de tener entre 150 y 250 campos.
* 5% de probabilidades de tener entre 250 y 400 campos.

**El Decimoséptimo Planeta:**

* 83% de probabilidades de tener menos de 40 campos.
* 10% de probabilidades de tener entre 40 y 100 campos.
* 1% de probabilidades de entre 100 y 150 campos.
* 1% de probabilidades de tener entre 150 y 300 campos.
* 5% de probabilidades de tener entre 300 y 500 campos.

**El Decimoctavo Planeta:**

* 90% de probabilidades de tener menos de 40 campos.
* 4% de probabilidades de tener entre 40 y 100 campos.
* 1% de probabilidades de entre 100 y 150 campos.
* 1% de probabilidades de tener entre 150 y 300 campos.
* 4% de probabilidades de tener entre 300 y 1500 campos.

**El Decimonoveno Planeta:**

* 92% de probabilidades de tener menos de 30 campos.
* 3% de probabilidades de tener entre 30 y 90 campos.
* 1% de probabilidades de entre 90 y 150 campos.
* 1% de probabilidades de tener entre 150 y 300 campos.
* 3% de probabilidades de tener entre 300 y 750 campos.

**El Vigésimo Planeta:**

* 94% de probabilidades de tener menos de 30 campos.
* 2% de probabilidades de tener entre 30 y 90 campos.
* 1% de probabilidades de entre 90 y 150 campos.
* 1% de probabilidades de tener entre 150 y 300 campos.
* 2% de probabilidades de tener entre 300 y 750 campos.

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

Estrellas:
----------

* Las estrellas de cada universo se encuentran en el archivo de configuración stars.php. El formato es el siguiente:
ID->(galaxy->ID_galaxia, id->Posición_en_galaxia, diameter->diametro(en soles), luminosity->luminosidad(en soles))
* Las posiciones serán de la siguiente manera: ['galaxy'], ['system'], ['planet'].