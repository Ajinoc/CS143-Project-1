CREATE TABLE Movie (
    id INT NOT NULL,
    title VARCHAR(100),
    year INT,
    rating VARCHAR(10),
    company VARCHAR(50),
    PRIMARY KEY (id) /* Primary Key 1: Every movie has a unique ID number */
) ENGINE = INNODB;

CREATE TABLE Actor (
    id INT NOT NULL,
    last VARCHAR(20),
    first VARCHAR(20),
    sex VARCHAR(6),
    dob DATE,
    dod DATE,
    PRIMARY KEY (id) /* Primary Key 2: Every actor has a unique ID number */
) ENGINE = INNODB;

CREATE TABLE Sales (
    mid INT,
    ticketsSold INT,
    totalIncome INT,
    FOREIGN KEY (mid) REFERENCES Movie(id), /* Foreign Key 1: Can only have sales records for movies actually in the database */
    CHECK(ticketsSold >= 0) /* Check 1: Can't sell a negative number of tickets */
) ENGINE = INNODB;

CREATE TABLE Director (
    id INT NOT NULL,
    last VARCHAR(20),
    first VARCHAR(20),
    dob DATE,
    dod DATE,
    PRIMARY KEY(id) /* Primary Key 3: Every director has a unique ID number */
) ENGINE = INNODB;

CREATE TABLE MovieGenre (
    mid INT,
    genre VARCHAR(20),
    FOREIGN KEY (mid) REFERENCES Movie(id) /* Foreign Key 2: Can only have genres for movies that actually exist */
) ENGINE = INNODB;

CREATE TABLE MovieDirector (
    mid INT,
    did INT,
    FOREIGN KEY (mid) REFERENCES Movie(id), /* Foreign Key 3: Can only have directors direct movies that exist */
    FOREIGN KEY (did) REFERENCES Director(id) /* Foreign Key 4: Can only have movies directed by directors that actually exist */
) ENGINE = INNODB;

CREATE TABLE MovieActor (
    mid INT,
    aid INT,
    role VARCHAR(50),
    FOREIGN KEY (mid) REFERENCES Movie(id), /* Foreign Key 5: Can only have actors acting in movies that exist */
    FOREIGN KEY (aid) REFERENCES Actor(id)  /* Foreign Key 6: Can only have movies starred by actors that exist */
) ENGINE = INNODB;

CREATE TABLE MovieRating (
    mid INT,
    imdb INT,
    rot INT,
    CHECK(imdb >= 1 AND imbd <= 100), /* Check 2: IMDB rating must be scaled from 1-100 */
    CHECK(rot >= 1 AND rot <= 100) /* Check 3: Rotten Tomatoes Rating must be scaled from 1-100 */
) ENGINE = INNODB;

CREATE TABLE Review (
    name VARCHAR(20),
    time TIMESTAMP,
    mid INT,
    rating INT,
    comment VARCHAR(500)
) ENGINE = INNODB;

CREATE TABLE MaxPersonID (
    id INT
) ENGINE = INNODB;

CREATE TABLE MaxMovieID (
    id INT
) ENGINE = INNODB;
