## Company Listing Application

### Tech Stack
- Laravel 8 Backend
- Vue Frontend with Inertia
- SQLite

### Requirements
|   |Requirement       |Notes                            |
|---|:------------------|:---------------------------------|
|[]|An Admin User should be able add a company.|The frontend must be completed for this as well as CompanyController@store.|
|[]|An Admin User should be able to edit a company.|The frontend must be completed for this as well as CompanyController@update.|
|[]|Logged in users should be able to rate a company.|There is a frontend component where companies can be rated, but the endpoint and backend needs to be created for it.|
|[]|The CompanyResource should return the average rating, rating count, and rating of the logged in user (if it exists).|The frontend's rating component will utilise this.|
|[]|A user should be able to filter the list by the company name, minimum rating, and maximum rating.|Both the frontend and CompanyController@index method need to be updated for this|
|[]|A public api endpoint should allows access to all companies with their rating and rating count| |

### Evaluation Criteria
- Readability and consistency of newly introduced code.
- Comprehensive unit testing coverage
- Consideration of edge cases
- Use of Laravel best practices and design patterns
- Atomic git commit history with helpful messages

### Bonus Points
- Take a look around the application and look for areas that 
you think could be improved upon. Just add a TODO and suggest
some refactors which will improve the maintainability or
readability of the project, or prevent any unexpected behavior.

### TODO
1. Laravel dusk for browser testing https://laravel.com/docs/8.x/dusk
2. Switch from a sqlite db to mysql or pgsql dbms to improve concurrency
3. Show flash messages after create / update action on the view
5. The ratings score can be divided by a scale in this case since we have a 5 star rating
the server can divide a users rating by 5 eg a 3 star rating will be stored as 3/5 = 0.6 .
This will be reformed by multiplying by the scale eg 0.6 * 5 = 3. This will make the score future proof from 
changes in scale eg from 5 to 10 star rating.
