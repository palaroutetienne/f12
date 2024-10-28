<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FORCE 12</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="js/bootstrap-4.0.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="css/polaris.css" rel="stylesheet">

    <script src="js/jquery-3.3.1.min.js"></script>
</head>
<body>
    <?php
        if(isset($_POST['manuel']))	//Si on vient de cliquer sur une icône ...
        {
            $action = "manuel";
        }
        else {
            if(isset($_POST['auto']))
            {
               $action = "auto";
            }
            else
            {
                if(isset($_POST['eureka']))
                {
                    $action = "eureka"; 
                }
                else
                {
                    if(isset($_POST['encyclopedie']))
                    {
                        $action = "encyclopedie"; 
                    }
                    else
                    {
                        if(isset($_POST['encyclopedie_manuel']))
                        {
                           $action = "encyclopedie_manuel"; 
                        }
                    }
                }
            }
            
        }
    ?>
    <div class="py-5">      
      <!-- Modal -->
        <div tabindex="-1" class="modal fade" id="myModal" role="dialog" aria-hidden="true" aria-labelledby="myModalLabel">
        <!-- Modal centrée -->
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" aria-hidden="true" type="button" data-dismiss="modal">×</button>
              <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <div class="table-borderless table-responsive">
                    <div class="row no-gutters">
                        <!-- Items du menu -->
                        <div class="col-3">
                            <div class="list-group" id="list-tab" role="tablist">
                                <a class="list-group-item list-group-item-action active" id="list-apropos-list" data-toggle="list" href="#list-apropos" role="tab" aria-controls="apropos">&Agrave; propos de Force Douze...</a>
                                <a class="list-group-item list-group-item-action" id="list-recherche-list" data-toggle="list" href="#list-recherche" role="tab" aria-controls="recherche">Rechercher...</a>
                                <a class="list-group-item list-group-item-action" id="list-notation-list" data-toggle="list" href="#list-notation" role="tab" aria-controls="notation">Options de notations...</a>
                                <a class="list-group-item list-group-item-action" id="list-tutorial-list" data-toggle="list" href="#list-tutorial" role="tab" aria-controls="tutoriel">Tutoriel / Aide...</a>
                                <a class="list-group-item list-group-item-action" id="list-exporter-list" data-toggle="list" href="#list-exporter" role="tab" aria-controls="exporter">Exporter MIDI...</a>
                                <a class="list-group-item list-group-item-action" id="list-accueil-list" data-toggle="page" href="index.php" role="tab" aria-controls="accueil">Retour accueil</a>
                            </div>
                        </div>
                        <!-- Contenus correspondant aux items du menu -->
                        <div class="col-9">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="list-apropos" role="tabpanel" aria-labelledby="list-apropos-list"><img class="img-fluid" src="images/apropos.png"/></div>
                                <div class="tab-pane fade" id="list-recherche" role="tabpanel" aria-labelledby="list-recherche-list">
                                    <div class="d-flex justify-content-center h-100">
                                        <div class="searchbar">
                                            <input class="search_input" type="text" name="" placeholder="Rechercher...">
                                            <a href="#" class="search_icon"><i class="fas fa-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="list-notation" role="tabpanel" aria-labelledby="list-notation-list">
                                    <div class="d-flex justify-content-center">
                                            <div class="notation_bar"> 
                                                <p style="white-space: nowrap;">
                                                    Affichage du nom des notes
                                                    <label class="radio-inline"><input type="radio" name="notation" value="0" checked="checked"/> La (d&eacute;faut)</label>
                                                    <label class="radio-inline"><input type="radio" name="notation" value="1"/> A </label>
                                                - Affichage du type d&apos;alt&eacute;ration
                                                    <label class="radio-inline"><input type="radio" name="alteration" value="0" checked="checked"/>&#x266d;</label>
                                                    <label class="radio-inline"><input type="radio" name="alteration" value="1"/>&#x266f;</label>
                                                    <button id="okModale" class="btn bouton-image bouton_ok"></button>
                                                </p>
                                            </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="list-tutorial" role="tabpanel" aria-labelledby="list-tutorial-list">
                                    <ul>
                                        <li><a href="ressources/synopsis.jpg">Synopsis</a></li>
                                        <li><a href="ressources/tutoriel.html">Tutoriel</a></li>
                                        <li><a href="#">Génèse de Force 12</a></li>
                                    <ul>
                                </div>
                                <div class="tab-pane fade" id="list-exporter" role="tabpanel" aria-labelledby="list-exporter-list">MIDI</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="container-fluid" >
            <div class="stickyHaut">
                <div class="row">
                    <div class="col-md-12">
                        <a class="d-box align-top" data-target="#myModal" data-toggle="modal" >        <!-- image trigger modal -->
                            <img class="img-responsive" id="logo" alt="info" src="images/logo.png" width="auto" height="auto">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div id="contenu" class="container-fluid">
            <?php
                if(isset($_POST['manuel'])||isset($_POST['auto'])||isset($_POST['eureka'])||isset($_POST['encyclopedie'])||isset($_POST['encyclopedie_manuel']))
                {
                    require('vue/v_'.$action.'.php');	//...on charge les vues choisies dans la div "contenu".
                }
            ?>
        </div>
        <footer class="container-fluid text-center">
        <form action='index.php' method='POST'>
            <div class="stickyBas">
                <div class="row">
                    
                        <div class="col-md-3">
                            
                                <?php if(!isset($action))
                                        {
                                            echo '<button id="eureka" name="eureka" class="btn bouton-image bouton_eureka" type="submit" value="v_eureka" style="display:block !important;">';
                                        }
                                        else
                                        {
                                            echo '<button id="eureka" name="eureka" class="btn bouton-image bouton_eureka" type="submit" value="v_eureka" style="display:none !important;">';
                                        }
                                ?>
                                        
                                                </button>
                        </div>     
                   
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-3">
                            <div class="right">
                                <?php if(!isset($action))
                                        {
                                            echo '<button id="auto" name="auto" class="btn bouton-image bouton_auto" type="submit" value="v_auto" style="display:block !important;">';
                                        }
                                        else
                                        {
                                            echo '<button id="auto" name="auto" class="btn bouton-image bouton_auto" type="submit" value="v_auto" style="display:none !important;">';
                                        }
                                ?>
                                                </button>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                    </div>
                        <div class="col-md-5">
                                        <?php if(!isset($action))
                                            {
                                                echo '<button id="manuel" name="manuel" class="btn bouton-image bouton_manuel" type="submit" value="v_manuel" style="display:block !important;">';
                                            }
                                            else
                                            {
                                                echo '<button id="manuel" name="manuel" class="btn bouton-image bouton_manuel" type="submit" value="v_manuel" style="display:none !important;">';
                                            }
                                    ?>
                                                    </button>
                        </div>
                </div>
            </div>
        </form>
        </footer>
    </div>
    <script>
        $(document).ready(function(){
            if(!$("#contenuEtude").length)
            {
                $('#list-exporter-list').remove();
            }
        });
    </script>
    <script src="js/konva.min.js"></script>
    <script src="js/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>		
   </body>
</html>
