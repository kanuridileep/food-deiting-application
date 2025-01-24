<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

// Database connection
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'eyhectip_nutras';
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch user profile from database
$stmt_profile = $pdo->prepare("SELECT * FROM user_profiles WHERE user_id = :user_id");
$stmt_profile->bindParam(':user_id', $user_id);
$stmt_profile->execute();
$user_profile = $stmt_profile->fetch(PDO::FETCH_ASSOC);

// Fetch selected diets from database
$stmt_diets = $pdo->prepare("SELECT diet_name FROM selected_diets WHERE user_id = :user_id");
$stmt_diets->bindParam(':user_id', $user_id);
$stmt_diets->execute();
$selected_diets = $stmt_diets->fetchAll(PDO::FETCH_COLUMN);

// Start HTML document
echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>User Profile</title>";
echo "<style>";
// CSS styles for profile and navigation
echo "
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f8f8;
        margin: 0;
        padding: 0;
    }

    .navbar {
        background-color: #4CAF50;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 20px;
    }

    .company-name {
        color: white;
        font-size: 24px;
        font-weight: bold;
    }

    .navbar-buttons {
        display: flex;
        align-items: center;
    }

    .navbar-buttons a {
        color: white;
        text-decoration: none;
        margin: 0 15px;
        font-size: 16px;
    }

    .profile-container {
        padding: 20px;
        max-width: 600px;
        margin: 20px auto;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .profile-container h2 {
        text-align: center;
        color: #4CAF50;
    }

    .profile-container ul {
        list-style-type: none;
        padding: 0;
    }

    .profile-container ul li {
        margin-bottom: 10px;
    }

    .profile-container ul li strong {
        font-weight: bold;
    }

    .edit-button {
        display: block;
        width: 25%;
        padding: 10px;
        text-align: center;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin: 20px auto 0;
    }

    .message {
        background-color: #f2f2f2;
        padding: 10px;
        margin: 10px 0;
        border-left: 4px solid #4CAF50;
    }
";
echo "</style>";
echo "</head>";
echo "<body>";

// Navigation bar
echo "
    <div class='navbar'>
        <div class='company-name'>Nutri<span style='color: #f8f8f8;'>Care</span></div>
        <div class='navbar-buttons'>
            <a href='chat.html'>health Tracker</a>
            <a href='alldiets.html'>Diet Plans</a>
            <a href='#help'>Help</a>
            <a href='#about-us'>About Us</a>
            <a href='index.html'>Logout</a>
        </div>
    </div>
";

// Display user profile
if ($user_profile) {
    echo "<div class='profile-container'>";
    echo "<h2>User Profile</h2>";
    echo "<ul>";
    foreach ($user_profile as $key => $value) {
        // Exclude 'id' and 'user_id' from printing
        if ($key != 'id' && $key != 'user_id') {
            echo "<li><strong>$key:</strong> $value</li>";
        }
    }
    echo "</ul>";

    // Display selected diets
    if ($selected_diets) {
        echo "<h2>Selected Diets</h2>";
        echo "<ul>";
        foreach ($selected_diets as $diet) {
            echo "<li>$diet</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No diets selected yet.</p>";
    }

    // Display message if any
    if (isset($_GET['message'])) {
        echo "<div class='message'>" . htmlspecialchars($_GET['message']) . "</div>";
    }

// Add Edit button
echo "<form action='profile1.html' method='get'>";
echo "<button type='submit' class='edit-button'>Edit</button>";
echo "</form>";


    echo "</div>";
} else {
    echo "User profile not found.";
}

echo "</body>";
echo "</html>";
?>
