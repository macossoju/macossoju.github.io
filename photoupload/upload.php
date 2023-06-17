<?php
if ($_FILES["file"]["name"] != '') {
    $allowed_extensions = array("jpg", "jpeg", "png");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);
    $upload_path = "uploads/";

    if (
        ($_FILES["file"]["type"] == "image/jpeg" || $_FILES["file"]["type"] == "image/png") &&
        in_array($extension, $allowed_extensions)
    ) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Error: " . $_FILES["file"]["error"];
        } else {
            $file_name = $_FILES["file"]["name"];
            $file_path = $upload_path . $file_name;

            if (file_exists($file_path)) {
                echo "File already exists.";
            } else {
                move_uploaded_file($_FILES["file"]["tmp_name"], $file_path);
                echo "<img src='$file_path' class='img-thumbnail' width='300' height='250' />";
            }
        }
    } else {
        echo "Invalid file format. Only JPG, JPEG, and PNG files are allowed.";
    }
} else {
    echo "No file selected.";
}
?>
