<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entreprise</title>
    
    <!-- CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <header class="header bg-light py-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <h1 class="mb-4">Entreprises</h1>
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid justify-content-center">
                            <ul class="navbar-nav flex-wrap justify-content-center">
                                <li class="nav-item">
                                    <a class="nav-link <?= ($action == "afficher") ? 'btn btn-primary text-white' : '' ?>" 
                                       href="index.php?action=afficher">
                                        Afficher les entreprises
                                    </a>
                                </li>
                                <li class="nav-item mx-2">
                                    <a class="nav-link <?= ($action == "tester") ? 'btn btn-primary text-white' : '' ?>" 
                                       href="index.php?action=tester">
                                        Vérifier la connexion
                                    </a>
                                </li>
                                <li class="nav-item me-2">
                                    <a class="nav-link <?= ($action == "ajouter_form") ? 'btn btn-primary text-white' : '' ?>" 
                                       href="index.php?action=ajouter_form">
                                        Ajouter une entreprise
                                    </a>
                                </li>
                                <li class="nav-item me-2">
                                    <a class="nav-link" 
                                       href="apropos.html" target="_blank">
                                        À propos de l'application
                                    </a>
                                </li>
                                <li class="nav-item me-2">
                                    <button type="button" class="btn btn-info py-1 px-2" 
                                            data-bs-toggle="modal" data-bs-target="#donneesModal">
                                        Générer des données fictives
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <form method="get" action="./index.php" class="d-flex">
                                        <input type="hidden" name="action" value="rechercher">
                                        <input type="text" class="form-control me-2" name="clef" 
                                               placeholder="Rechercher" aria-label="Rechercher">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <?php if (!empty($msg)): ?>
                <div class="row">
                    <div class="col-12">
                        <?= $msg ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <main class="container my-4">
        <?= $contenuePrincipale ?>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="donneesModal" tabindex="-1" aria-labelledby="donneesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="donneesModalLabel">Générer des données fictives</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <form method="POST" action="./index.php?action=donnees_fictives">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombreDonnees" class="form-label">Nombre de données à générer:</label>
                            <input type="number" class="form-control" name="nbr" id="nombreDonnees" 
                                   min="1" placeholder="ex: 10" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Générer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/jquery.dataTables.min.js"></script>
    <script src="./assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="./assets/js/datatables-demo.js"></script>
</body>
</html>