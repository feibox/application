<!DOCTYPE html>
<html lang="sk">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Test</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Bootstrap -->
    <link href="http://127.0.0.1:8888/test/public/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.9.1/styles/vs.min.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body> 
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">UNISTUFF</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="#">FEI</a></li>
        <li><a href="#">Softvérové centrum</a></li>
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
      <li>
        <li class="inactive"><a href="#">University Stuff<span class="sr-only">(current)</span></a></li>
      </li>
      <li>  
      <button type="button" class="btn btn-default navbar-btn" aria-label="Left Align">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
      </button>
      </li>
      <li><span class="btn-separator"></span></li>
      <li>
      <div class="btn-group">
      <button type="button" class="btn btn-default navbar-btn dropdown-toggle" data-toggle="dropdown" aria-label="Left Align">
        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
        <span class="badge">4</span>
      </button>
          <ul class="dropdown-menu">
            <li class="dropdown-header">Aktuálne upozornenia</li>
            <li><a href="#">Súbor cviko1.pdf bol označný na vymazanie</a></li>
            <li><a href="#">Boli ste upozornený na nový súbor tahak.doc</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">História upozornení</a></li>
          </ul>
      </div>
        </li>
        
        <li>
      <form class="navbar-form" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      </li>
        
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<div class="container-fluid">
      <div class="row">
        {{$content}}
      </div>
    </div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://127.0.0.1:8888/test/public/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.9.1/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
  </body>
</html>