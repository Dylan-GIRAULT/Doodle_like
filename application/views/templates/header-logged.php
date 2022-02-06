<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WIM - Doodle like</title>
        <!-- Import Framework Bulma CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.2/css/bulma.min.css" integrity="sha512-byErQdWdTqREz6DLAA9pCnLbdoGGhXfU6gm1c8bkf7F51JVmUBlayGe2A31VpXWQP+eiJ3ilTAZHCR3vmMyybA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Import Framework Fontawesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Import CSS pour les polices -->
        <link rel="stylesheet" href="https://dwarves.iut-fbleau.fr/~toutain/wim/projet/assets/css/fonts.css"> 
        <!-- Import CSS pour le footer -->
        <link rel="stylesheet" href="https://dwarves.iut-fbleau.fr/~toutain/wim/projet/assets/css/wrapper.css"> 
    </head>
    <body class="body-wrapper">
        <div class="page-wrapper">
            <nav class="navbar is-light">
                <div class="navbar-brand">
                <a href="<?= base_url("") ?>" class="navbar-item">
                        <h3 class="is-size-3 logo-font">Doodle Like</h1>
                    </a>
                </div>
    
                <div class="navbar-end">
                    <div class="navbar-item">
                        <?= $username ?>
                    </div>
                    <div class="navbar-item">
                        <div class="field is-grouped">
                            <p class="control">
                            <a href="<?= base_url("deconnexion") ?>" class="button is-primary">
                                    <span class="icon"><i class="fas fa-sign-out-alt"></i></span><span>Deconnexion</span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </nav>
