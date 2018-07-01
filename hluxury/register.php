<?php
    require("config.php");
    if(!empty($_POST))
    {
        // Ensure that the user fills out fields
        if(empty($_POST['username']))
        { die("Please enter a username."); }
        if(empty($_POST['password']))
        { die("Please enter a password."); }
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        { die("Invalid E-Mail Address"); }

        // Check if the username is already taken
        $query = "
            SELECT
                1
            FROM users
            WHERE
                username = :username
        ";
        $query_params = array( ':username' => $_POST['username'] );
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
        $row = $stmt->fetch();
        if($row){ die("This username is already in use"); }
        $query = "
            SELECT
                1
            FROM users
            WHERE
                email = :email
        ";
        $query_params = array(
            ':email' => $_POST['email']
        );
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage());}
        $row = $stmt->fetch();
        if($row){ die("This email address is already registered"); }

        // Add row to database
        $query = "
            INSERT INTO users (
                username,
                password,
                salt,
                email
            ) VALUES (
                :username,
                :password,
                :salt,
                :email
            )
        ";

        // Security measures
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        $password = hash('sha256', $_POST['password'] . $salt);
        for($round = 0; $round < 65536; $round++){ $password = hash('sha256', $password . $salt); }
        $query_params = array(
            ':username' => $_POST['username'],
            ':password' => $password,
            ':salt' => $salt,
            ':email' => $_POST['email']
        );
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex){ die("Failed to run query: " . $ex->getMessage()); }
        header("Location: index.php");
        die("Redirecting to index.php");
    }
?>
<body>
  <form action="register.php" method="post">

      <h1>Sign Up</h1>
      <p>Please fill in this form to create an account.</p>
      <hr>

<label>Email:</label>
<input type="text" name="email" value="" />
<label>Username:</label>
<input type="text" name="username" value="" />
<label>Password:</label>
<input type="text" name="password" value="" /> <br /><br/>
<input type="submit" class="btn btn-info" value="Register" />


  </form>
</body>
