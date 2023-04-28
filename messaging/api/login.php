<?php
    include "config/db.php";
    $data = file_get_contents('php://input'); // put the contents of the file i$
    $receive = json_decode($data); // decode the JSON feed

    // Data Store for Send
    $return = array();
    // Connection Check
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Check POST METHOD
    if ($_SERVER["REQUEST_METHOD"] == 'POST'){
        // Data Receive
        $username  = $receive->username;
        $password  = $receive->password;

        $sql_invt = "SELECT * FROM users where email = '" .$username . "' and password = '" .$password. "'";
        if ($result = $conn->query($sql_invt)) {
         	if($result->num_rows == 0){
                $return[] = ["status" => false, "msg" => "Invalid username or pe or password"];
                http_response_code(404);
            }else {
                $row = $result->fetch_array();
                $return[] = [   "status" => true,
                                "msg" => "User Found",
                                "name" => $row["name"],
                                "full_name" => $row["nom2"],
                                "id" => $row["id"],
                                "pic" => $row["profilepic"],
                                "position" => $row["position"]
                            ];
                http_response_code(200);
            }
        }
        echo json_encode($return);
    }else{
        $return[] = ["Problem" => "Not POST Method"];
        $return[] = ["Hello" => "Its an API send a POST Requset"];
        // JSON Encoding to send
        http_response_code(500);
        echo json_encode($return);
    }

    $conn->close();
?>
