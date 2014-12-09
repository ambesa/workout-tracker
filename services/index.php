<?php

require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// Workouts
$app->get('/workouts', 'getWorkouts');
$app->post('/workouts', 'addWorkout');
$app->delete('/workouts/:wid/', 'deleteWorkout');
//$app->get('/workouts/:id',  'getWorkout');
//$app->get('/workouts/search/:query', 'findByName');
//$app->post('/workouts', 'addWorkout');
//$app->put('/workouts/:id', 'updateWorkout');
//$app->delete('/workouts/:id',   'deleteWorkout');
// Exercises
$app->get('/workouts/:wid/exercises', 'getExercises');
$app->post('/workouts/:wid/exercises', 'addExercise');
$app->delete('/workouts/:wid/exercises/:eid', 'deleteExercise');

// Sets
$app->get('/workouts/:wid/exercises/:eid/sets', 'getSets');
$app->post('/workouts/:wid/exercises/:eid/sets', 'addSet');
$app->delete('/workouts/:wid/exercises/:eid/sets/:sid', 'deleteSet');

$app->run();
 
function getWorkouts() {
    $sql = "SELECT WorkoutID, PersonID, StartDate, EndDate, Location, Notes 
            FROM Workouts
            ORDER BY StartDate DESC";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $workouts = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"workouts": ' . json_encode($workouts) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function getExercises($wid) {
    $sql = "SELECT ExerciseID, WorkoutID, ExerciseOrder, ExerciseName 
            FROM Exercises
            WHERE WorkoutID = :wid";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("wid", $wid);
        $stmt->execute();
        $exercises = $stmt->fetchAll(PDO::FETCH_OBJ);
        //$exercises = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"exercises": ' . json_encode($exercises) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function getSets($wid, $eid) {
    $sql = "SELECT SetID, ExerciseID, SetOrder, Repetitions, Quantity 
            FROM Sets
            WHERE ExerciseID = :eid
            ORDER BY SetOrder ASC";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("eid", $eid);
        $stmt->execute();
        $exercises = $stmt->fetchAll(PDO::FETCH_OBJ);
        //$exercises = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"sets": ' . json_encode($exercises) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function getWorkout($id) {
    $sql = "SELECT * FROM wine WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $wine = $stmt->fetchObject();
        $db = null;
        echo json_encode($wine);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function addWorkout() {
    $request = \Slim\Slim::getInstance()->request();
    $workout = json_decode($request->getBody());
    $sql = "INSERT INTO Workouts (PersonID, StartDate, EndDate, Location, Notes) VALUES (1, :startdate, :enddate, :location, :notes)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("startdate", $workout->StartDate);
        $stmt->bindParam("enddate", $workout->EndDate);
        $stmt->bindParam("location", $workout->Location);
        $stmt->bindParam("notes", $workout->Notes);
        $stmt->execute();
        $workout->id = $db->lastInsertId();
        $db = null;
        echo json_encode($workout);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function addExercise($wid) {
    $request = \Slim\Slim::getInstance()->request;
    $exercise = json_decode($request->getBody());

    $sql = "SELECT MAX(ExerciseOrder) as max_exercise_order FROM Exercises WHERE WorkoutID = :workoutid";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam('workoutid', $wid);
        $stmt->execute();
        $db = null;
        $max_order = $stmt->fetchObject();
        print_r($max_order);
        $new_order = $max_order->max_exercise_order + 1;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
    $sql = "INSERT INTO Exercises (WorkoutID, ExerciseOrder, ExerciseName) VALUES (:wid, :exerciseorder, :exercisename)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":wid", $wid);
        $stmt->bindParam(":exerciseorder", $new_order);
        $stmt->bindParam(":exercisename", $exercise->ExerciseName);
        $stmt->execute();
        $exercise->id = $db->lastInsertId();
        $db = null;
        echo json_encode($exercise);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function addSet($wid, $eid) {
    $request = \Slim\Slim::getInstance()->request;
    $set = json_decode($request->getBody());
    print_r($set);

    $sql = "SELECT MAX(SetOrder) as max_set_order FROM Sets WHERE ExerciseID = :exerciseid";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':exerciseid', $eid);
        $stmt->execute();
        $db = null;
        $max_order = $stmt->fetchObject();
        $new_order = $max_order->max_set_order + 1;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
    $sql = "INSERT INTO Sets (ExerciseID, SetOrder, Quantity, Repetitions) VALUES (:exerciseid, :setorder, :quantity, :repetitions)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        print_r($set);
        $stmt->bindParam(":exerciseid", $eid);
        $stmt->bindParam(":setorder", $new_order);
        $stmt->bindParam(":quantity", $set->Quantity);
        $stmt->bindParam(":repetitions", $set->Repetition);
        $stmt->execute();
        $set->id = $db->lastInsertId();
        $db = null;
        echo json_encode($set);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function updateWorkout($id) {
    $request = Slim::getInstance()->request();
    $body = $request->getBody();
    $wine = json_decode($body);
    $sql = "UPDATE wine SET name=:name, grapes=:grapes, country=:country, region=:region, year=:year, description=:description WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("name", $wine->name);
        $stmt->bindParam("grapes", $wine->grapes);
        $stmt->bindParam("country", $wine->country);
        $stmt->bindParam("region", $wine->region);
        $stmt->bindParam("year", $wine->year);
        $stmt->bindParam("description", $wine->description);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
        echo json_encode($wine);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function deleteWorkout($id) {
    $sql = "DELETE FROM wine WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function deleteExercise($wid, $eid) {
    $sql = "DELETE 
            FROM Exercises
            WHERE ExerciseID = :eid";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":eid", $eid);
        $stmt->execute();
        $db = null;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function deleteSet($wid, $eid, $sid) {
    $sql = "DELETE 
            FROM Sets
            WHERE SetID = :set_id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":set_id", $sid);
        $stmt->execute();
        $db = null;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function findByName($query) {
    $sql = "SELECT * FROM wine WHERE UPPER(name) LIKE :query ORDER BY name";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $query = "%".$query."%";
        $stmt->bindParam("query", $query);
        $stmt->execute();
        $wines = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"wine": ' . json_encode($wines) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function getConnection() {
    $dbhost="127.0.0.1";
    $dbuser="dbuser";
    $dbpass="123";
    $dbname="dbname";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
 
?>