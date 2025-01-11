<?php
$con = new mysqli("localhost", "u402400705_brgyaurelio", "!E6u6lTz0", "u402400705_brgyaurelio");

// Check for connection errors
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$con->set_charset("utf8");

extract($_POST);
extract($_GET); // Fixed typo from "extrat" to "extract"

if (isset($new_program)) {
    // Prepared statement to prevent SQL injection
    $sql = "INSERT INTO `programs` (`program_name`, `program_desc`, `program_status`, `program_members`) 
            VALUES (?, ?, '0', '0')";
    
    // Prepare the statement
    $stmt = $con->prepare($sql);
    
    // Bind parameters to the statement
    $stmt->bind_param("ss", $program_title, $program_desc); // "ss" means two string parameters
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "1"; // Successfully inserted
    } else {
        echo "0"; // Failed to insert
    }
    
    // Close the statement
    $stmt->close();
}

// Close the connection


if (isset($editProgramform)) {
    // Prepare the SQL query with placeholders
    $sql = "UPDATE `programs` 
            SET `program_name` = ?, `program_desc` = ?, `program_status` = ? 
            WHERE `program_id` = ?";
    
    // Prepare the statement
    $stmt = $con->prepare($sql);
    
    if ($stmt) {
        // Bind parameters to the prepared statement
        // "sssi" means: string, string, string, integer
        $stmt->bind_param("sssi", $program_title, $program_desc, $program_status, $program_id);
        
        // Execute the query
        if ($stmt->execute()) {
            echo "1"; // Success
        } else {
            echo "0"; // Failure
        }
        
        // Close the statement
        $stmt->close();
    } else {
        // Error in preparing the statement
        echo "Error preparing statement: " . $con->error;
    }
}

if(isset($delete_program)){
    
    $sql ="DELETE FROM `programs` WHERE `program_id`='$program_id'";
    $query = $con->query($sql);
    if(query){
        echo "1";
    }else{
        echo "0";
    }
    
}
if(isset($delete_progmem)){
    
    $sql ="DELETE FROM `program_mem` WHERE `progmem_id`='$progmem_id'";
    $query = $con->query($sql);
    if(query){
        echo "1";
    }else{
        echo "0";
    }
    
}
if (isset($backup_database)) {
    $host = 'localhost';
    $username = 'u402400705_brgyaurelio';
    $password = '!E6u6lTz0';
    $dbname = 'u402400705_brgyaurelio';

    // Set a dynamic file name
    $filename = $dbname . '_backup_' . date('Y-m-d_H-i-s') . '.sql';

    // Set headers to force download of the SQL file
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Connect to the database
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Function to export the database to SQL
    function backupDatabase($conn, $dbname) {
        $tables = [];
        $result = $conn->query("SHOW TABLES");

        while ($row = $result->fetch_row()) {
            $tables[] = $row[0];
        }

        $sql = "";

        foreach ($tables as $table) {
            // Get the table creation statement
            $createTableResult = $conn->query("SHOW CREATE TABLE $table");
            $createTableRow = $createTableResult->fetch_row();
            $sql .= $createTableRow[1] . ";\n\n";

            // Get the table data
            $dataResult = $conn->query("SELECT * FROM $table");
            while ($rowData = $dataResult->fetch_assoc()) {
                $sql .= "INSERT INTO $table (" . implode(",", array_keys($rowData)) . ") VALUES ('" . implode("','", array_values($rowData)) . "');\n";
            }

            $sql .= "\n\n";
        }

        return $sql;
    }

    // Generate the SQL backup file
    $sqlBackup = backupDatabase($conn, $dbname);

    // Output the SQL data
    echo $sqlBackup;

    // Close connection

}


?>
