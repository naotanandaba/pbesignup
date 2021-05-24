<?php
include "db.php";

session_start();

$nombreuser = mysqli_real_escape_string($conn, $_POST['nombreuser']);
$password1 = mysqli_real_escape_string($conn, $_POST['password1']);
$password2 = mysqli_real_escape_string($conn, $_POST['password2']);

if(strcmp($password1,$password2) == 0){
    if (isset($nombreuser) && isset($contrasenya1) && isset($contrasenya2)) {
        $name_bbdd = "SELECT name FROM students WHERE name LIKE '%" . $nombreuser . "%'";
        if(mysqli_query($conn, $name_bbdd)){
            $salt = 'SHIFLETT';
            $password_hash = hash('sha256', $salt . hash('sha256', $contrasenya1 . $salt));
            echo $password_hash;
            $sql = "INSERT INTO students (id_student, name, password) VALUES ('', '$nombreuser',  '$password_hash')";
                if (mysqli_query($conn, $sql)) {
                    $_SESSION['nombreuser'] = $nombreuser;
                    header('Location: ../tablas.php');
                } else {
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                }
        }else{
            echo "<script> alert('ERROR usuario existente');
                                window.location= '../registro.php'
                                </script>";
        }
            
    } else {
        echo "Faltan campos por rellenar";
    }
} else {
    echo "<script> alert('ERROR en las contraseña');
                                    window.location= '../registro.php'
                                </script>";
}
// close connection
mysqli_close($conn);
?>