<?php
include_once __DIR__ . '/assets/src/conn.php';
if ($role_id !== 2) {
    header('Location: ?view=accueil'); 
    exit;
}
?>

<div class="page-header">
    <h2>Paramétrage</h2>
</div>

<div class="parametrage-container">

    <form method="POST" action="">
        
        <section class="config-section database-config">
            <h3>Base de données</h3>
            <div class="form-group">
                <label for="db_ip">Adresse IP*</label>
                <input type="text" id="db_ip" name="db_ip" required>
            </div>
            <div class="form-group">
                <label for="db_name">Nom*</label>
                <input type="text" id="db_name" name="db_name" required>
            </div>
            <div class="form-group">
                <label for="db_identifiant">Identifiant*</label>
                <input type="text" id="db_identifiant" name="db_identifiant" required>
            </div>
            <div class="form-group">
                <label for="db_password">Mot de passe*</label>
                <input type="password" id="db_password" name="db_password" required>
            </div>
        </section>

        <hr>

        <section class="config-section application-config">
            <h3>Application</h3>
            <div class="form-group">
                <label for="app_name">Nom*</label>
                <input type="text" id="app_name" name="app_name" required>
            </div>

            <div class="form-group maintenance-mode-group">
                <label for="maintenance_mode">Mode maintenance</label>
                <label class="switch">
                    <input type="checkbox" id="maintenance_mode" name="maintenance_mode">
                    <span class="slider round"></span>
                </label>
            </div>
        </section>

        </form>
    
</div>