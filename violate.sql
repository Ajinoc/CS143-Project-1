/* Primary Key 1: Two movies can't share an id number */
INSERT INTO Movie VALUES(1, 'Movie 1', 2016, '50', 'Pixar');
INSERT INTO Movie VALUES(1, 'Movie 2', 2017, '75', 'Dreamworks');
/*
Query OK, 1 row affected (0.02 sec)

ERROR 1062 (23000): Duplicate entry '1' for key 'PRIMARY'
*/

/* Primary Key 2: Two actors can't share an id number */
INSERT INTO Actor VALUES(2, 'Actor', 'First', 'M', '02/01/1996', '02/01/1996');
INSERT INTO Actor VALUES(2, 'Actor', 'Second', 'M', '02/01/1996', '02/01/1996');
/*
Query OK, 1 row affected, 2 warnings (0.02 sec)

ERROR 1062 (23000): Duplicate entry '2' for key 'PRIMARY'
*/

/* Primary Key 3: Two directors can't share an id number */
INSERT INTO Director VALUES(1, 'Director', 'First', '02/01/1996', '02/01/1996');
INSERT INTO Director VALUES(1, 'Director', 'Second', '02/01/1996', '02/01/1996');
/*
Query OK, 1 row affected, 2 warnings (0.01 sec)

ERROR 1062 (23000): Duplicate entry '1' for key 'PRIMARY'
*/

/* Foreign Key 1: Sales record for a movie not in the database */
INSERT INTO Sales VALUES(1, 100, 10000);
/*
ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`Sales`, CONSTRAINT `Sales_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
*/

/* Foreign Key 2: Genre for a movie not in the database */
INSERT INTO MovieGenre VALUES(1, 'Horror');
/*
ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
*/

/* Foreign Key 3: Having directors directing a movie that doesn't exist */
INSERT INTO MovieDirector VALUES(16, 1);
/*
ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
*/

/* Foreign Key 4: Having a movie directed by a director that doens't exist */
INSERT INTO MovieDirector VALUES(15, 2)
/*
ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_2` FOREIGN KEY (`did`) REFERENCES `Director` (`id`))
*/

/* Foreign Key 5: Having actor in movie that doesn't exist */
INSERT INTO MovieActor VALUES(1, 1, 'Hero');
/*
ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
*/

/* Foreign Key 6: Having a movie starred with actors that don't exist */
INSERT INTO MovieActor VALUES(2, 5, 'Hero');
/*
ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY (`aid`) REFERENCES `Actor` (`id`))
*/

/* Check 1: Selling a negative number of tickets */
INSERT INTO Sales VALUES(2, -100, 10000);

/* Check 2: IMDB Rating not scaled out of 100 */
INSERT INTO MovieRating VALUES(2, 1000, 50);

/* Check 3: Rotten Tomato Rating not scaled out of 100 */
INSERT INTO MovieRating VALUES(2, 50, 1000);
