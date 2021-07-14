<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Jekyll v4.1.1">
  <title>Signin Template · Bootstrap</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/sign-in/">

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

  <!-- Favicons -->
  <link rel="apple-touch-icon" href="/docs/4.5/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
  <link rel="icon" href="/docs/4.5/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
  <link rel="icon" href="/docs/4.5/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
  <link rel="manifest" href="/docs/4.5/assets/img/favicons/manifest.json">
  <link rel="mask-icon" href="/docs/4.5/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
  <link rel="icon" href="/docs/4.5/assets/img/favicons/favicon.ico">
  <meta name="msapplication-config" content="/docs/4.5/assets/img/favicons/browserconfig.xml">
  <meta name="theme-color" content="#563d7c">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
  <!-- Custom styles for this template -->
  <link href="/assets/signin.css" rel="stylesheet">
</head>

<body class="text-center">
  <form class="form-signin" method="POST" action="/AuthController/login">
    <img class="mb-4" src="/assets/img/logo-telkom.jpg" alt="" width="200">
    <h1 class="h3 mb-3 font-weight-normal">Silakan Login</h1>
    <div class="alert alert-danger d-none"></div>
    <label for="email" class="sr-only">Email</label>
    <input type="email" id="email" name="email" class="form-control" placeholder="Email" required autofocus>
    <label for="password" class="sr-only">Password</label>
    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Masuk</button>
    <p class="mt-5 mb-3 text-muted">&copy; <?= date('Y'); ?> PT. Telkom Akses</p>
  </form>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

  <script>
    $('form').submit(function(e) {
      e.preventDefault();
      let formData = new FormData($(this)[0]);
      $.ajax({
        url: $(this).attr('action'),
        type: 'post',
        dataType: 'json',
        contentType: false,
        processData: false,
        data: formData,
        success: function(res) {
          // console.log(res);
          if (!res.success) {
            $('.alert').removeClass('d-none')
            $('.alert').html(res.msg)
          } else {
            location.href = res.redirect
          }
        }
      });
    })
  </script>
</body>

</html>