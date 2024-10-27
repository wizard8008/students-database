<?php
$conn = new mysqli('localhost', 'root', '', 'students');
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sql = "SELECT * FROM students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>List of Students</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap">
</head>
<body>
    <h1>List of Students</h1>
    <a href="add.php" class="add-student" style="margin-bottom: 25px;"><span>Add New Student</span></a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($linha = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $linha['id'] . "</td>";
                echo "<td>" . $linha['name'] . "</td>";
                echo "<td>" . $linha['email'] . "</td>";
                echo "<td>" . $linha['contact'] . "</td>";
                echo "<td>
                    <a href='edit.php?id=" . $linha['id'] . "'>Edit</a> | 
                    <a href='delete.php?id=" . $linha['id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No records found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>