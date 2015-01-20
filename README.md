AFK
===


IMPORTANT
=========

La video d'acceuil n'est pas sur le repo, parce que elle est plutot fat, télécharger la video avec
youtube-dl.

Utilisez un serveur web nginx sur vos propres machines, avec mariadb et php php-fpm.

Vous trouverez le fichier de la base de donnée dans AFK.sql
Utilisez google pour configurer les identifiant de la BDD

Dans l'invité de mariadb, faite un
`CREATE DATABASE AFK;`
`use AFK` et `source [chemin absolu vers le fichier]`

Pour nginx, supposant que le projet se trouve dans le dossier /www, voici la config

En dehors du bloc server:
```
upstream backend {
   server unix:/var/run/php-fpm/php-fpm.sock;
}
```

Dans le bloc server:

```
    listen       80;
    server_name  localhost;
    
    location / {
        root   /www;
        index  index.html index.htm index.php;
        try_files $uri /index.php$is_args$args;
    }
    
    location ~ \.php$ {
        root /www;
        fastcgi_pass backend;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root/$fastcgi_script_name;
        include fastcgi_params;
}
```

Pour php, commentez la directive open_basedir dans /etc/php.ini et n'oubliez pas de redemmarer les services:
sudo systemctl restart nginx php-fpm mysqld
