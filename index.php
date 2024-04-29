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

<body class="d-flex flex-column h-100">

  <?php include 'includes/header.php';?>

  <main id="main-ctn">

    <div class="container mw-100">
          <div class="row">
              <div class="col-md-6 offset-md-3 overflow-hidden">
                  <div class="jumbo mx-auto my-5 pt-5">
                      <div class="card w-100 h-auto bg-white p-3 mb-5 border border-light-subtle rounded position-relative start-0 txt-ctt">
                          <div class="card-body">
                              <h1 class="card-title mb-5 text-center fs-1 fw-bold">Your new cellphone with just 3 questions</h1>
                              <h2 class="card-subtitle mt-0 mb-2 fw-normal fs-4">No tech specs...</h2>
                              <h2 class="card-subtitle mt-0 mb-2 fw-normal fs-4">No upselling...</h2>
                              <h2 class="card-subtitle  mt-0 mb-5 fw-normal fs-4">No hassle in store.</h2>
                              <button id="start-btn" class="d-block m-auto py-2 px-3 rounded-pill fs-6 fw-bold animate__animated animate__pulse">Start</button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

  </main>

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

  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>	
  <script src="js/main.js"></script>

</body>

</html>
