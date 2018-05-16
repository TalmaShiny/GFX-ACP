Das Grafik-**ACP** (Admin Control Panel) ist eine einfache Art CMS (Content Management System), welches Webbys bei der Erstellung von Grafik-Seiten unterstützt.

# Geschichte
[Isa](http://lovefolio.the-peril.com/) hat vor ca. 7-8 Jahren ein ACP für Grafik-Seiten programmiert. Dies sind Websites wie [www.the-peril.com](www.the-peril.com), die für Besucher kostenlose HTML/CSS-Designs, Tutorials zum Programmierung und Designen, Photoshop-Ressourcen uvm. anbieten.

Als ACP wird im unkommerziellen Webdesignbereich ein eigentliches CMS bezeichnet. Für einen professionellen Rahmen gibt es viele bekannte CMS wie beispielsweise Joomla oder Typo3, die jedoch für unsere Bedürfnisse etwas zu komplex gebaut sind. Isa hat sich vorgenommen, ein CMS gerichtet auf Grafik-Websites zu programmieren und den Besuchern dieses kostenlos zur Verfügung zu stellen. Als Gegenleistung für ihre Arbeit verlangt sie jedoch einen dicken Link in den Credits und in der Navi/Footer 🙂

Mit dem ACP ist auf Dauer kein lästiges Arbeiten in zB. PHPmyAdmin und kein ständiges FTP-Programm mehr nötig. Auch absolute Anfänger können dies verwenden, denn alles Notwendige kann auf der Website direkt verwaltet werden, in dem man sich mit deinem Benutzeraccount und Passwort anmeldet.

# Linzenz und Preis

Isa stellt das ACP kostenlos zur Verfügung. Es darf verwendet, angepasst und erweitert werden. Eigene Erweiterungen dürfen gerne zum Download angeboten werden.

Voraussetzung: Sie ist darüber informiert, behält ihren deutlich sichtbaren Creditlink und die Erweiterung ist weiterhin kostenlos, falls es den Quellcode ihres ACPs enthält. Ist es ein integrierbares Modul und ACP Code wird nicht mitgeliefert, obliegt die Entscheidung des Preises dem Urheber und nicht Isa.

# Screenshots
<p align="center">
  <a href="https://cakephp.org/" target="_blank" >
    <img alt="Screenshot" src="http://lovefolio.the-peril.com/wp-content/uploads/2016/01/1-449x304.png" />
  </a>
</p>

# Installation

1. Du musst die neuen entpackten Dateien, Verzeichnise mit allen Dateien und Unterordnern auf deinen Server laden (per FTP-Programm).
2. Du solltest bei deinem Hoster eine neuen Datenbank anlegen.
3. Nun solltest du auf deinem Server (via FTP-Programm) die db.php Datei mit den Angaben für deinen Server befüllen.
4. Nun führst du im Webbrowser die Datei "INSTALL.php" aus (http://DEINEURL/INSTALL.php)
   Diese Datei führt die Erweiterung der Datenbanktabellen aus und füllt sie an benötigter Stelle bereits mit Datensätzen.
   Als Bestätigung muss danach ein grüner Text mit folgenden Inhalt erscheinen: "Datenbank-Tabellen erfolgreich angelegt"
5. Rufe nun die Registrierung auf (http://DEINEURL/registrierung.php) und registriere dir einen Benutzer
6. Nun einfach ins ACP einloggen und schauen ob es funktioniert hat :)
7. Es ist nun wichtig, dass du die "INSTALL.php" wieder löschst.
8. Solltest du nicht wollen, dass User sich selber anmelden können,
   sondern du sie nur persönlich über die Benutzerverwaltung anlegen kannst,
   dann lösche bitte die registrierung.php
   
Das wars dann auch schon. Wir wünschen dir viel Spass mit dem ACP :)
