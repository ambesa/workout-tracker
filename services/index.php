<?php

require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

include 'functions/Workouts.php';
include 'functions/Exercises.php';
include 'functions/Sets.php';
include 'functions/Special.php';
include 'functions/DatabaseConnection.php';

// Workouts

$app->get('/all', function() {
    echoJSON(getAll());
});

$app->get('/workouts', function() {
    echoJSON(getWorkouts());
});
$app->post('/workouts', 'addWorkout');
$app->delete('/workouts/:wid/', 'deleteWorkout');
//$app->get('/workouts/:id',  'getWorkout');
//$app->get('/workouts/search/:query', 'findByName');
//$app->post('/workouts', 'addWorkout');
//$app->put('/workouts/:id', 'updateWorkout');
//$app->delete('/workouts/:id',   'deleteWorkout');

// Exercises
$app->get('/workouts/:wid/exercises', function($wid) {
    echoJSON(getExercises($wid));
});
$app->post('/workouts/:wid/exercises', 'addExercise');
$app->delete('/workouts/:wid/exercises/:eid', 'deleteExercise');

// Sets
$app->get('/workouts/:wid/exercises/:eid/sets', function($wid, $eid) {
    echoJSON(getSets($eid));
});
$app->post('/workouts/:wid/exercises/:eid/sets', 'addSet');
$app->delete('/workouts/:wid/exercises/:eid/sets/:sid', 'deleteSet');

$app->run();
 
?>