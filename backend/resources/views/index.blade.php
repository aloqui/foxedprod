<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>FoxedFolio</title>
  <link href="https://fonts.googleapis.com/css?family=Khula:400|Crimson+Text:400,600,700|Lato:300,400,700,900" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy"
    crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/0.11.1/trix.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.32.0/codemirror.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.32.0/theme/twilight.css">
  <script defer src="https://use.fontawesome.com/releases/v5.0.3/js/all.js"></script>
  <link rel="stylesheet" href="./css/app.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.32.0/addon/hint/show-hint.css">

</head>

<body>
  <div id="app"></div>
  <div class="footer pt-4 pb-4">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="d-flex flex-column justify-content-center">
            <a href="" class="content__helper mb-2"><u>Developers & Researchers</u></a>
            <h5 class="content__helper">Cueto, Chester</h5>
            <h5 class="content__helper">Dizon, Franchette</h5>
            <h5 class="content__helper">Lumanlan, John Anna</h5>
            <h5 class="content__helper">Oquindo, Al</h5>
          </div>
        </div>
        <div class="col">
          <div class="d-flex flex-column justify-content-center">
            <h5 class="content__helper"><u>Contact Us</u></h5>
            <h5 class="content__helper text-uppercase mt-2">+63 917 869 1802</h5>
            <h5 class="content__helper">al.oquindooff@gmail.com</h5>
          </div>
        </div>
        <div class="col">
          <div class="d-flex flex-column justify-content-center">
            <h5 class="content__helper">© FoxedFolio 2018</h5>
            <h5 class="content__helper text-uppercase mt-2">'For the Foxes..'</h5>
          </div>
        </div>
        <div class="col">
          <div class="d-flex flex-column justify-content-center">
            <a href="#" class="content__helper">Privacy Policy</a>
            <a href="#" class="content__helper">Terms of Use</a>
            <a href="#" class="content__helper">Site Map</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.32.0/codemirror.js"></script>

  <!-- For HTML/XML -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.32.0/mode/xml/xml.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.32.0/mode/htmlmixed/htmlmixed.js"></script>

  <!-- For CSS -->
  <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>
  </script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.32.0/mode/css/css.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.32.0/addon/hint/css-hint.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.32.0/addon/hint/show-hint.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.32.0/addon/hint/html-hint.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.32.0/addon/hint/javascript-hint.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.32.0/addon/hint/xml-hint.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.32.0/addon/edit/closetag.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.33.0/addon/edit/closebrackets.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.33.0/addon/edit/matchbrackets.min.js"></script>

  <!-- For JS -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.32.0/mode/javascript/javascript.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.32.0/addon/hint/show-hint.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
    crossorigin="anonymous"></script>
  <script src="./js/build.js"></script>

</body>

</html>