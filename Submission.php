<?php
// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $skills = $_POST['skills'];
    $projects = $_POST['projects'];
    $education = $_POST['edu'];
    $address = $_POST['address'];
    $resume = $_FILES['resume'];

    // Check if file was uploaded without errors
    if ($resume['error'] == 0) {
        $allowed = ['pdf'];
        $filename = $resume['name'];
        $filetype = $resume['type'];
        $filesize = $resume['size'];

        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            die("Error: Please upload a valid PDF file.");
        }

        // Verify file size - 5MB maximum
        if ($filesize > 5 * 1024 * 1024) {
            die("Error: File size is larger than the allowed limit.");
        }

        // Create directory if not exists
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($resume['tmp_name'], $upload_dir . $filename)) {
            echo "Your resume was uploaded successfully.";
            // Save form data to a text file (optional)
            $formData = "Name: $name\nDOB: $dob\nGender: $gender\nMobile: $mobile\nEmail: $email\nSkills: $skills\nProjects: $projects\nEducation: $education\nAddress: $address\nResume: $upload_dir$filename\n\n";
            file_put_contents('submissions.txt', $formData, FILE_APPEND);
        } else {
            echo "Error: There was a problem uploading your file. Please try again.";
        }
    } else {
        echo "Error: " . $resume['error'];
    }
}
?>
