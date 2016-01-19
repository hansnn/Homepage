<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Martin Moe Hansen</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" id="nav-toggle" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>  
      <div class="collapse navbar-collapse" id="main-nav">
        <ul class="nav navbar-nav">
        <?php foreach ($json['navbar'] as $key=>$value): ?>
          <li><a href="#" data-id="<?php echo $key ?>" 
          class="scroll-link"><?php echo $value ?></a></li>
        <?php endforeach; ?>

        </ul>
        <ul class="nav pull-right" id="language">
          <button id="languageBtn" type="button" class="btn btn-default navbar-btn"><?php echo $json['language'] == "no" ? "English" : "Norsk" ?></button>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container" id="main-content">

    <div id="home" class="row page-section">
      <div class="col-xs-12">
        <div class="text-center presentation">
          <h1>Martin Moe Hansen</h1>
          <p class="lead"><?php echo $json['description']; ?></p>
        </div>
      </div> <!-- .col-xs-12 -->
    </div> <!-- .page-section -->

    <div id="work" class="row page-section">
      <div class="col-xs-12">
        <h2 class="page-section-header"><?php echo $json['work']['heading'] ?></h2>
        <?php $i = 0; foreach($json['work']['data'] as $key=>$workplace): ?>
        <div class="row">
          <div class="col-xs-2">
            <h4 class="year"><?php echo $workplace['date']; ?></h4>
          </div>
          <div class="col-xs-1">
            <div class="collapse-btn">
              <span class="glyphicon 
              <?php if ($i == 0) {echo 'glyphicon-minus';} else {echo 'glyphicon-plus';}?>"></span>
            </div>
          </div>
          <div class="col-xs-9">
            <h4><?php echo $workplace['position']; ?></h4>
            <div class="collapse <?php if ($i++ == 0) {echo 'in';}?>">
              <p>
                <?php echo $json['work']['heading2']; ?>
                <br>
                <?php echo $workplace['assignments']; ?>
              </p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div> <!-- .col-xs-12 -->
    </div> <!-- #work -->

    <div id="education" class="row page-section">
      <div class="col-xs-12">
        <h2 class="page-section-header"><?php echo $json['education']['heading'] ?></h2>
        <?php $i = 0; foreach($json['education']['data'] as $key=>$study): ?>
        <div class="row">
          <div class="col-xs-2">
            <h4 class="year"><?php echo $study['year']; ?></h4>
          </div>
          <div class="col-xs-1">
            <div class="collapse-btn">
              <span class="glyphicon 
              <?php if ($i == 0) {echo 'glyphicon-minus';} else {echo 'glyphicon-plus';}?>"></span>
            </div>
          </div>
          <div class="col-xs-9">
            <h4><?php echo $study['class']; ?></h4>
            <div class="collapse <?php if ($i++ == 0) {echo 'in';}?>">
              <p>
                <?php echo $study['info']; ?>
              </p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div> <!-- .col-xs-12 -->
    </div> <!-- #education -->

    <div id="skills" class="row page-section">
      <div class="col-xs-12">
        <h2 class="page-section-header"><?php echo $json['skills']['heading'] ?></h2>
        <div class="page-section-intro">
          <?php foreach($json['skills']['data'] as $key=>$skill): ?>
            <p><?php echo $skill; ?></p>
          <?php endforeach; ?>
        </div>
        <div class="row">
          <div class="col-xs-4" id="backend">
            <div class="progbar">
              <strong></strong>
              <span>Backend - Python/PHP/Java</span>
            </div>
          </div>
          <div class="col-xs-4" id="frontend">
            <div class="progbar">
              <strong></strong>
              <span>Frontend - HTML5/CSS3/Javascript</span>
            </div>
          </div>
        </div> <!-- .row -->
      </div> <!-- .col-xs-12 -->
    </div> <!-- #skills -->

    <div id="contact" class="row page-section">
      <div class="col-xs-12">
        <h2 class="page-section-header"><?php echo $json['contact']['heading']; ?>
        <br><small><?php echo $json['contact']['heading2']; ?></small></h2>
        <div class="row">
          <form class="form-horizontal" role="form" method="post" action="/?lang=<?php echo $json['language'] ?>">

            <div class="form-group">
              <label for="name" class="col-sm-2 control-label"><?php echo $json['form']['label']['name']; ?></label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="name" name="name" 
                placeholder="<?php echo $json['form']['placeholder']['name']; ?>" value="<?php echo $form['name'] ?>">
                  <?php echo "<p class='text-danger'>" . $form['errName'] . "</p>";?>
               </div>
            </div>

            <div class="form-group">
              <label for="email" class="col-sm-2 control-label"><?php echo $json['form']['label']['email']; ?></label>
              <div class="col-sm-9">
                <input type="email" class="form-control" id="email" name="email" 
                placeholder="<?php echo $json['form']['placeholder']['email']; ?>" value="<?php echo $form['email'] ?>">
                 <?php echo "<p class='text-danger'>" . $form['errEmail'] . "</p>"?>
               </div>
            </div>

            <div class="form-group">
              <label for="melding" class="col-sm-2 control-label"><?php echo $json['form']['label']['message']; ?></label>
              <div class="col-sm-9">
                <textarea name="message" rows="4" class="form-control"><?php echo $form['message'];?></textarea>
                 <?php echo "<p class='text-danger'>" . $form['errMessage'] . "</p>";?>
               </div>
            </div>

            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-2">
                <input type="hidden" name="lang" value="<?php if (isset($_GET['lang'])) {echo htmlspecialchars($_GET['lang']);} ?>">
                <input type="submit" name="submit" id="submit" value="Send" class="btn">
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-9 col-sm-offset-2">
                <!-- Display success/error message after form submit -->
                <?php echo $form['result'];?>
              </div>
            </div>
          </form>
        </div> <!-- .row -->
        <div class="page-section-footer">
          <p><?php echo $json['contact']['footer']; ?></p>
        </div>
      </div> <!-- .col-xs-12 -->
    </div> <!-- #contact -->

  </div> <!-- .container -->


</body>

<script src="lib/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="lib/jquery-circle-progress-1.1.3/dist/circle-progress.js"></script>
<script src="lib/jquery.appear-master/jquery.appear.js"></script>
<script src="script.js"></script>

</html>
