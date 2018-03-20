# project-portal
1. Using MVC pattern we have seprated all the database logics. All the files that are associated with database are in model directory.
2. All routes are defined by using fat free in index file.
3. All the database functionality defined with PDO and prepared statements. Each method inside our dataObject.php used this layer.
4. In model directory our project.php class provides the functionality to add and get all the information from database as well as delete and update. 
5. Each memeber made commits after changing or updating any thing in our project.
6. We have used two classes one is DataObject and the other one is Project class. Project class extends from DataObject class. All the database functionality is in DataObject class so the Project class calls its parent class functions for making any change or getting any information from database. These files avaiables in model with name dataObject.php and project.php.
7. All php files that are in model contained docblocks.
8. All the validation, insertion and update information in project has been completed with ajax, php and jquery. All javascript files are in scripts directory. 
