<?php
include('header.php');

$benutzer = "CREATE TABLE IF NOT EXISTS benutzer (
	id int(11) NOT NULL AUTO_INCREMENT,
	name varchar(20) NOT NULL,
	passwort varchar(255) NOT NULL,
	email varchar(40) NOT NULL,
	hp varchar(50) NOT NULL,
	tag int(11) NOT NULL,
	monat int(11) NOT NULL,
	jahr int(11) NOT NULL,
	bild varchar(10) NOT NULL,
	benutzertext text NOT NULL,
	since int(11) NOT NULL,
	gruppe int(11) NOT NULL,
	refresh int(11) NOT NULL,
	PRIMARY KEY (id)
	)";
mysqli_query($link, $benutzer) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Benutzer-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Benutzer-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$benutzergruppen = "CREATE TABLE IF NOT EXISTS benutzer_gruppen (
  	id int(11) NOT NULL AUTO_INCREMENT,
  	bezeichnung varchar(20) NOT NULL,
  	PRIMARY KEY (`id`)
	)";
mysqli_query($link, $benutzergruppen) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Benutzergruppen-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Benutzergruppen-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$benutzerlogin = "CREATE TABLE IF NOT EXISTS benutzer_login (
	id int(11) NOT NULL AUTO_INCREMENT,
	name varchar(20) NOT NULL,
	ip varchar(50) NOT NULL,
	timestamp varchar(50) NOT NULL,
	status varchar(20) NOT NULL,
	PRIMARY KEY (id)
	)";
mysqli_query($link, $benutzerlogin) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Benutzer_login-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Benutzer_login-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$navilinks = "CREATE TABLE IF NOT EXISTS navilinks (
	id int(11) NOT NULL AUTO_INCREMENT,
	name varchar(30) NOT NULL,
	datei varchar(40) NOT NULL,
	sparte int(11) NOT NULL,
	PRIMARY KEY (id)
	)";
mysqli_query($link, $navilinks) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Navilinks-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Navilinks-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$navilinks = "INSERT INTO navilinks (id, name, datei, sparte) VALUES
	(1, 'Profil bearbeiten', 'profil_edit.php', 2),
	(2, 'Navisparten verwalten', 'spartenverwalten.php', 1),
	(3, 'Log ansehen', 'log.php', 1),
	(4, 'Navilinks verwalten', 'linksverwalten.php', 1),
	(5, 'Team verwalten', 'admin_verwaltung.php', 1),
	(6, 'Newseinträge verwalten', 'newsverwalten.php', 2),
	(7, 'Tutorials verwalten', 'tutorialsverwalten.php', 3),
	(8, 'Affiliates verwalten', 'affisverwalten.php', 2),
	(9, 'A&A verwalten', 'askbeantworten.php', 2),
	(10, 'Updateplan verwalten', 'updateplanverwalten.php', 2),
	(11, 'Headers verwalten', 'headersverwalten.php', 3),
	(12, 'Designs verwalten', 'designsverwalten.php', 3),
	(13, 'Credits verwalten', 'creditsverwalten.php', 2),
	(14, 'Icons verwalten', 'iconsverwalten.php', 3),
	(15, 'Wallpapers verwalten', 'wallpapersverwalten.php', 3),
	(16, 'Textures verwalten', 'texturesverwalten.php', 3),
	(17, 'Materials verwalten', 'materialsverwalten.php', 3),
	(18, 'Iconbases verwalten', 'iconbasesverwalten.php', 3),
	(19, 'Blends verwalten', 'blendsverwalten.php', 3),
	(20, 'Signatures verwalten', 'signaturesverwalten.php', 3),
	(21, 'Brushes verwalten', 'brushesverwalten.php', 3),
	(22, 'Downloads verwalten', 'downloadsverwalten.php', 3),
	(23, 'PSDs verwalten', 'psdsverwalten.php', 3),
	(24, 'Icontextures verwalten', 'icontexturesverwalten.php', 3),
	(25, 'Reviews verwalten', 'reviewsverwalten.php', 3)";
mysqli_query($link, $navilinks) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Navilinks-Datensätze erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei den Navilinksdaten " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$navisparte = "CREATE TABLE IF NOT EXISTS navisparten (
	id int(11) NOT NULL AUTO_INCREMENT,
	Spartenbezeichnung varchar(30) NOT NULL,
	PRIMARY KEY (id)
	)";
mysqli_query($link, $navisparte) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Navisparten-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Navisparten-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$navisparteninsert = "INSERT INTO navisparten (id, Spartenbezeichnung) VALUES
	(1, 'ACP - Admin Menü'),
	(2, 'ACP - Bereich Allgemein'),
	(3, 'ACP - Bereich Gfx')";
mysqli_query($link, $navisparteninsert) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Navisparten-Datensätzen erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei den Navisparten-Datensätzen " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

/***************** AB HIER PAKET 2 ***************************/
$news = "CREATE TABLE IF NOT EXISTS news (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(100) NOT NULL,
	text TEXT NOT NULL,
	updates TEXT NOT NULL,
	time VARCHAR(40) NOT NULL,
	autor VARCHAR(30) NOT NULL
	)";
mysqli_query($link, $news) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>News-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der News-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$news_komments = "CREATE TABLE IF NOT EXISTS news_kommentare (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	news_id INT NOT NULL,
	name VARCHAR(40) NOT NULL,
	email VARCHAR(60) NOT NULL,
	hp VARCHAR(60) NOT NULL,
	time VARCHAR(40) NOT NULL,
	text TEXT NOT NULL
	)";
mysqli_query($link, $news_komments) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Newskommentar-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Newskommentar-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$tuts = "CREATE TABLE IF NOT EXISTS tutorials (
	id int(11) NOT NULL AUTO_INCREMENT,
	titel varchar(40) NOT NULL,
	webby varchar(20) NOT NULL,
	date int(11) NOT NULL,
	serie varchar(20) NOT NULL,
	text text NOT NULL,
	vorschau varchar(10) NOT NULL,
	PRIMARY KEY (id)
	)";
mysqli_query($link, $tuts) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Tutorials-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Tutorials-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$tutskommi = "CREATE TABLE IF NOT EXISTS tutorials_kommentare (
	id int(11) NOT NULL AUTO_INCREMENT,
	tutorial_id int(11) NOT NULL,
	name varchar(40) NOT NULL,
	email varchar(60) NOT NULL,
	hp varchar(60) NOT NULL,
	time varchar(40) NOT NULL,
	text text NOT NULL,
	PRIMARY KEY (id)
	)";
mysqli_query($link, $tutskommi) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Tutorialkommentar-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Tutorialkommentar-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

/**************************** AB HIER PAKET 3 ***************************/
$affisbecome = "CREATE TABLE IF NOT EXISTS affisbecome (
	id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(50) NOT NULL,
	url varchar(255) NOT NULL,
	button varchar(255) NOT NULL
	)";
mysqli_query($link, $affisbecome) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Affibecome-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Affibecome-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$affis = "CREATE TABLE IF NOT EXISTS affis (
	id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(50) NOT NULL,
	url varchar(255) NOT NULL,
	button varchar(255) NOT NULL,
	hits int(11) NOT NULL
	)";
mysqli_query($link, $affis) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Affi-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Affi-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$askme = "CREATE TABLE IF NOT EXISTS askme (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30) NOT NULL,
	frage TEXT NOT NULL,
	time INT(20) NOT NULL,
	antwort TEXT NOT NULL,
	webby VARCHAR(20) NOT NULL
	)";
mysqli_query($link, $askme) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Askme-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Askme-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

/******************************* AB HIER PAKET 4 ********************/
$credits = "CREATE TABLE IF NOT EXISTS credits (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	typ VARCHAR(20) NOT NULL,
	name VARCHAR(50) NOT NULL,
	url VARCHAR(80) NOT NULL
	)";
mysqli_query($link, $credits) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Credits-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Credits-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$creditsinsert = "INSERT INTO credits (id, typ, name, url) VALUES
	(1, 'sonstiges', 'ACP - The-Peril.com', 'http://the-peril.com'),
	(2, 'sonstiges', 'Smileys - Everaldo.com', 'http://www.everaldo.com/')";
mysqli_query($link, $creditsinsert) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Creditsdatensätze erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei den Creditsdaten " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$updateplan = "CREATE TABLE IF NOT EXISTS updateplan (
	id int(11) NOT NULL AUTO_INCREMENT,
	name varchar(50) NOT NULL,
	tag int(5) NOT NULL,
	monat int(5) NOT NULL,
	jahr int(5) NOT NULL,
	event varchar(100) NOT NULL,
	PRIMARY KEY (id)
	)";
mysqli_query($link, $updateplan) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Updateplan-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Updateplan-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$gfx = "CREATE TABLE IF NOT EXISTS gfx (
	id int(11) NOT NULL AUTO_INCREMENT,
	typ varchar(20) NOT NULL,
	timestamp int(11) NOT NULL,
	webby varchar(30) NOT NULL,
	bild varchar(10) NOT NULL,
	vorschau varchar(10) NOT NULL,
	vorschaugross varchar(10) NOT NULL,
	down varchar(10) NOT NULL,
	serie varchar(50) NOT NULL,
	name varchar(70) NOT NULL,
	views int(11) NOT NULL,
	PRIMARY KEY (id)
	)";
mysqli_query($link, $gfx) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Gfx-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Gfx-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

/*********************************** AB HIER PAKET 5 ********************************/

$dls2 = "CREATE TABLE IF NOT EXISTS downloads_kommentare (
	  id int(11) NOT NULL AUTO_INCREMENT,
	  dl_id int(11) NOT NULL,
	  name varchar(30) COLLATE utf8_unicode_ci NOT NULL,
	  email varchar(40) COLLATE utf8_unicode_ci NOT NULL,
	  hp varchar(50) COLLATE utf8_unicode_ci NOT NULL,
	  time int(11) NOT NULL,
	  text text COLLATE utf8_unicode_ci NOT NULL,
	  PRIMARY KEY (id)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";
mysqli_query($link, $dls2) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Downloadskomments-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Downloadskommentare-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$dl = "CREATE TABLE IF NOT EXISTS downloads (
	  id int(11) NOT NULL AUTO_INCREMENT,
	  name varchar(70) COLLATE utf8_unicode_ci NOT NULL,
	  typ varchar(15) COLLATE utf8_unicode_ci NOT NULL,
	  info text COLLATE utf8_unicode_ci NOT NULL,
	  vorschau varchar(10) COLLATE utf8_unicode_ci NOT NULL,
	  screen varchar(10) COLLATE utf8_unicode_ci NOT NULL,
	  zip varchar(10) COLLATE utf8_unicode_ci NOT NULL,
	  text text COLLATE utf8_unicode_ci NOT NULL,
	  webby varchar(20) COLLATE utf8_unicode_ci NOT NULL,
	  views int(11) NOT NULL,
	  downloads int(11) NOT NULL,
	  PRIMARY KEY (id)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";
mysqli_query($link, $dl) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Downloads-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Downloads-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

/******************** RATING SYTEM *************************/

$rating = "CREATE TABLE IF NOT EXISTS rating (
	ratingid int(11) NOT NULL AUTO_INCREMENT,
	itemid int(11) NOT NULL,
	wertung int(11) NOT NULL,
	ip varchar(200) NOT NULL,
	bereich varchar(150) NOT NULL,
	PRIMARY KEY (ratingid)
	)";
mysqli_query($link, $rating) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Rating-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Rating-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

/********************************** REVIEWS ************************/

$create_reviews = "CREATE TABLE IF NOT EXISTS reviews (
	  id int(11) NOT NULL AUTO_INCREMENT,
	  titel varchar(50) NOT NULL,
	  freitext varchar(50) NOT NULL,
	  info text NOT NULL,
	  rate1 int(11) NOT NULL,
	  rate1_text text NOT NULL,
	  rate2 int(11) NOT NULL,
	  rate2_text text NOT NULL,
	  rate3 int(11) NOT NULL,
	  rate3_text text NOT NULL,
	  rate4 int(11) NOT NULL,
	  rate4_text text NOT NULL,
	  rate5 int(11) NOT NULL,
	  rate5_text text NOT NULL,
	  bewertung int(11) NOT NULL,
	  gesamt_text text NOT NULL,
	  webby varchar(20) NOT NULL,
	  date int(20) NOT NULL,
	  serie varchar(15) NOT NULL,
	  vorschau varchar(8) NOT NULL,
	  PRIMARY KEY (id)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
mysqli_query($link, $create_reviews);
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Review-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Review-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$create_reviews_kom = "CREATE TABLE IF NOT EXISTS reviews_kommentare (
	  id int(11) NOT NULL AUTO_INCREMENT,
	  review_id int(11) NOT NULL,
	  name varchar(40) NOT NULL,
	  email varchar(60) NOT NULL,
	  hp varchar(60) NOT NULL,
	  time varchar(40) NOT NULL,
	  text text NOT NULL,
	  PRIMARY KEY (id)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
mysqli_query($link, $create_reviews_kom);
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Reviewkommentare-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Reviewkommentare-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

/************************ SMILIES  ***********************************/

$smilies = "CREATE TABLE IF NOT EXISTS smilies (
	  id int(255) NOT NULL,
	  code varchar(20) NOT NULL,
	  endung varchar(4) NOT NULL
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
mysqli_query($link, $smilies) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Smilies-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Smilies-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$smilies_fuellen = "INSERT INTO smilies (id, code, endung) VALUES
	(1, '*yeah*', '.png'),
	(2, '*yeha*', '.png'),
	(3, '*smile*', '.png'),
	(4, '*sad*', '.png'),
	(5, '*evil*', '.png'),
	(6, '*sleep*', '.png'),
	(7, '*angry*', '.png'),
	(8, '*happy*', '.png'),
	(9, '*cry*', '.png'),
	(10, '*dollar*', '.png'),
	(11, '*hehe*', '.png'),
	(12, '*quiet*', '.png'),
	(13, '*o.o*', '.png'),
	(14, '*hm...*', '.png'),
	(15, '*aeeh*', '.png'),
	(16, '*puh*', '.png'),
	(17, '*grml*', '.png');";
mysqli_query($link, $smilies_fuellen) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Smilies-Datensätze erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei den Smiliesdatensätzen " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

/************************* BESUCHERZÄHLER **************************/

$besucher = "CREATE TABLE besucherzaehler (
	ip VARCHAR(135) NOT NULL,
	timestamp INT NOT NULL,
	datum DATE NOT NULL,
	PRIMARY KEY (ip,datum)
	)";
mysqli_query($link, $besucher) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Besucherzähler-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Besucherzähler-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}
/************************* FORUM *************************************/

$kategorien = "CREATE TABLE IF NOT EXISTS forum_kategorien (
	id int(11) NOT NULL AUTO_INCREMENT,
	name varchar(100) NOT NULL,
	zugriff int(11) NOT NULL,
	position int(11) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4;";
mysqli_query($link, $kategorien) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Forumkategorien-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Forumkategorien-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$kategorien_fuellen = "INSERT INTO forum_kategorien (id, name, zugriff, position) VALUES
	(1, 'Admin Zone', 1, 10),
	(2, 'Allgemein', 2, 20),
	(3, 'Off Topic', 2, 30);";
mysqli_query($link, $kategorien_fuellen) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Forumkategorien-Datensätze erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei den Forumkategoriendaten " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$foren = "CREATE TABLE IF NOT EXISTS forum_foren(
	id int(11) NOT NULL AUTO_INCREMENT,
	status varchar(10) NOT NULL,
	name varchar(50) NOT NULL,
	beschreibung text NOT NULL,
	position int(11) NOT NULL,
	kategorie_id int(11) NOT NULL,
	PRIMARY KEY (id)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9;";
mysqli_query($link, $foren) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Forumforen-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Forumforen-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$foren_fuellen = "INSERT INTO forum_foren (id, status, name, beschreibung, position, kategorie_id) VALUES
	(1, 'aktiv', 'Organisation', 'Hier werden Ideen besprochen und geplant ', 10, 1),
	(2, 'aktiv', 'Team', 'Hier findet ihr alles was das Team an sich betrifft ', 20, 1),
	(3, 'aktiv', 'News', 'Neuigkeiten und Regeln, bitte regelmässig vorbeischauen!', 10, 2),
	(4, 'aktiv', 'Feedback', 'Kritik, Lob und allgemeines Feedback bitte hier rein posten ', 20, 2),
	(5, 'aktiv', 'Vorstellungen', 'Neue Gesichter im Forum können sich hier vorstellen', 30, 2),
	(6, 'aktiv', 'Sport', 'Alles zum Thema Sport & Fitness', 10, 3),
	(7, 'aktiv', 'Beziehungen', 'Liebe, Freundschaft - lasst euren Gedanken hier freien Lauf', 20, 3),
	(8, 'aktiv', 'Sonstiges & Spam', 'alles, was wo anders nicht hineinpasst', 30, 3);";
mysqli_query($link, $foren_fuellen) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Forumforen-Datensätze erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei den Forumforen-Datensätzen " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$themen = "CREATE TABLE IF NOT EXISTS forum_themen (
	id int(11) NOT NULL AUTO_INCREMENT,
	thema varchar(100) NOT NULL,
	timestamp int(11) NOT NULL,
	status varchar(10) NOT NULL,
	foren_id int(11) NOT NULL,
	ersteller_id int(11) NOT NULL,
	PRIMARY KEY (id)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;";
mysqli_query($link, $themen) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Forumthemen-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Forumthemen-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

$antworten = "CREATE TABLE IF NOT EXISTS forum_antworten(
	id int(11) NOT NULL AUTO_INCREMENT,
	timestamp int(11) NOT NULL,
	text text NOT NULL,
	themen_id int(11) NOT NULL,
	ersteller_id int(11) NOT NULL,
	PRIMARY KEY (id)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
mysqli_query($link, $antworten) OR die(mysqli_error($link));
if (mysqli_errno($link) == 0) {
    echo "<p class='ok'>Forumantworten-Tabelle erfolgreich erstellt!</p><br>";
} else { // Wenn MySQL Fehler..
    echo "<p class='fault'>Fehler bei der Forumantworten-Tabelle " . mysqli_errno($link) . ":" . mysqli_error($link) . "</p>"; // Fehlerausgabe
}

echo "<p class='ok'><br><b>Alle Datenbank-Tabellen erfolgreich angelegt!</b><br><br></p>";

include('footer.php');
?>	
