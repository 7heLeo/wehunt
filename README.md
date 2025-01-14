## REQUISITO:
implementare una web application laravel* che dopo il login di utente tramite username e password fornisca un token.
Non è necessario la fase di registrazione dell'utente con invio mail, puoi immaginare di partire con un db già contenente un utenza user: "root" password: "password"
Utilizzare il token recuperato dopo l'accesso per interrogare un api esposta dal sistema che faccia da proxy verso openbrewerydb (https://www.openbrewerydb.org/documentation/) e mostri una lista paginata di birre recuperata dai loro servizi.

##
- PHP 8.1.10
- LARAVEL 10.48.25
- DOCKER 27.3.1

##
RIPRISTINO CARTELLA VENDOR: RUN > composer install

##
DATABASE MySQL 5.7.39
Dati di accesso al database così come configurati nei file .env .env.testing:
HOST = 127.0.0.1
PORT = 3306
DATABASE = wehunt
USERNAME = root
PASSWORD = root

Il Database non è incluso e dovrebbe essere ospitato in un servizio esterno, quindi cambiata la configurazione di conseguenza.

Il dump delle tabelle e dei dati necessari all'applicazione salvato sul file DBdump.sql

##
DOCKER: RUN > docker compose up --build

##
FRONTEND: http://localhost:8000/
BACKEND API DOCUMENTATION: http://localhost:8000/swagger

##
API TEST: RUN > php artisan test --env=testing

##


