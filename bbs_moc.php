<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cebu Online BBS</title>
  <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/form.css">
  <link rel="stylesheet" href="assets/css/timeline.css">
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#page-top"><span class="strong-title"><i class="fa fa-linux"></i> Oneline bbs</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
<!--                   <li class="hidden">
                      <a href="#page-top"></a>
                  </li>
                  <li class="page-scroll">
                      <a href="#portfolio">Portfolio</a>
                  </li>
                  <li class="page-scroll">
                      <a href="#about">About</a>
                  </li>
                  <li class="page-scroll">
                      <a href="#contact">Contact</a>
                  </li> -->
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-4 content-margin-top">


        <!-- Changed POST link target from bbs.php to bbs_moc.php -->
        <form action="bbs_moc.php" method="post">
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="nickname" class="form-control"
                       id="validate-text" placeholder="nickname" required>

              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
            
          </div>

          <div class="form-group">
            <div class="input-group" data-validate="length" data-length="4">
              <textarea type="text" class="form-control" name="comment" id="validate-length" placeholder="comment" required></textarea>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>

          <button type="submit" class="btn btn-primary col-xs-12" disabled>つぶやく</button>
        </form>
      </div>

<!-- == PHP from here ========================================================== -->
<?php

//OFFSET----------------------------------------------------------------------------
  if($_SERVER['REQUEST_METHOD']=='POST'){
    header('Location:http://localhost/oneline_bbs_1-master/bbs_moc.php');
  }

//INSERT----------------------------------------------------------------------------
  $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
  $user = 'root';
  $password = '';
  $dbh = new PDO($dsn,$user,$password);
  $dbh->query('SET NAMES utf8');

  if(isset($_POST) && !empty($_POST)){

//INSERT----------------------------------------------------------------------------
    $sql = "INSERT INTO `posts`(`nickname`, `comment`, `created`) ";
    $sql .="VALUES ('".$_POST['nickname']."','".$_POST['comment']."',now())";

    $stmt=$dbh->prepare($sql);
    $stmt->execute();
//INSERT----------------------------------------------------------------------------
  }

//SELECT----------------------------------------------------------------------------
  $sql = 'SELECT * FROM `posts`';
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
//SELECT----------------------------------------------------------------------------

  $posts = array();

  while(1){
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    if($rec == false){
      break;
    }

    $posts[]=$rec;  //Array from DB
  }
    $_POST = array();
    $dbh = null;
?>
<!-- == PHP by here ========================================================== -->


      <div class="col-md-8 content-margin-top">

        <div class="timeline-centered">

<!-- ==== Set of one comment ==================================  -->
      <?php
        foreach ($posts as $post) {
      ?>
        <article class="timeline-entry">

            <div class="timeline-entry-inner">

                <div class="timeline-icon bg-success">
                    <i class="entypo-feather"></i>
                    <i class="fa fa-cogs"></i>
                </div>

                <div class="timeline-label">

                    <br />
                    <h2><a href="#"> <?php echo $post['nickname']; ?> </a> <span><?php echo $post['created'];?></span></h2>
                    <p><?php echo $post['comment'];?></p>
                    <br />

                    <!-- REPLY ================================================================================================= -->
                    <form action="bbs_moc.php" method="post">
                      <div class="form-group">
                        <div class="input-group">
                          <input type="text" name="nickname2" class="form-control"
                                   id="validate-text" placeholder="nickname2" required>

                        <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span> 
                        </div>                        
                      </div>

                      <div class="form-group">
                        <div class="input-group" data-validate="length" data-length="4">
                          <textarea type="text" class="form-control" name="comment2" id="validate-length" placeholder="comment2" required></textarea>
                          <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
                        </div>
                      </div>

                      <button type="submit" class="btn btn-primary col-xs-12" disabled>返信</button>
                      <br /><br /><br />
                    </form>  
                    <!-- REPLY ================================================================================================= -->
                </div>
            </div>

        </article>

      <?php
      }
      ?>


<!-- ==== Set of one comment ==================================  -->

        <article class="timeline-entry begin">

            <div class="timeline-entry-inner">

                <div class="timeline-icon" style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg);">
                    <i class="entypo-flight"></i> +
                </div>

            </div>

        </article>

      </div>

    </div>
  </div>





  
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/form.js"></script>
</body>
</html>



