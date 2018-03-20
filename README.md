# project-portal
1. Using MVC pattern we have seprated all the database logics. All the files that are associated with database are in model directory. All the html files are in views directory. We used index.php to control all the request.
2. All the routes defined and templating html files has been completed by using fat free in index file.
3. All the database functionality defined with PDO and prepared statements. Each method inside our dataObject.php used this layer.
4. In model directory our project.php class provides the functionality to add and get all the information from database as well as delete and update. 
5. Each memeber made commits after changing or updating any thing in our project.
6. We have used two classes one is DataObject and the other one is Project class. DataObject class encapsulated the select, insert, update and delete database functionality. Project class extends from DataObject class and mapping the project data to database tables with it's table definition and parent's methods.
7. All php files that are in model contained docblocks.
8. All the validation, insertion and update information in project has been completed with ajax, php and jquery. All javascript files are in scripts directory. 
