
GyalogútKataszter - Telepítéshez:

1. adatbázis
 * mysql-ben létrehozni egy dedikált usert, és egy üres adatbázist hozzá teljes jogosultságokkal
 * importálni az adatbázis snapshotot phpMyAdmin-ból

2. szoftver
 * bemásolni jelen könyvtár tartalmát a webszerver megfelelő alkönyvtárába, ahol php-t is lehet futtatni
 * .htaccess fájlban az elérési út aktualizálása, szükség szerint a .htpasswd megváltoztatása
 * www/gyk_php/db_conn.php fájlban az adatbáziskapcsolat aktualizálása
 * includes/configuration.inc.php fájlban az adatbáziskapcsolat és az elérési utak aktualizálása (__DOCROOT__, __VIRTUAL_DIRECTORY__, __SUBDIRECTORY__)
   az ott kommentben leírtak alapján (új SERVER_INSTANCE rész is létrehozható hozzá)

Használat: index.php megnyitása böngészőből.

Az alábbi verziókkal tesztelve:
	* Apache/2.2.12 (Ubuntu) webszerver
	* MySQL Szerver verzió: 5.1.37-1ubuntu5.5
	* PHP verzió: 5.2.10-2ubuntu6.10 
 	* Mozilla Firefox 3.6.17

