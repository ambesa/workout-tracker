<?php

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
        // Add Sets to Exercises
        foreach($exercises as $exercise){
            $exercise_id = $exercise->ExerciseID;
            $set_list = getSets($exercise_id);
            $exercise->Sets = $set_list['sets'];

            // Add Set Min to Exercises
            //$exercise_min = getExerciseMin($exercise_id);
            $exercise->ExerciseStats = getExerciseStats($exercise_id)[0];//$exercise_min['exercise_min'];
        }

        // Create Exercises Object
        $exercise_list['exercises'] = $exercises;
        return $exercise_list;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getExerciseStats($eid) {
    $sql = "SELECT MIN(Quantity) as ExerciseMin, MAX(Quantity) as ExerciseMax, ROUND(AVG(Quantity)) as ExerciseAvg
            FROM Sets
            WHERE ExerciseID = :eid";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("eid", $eid);
        $stmt->execute();
        $stats = $stmt->fetchAll(PDO::FETCH_OBJ);
        //$exercises = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //$exercise_min['exercise_min'] = $min;
        return $stats;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getExerciseMax($eid) {
    $sql = "SELECT MAX(Quantity) 
            FROM Sets
            WHERE ExerciseID = :eid";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("eid", $eid);
        $stmt->execute();
        $max = $stmt->fetchAll(PDO::FETCH_OBJ);
        //$exercises = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $exercise_max['exercise_max'] = $max;
        return $exercise_max;
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

?>