<!DOCTYPE html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>Celleo - smartphone purchase roboadvisor</title>
  <meta name="description" content="Celleosmart is a roboadvisor that helps you in finding the smartphone that is right for you. No hassle to the store, no jargon… and no pushy sale either!">
  <meta name=”robots” content=”index, follow”>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- OG meta -->
  <meta property=”og:type” content=”website” />
  <meta property=”og:title” content="Celleo - smartphone purchase roboadvisor" />
  <meta property=”og:description” content="Celleosmart is a roboadvisor that helps you in finding the smartphone that is right for you. No hassle to the store, no jargon… and no pushy sale either!" />
  <meta property=”og:image” content=”https://celleosmart.com/img/billboard.jpg” />
  <meta property=”og:url” content=”www.celleosmart.com” />
  <meta property=”og:site_name” content=”Celleo” />
  <!-- Twitter meta -->
  <meta name=”twitter:title” content="Celleo - smartphone purchase roboadvisor">
  <meta name=”twitter:description” content="Celleosmart is a roboadvisor that helps you in finding the smartphone that is right for you. No hassle to the store, no jargon… and no pushy sale either!">
  <meta name=”twitter:image” content=”https://celleosmart.com/img/billboard.jpg”>
  <meta name=”twitter:site” content=”@Celleo”>
  <meta name=”twitter:creator” content=”@Celleo”>
  <!-- <link rel="manifest" href="site.webmanifest"> -->
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <!-- <link rel="stylesheet" href="css/normalize.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="stylesheet" href="css/main.min.css">

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-151418641-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-151418641-1');
  </script>
  
</head>

<body>

  <?php include 'includes/header.php';?>

  <div id="main-ctn">

    <div id="chat-window">
      <div class="bot-interaction intro">
      
          <div class="interaction-bloc">
              <div class="question">
                  <div class="avatar"></div>
                  <div class="qtn-bloc">
                      <p>Hi, my name is Celleo and I will help to find the perfect smartphone for you!</p>
                  </div>
              </div>
          </div>
          
      </div>

      <div class="bot-interaction intro">
          <div class="interaction-bloc">
              <div class="question">
                  <div class="avatar"></div>
                  <div class="qtn-bloc">
                      <p>Let's do it!</p>
                  </div>
              </div>
          </div>        
      </div>
    
    </div>
  </div>

  <div id="send-param-div">
    <button id="reduce-Cmd-Btn">
      <img src="./img/back-triangle-down.png" alt="reduce div">
    </button>
    <div>
        <h3>Excellent!</h3>
        <p>I've got all the information I need to fetch the perfect smartphone for you!</p>
        <p>Ready?!</p>

        <form id="devSubmit" action="devices.php" method="post">

          <input type="hidden" id="ParamArray" name="ParamArray" value="">

          <input type="submit" id="sendParamBtn" name="sendParam" value="Let's do it!" />

        </form>

    </div>
  </div>

  <?php include 'includes/footer.php';?>

  <!-- <script src="js/vendor/modernizr-3.6.0.min.js"></script> -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <!-- <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script> -->
  <!-- <script src="js/plugins.js"></script> -->
  <script src="js/main.js"></script>

  <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
  <!-- <script>
    window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto'); ga('send', 'pageview')
  </script>
  <script src="https://www.google-analytics.com/analytics.js" async defer></script> -->
</body>

</html>
