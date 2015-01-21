<?php

function getAll() {
    $workout_log = getWorkouts();
    $workouts = $workout_log['workouts'];
    foreach($workouts as $workout){
        $workout_id = $workout->WorkoutID;
        $exercise_list = getExercises($workout_id);
        $workout->Exercises = $exercise_list['exercises'];
        foreach($workout->Exercises as $exercise){
            $exercise_id = $exercise->ExerciseID;
            $set_list = getSets($exercise_id);
            $exercise->Sets = $set_list['sets'];
        }
    }
    return $workout_log;
}

function getWorkouts() {
    $sql = "SELECT WorkoutID, PersonID, StartDate, EndDate, Location, Notes 
            FROM Workouts
            ORDER BY StartDate DESC";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $workouts = $stmt->fetchAll(PDO::FETCH_OBJ);
        foreach ($workouts as $workout) {
            $date = substr($workout->StartDate, 0, 10);
            $time = substr($workout->StartDate, 11, 8);
            $workout->StartDate = $date . 'T' . $time;
        }
        $db = null;
        $workout_log['workouts'] = $workouts;
        return $workout_log;
    } catch(PDOException $e) {
        return echoError($e->getMessage());
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
 
?>