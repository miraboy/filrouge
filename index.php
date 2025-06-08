<?php
// Activer le mode strict
declare(strict_types=1);

// Démarrer la session
session_start();

// Inclusion des fichiers nécessaires
include 'donnees.php';
include 'entreprise.php';

// Initialisation des variables
$contenuePrincipale = "";
$msg = "";

// Connexion à la base de données
$pdo = connecter();
if (!$pdo) {
    $contenuePrincipale = "<h3 class='m-5'>Erreur de connexion à la base de données</h3>";
    include 'squelette.php';
    exit;
}

// Vérification si une action est demandée via GET
if (!empty($_GET['action'])) {
    $action = htmlspecialchars($_GET['action'], ENT_QUOTES, 'UTF-8');

    // Switch sur les différentes actions possibles
    switch ($action) {
        // Test de connexion à la base de données
        case "tester":
            $contenuePrincipale = $pdo ? "<h3 class='m-5'>Connexion établie</h3>" : "<h3 class='m-5'>Connexion non établie</h3>";
            break;

        // Affichage de la liste des entreprises
        case 'afficher':
            $entreprise = new Entreprise($pdo);
            $entreprises = $entreprise->getAll();

            // Tri si des paramètres de tri sont fournis
            if (isset($_GET['fonction'], $_GET['clef'], $_GET['ordre'])) {
                $clef = htmlspecialchars($_GET['clef'], ENT_QUOTES, 'UTF-8');
                $ordre = htmlspecialchars($_GET['ordre'], ENT_QUOTES, 'UTF-8');
                $entreprises = trierParCle($entreprises, $clef, $ordre);
            }

            // Pagination
            $parPage = 10;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $total = count($entreprises);
            $totalPages = ceil($total / $parPage);
            $entreprises = paginerTab($parPage, $page, $entreprises);

            // Construction de l'interface
            $contenuePrincipale .= '<p class="lead text-uppercase mt-4">Les entreprises</p>';
            $contenuePrincipale .= '
                <div class="col-md-8">
                    <form method="get" action="./index.php">
                        <input type="hidden" name="action" value="afficher">
                        <input type="hidden" name="fonction" value="trier">
                        <span class="d-flex">
                            <label for="clef" class="col-2">Trier par</label>
                            <select id="clef" name="clef" class="form-control border-primary">
                                <option value="id">Id</option>
                                <option value="nom">Nom</option>
                                <option value="description">Description</option>
                                <option value="adresse">Adresse</option>
                                <option value="nbrEmp">Nombre d\'employé</option>
                                <option value="dateC">Date de création</option>
                            </select>
                            <select id="ordre" name="ordre" class="form-control border-primary mx-2">
                                <option value="asc">Croissant</option>
                                <option value="desc">Décroissant</option>
                            </select>
                            <button class="btn btn-primary" type="submit">Trier</button>
                        </span>
                    </form>
                </div>';

            // Tableau des entreprises
            $contenuePrincipale .= "<div class='table-responsive'>";
            $contenuePrincipale .= "<table class='table table-striped'>";
            $contenuePrincipale .= "<thead class='thead-dark'><tr>
                <th scope='col'>ID</th>
                <th scope='col'>Photo</th>
                <th scope='col'>Nom</th>
                <th scope='col'>Description</th>
                <th scope='col'>Adresse</th>
                <th scope='col'>Nombre d'employé</th>
                <th scope='col'>Date de création</th>
                <th>Action</th>
            </tr></thead>";
            $contenuePrincipale .= "<tbody>";

            foreach ($entreprises as $entreprise) {
                $contenuePrincipale .= $entreprise;
            }

            $contenuePrincipale .= "</tbody></table></div>";

            // Pagination
            $contenuePrincipale .= "<div class='my-2 text-center'>";
            if ($page > 1) {
                $prev = $page - 1;
                $contenuePrincipale .= "<a class='btn btn-info' href='?action=afficher&page=$prev&parPage=$parPage'>Prev</a> ";
            } else {
                $contenuePrincipale .= "<span class='btn btn-secondary'>Prev</span> ";
            }

            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $page) {
                    $contenuePrincipale .= "<strong class='btn btn-primary'>$i</strong> ";
                } else {
                    $contenuePrincipale .= "<a class='btn btn-secondary' href='?action=afficher&page=$i&parPage=$parPage'>$i</a> ";
                }
            }

            if ($page < $totalPages) {
                $next = $page + 1;
                $contenuePrincipale .= "<a class='btn btn-info' href='?action=afficher&page=$next&parPage=$parPage'>Next</a>";
            } else {
                $contenuePrincipale .= "<span class='btn btn-secondary'>Next</span>";
            }

            $contenuePrincipale .= "</div>";
            break;

        // Affichage détaillé d'une entreprise
        case "voir":
            if (!isset($_GET['id'])) {
                header("Location: ./index.php?action=afficher");
                exit;
            }

            $id = (int)htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
            $entreprise = Entreprise::rechercherParId($id, $pdo);

            if ($entreprise) {
                $contenuePrincipale .= '
                <p class="lead text-center my-4">Entreprise ' . $entreprise->getId() . '</p>
                <form method="POST">
                    <div class="form-group">
                        <label for="nom">Nom :</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="' . htmlspecialchars($entreprise->getNom(), ENT_QUOTES, 'UTF-8') . '" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="description">Description :</label>
                        <input type="text" class="form-control" id="description" name="description" value="' . htmlspecialchars($entreprise->getDescription(), ENT_QUOTES, 'UTF-8') . '" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="adresse">Adresse :</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" value="' . htmlspecialchars($entreprise->getAdresse(), ENT_QUOTES, 'UTF-8') . '" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="nbrEmp">Nombre d\'employé :</label>
                        <input type="text" class="form-control" id="nbrEmp" name="nbrAmp" value="' . $entreprise->getNbrEmp() . '" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="dateC">Date de création :</label>
                        <input type="text" class="form-control" id="dateC" name="dateC" value="' . htmlspecialchars($entreprise->getDateC(), ENT_QUOTES, 'UTF-8') . '" required disabled>
                    </div>
                    <a class="btn btn-primary btn-block my-4" href="./index.php?action=afficher">Retour</a>
                    <a class="btn btn-warning btn-block my-4" href="./index.php?action=modification_form&id=' . $id . '">Modifier</a>
                </form>';
            } else {
                $contenuePrincipale .= '
                <div class="alert alert-danger my-3 p-3">
                    <h4>Erreur</h4>
                    <p>
                        Entreprise non trouvée.<br>
                        <a class="btn btn-danger mt-3" href="./index.php?action=afficher">Retour</a>
                    </p>
                </div>';
            }
            break;

        // Confirmation de suppression
        case "confirmer_suppression":
            if (!isset($_GET['id'])) {
                header("Location: ./index.php?action=afficher");
                exit;
            }

            $id = (int)htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
            $contenuePrincipale .= '
                <div class="alert alert-danger my-3 p-3">
                    <h4>Entreprise ' . $id . '</h4>
                    <p>
                        Êtes-vous sûr de supprimer cette entreprise ? Cette action est irréversible !<br>
                        <a class="btn btn-danger mt-3" href="./index.php?action=supprimer&id=' . $id . '">Confirmer la suppression</a>
                    </p>
                </div>';
            break;

        // Suppression effective
        case "supprimer":
            if (!isset($_GET['id'])) {
                header("Location: ./index.php?action=afficher");
                exit;
            }

            $id = (int)htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
            $entreprise = Entreprise::rechercherParId($id, $pdo);

            if ($entreprise && $entreprise->supprimer()) {
                $contenuePrincipale .= '
                <div class="alert alert-success my-3 p-3">
                    <h4>Entreprise ' . $id . '</h4>
                    <p>
                        L\'entreprise a été supprimée avec succès.<br>
                        <a class="btn btn-success mt-3" href="./index.php?action=afficher">Retour</a>
                    </p>
                </div>';
            } else {
                $contenuePrincipale .= '
                <div class="alert alert-info my-3 p-3">
                    <h4>Entreprise ' . $id . '</h4>
                    <p>
                        L\'entreprise n\'existe pas ou n\'a pas pu être supprimée.<br>
                        <a class="btn btn-info mt-3" href="./index.php?action=afficher">Retour</a>
                    </p>
                </div>';
            }
            break;

        // Formulaire de modification
        case "modification_form":
            if (!isset($_GET['id'])) {
                header("Location: ./index.php?action=afficher");
                exit;
            }

            $id = (int)htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
            $entreprise = Entreprise::rechercherParId($id, $pdo);

            if ($entreprise) {
                $contenuePrincipale .= '
                <p class="lead text-center my-4">Entreprise ' . $entreprise->getId() . '</p>
                <form method="POST" action="./index.php?action=confirme_modification&id=' . $entreprise->getId() . '">
                    <div class="form-group">
                        <label for="nom">Nom :</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="' . htmlspecialchars($entreprise->getNom(), ENT_QUOTES, 'UTF-8') . '" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description :</label>
                        <input type="text" class="form-control" id="description" name="description" value="' . htmlspecialchars($entreprise->getDescription(), ENT_QUOTES, 'UTF-8') . '" required>
                    </div>
                    <div class="form-group">
                        <label for="adresse">Adresse :</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" value="' . htmlspecialchars($entreprise->getAdresse(), ENT_QUOTES, 'UTF-8') . '" required>
                    </div>
                    <div class="form-group">
                        <label for="nbrEmp">Nombre d\'employé :</label>
                        <input type="number" class="form-control" id="nbrEmp" name="nbrEmp" value="' . $entreprise->getNbrEmp() . '" required>
                    </div>
                    <div class="form-group">
                        <label for="dateC">Date de création :</label>
                        <small><em>jj-mm-aaaa</em></small>
                        <input type="text" class="form-control" id="dateC" name="dateC" value="' . htmlspecialchars($entreprise->getDateC(), ENT_QUOTES, 'UTF-8') . '" required>
                    </div>
                    <button class="btn btn-warning btn-block my-4" type="submit">Modifier</button>
                    <a class="btn btn-primary btn-block my-4" href="./index.php?action=afficher">Retour</a>
                </form>';
            } else {
                $contenuePrincipale .= '
                <div class="alert alert-danger my-3 p-3">
                    <h4>Erreur</h4>
                    <p>
                        Entreprise non trouvée.<br>
                        <a class="btn btn-danger mt-3" href="./index.php?action=afficher">Retour</a>
                    </p>
                </div>';
            }
            break;

        // Confirmation de modification
        case "confirme_modification":
            if (empty($_POST) || !isset($_GET['id'])) {
                header("Location: ./index.php?action=afficher");
                exit;
            }

            $id = (int)htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');

            if (validerForm($_POST)) {
                $_SESSION['form'] = [
                    'nom' => htmlspecialchars($_POST['nom'], ENT_QUOTES, 'UTF-8'),
                    'description' => htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8'),
                    'adresse' => htmlspecialchars($_POST['adresse'], ENT_QUOTES, 'UTF-8'),
                    'nbrEmp' => (int)$_POST['nbrEmp'],
                    'dateC' => htmlspecialchars($_POST['dateC'], ENT_QUOTES, 'UTF-8'),
                ];
                $contenuePrincipale .= '
                <div class="alert alert-warning my-3 p-3">
                    <h4>Entreprise ' . $id . '</h4>
                    <p>
                        Êtes-vous sûr de modifier cette entreprise ?<br>
                        <a class="btn btn-warning mt-3" href="./index.php?action=modifier&id=' . $id . '">Confirmer la modification</a>
                    </p>
                </div>';
            } else {
                $contenuePrincipale .= '
                <div class="alert alert-danger my-3 p-3">
                    <h4>Entreprise ' . $id . '</h4>
                    <p>
                        Une erreur a été détectée !<br>
                        ' . ($_SESSION['error'] ?? 'Erreur inconnue') . '<br>
                        <a class="btn btn-danger mt-3" href="./index.php?action=modification_form&id=' . $id . '">Retour</a>
                    </p>
                </div>';
            }
            break;

        // Modification effective
        case 'modifier':
            if (!isset($_GET['id']) || !isset($_SESSION['form'])) {
                header("Location: ./index.php?action=afficher");
                exit;
            }

            $id = (int)htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
            $form = $_SESSION['form'];

            $entreprise = new Entreprise(
                $pdo,
                $form['nom'],
                $form['description'],
                $form['adresse'],
                $form['nbrEmp'],
                $form['dateC']
            );
            $entreprise->setId($id);

            if ($entreprise->modifier()) {
                $contenuePrincipale .= '
                <div class="alert alert-success my-3 p-3">
                    <h4>Entreprise ' . $id . '</h4>
                    <p>
                        Modification effectuée avec succès<br>
                        <a class="btn btn-success mt-3" href="./index.php?action=voir&id=' . $id . '">Voir l\'entreprise</a>
                    </p>
                </div>';
                unset($_SESSION['form']);
            } else {
                $contenuePrincipale .= '
                <div class="alert alert-danger my-3 p-3">
                    <h4>Entreprise ' . $id . '</h4>
                    <p>
                        Une erreur s\'est produite !<br>
                        <a class="btn btn-danger mt-3" href="./index.php?action=voir&id=' . $id . '">Voir l\'entreprise</a>
                    </p>
                </div>';
            }
            break;

        // Formulaire d'ajout
        case "ajouter_form":
            $nom = $description = $adresse = $nbrEmp = $dateC = "";
            if (isset($_SESSION['form'])) {
                $nom = htmlspecialchars($_SESSION['form']['nom'], ENT_QUOTES, 'UTF-8');
                $description = htmlspecialchars($_SESSION['form']['description'], ENT_QUOTES, 'UTF-8');
                $adresse = htmlspecialchars($_SESSION['form']['adresse'], ENT_QUOTES, 'UTF-8');
                $nbrEmp = (int)$_SESSION['form']['nbrEmp'];
                $dateC = htmlspecialchars($_SESSION['form']['dateC'], ENT_QUOTES, 'UTF-8');
            }

            $contenuePrincipale .= '
            <p class="lead text-center my-4">Ajouter une entreprise</p>
            <form method="POST" action="./index.php?action=confirme_ajout">
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="' . $nom . '" placeholder="Nom de l\'entreprise" required>
                </div>
                <div class="form-group">
                    <label for="description">Description :</label>
                    <input type="text" class="form-control" id="description" name="description" value="' . $description . '" placeholder="Description de l\'entreprise" required>
                </div>
                <div class="form-group">
                    <label for="adresse">Adresse :</label>
                    <input type="text" class="form-control" id="adresse" name="adresse" value="' . $adresse . '" placeholder="Adresse de l\'entreprise" required>
                </div>
                <div class="form-group">
                    <label for="nbrEmp">Nombre d\'employé :</label>
                    <input type="number" class="form-control" id="nbrEmp" name="nbrEmp" value="' . $nbrEmp . '" placeholder="Nombre d\'employés" required>
                </div>
                <div class="form-group">
                    <label for="dateC">Date de création :</label>
                    <input type="text" class="form-control" id="dateC" name="dateC" value="' . $dateC . '" placeholder="jj-mm-aaaa" required>
                </div>
                <button class="btn btn-warning btn-block my-4" type="submit">Ajouter</button>
                <a class="btn btn-primary btn-block my-4" href="./index.php?action=afficher">Retour</a>
            </form>';
            break;

        // Confirmation d'ajout
        case "confirme_ajout":
            if (empty($_POST)) {
                header("Location: ./index.php?action=afficher");
                exit;
            }

            if (validerForm($_POST)) {
                $_SESSION['form'] = [
                    'nom' => htmlspecialchars($_POST['nom'], ENT_QUOTES, 'UTF-8'),
                    'description' => htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8'),
                    'adresse' => htmlspecialchars($_POST['adresse'], ENT_QUOTES, 'UTF-8'),
                    'nbrEmp' => (int)$_POST['nbrEmp'],
                    'dateC' => htmlspecialchars($_POST['dateC'], ENT_QUOTES, 'UTF-8'),
                ];
                $contenuePrincipale .= '
                <div class="alert alert-warning my-3 p-3">
                    <h4>Ajouter une entreprise</h4>
                    <p>
                        Êtes-vous sûr d\'ajouter cette entreprise ?<br>
                        <a class="btn btn-warning mt-3" href="./index.php?action=ajouter">Confirmer l\'ajout</a>
                    </p>
                </div>';
            } else {
                $contenuePrincipale .= '
                <div class="alert alert-danger my-3 p-3">
                    <h4>Entreprise</h4>
                    <p>
                        Une erreur a été détectée !<br>
                        ' . ($_SESSION['error'] ?? 'Erreur inconnue') . '<br>
                        <a class="btn btn-danger mt-3" href="./index.php?action=ajouter_form">Retour</a>
                    </p>
                </div>';
            }
            break;

        // Ajout effectif
        case 'ajouter':
            if (!isset($_SESSION['form'])) {
                header("Location: ./index.php?action=afficher");
                exit;
            }

            $form = $_SESSION['form'];
            $entreprise = new Entreprise(
                $pdo,
                $form['nom'],
                $form['description'],
                $form['adresse'],
                $form['nbrEmp'],
                $form['dateC']
            );

            if ($entreprise->ajouter()) {
                $contenuePrincipale .= '
                <div class="alert alert-success my-3 p-3">
                    <h4>Entreprise</h4>
                    <p>
                        Ajout effectué avec succès<br>
                        <a class="btn btn-success mt-3" href="./index.php?action=afficher">Voir les entreprises</a>
                    </p>
                </div>';
                unset($_SESSION['form']);
            } else {
                $contenuePrincipale .= '
                <div class="alert alert-danger my-3 p-3">
                    <h4>Entreprise</h4>
                    <p>
                        Une erreur s\'est produite !<br>
                        <a class="btn btn-danger mt-3" href="./index.php?action=ajouter_form">Retour</a>
                    </p>
                </div>';
            }
            break;

        // Recherche d'entreprises
        case 'rechercher':
            if (empty($_GET['clef'])) {
                header("Location: ./index.php?action=afficher");
                exit;
            }

            $clef = trim(htmlspecialchars($_GET['clef'], ENT_QUOTES, 'UTF-8'));
            $entreprises = Entreprise::rechercherParClef($clef, $pdo);

            $contenuePrincipale .= '<p class="lead my-4">Résultats pour "' . htmlspecialchars($clef, ENT_QUOTES, 'UTF-8') . '"</p>';
            $contenuePrincipale .= '<div class="table-responsive">';
            $contenuePrincipale .= '<table class="table table-striped">';
            $contenuePrincipale .= '<thead class="thead-dark"><tr>
                <th scope="col">ID</th>
                <th scope="col">Photo</th>
                <th scope="col">Nom</th>
                <th scope="col">Description</th>
                <th scope="col">Adresse</th>
                <th scope="col">Nombre d\'employé</th>
                <th scope="col">Date de création</th>
                <th>Action</th>
            </tr></thead>';
            $contenuePrincipale .= '<tbody>';

            foreach ($entreprises as $entreprise) {
                $contenuePrincipale .= $entreprise;
            }

            $contenuePrincipale .= '</tbody></table></div>';
            break;

        // Upload de logo
        case 'upload_logo':
            if (!isset($_GET['id'])) {
                header("Location: ./index.php?action=afficher");
                exit;
            }
            header("Location: ./fichier_upload.php?id=" . (int)htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8'));
            exit;

        // Génération de données fictives
        case 'donnees_fictives':
            if (empty($_POST)) {
                header("Location: ./index.php?action=afficher");
                exit;
            }

            $nbr = isset($_POST['nbr']) ? (int)htmlspecialchars($_POST['nbr'], ENT_QUOTES, 'UTF-8') : 0;
            if ($nbr <= 0) {
                $msg = '
                <div class="alert alert-danger my-3 p-3">
                    <p>
                        La valeur est vide ou inférieure à 1<br>
                        <a class="btn btn-success mt-3" href="./index.php?action=afficher">Voir les entreprises</a>
                    </p>
                </div>';
            } else {
                $entreprise = new Entreprise($pdo);
                $entreprise->ajouterD($nbr);
                header("Location: ./index.php?action=afficher");
                exit;
            }
            break;

        // Action par défaut
        default:
            header("Location: ./index.php?action=afficher");
            exit;
    }
} else {
    header("Location: ./index.php?action=afficher");
    exit;
}

// Inclusion du template
include 'squelette.php';