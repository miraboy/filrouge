<?php

class Entreprise
{
    private ?int $id = null;
    private string $logo;
    private string $nom;
    private string $description;
    private string $adresse;
    private string $dateC; // date de création
    private int $nbrEmp;

    private PDO $pdo;

    // Constructeur avec injection PDO
    public function __construct(PDO $pdo, string $nom = "", string $description = "", string $adresse = "", int $nbrEmp = 1, string $dateC = "")
    {
        $this->pdo = $pdo;
        $this->nom = $nom;
        $this->logo = "logo.jpg"; // valeur par défaut
        $this->description = $description;
        $this->adresse = $adresse;
        $this->nbrEmp = max(1, $nbrEmp);
        $this->dateC = $dateC ?: date('Y-m-d');
    }

    // Convertir un tableau SQL en objet Entreprise
    public static function fromArray(array $row, PDO $pdo): Entreprise
    {
        $entreprise = new self(
            $pdo,
            $row['nom'],
            $row['description'],
            $row['adresse'],
            (int)$row['nbrEmp'],
            $row['dateC']
        );
        $entreprise->setId((int)$row['id']);
        $entreprise->setLogo($row['logo'] ?? null);
        return $entreprise;
    }

    public function __toString(): string
    {
        return "<tr>
            <th scope='row'> {$this->id} </th>
            <td><img src='./logo/{$this->logo}' style='height: 40px!important;'></td>
            <td> {$this->nom} </td>
            <td> {$this->description} </td>
            <td> {$this->adresse} </td>
            <td> {$this->nbrEmp} </td>
            <td> {$this->dateC} </td>
            <td>
                <a href='./index.php?action=voir&id={$this->id}' class='btn btn-success'><i class='fas fa-eye'></i></a>
                <a href='./index.php?action=modification_form&id={$this->id}' class='btn btn-warning'><i class='fas fa-pencil-alt'></i></a>
                <a href='./index.php?action=confirmer_suppression&id={$this->id}' class='btn btn-danger'><i class='fas fa-trash'></i></a>
                <a href='./index.php?action=upload_logo&id={$this->id}' class='btn btn-info'><i class='fas fa-upload'></i></a>
            </td>
        </tr>";
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getPhoto(): string { return $this->logo; }
    public function getDescription(): string { return $this->description; }
    public function getAdresse(): string { return $this->adresse; }
    public function getDateC(): string { return $this->dateC; }
    public function getNbrEmp(): int { return $this->nbrEmp; }
    public function getPdo(): PDO { return $this->pdo; }

    // Setters
    public function setId(int $id): void { $this->id = $id; }
    public function setNom(string $nom): void { $this->nom = $nom; }
    public function setLogo(?string $logo): void { $this->logo = $logo ?: "logo.jpg"; }
    public function setDescription(string $description): void { $this->description = $description; }
    public function setAdresse(string $adresse): void { $this->adresse = $adresse; }
    public function setNbrEmp(int $nbrEmp): void { $this->nbrEmp = max(1, $nbrEmp); }
    public function setDateC(string $dateC): void { $this->dateC = $dateC; }

    // SCRUD
    public function ajouter(): bool
    {
        $sql = "INSERT INTO entreprises (nom, logo, description, adresse, nbrEmp, dateC) 
                VALUES (:nom, :logo, :description, :adresse, :nbrEmp, :dateC)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nom' => $this->nom,
            ':logo' => $this->logo,
            ':description' => $this->description,
            ':adresse' => $this->adresse,
            ':nbrEmp' => $this->nbrEmp,
            ':dateC' => $this->dateC
        ]);
    }

    public function modifier(): bool
    {
        if ($this->id === null) throw new Exception("ID requis pour modifier");

        $sql = "UPDATE entreprises 
                SET nom = :nom, logo = :logo, description = :description, adresse = :adresse, nbrEmp = :nbrEmp, dateC = :dateC 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nom' => $this->nom,
            ':logo' => $this->logo,
            ':description' => $this->description,
            ':adresse' => $this->adresse,
            ':nbrEmp' => $this->nbrEmp,
            ':dateC' => $this->dateC,
            ':id' => $this->id
        ]);
    }

    public function modifierLogo(): bool
    {
        if ($this->id === null) throw new Exception("ID requis pour modifier le logo");

        $sql = "UPDATE entreprises SET logo = :logo WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':logo' => $this->logo,
            ':id' => $this->id
        ]);
    }

    public function supprimer(): bool
    {
        if ($this->id === null) return false;

        $sql = "DELETE FROM entreprises WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $this->id]);
    }

    public static function rechercherParId(int $id, PDO $pdo): ?Entreprise
    {
        $stmt = $pdo->prepare("SELECT * FROM entreprises WHERE id = :id");
        $stmt->execute([':id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? self::fromArray($data, $pdo) : null;
    }

    public static function rechercherParClef(string $clef, PDO $pdo): array
    {
        $sql = "SELECT * FROM entreprises 
                WHERE nom LIKE :clef OR description LIKE :clef 
                OR adresse LIKE :clef OR id LIKE :clef 
                OR nbrEmp LIKE :clef OR dateC LIKE :clef";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':clef' => "%$clef%"]);

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = self::fromArray($row, $pdo);
        }
        return $result;
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM entreprises");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = self::fromArray($row, $this->pdo);
        }
        return $result;
    }

    // Pour insérer plusieurs entreprises (ex : seed)
    public function ajouterD(int $nbr = 10): void
    {
        for ($i = 0; $i < $nbr; $i++) {
            $entreprise = new self($this->pdo, "Teck", "vente de produit teck", "Paris", 108, "2000-05-19");
            $entreprise->ajouter();
        }
    }
}

?>
