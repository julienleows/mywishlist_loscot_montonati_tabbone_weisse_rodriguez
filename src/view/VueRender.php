<?php
namespace mywishlist\view;


class VueRender {
    public function render($content) {
        return <<<END
        <!DOCTYPE html>
        <html>
            <head>
                <title>My Wish List</title>
                 <!-- css boostrap -->
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
                <!-- viewport -->
                <meta name="viewport" content="width=device-with, initial-scale=1.0"
            </head>
            <body>
                <!-- navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                  <div class="container-fluid">
                       <a class="navbar-brand" href="#">
                           My WishList
                       </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="listes">Listes</a></li>
                        <li class="nav-item"><a class="nav-link" href="crealiste">Creation liste</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Connexion/Inscription</a></li>
                      </ul>
                     </div>
                  </div>
                </nav>
                
                <!-- page web -->
                <div class="container">
                    $content
                </div>
                
                <!-- js boostrap -->
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
            </body>
        </html> 
END;
    }


    public function home() {
        return <<<END
            <p>ici c'est la page d'accueil</p>
END;
    }

}