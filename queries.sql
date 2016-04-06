--names <firstname> <lastname> of all actors in the movie 'Die Another Day'
SELECT CONCAT(first, ' ', last) FROM Actor 
INNER JOIN MovieActor ON Actor.id=MovieActor.aid 
INNER JOIN Movie ON MovieActor.mid=Movie.id 
WHERE title='Die Another Day';

--count of all actors who acted in multiple movies
SELECT COUNT(DISTINCT ma1.aid) FROM MovieActor ma1 
INNER JOIN MovieActor ma2 ON ma1.aid=ma2.aid 
WHERE ma1.mid<>ma2.mid;

--title of movies that sold over 1,000,000 tickets
SELECT title FROM Movie 
INNER JOIN Sales ON Movie.id=Sales.mid 
WHERE ticketsSold>1000000;

--title of movies that have below a 25% approval rating on Rotten Tomatoes, 
--but over 75% approval rating on IMDB
SELECT title FROM Movie  
INNER JOIN MovieRating ON Movie.id=MovieRating.mid  
WHERE rot<25 AND imdb>75;

--names <firstname> <lastname> of all actors who appeared in movies as 'Himself' or 'Herself'
SELECT DISTINCT CONCAT(first, ' ', last) FROM Actor  
INNER JOIN MovieActor ON Actor.id=MovieActor.aid  
WHERE role='Himself' OR role='Herself';