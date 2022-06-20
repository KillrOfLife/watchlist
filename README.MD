#Watchlist for multiple users

The idea is simple. this is a database that keeps track of all the movies and series you want to watch or have watched.
It has the functionality of being able to know what to watch together with the other users that are using this watchlist.
NOTE: This is a selfhosted service so only the users that can access this webpage will be seen as a user.

##Requirements
docker/docker-desktop
docker-compose

##setup
```bash
docker-compose up -d
```
create a mysql table per user
```mysql
CREATE TABLE watchlist1 ( id MEDIUMINT NOT NULL AUTO_INCREMENT, TMDBID int NOT NULL, name CHAR(20) NOT NULL, in_wl boolean not null, watched boolean not null, type char(8) NOT NULL, PRIMARY KEY (id) );
```


