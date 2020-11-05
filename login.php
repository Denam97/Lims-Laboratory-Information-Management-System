  <?php
    include("config.php");
    include("session.php");

    session_start();
    $message = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $username = mysqli_real_escape_string($conn, $_POST['user']);
        $password = mysqli_real_escape_string($conn, $_POST['pass']);

        $quer = "select * from user where username='$username' and password='$password'";


        $result = $conn->query($quer);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $_SESSION['user_id'] = $row['username'];
            }
            header("Location: ./index.php");
        } else {

            $_SESSION['status'] = "Username or password Incorrect!";

            $message = "Username or Password incorrect!";
        }
    }
    if (isset($_SESSION['user_id'])) {
        header("Location: ./index.php");
    }

    ?>


  <!Doctype html>

  <head>
      <title>Login</title>
      <link href="css/login.css" rel="stylesheet" type="text/css">
  </head>

  <body>


      <div class="heading">
          <h2>ABC Laboratory</h2>
      </div>
      <div class="logform">
          <img src="./images/logicon.png" alt="logicon" class="logicon">
          <h1 align="center">WELCOME</h1>

          <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
              <div class="error-head">

                  <?php
                    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
                        echo '<h2 align="center" class="error">' . $_SESSION['status'] . '</h2>';
                        unset($_SESSION['status']);
                    }
                    ?>
              </div>
              <p>Username</p>
              <input type="text" name="user" placeholder="Enter username" required>
              </br>
              </br>

              <p>Password</p>
              <input type="password" name="pass" placeholder="Enter password" required>

              </br>
              </br>

              <input type="submit" name="submit" value="Login" align="center">

          </form>
      </div>

  </body>

  </html>