

I1: Add Actor/Director Info
	Implemented by: Kaitlyn Cason
	One page was used to implement both Actor/Director info. The sex option is ignored if the identity is a Director.
	Assumes user will enter correct DoB and DoD information (DoD can be left blank). If incorrect DoB, it is automatically entered as 0000-00-00.
	Forces user to enter something in the First Name, Last Name, and DoB boxes.
	Updates the MaxPersonID by one.

I2: Add Movie Information
	Implemented by: Kaitlyn Cason
	Allows user to check more than one genre box.
	User must enter something for the Title, Company, and Year. The Year must be a digit between 0 and 9999, inclusive.
	Updates MaxMovieID by one.

I3: Add Comments to Movies
	Implemented by: Kaitlyn Cason
	Allows users to rate and add comments to any existing movies.
	Timestamps are gathered by the server, not given by user.
	Reviewer name is by default "Sir Anonymous", but can be changed by user.
	Ratings go from 5 to 1.
	If a user visits this page from a B1 browse of Movie Information, movie title is automatically chosen for the user (it is the movie that they were browsing on Movie Information).
	After submission, the user can click a bottom link to be rerouted to that movie's information page, where they can read the rest of the comments.

I4: Add "Actor to Movie" Relations
	Implemented by: Kaitlyn Cason
	Allows users to link an already existing actor (with a role) to an already existing movie. 
	This is implemented using a drop-down menu.
	Since some entries in the database allow the actors to have an empty role field, this is allowed in this implementation as well.

I5: Add "Director to Movie" Relations
	Implemented by: Kaitlyn Cason
	Allows users to link an already existing director to an already existing movie. 
	This is implemented using a drop-down menu.

B1: Shows Actor Information
	Implemented by: Kaitlyn Cason
	Allows users to view name, sex, DoB, and DoD of the actor.
	Lists the roles the actor played in each movie. Embedded links to browse the movie information is implemented for each movie the actor plays in.
	The search interface is implemented at the bottom of this page, allowing a user to directly search for an actor/movie after viewing the current actor.
	Upon first click from the left menu bar, the Actor Information is empty as default until an actor is searched for.

B2: Shows Movie Information
	Implemented by: Adam Jones (Movie Reviews by Kaitlyn)
	Allows users to view the title, year, rating, company, director(s), genre(s), tickets sold, total income, IMDb rating, and Rotten Tomatoes rating.
	Under that, all actors and their roles are listed for the movie.
	Lastly, below that are the movie reviews. Shows the user the average rating out of 5 from a total number of reviews. 
	The reviews are below listing timestamp, name, rating, and comments.
	Upon first click from the left menu bar, the MovieInformation is empty as default until a movie is searched for.

S1: Search for Actor/Movie through Keyword Search
	Implemented by: Adam Jones
	Allows users to search for an actor or movie title using a key word search.
	Allows for multiple name searches (ie. Billy Joe Bob will search for all 3 as a first name, just one, etc.) as well as an inclusive movie title search.
	We included DoB and movie years to help differentiate if multiple actors or multiple movies have the same name.
	All actors or movie results have embedded links that will redirect the user to the correct Actor/Movie Information page where they can view information about their search.

t1,t2,t3,t4,t5.html
	All implemented by Adam Jones.
	Since we used more than one frame, the Selenium test cases work when run slowly.

All these assume a database has been preloaded into the server using load.sql (since we assume MaxMovieID and MaxPersonID have a value.)

As a team, we felt that we could improve on time management.