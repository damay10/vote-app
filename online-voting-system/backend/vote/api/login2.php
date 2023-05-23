<?php
    session_start();
    include("connection.php");

    $mobile = "";
    $password = "";
    $role = "";

    if (isset($_POST['mobile'])) {
        $mobile = $_POST['mobile'];
    }
    
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    }
    
    if (isset($_POST['role'])) {
        $role = $_POST['role'];
    }
    
    // $stmt = $connect->prepare("SELECT * from user WHERE mobile=? AND password=? AND role=?");
    // $stmt->bind_param("sss", $mobile, $password, $role);
    // $stmt->execute();
    // echo $connect->error;
    // $result = $stmt->get_result();

    $result = mysqli_query
    ($connect, "SELECT * from user WHERE mobile='$mobile' AND password='$password' AND role='$role");

    echo "ini result";
    $dataresult = mysqli_fetch_assoc($result);
    var_dump($dataresult);

    if($result) {
        var_dump($result);
        if($result->num_rows > 0) {
            $getGroups = $connect->query("SELECT name, photo, votes, id FROM user WHERE role=2");
            if ($getGroups && $getGroups->num_rows > 0) {
                $groups = $getGroups->fetch_all(MYSQLI_ASSOC);
                $_SESSION['groups'] = $groups;
            }
            $data = $result->fetch_array();
            $_SESSION['id'] = $data['id'];
            $_SESSION['status'] = $data['status'];
            $_SESSION['data'] = $data;
            echo '<script>
                    window.location = "../routes/dashboard.php";
                </script>';
        } else{
            echo "Error";
            echo mysqli_error($connect);
            echo '<script>
                alert("Invalid credentials!");
                // window.location = "../";
            </script>';
        }
    } else {
        echo 'Query error: ' . $connect->error;
    }

    //$stmt->close();
    $connect->close();
?>