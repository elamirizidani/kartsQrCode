<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['files'])) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadedFiles = [];
    foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
        $fileName = basename($_FILES['files']['name'][$key]);
        $targetFile = $uploadDir . $fileName;

        // You can add file type checks here if needed
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Restrict allowed file types if necessary
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'avi'];
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($tmpName, $targetFile)) {
                $uploadedFiles[] = $targetFile;
            }
        }
    }

    if (count($uploadedFiles) > 0) {
        echo '<div class="container mt-5">';
        echo '<h4 class="text-success">Successfully uploaded files:</h4>';
        echo '<ul>';
        foreach ($uploadedFiles as $file) {
            echo '<li>' . $file . '</li>';
        }
        echo '</ul>';
        echo '</div>';
    } else {
        echo '<div class="container mt-5">';
        echo '<h4 class="text-danger">Failed to upload files. Please try again.</h4>';
        echo '</div>';
    }
} else {
    echo '<div class="container mt-5">';
    echo '<h4 class="text-danger">No files uploaded.</h4>';
    echo '</div>';
}
?>