SELECT CONCAT(first, ' ', last) FROM Actor 
INNER JOIN MovieActor ON Actor.id=MovieActor.aid 
INNER JOIN Movie ON MovieActor.mid=Movie.id 
WHERE title='Die Another Day';

SELECT title FROM Movie 
INNER JOIN Sales ON Movie.id=Sales.mid 
WHERE ticketsSold>1000000;