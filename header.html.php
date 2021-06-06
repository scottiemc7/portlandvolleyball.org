<!DOCTYPE html>
<html lang="en">
<head>
  <title>Portland Volleyball Association</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="favicon.ico" />

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!--[if lt IE 9]>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js">
    </script>
  <![endif]-->
  <link rel="stylesheet" href="/styles/pva.css?2.0.8">


  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700|Open+Sans:400,700" rel="stylesheet">
  <script language="javascript">
    function getE(handle, domain) {
      return handle + '@' + domain;
    }
    function getMailto(handle, domain)
    {
      document.write('<a href="mailto:' + handle + '@' + domain + '">' + handle + '@' + domain + '</a>.');
    }
  </script>
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-82904877-1', 'auto');
    ga('send', 'pageview');

  </script>
</head>

<body>
  <?php include 'partials/registration_banner.html.php'; ?>
  <nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="collapsed navbar-toggle" data-toggle="collapse" data-target="#pva-navbar-collapse" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="/" class="navbar-brand">
          <img src="/images/header-logo.svg" style="max-height: 100%;width: 80px; margin: 5px 10px;" />
        </a>
      </div>
      <div id="pva-navbar-collapse" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li>
            <a href="/">Home</a>
          </li>
          <li>
            <a href="/schedules.php">Schedules</a>
          </li>
          <li>
            <a href="/scores.php">Scores</a>
          </li>
          <li>
            <a href="/standings.php">Standings</a>
          </li>
          <li>
            <a href="/gyms.php">Gyms</a>
          </li>
          <li>
            <a href="/rules.php">Rules</a>
          </li>
          <li>
            <a href="/contact.php">Contact</a>
          </li>
          <li>
            <a href="/checkin.php">COVID Check-In</a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">More <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li>
                <a href="/winners.php">Winners</a>
              </li>
              <li>
                <a href="/about.php">About</a>
              </li>
              <li>
                <a href="/links.php">Links</a>
              </li>
              <li>
                <a href="/archives.php">News Archives</a>
              </li>
              <li>
                <a href="http://www.facebook.com/PortlandVolleyballAssociation" target="_blank">Facebook</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>