<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

Il se peut que les performances d’affichage de la liste des pokemon soient médiocre du fait de la
récupération de l’ensemble des images. Cependant, dans le contexte de l’exercice, nous avons
comme contrainte que l’API ne doit pas diffuser le lien direct des images au utilisateurs

Que feriez-vous pour améliorer les performances du WS ?

Afin de ne pas fournir le lien de l'image directement à l'utilisateur et dans un contexte de performances, on pourrait créer une route sur notre API qui retournera l'image sans que le client puisse accéder au lien originel.
