<?php
include 'donnees.php'; // On suppose que ceci configure la connexion $pdo
include 'entreprise.php';

function uploadFile($file, $renameFile = true, $uploadDir = './uploads/', $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'], $maxSize = 3 * 1024 * 1024) {
    // Initialisation de la réponse
    $response = [
        'success' => false,
        'data' => null,
        'message' => ''
    ];

    // Vérifier si le fichier a été uploadé sans erreur
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $response['message'] = 'Erreur lors de l\'upload du fichier. Code d\'erreur : ' . $file['error'];
        return $response;
    }

    // Vérifier le type de fichier
    $fileType = mime_content_type($file['tmp_name']);
    if (!in_array($fileType, $allowedTypes)) {
        $response['message'] = 'Type de fichier non autorisé. Types autorisés : ' . implode(', ', $allowedTypes);
        return $response;
    }

    // Vérifier la taille du fichier
    if ($file['size'] > $maxSize) {
        $response['message'] = 'Le fichier est trop volumineux. Taille maximale autorisée : ' . ($maxSize / 1024 / 1024) . ' Mo';
        return $response;
    }

    // Créer le dossier d'upload s'il n'existe pas
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if ($renameFile === true) {
        $fileName = uniqid('logo_', true) . '_' . basename($file['name']);
    } elseif (is_string($renameFile)) {
        $fileName = $renameFile . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    } else {
        $fileName = basename($file['name']);
    }

    $destination = $uploadDir . $fileName;

    // Déplacer le fichier uploadé vers le dossier de destination
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $response['success'] = true;
        $response['data'] = [
            'file_name' => $fileName,
            'file_path' => $destination,
            'file_type' => $fileType,
            'file_size' => $file['size']
        ];
        $response['message'] = 'Fichier uploadé avec succès.';
    } else {
        $response['message'] = 'Erreur lors du déplacement du fichier.';
    }

    return $response;
}

$contenuePrincipale = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $id = $_SESSION['id'];
        $customName = 'logo_' . $id;

        // Appel de la fonction uploadFile
        $result = uploadFile($file, $customName, './logo/');

        // Affichage du résultat
        if ($result['success']) {
            // Correction : Passer $pdo à la méthode statique rechercherParId
            $entreprise = Entreprise::rechercherParId($id, $pdo);
            if ($entreprise) {
                $entreprise->setLogo($result['data']['file_name']);
                $entreprise->modifierLogo(); // Utiliser modifierLogo pour ne mettre à jour que le logo

                $contenuePrincipale .= '
                    <div class="alert-success my-3 p-3">
                        <h4>Téléchargement de Logo</h4>
                        <p>
                            Téléchargement réussi ' . htmlspecialchars($result['data']['file_path']) . ' !!!<br>
                            <a class="btn btn-success mt-3" href="./index.php?action=afficher">Afficher les entreprises</a>
                        </p>
                    </div>
                ';
            } else {
                $contenuePrincipale .= '
                    <div class="alert-danger my-3 p-3">
                        <h4>Entreprise</h4>
                        <p>
                            Entreprise non trouvée pour l\'ID ' . htmlspecialchars($id) . '.<br>
                            <a class="btn btn-danger mt-3" href="./index.php?action=afficher">Retour</a>
                        </p>
                    </div>
                ';
            }
        } else {
            $contenuePrincipale .= '
                <div class="alert-danger my-3 p-3">
                    <h4>Entreprise</h4>
                    <p>
                        Une erreur s\'est produite !!! <br>
                        ' . htmlspecialchars($result['message']) . '<br>
                        <a class="btn btn-danger mt-3" href="./index.php?action=afficher">Retour</a>
                    </p>
                </div>
            ';
        }
    } else {
        $contenuePrincipale = '<p>Aucun fichier n\'a été uploadé.</p>';
    }
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $_SESSION['id'] = $id;
        $contenuePrincipale .= '<p class="lead text-uppercase mt-4">Télécharger le logo de l\'entreprise ' . htmlspecialchars($id) . '</p>';
        $contenuePrincipale .= '
        <form action="fichier_upload.php?id=' . htmlspecialchars($id) . '" method="post" enctype="multipart/form-data">
            <div class="form-group col-sm-6">
                <label for="file">Le logo de l\'entreprise (image de 3 Mo max) :</label>
                <input type="file" class="form-control my-2" name="file" id="file" required>
            </div>
            <button class="btn btn-success" type="submit">Envoyer</button>
            <a class="btn btn-danger" href="index.php?action=afficher">Retour</a>
        </form>';
    } else {
        header("Location: ./index.php?action=afficher");
        exit;
    }
}

include 'squelette.php';
?>