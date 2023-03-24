<?php
    require "db.php";

    $dataPurpose = $_GET['dataPurpose'];

    if ($conn)
    {
        switch ($dataPurpose) 
        {
            case "addData":
                If(isset($_POST["name"]) && isset($_POST["price"]))
                {
                    $data = array(
                        "name" => test_input($_POST["name"]),
                        "price" => test_input($_POST["price"])
                    );

                    // Get keys string from data array
                    $columns = $this->implodeArray(array_keys($data));

                    // Get values string from data array with prefix (:) added
                    $prefixed_array = preg_filter('/^/', ':', array_keys($data));
                    $values = $this->implodeArray($prefixed_array);

                    try {
                        // prepare sql and bind parameters
                        $sql = "INSERT INTO data ($columns) VALUES ($values); SELECT LAST_INSERT_ID();";
                        $stmt = $conn->prepare($sql);

                        // insert row
                        $stmt->execute($data);
                        
                        $resultData = $conn->lastInsertId();

                        echo json_encode(" ['response' => true, 'message' => 'Data Submitted Successfully', 'code' => '0', 'data' => $resultData]");
                    }
                    catch (PDOException $error) {
                        
                        echo json_encode(" ['response' => false, 'message' => 'Error! '.$error, 'code' => '1', 'data' => '']");
                    }

                }    
                break;
            case "getAllData":
                If(isset($_POST["getData"]))
                {
                    // Get all categories
                    $stmt = $conn->prepare("SELECT * FROM `data`");
                    if($stmt->execute())
                    {
                        $datalist = $stmt->fetchAll();

                        foreach ($datalist as $data) :
                            $insideDt .= '
                            <tr>
                                <th scope="row">'.$data["name"].'</th>
                                    <td>'.$data["price"].'</td>
                                <td>
                                    <button class="btna1 mr-2" onclick="editData("'.$data["id"].'")">Edit</button>
                                    <button class="btna2" onclick="deleteData('.$data["id"].')">Delete</button>
                                </td>
                            </tr>
                            ';
                        endforeach;

                        echo json_encode("['response' => true, 'message' => 'Success getting Data, 'code' => '0', 'data' => $insideDt]");
                    }
                    else
                    {
                        echo json_encode("['response' => false, 'message' => 'System Processing Error!', 'code' => '1', 'data' => '']");
                    }
                }
                break;
            case "editData":
                If(isset($_POST["name"]) && isset($_POST["price"]) && isset($_POST["pid"]))
                {
                    $sql = "UPDATE `data` SET `name`= ?, `price`= ? WHERE `pid` = ?";
                                            
                    $stmt = $conn->prepare($sql);

                    if($stmt->execute([$_POST["name"], $_POST["price"], $_POST["pid"]]))
                    {
                        echo json_encode( ['response' => true, 'message' => 'Data updated Successfully', 'code' => '0', 'data' => '']);
                    }
                }
                break;
            case "deleteData":
                If(isset($_POST["pid"]))
                {
                    $sql = "DELETE` FROM data WHERE `id` = ?";
                                        
                    $stmt = $conn->prepare($sql);

                    if($stmt->execute([$_POST["pid"]]))
                    {
                        echo json_encode( ['response' => true, 'message' => 'Data deleted successfully', 'code' => '0', 'data' => '']);
                    }
                    else
                    {
                        echo json_encode( ['response' => false, 'message' => 'Unable to delete Data', 'code' => '1', 'data' => '']);
                    }
                }
                break;
                default:
                    echo json_encode("['response' => false, 'message' => 'System Processing Error!', 'code' => '1', 'data' => '']");
        }
        
    }

    function implodeArray($array){
        return implode(", ", $array);
    }

    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>