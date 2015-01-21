workout-tracker
===============
This web app allows you to enter in and save your workouts. It will present graphs that show your progress over time. It will also provide recommendations to improve your next workout. It's divided into three main views.

>###Workout Log View
>In this view, you see the list of workouts ordered by date. At the top, you can quickly add a new workout to your workout log. To see more info about a particular workout, click on a specific date.

>### Workout Info View
>When you click on a specific workout date, you're taken to the workout info page. Here, you can add the exercises you completed, e.g. 'Bench Press', 'Squat', or 'Deadlift'. 

>### Exercise Info View
>When you click on a specific exercise on the workout info page, you're taken to the exercise info page. On this page, you can enter in the sets and repetitions you performed for that particular exercise.

## [Demo](http://mattagra.com/workout-tracker/#/workouts)

## Setting Up
* In 'services/index.php', look at the getConnection() function at the end of the file and modify the values for *$dbhost*, *$dbuser*, *$dbpass*, and *$dbname*.
* Run the SQL query in the 'sql' folder to set up the necessary tables in your database. 

## Todo
* Graph exercise sets/repetiions over time
* Present weight & repetiion recommendations to user for next workout based on last workout
* Calendar view for workout log
* Update entered information
