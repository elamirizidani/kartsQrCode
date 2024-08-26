<?php

class Databases
{
    public $con;
    public $db;
    public function __construct()
    {
        $this->con = mysqli_connect("localhost", "root", "root", "karts");

        $this->db = "karts";
        if (!$this->con) {
            echo 'Database Connection Error ' . mysqli_connect_error($this->con);
        }
    }
    function insert($tbl_name, $data)
    {
        // Check if $data is a multi-dimensional array
        if (isset($data[0]) && is_array($data[0])) {
            // Handle multiple rows
            $columns = implode(",", array_keys($data[0]));
            $values = [];

            foreach ($data as $row) {
                $values[] = "('" . implode("','", array_values($row)) . "')";
            }

            $valuesString = implode(",", $values);
            $query = "INSERT INTO " . $tbl_name . " (" . $columns . ") VALUES " . $valuesString;
        } else {
            // Handle single row
            $query = "INSERT INTO " . $tbl_name . " (";
            $query .= implode(",", array_keys($data)) . ') VALUES (';
            $query .= "'" . implode("','", array_values($data)) . "')";
        }

        if (mysqli_query($this->con, $query)) {
            return true;
        } else {
            return false;
        }
    }

    function read($table)
    {
        $tables = mysqli_query($this->con, "SELECT * FROM " . $table . "");
        while ($table = mysqli_fetch_assoc($tables)) {
            $array[] = $table;
        }
        if (!empty($array))
            return $array;
    }
    
    function readCondition($table, $condition)
    {
        $cond = "";
        foreach ($condition as $key => $value) {
            $cond .="`". $key . "`='" . $value . "' AND ";
        }
        $cond = substr($cond, 0, -5);
        $select = mysqli_query($this->con, "SELECT * FROM " . $table . " WHERE " . $cond . "");
        
        while ($selects = mysqli_fetch_assoc($select)) {
            $array[] = $selects;
        }
        if (!empty($array))
            return $array;
    }


    function update($table, $condition, $data)
    {
        $cond = "";
        $fields = "";

        foreach ($data as $key => $value) {
            $fields .= $key . "='" . $value . "',";
        }
        $fields = substr($fields, 0, -1);

        foreach ($condition as $key => $value) {
            $cond .= $key . "='" . $value . "' AND ";
        }
        $cond = substr($cond, 0, -5);

        $table = mysqli_query($this->con, "UPDATE " . $table . " SET " . $fields . " WHERE " . $cond . "");
        if ($table)
            return true;
    }

    function searchDictionary($table, $condition)
    {
        $cond = "";
        foreach ($condition as $key => $value) {
            $cond .= $key . " LIKE '%" . $value . "%' AND ";
        }
        $cond = substr($cond, 0, -4);
        $select = mysqli_query($this->con, "SELECT * FROM " . $table . " WHERE " . $cond . "");
        while ($selects = mysqli_fetch_assoc($select)) {
            $array[] = $selects;
        }
        if (!empty($array))
            return $array;
    }

    function search($table, $condition)
    {
        $cond = "";
        foreach ($condition as $key => $value) {
            $cond .= $key . "='" . $value . "' AND ";
        }
        $cond = substr($cond, 0, -5);
        $select = mysqli_query($this->con, "SELECT * FROM " . $table . " WHERE " . $cond . "");
        while ($selects = mysqli_fetch_assoc($select)) {
            $array[] = $selects;
        }
        if (!empty($array))
            return $array;
    }

    function getClassName($classId){
        $projects = mysqli_query($this->con, "SELECT * FROM `class` JOIN `sections` ON `sections`.`sectionId` = `class`.`sectionId` JOIN `subClass` on `class`.`classId` =`subClass`.`classId` WHERE `subClass`.`subClassId` = '$classId'");
        while($project = mysqli_fetch_assoc($projects))
        {
            $array[] = $project;
        }
        if(!empty($array))
            return $array;
    }


    function readInCondition($table, $condition)
    {
        $cond = "";
        foreach ($condition as $key => $value) {
            if (is_array($value)) {
                $valueList = implode(',', array_map('intval', $value));
                $cond .= "`" . $key . "` IN (" . $valueList . ") AND ";
            } else {
                $cond .= "`" . $key . "`='" . mysqli_real_escape_string($this->con, $value) . "' AND ";
            }
        }
        $cond = substr($cond, 0, -5); // Remove the trailing ' AND '
// echo "SELECT * FROM " . $table . " WHERE " . $cond;
        $query = "SELECT * FROM " . $table . " WHERE " . $cond;
        $select = mysqli_query($this->con, $query);

        $array = [];
        while ($selects = mysqli_fetch_assoc($select)) {
            $array[] = $selects;
        }
        if (!empty($array)) {
            return $array;
        }
        return [];
    }

    function insertReturnId($tbl_name, $data)
    {
        $string = "INSERT INTO " . $tbl_name . "(";
        $string .= implode(",", array_keys($data)) . ') VALUES (';
        $string .= "'" . implode("','", array_values($data)) . "')";
        if (mysqli_query($this->con, $string)) {
            $last_id = mysqli_insert_id($this->con);
            return $last_id;
        }
    }

    function removeDuplicates($array) {
        // Create an associative array to track unique values
        $uniqueValues = array();
    
        foreach ($array as $value) {
            $uniqueValues[$value] = true;
        }
    
        // Return the keys of the associative array, which are the unique values
        return array_keys($uniqueValues);
    }


    function readJoinCondition($table, $joins = [], $condition = [])
{
    // Construct the FROM clause
    $fromClause = "`" . $table . "`";

    // Construct the JOIN clause
    $joinClause = "";
    foreach ($joins as $join) {
        $joinType = isset($join['type']) ? strtoupper($join['type']) : 'INNER';
        $joinClause .= " $joinType JOIN `" . $join['table'] . "` ON " . $join['on'] . " ";
    }

    // Construct the WHERE clause
    
    if(!empty($condition))
    {
        $cond = " WHERE ";
    }
    else{
        $cond = "";
    }
    foreach ($condition as $key => $value) {
        $cond .= "" . $key . "='" . $value . "' AND ";
    }
    $cond = substr($cond, 0, -5); // Remove trailing ' AND '

    // Construct the full SQL query
    // echo "SELECT * FROM " . $fromClause . " " . $joinClause . " " . $cond;
    $query = "SELECT * FROM " . $fromClause . " " . $joinClause . " " . $cond;

    // Execute the query
    $select = mysqli_query($this->con, $query);

    // Fetch results
    $array = [];
    while ($selects = mysqli_fetch_assoc($select)) {
        $array[] = $selects;
    }

    // Return the results if not empty
    if (!empty($array)) {
        return $array;
    }
}

function find_consecutive_sequences($records, $sequence_length) {
    $sequences = array();
    $count = count($records);

    for ($i = 0; $i <= $count - $sequence_length; $i++) {
        $is_sequence = true;
        for ($j = 1; $j < $sequence_length; $j++) {
            if ($records[$i]['value'] != $records[$i + $j]['value']) {
                $is_sequence = false;
                break;
            }
        }

        if ($is_sequence) {
            $sequences[] = array_slice($records, $i, $sequence_length);
            $i += $sequence_length - 1; // Skip the sequence we just found
        }
    }

    return $sequences;
}



}

// where name like '%$a%';