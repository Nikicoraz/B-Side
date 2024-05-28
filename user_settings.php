<!DOCTYPE html>
<html lang="en">
<head>
    <title>User's settings</title>
    <link rel="stylesheet" type="text/css" href="css/comune.css">
</head>
<body>
    <form method="POST" action="./php_scripts/update_username.php">
        <h1>Update username</h1>
        <input type="text" name="new_username" id="new_username">
        <input type="submit" value="Update">
    </form>
    
    <form method="POST" action="./php_scripts/update_bio.php">
        <h1>Update bio</h1>
        <input type="text" name="new_bio" id="new_bio">
        <input type="submit" value="Update">
    </form>

    <form method="POST" action="./php_scripts/update_profile_picture.php" enctype="multipart/form-data">
        <h1>Update profile picture</h1>
        <input type="file" name="new_profile_picture" id="new_profile_picture">
        <input type="submit" value="Update">
    </form>
</body>
</html>