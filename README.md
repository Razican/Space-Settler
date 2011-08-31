Información de cambios:
=======================

El proyecto, a falta de un instalador, se entrega con un usuario predefinido:

**Usuario**: admin

**Contraseña**: 12345

* * *
Se recomienda siempre usar UTF-8 en su variante *general_ci* en la base de datos y en la codificación de todos los archivos del juego.

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

Tabla **sps_buddy**: --> **sps_firends**:

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

* Se cambian las ID's a int(10) unsigned, para permitir Ya que no tiene sentido tener mucísimas veces más ID's que personas en el mundo.
Solo aplicado a usuarios, alianzas y planetas. Las demás serán bigint(20) unsigned.
* Se ajustan los valires numéricos, ya que no tiene sentido un int(32).
* Se cambia la codificación a UTF-8, con la variante "general_ci".
* Se usarán los int's más pequeños posibles para almacenar datos: int(2) --> tinyint(2).
* Recursos: bigint(20) unsigned.
* Naves: bigint(20) unsigned.
* Niveles: int(10) unsigned.
* Tiempo: int(10) unsigned.
* Misiles: int(10) unsigned.
* Campos tipo galaxy: tinyint(1)
* Campos tipo system: smallint(3)
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

Más Datos
---------

Es muy probable la supresión de la tabla config, y puede que la de plugins, ya que se pueden usar archivos para gestionar dichas opciones.
Aún así, queda mucho por ver. El sistema de plugins será adaptado a CodeIgniter, de manera que se usen librerías. Pero se debe avanzar más en el desarrollo.

Cosas por hacer
---------------

Crear una función reset_password más completa, para que el controlador haga algo como *if reset_password message else message*.