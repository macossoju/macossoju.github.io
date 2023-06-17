<?php
// Check if a file was uploaded successfully
if ($_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
  $targetDir = "uploads/"; // Specify the directory where you want to store the uploaded files
  $targetFile = $targetDir . basename($_FILES["photo"]["name"]);

  // Get the file extension
  $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  // Check if the file extension is allowed
  if ($fileExtension === "jpg" || $fileExtension === "jpeg" || $fileExtension === "png") {
    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
      // File upload successful
      echo "File uploaded successfully.";
    } else {
      // Error moving the uploaded file
      echo "Error uploading the file.";
    }
  } else {
    // Invalid file extension
    echo "Only JPEG and PNG files are allowed.";
  }
} else {
  // Error uploading the file
  echo "Error uploading the file.";
}
?>
