<?php
    require_once("includes/DB.php");
    require_once("includes/Functions.php");
    require_once("includes/Sessions.php");

    if(isset($_POST["Submit"])){
        $Category = $_POST["CategoryTitle"];
        $Admin = "Arkar";
        date_default_timezone_set("Asia/Myanmar");
        $CurrentTime = time();
        $DateTime =  strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);

        if(empty($Category)){
            $_SESSION["ErrorMessage"]= "All fields must be filled out";
            Redirect_to("Categories.php");
        }elseif(strlen($Category)<3){
            $_SESSION["ErrorMessage"]= "Category title should be greater than 2 characters";
            Redirect_to("Categories.php");
        }elseif(strlen($Category)>49){
            $_SESSION["ErrorMessage"]= "Category title should be less than 50 characters";
            Redirect_to("Categories.php");
        }else {
            global $ConnectingDB;
            $sql = "INSERT INTO category(title,author,datetime)";
            $sql .= "VALUES(:categoryName,:adminName,:datetime)";
            $stmt = $ConnectingDB->prepare($sql);
            $stmt->bindValue(':categoryName',$Category);
            $stmt->bindValue(':adminName',$Admin);
            $stmt->bindValue(':datetime',$DateTime);
            $Execute = $stmt->execute();

            if($Execute){
                $_SESSION["SuccessMessage"]="Category with id: ".$ConnectingDB->lastInsertId()." added successfully.";
                Redirect_to("Categories.php");
            }else {
                $_SESSION["ErrorMessage"]="Something went wrong. Try again!";
                Redirect_to("Categories.php");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://kit.fontawesome.com/0b74455133.css" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Categories</title>
</head>
<body>
   <!-- NAVBAR -->
   <div style="height: 10px; background: #27aae1;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand"><i class="fa-solid fa-music"></i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav" style="margin-right: auto;">
                    <li class="nav-item">
                        <a href="MyProfile.php" class="nav-link"><i class="fa-regular fa-user"></i> My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="Dashboard.php" class="nav-link"><i class="fa-solid fa-table-columns"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="Posts.php" class="nav-link"><i class="fa-regular fa-newspaper"></i> Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="Categories.php" class="nav-link"><i class="fa-solid fa-bars"></i> Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="Admins.php" class="nav-link"><i class="fa-solid fa-people-roof"></i> Manage Admins</a>
                    </li>
                    <li class="nav-item">
                        <a href="Comments.php" class="nav-link"><i class="fa-solid fa-envelope"></i> Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php" class="nav-link"><i class="fa-brands fa-blogger-b"></i> Live Blog</a>
                    </li>
                </ul>
                <ul class="navbar-nav" style="margin-left: auto;">
                    <li class="nav-item"><a href="Logout.php" class="nav-link logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div style="height: 10px; background: #27aae1;"></div>
    <!--NAVBAR END-->

    <!--HEADER-->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fa-regular fa-pen-to-square" style="color: skyblue;"></i> Manage Categories</h1>
                </div>
            </div>
        </div>
    </header>
    <!--HEADER END-->
    
    <!--Main Area-->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height: 400px;">
            <?php 
                echo ErrorMessage();
                echo SuccessMessage();
            ?>
                <form class="" action="Categories.php" method="post">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add New Category</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group py-2">
                                <label for="title"><span class="FieldInfo">Category Title: </span></label>
                                <input class="form-control" type="text" name="CategoryTitle" id="title" placeholder="Type title here" value="">
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-warning" style="width: 100%;"><i class="fa-solid fa-arrow-left-long"></i> To Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" class="btn btn-success" style="width: 100%;">
                                        <i class="fa-solid fa-check"></i> Publish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--Main Area End-->

    <!--FOOTER-->
    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <p class="lead text-center">Designed By | Arkar Hein | 2023 &copy; ----All right Reserved.</p>
                <p class="text-center small"><a style="color: white; text-decoration: none; cursor: pointer;" href="#">
                    This site is only used for Study purpose. No one is allowed to distribute copies.
                </a></p>
            </div>
        </div>
    </footer>
    <div style="height: 10px; background: #27aae1;"></div>
    <!--FOOTER END-->

    <script src="https://kit.fontawesome.com/0b74455133.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>    

</body>
</html>