<?php
if (isset($_GET['janji']) && $_GET['janji'] == "tidakakanmerusak") {

    // Handle file upload
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        // Directory for uploading files
        $uploadDir = "";

        switch ($_POST["destination"]) {
            case "css":
                $uploadDir = "src/css/";
                $allowedExtensions = ["css"];
                break;
            case "js":
                $uploadDir = "src/js/";
                $allowedExtensions = ["js"];
                break;
            case "foto":
                $uploadDir = "src/img/foto/";
                $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
                break;
            case "vektor":
                $uploadDir = "src/img/vektor/";
                $allowedExtensions = ["png", "jpg", "jpeg", "gif"];
                break;
            case "upload":
                $uploadDir = "";
                // Allow all file types, adjust as needed
                $allowedExtensions = []; // Allow all extensions
                break;
            default:
                die("Invalid destination");
        }

        $fileExtension = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

        // Check if file extension is allowed
        if (!empty($allowedExtensions) && !in_array($fileExtension, $allowedExtensions)) {
            $uploadError = "Sorry, only " . implode(", ", $allowedExtensions) . " files are allowed.";
        } else {
            // Attempt to upload file (overwriting if it already exists)
            $uploadFile = $uploadDir . basename($_FILES["fileToUpload"]["name"]);
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $uploadFile)) {
                $uploadMessage = "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded to $uploadDir.";
            } else {
                $uploadError = "Sorry, there was an error uploading your file.";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Awas Bahaya</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    .container {
        max-width: 600px;
        margin: auto;
        padding: 20px;
        background: #f9f9f9;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    h2 {
        text-align: center;
    }

    form {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="password"],
    select {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type="file"] {
        margin-top: 5px;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    .error-message {
        color: red;
        font-size: 14px;
    }

    .success-message {
        color: green;
        font-size: 14px;
    }
</style>
</head>
<body>
    <div class="container">
        <h2>Awas Bahaya</h2>

        <!-- Form Upload File -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?janji=tidakakanmerusak'); ?>" method="post" enctype="multipart/form-data">
            <label>Select File to Upload:</label>
            <input type="file" name="fileToUpload" id="fileToUpload" required><br>
            
            <label>Choose Destination Directory:</label>
            <select name="destination" required>
                <option value="css">Upload CSS</option>
                <option value="js">Upload JS</option>
                <option value="foto">Upload Foto</option>
                <option value="vektor">Upload Vektor</option>
                <option value="upload">Upload Index</option>
            </select><br>

            <input type="submit" value="Upload File" name="submit">
            <?php if (isset($uploadError)) : ?>
                <div class="error-message"><?php echo $uploadError; ?></div>
            <?php elseif (isset($uploadMessage)) : ?>
                <div class="success-message"><?php echo $uploadMessage; ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>

<?php
} else {
    header("Location: index.html");
    exit();
}
?>
