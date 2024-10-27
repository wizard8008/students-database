<?php
$conn = new mysqli('localhost', 'root', '', 'students');
if ($conn->connect_error) {
    die("Connection failure: " . $conn->connect_error);
}

$error_message = "";
$name = $email = $contact = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    if (empty($name) || empty($email) || empty($contact)) {
        $error_message = "All fields are required!";
    } 
    elseif (!preg_match("/^[a-zA-Zа-яА-ЯёЁ]+$/u", $name)) {
        $error_message = "The name can contain only letters!";
    } 
    elseif (!preg_match("/^\+\d{12}$/", $contact)) {
        $error_message = "The phone number must begin with '+' and contain 12 digits!";
    } 
    else {
        $stmt = $conn->prepare("INSERT INTO students (name, email, contact) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $contact);

        if ($stmt->execute()) {
            header('Location: index.php');
            exit();
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Student</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap">
</head>
<body>
    <h1>Add New Student</h1>
    
    <?php if ($error_message): ?>
        <div style="color: #ff5252; margin-bottom: 15px;"><?= $error_message; ?></div>
    <?php endif; ?>

    <form name="studentForm" method="post" action="" onsubmit="return validateForm()" style="background-color: #333; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);">
    <label for="name" style="display: block; margin-bottom: 5px;">Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($name); ?>" style="width: 90%; padding: 10px; border-radius: 5px; border: 1px solid #333; margin-bottom: 15px;">
    
    <label for="email" style="display: block; margin-bottom: 5px;">Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($email); ?>" style="width: 90%; padding: 10px; border-radius: 5px; border: 1px solid #333; margin-bottom: 15px;">
    
    <label for="contact" style="display: block; margin-bottom: 5px;">Contact:</label>
    <input type="text" name="contact" value="<?= htmlspecialchars($contact); ?>" maxlength="13" style="width: 90%; padding: 10px; border-radius: 5px; border: 1px solid #333; margin-bottom: 15px;">
    
    <input type="submit" value="Add" class="add-student" style="background-color: #a1ff6a; color: #000000; border: none; cursor: pointer; transition: background-color 0.3s; width: 100%; padding: 10px; border-radius: 5px;">
</form>

    <br>
    <a href="index.php" class="add-student">Back</a>
</body>
</html>

<?php
$conn->close();
?>
