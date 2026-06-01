<?php 
// Démarrer la mise en tampon de sortie pour inclure ce contenu dans un layout
ob_start();

// Centraliser la connexion à la base de données
$conn = new mysqli("localhost", "root", "", "gestion_personnel");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}
?>

<div class="main-panel">        
    <div class="content-wrapper">
        <div class="row d-flex">
            <!-- Formulaire -->
            <div class="col-md-10 grid-margin stretch-card">
                <div class="card" style="width: 1200px; height: 1200px;">
                    <div class="card-body">
                        <h4 class="card-title">FORMULAIRE</h4>

                        <form id="formCollaborateur">
                            <!-- Champ Nom -->
                            <div class="form-group">
                                <label for="Nom_collaborateur">Nom du collaborateur</label>
                                <input type="text" id="nom_collaborateur" name="Nom_collaborateur" class="form-control" placeholder="Entrez le nom du collaborateur" required>
                            </div>

                            <!-- Champ Prénom -->
                            <div class="form-group">
                                <label for="Prenom_collaborateur">Prénom du collaborateur</label>
                                <input type="text" id="prenom_collaborateur" name="Prenom_collaborateur" class="form-control" placeholder="Entrez le prénom du collaborateur" required>
                            </div>

                            <!-- Champ Contact -->
                            <div class="form-group">
                                <label for="Contact_collaborateur">Contact du collaborateur</label>
                                <input type="number" id="contact_collaborateur" name="Contact_collaborateur" class="form-control" placeholder="Entrez le contact du collaborateur" required>
                            </div>

                            <!-- Champ Email -->
                            <div class="form-group">
                                <label for="Email_collaborateur">Email du collaborateur</label>
                                <input type="email" id="Email_collaborateur" name="Email_collaborateur" class="form-control" placeholder="Entrez l'email du collaborateur" required>
                            </div>

                            <!-- Champ Date de naissance -->
                            <div class="form-group">
                                <label for="Date_naissance_collaborateur">Date de naissance</label>
                                <input type="date" id="date_naissance_collaborateur" name="Date_naissance_collaborateur" class="form-control" required>
                            </div>

                            <!-- Champ Photo -->
                            <div class="form-group">
                                <label for="Photo_collaborateur">Photo du collaborateur</label>
                                <input type="file" id="photo_collaborateur" name="Photo_collaborateur" class="form-control" accept="image/*" required>
                            </div>

                            <!-- Liste déroulante : Service -->
                            <div class="form-group">
                                <label for="service">Service</label>
                                <select id="service" name="ID_service" class="form-control" required>
                                    <option value="" disabled selected>Choisir un service</option>
                                    <?php
                                    $query = "SELECT ID_service, Libelle_service FROM service";
                                    $result = $conn->query($query);

                                    if ($result && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['ID_service'] . "'>" . htmlspecialchars($row['Libelle_service'], ENT_QUOTES, 'UTF-8') . "</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>Aucun service disponible</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Liste déroulante : Fonction -->
                            <div class="form-group">
                                <label for="fonction">Fonction</label>
                                <select id="fonction" name="ID_fonction" class="form-control" required>
                                    <option value="" disabled selected>Choisir une fonction</option>
                                    <?php
                                    $query = "SELECT ID_fonction, Libelle_fonction FROM fonction";
                                    $result = $conn->query($query);

                                    if ($result && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['ID_fonction'] . "'>" . htmlspecialchars($row['Libelle_fonction'], ENT_QUOTES, 'UTF-8') . "</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>Aucune fonction disponible</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Liste déroulante : Société -->
                            <div class="form-group">
                                <label for="societe">Société</label>
                                <select id="societe" name="ID_societe" class="form-control" required>
                                    <option value="" disabled selected>Choisir une société</option>
                                    <?php
                                    $query = "SELECT ID_societe, Nom_societe FROM societe";
                                    $result = $conn->query($query);

                                    if ($result && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['ID_societe'] . "'>" . htmlspecialchars($row['Nom_societe'], ENT_QUOTES, 'UTF-8') . "</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>Aucune société disponible</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Liste déroulante : Contrat -->
                            <div class="form-group">
                                <label for="tcontrat">Contrat</label>
                                <select id="contrat" name="ID_contrat" class="form-control" required>
                                    <option value="" disabled selected>Choisir un type de contrat</option>
                                    <?php
                                    $query = "SELECT ID_contrat, Libelle_contrat, Date_debut_contrat, Date_fin_contrat, Duree_contrat FROM contrat";
                                    $result = $conn->query($query);

                                    if ($result && $result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['ID_contrat'] . "'>" . htmlspecialchars($row['Libelle_contrat'] . " - " . $row['Date_debut_contrat'] . " à " . $row['Date_fin_contrat'], ENT_QUOTES, 'UTF-8') . "</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>Aucun type de contrat disponible</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Bouton de soumission -->
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                            </div>
                        </form>

                        <!-- Modal pour afficher un message de succès ou d'erreur -->
                        <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="modalMessage"></div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Script pour gérer le formulaire -->
                        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                        <script>
                            $(document).ready(function () {
                                $('#formCollaborateur').on('submit', function (e) {
                                    e.preventDefault();

                                    $.ajax({
                                        url: '/Backend/Connexion_collaborateur.php',
                                        type: 'POST',
                                        data: $(this).serialize(),
                                        success: function (response) {
                                            if (response.status === "success") {
                                                $('#modalMessage').html(`<div class="text-success">${response.message}</div>`);
                                            } else {
                                                $('#modalMessage').html(`<div class="text-danger">${response.message}</div>`);
                                            }
                                            $('#alertModal').modal('show');
                                            $('#formCollaborateur')[0].reset();
                                        },
                                        error: function () {
                                            $('#modalMessage').html('<div class="text-danger">Une erreur est survenue. Veuillez réessayer.</div>');
                                            $('#alertModal').modal('show');
                                        }
                                    });
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$conn->close();
$content = ob_get_clean();
include '../Page_accueil.php';
?>
