CREATE DATABASE blog;

CREATE USER 'blog_user'@'localhost' IDENTIFIED BY 'bl0ggert0n';

GRANT USAGE ON *.* TO 'blog_user'@'localhost' IDENTIFIED BY 'bl0ggert0n'
WITH MAX_QUERIES_PER_HOUR 0
MAX_UPDATES_PER_HOUR 0
MAX_CONNECTIONS_PER_HOUR 0
MAX_USER_CONNECTIONS 0;

GRANT Create Routine, Insert, Lock Tables, References, Select, Drop, Delete,
Index, Alter Routine, Create View, Create Temporary Tables, Show View, Trigger,
Event, Create, Update, Execute, Grant Option, Alter ON `blog`.* TO `blog_user`@`localhost`;
