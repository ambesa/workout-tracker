<?php



function getSets($eid) {
    $sql = "SELECT SetID, SetOrder, Repetitions, Quantity 
            FROM Sets
            WHERE ExerciseID = :eid
            ORDER BY SetOrder ASC";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("eid", $eid);
        $stmt->execute();
        $sets = $stmt->fetchAll(PDO::FETCH_OBJ);
        //$exercises = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $set_list['sets'] = $sets;
        return $set_list;
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

?>