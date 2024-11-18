<?php
$conn = new mysqli("localhost", "root", "", "form_signup");

if($conn->connect_error){
    die("Connection failed" . $conn->connect_error);
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST["add"])){
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password= $_POST["password"];
        $conn->query("INSERT INTO users(name,email,password) VALUES ('$name', '$email' , '$password')");
    }elseif (isset($_POST["delete"])) {
        $id = $_POST["id"];
        $conn->query("DELETE FROM users WHERE id = $id");
    }
}
$results = $conn->query("SELECT id, name ,email, password from users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Sign Up</h1>
    <div class="container">
        <form action="index.php" method="post">
            <input type="hidden" name="id" id="id">
            <label for="name">Enter Full Name</label>
            <br>
            <input type="text" name="name" id="name" placeholder="Enter Full Name" required>
            <br>
            <label for="email">Enter Email</label>
            <br>
            <input type="email" name="email" id="email" placeholder="abc@hotmail.com" required>
            <br>
            <label for="password">Enter 8 character password</label>
            <br>
            <input type="password" name="password" id="password" maxlength="8" required >
            <br>
            <button type="submit" name="add" id="add">Sign Up Now</button>
        </form>
    </div>
    <h1> Retrieving Your Data </h1>
    <div class="container-fluid">
        <table>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>email</th>
                <th>password</th>
                <th>action</th>
            </tr>
            <?php
                if($results->num_rows>0){
                    while ($row = $results -> fetch_assoc()){
                        echo "<tr>";
                            echo "<td>" .$row['id'] . "</td>";
                            echo "<td>" .$row['name'] . "</td>";
                            echo "<td>" .$row['email'] . "</td>";
                            echo "<td>" .$row['password'] . "</td>";
                            echo "<td>
                                <form action='index.php' method='post'>
                                    <input type='hidden' name='id' id='id' value='".$row['id']."'>
                                     <button type='submit' name='delete' id='delete' onclick='return confirm(\"Are you sure you want to delete?\")'>Delete</button>
                                </form>
                            </td>";
                        echo "</tr>";
                    }
                }else{
                    echo "<tr><td colspan='5'> No items found </td></tr>";
                }
                $conn ->close();
            ?>
        </table>
    </div>
</body>
</html>