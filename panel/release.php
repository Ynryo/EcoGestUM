<?php
include_once __DIR__ . '/assets/src/conn.php';
if ($role_id !== 2) {
    header('Location: ?view=release');
    exit;
}
?>

<div class="page-header">
    <h2>Publier un communiqué</h2>
</div>

<div class="parametrage-container">

    <form method="POST" action="">

        <section class="config-section release-config">
            <div class="form-group">
                <label for="rl_title">Titre*</label>
                <input type="text" id="rl_title" name="rl_title" required>
            </div>
            <div class="form-group">
                <label for="rl_content">Contenu*</label>
                <input type="text" id="rl_content" name="rl_content" required>
            </div>
            <button class="button blue">Envoyer</button>
        </section>

        <hr>d