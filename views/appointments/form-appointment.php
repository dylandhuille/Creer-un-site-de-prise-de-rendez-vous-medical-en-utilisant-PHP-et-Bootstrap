<!-- Affichage d'un message d'erreur personnalisé -->
<?php if(isset($message)) {?>
    
    <div class="alert alert-warning" role="alert">
        <?= nl2br($message)?>
    </div>

<?php } ?>
<!-- -------------------------------------------- -->

<!-- On peut ajouter un attribut 'novalidate' dans la balise form pour désactiver temporairement tous les required et pattern -->
<form class="row g-3 needs-validation" novalidate method="POST">

    <div class="mb-4">
        <div class="form-outline">
            <input type="datetime-local" value="<?= date('Y-m-d\TH:i', strtotime($dateHour)) ?? '' ?>" class="form-control" id="dateHour" name="dateHour" required />
            <div class="valid-feedback">Parfait!</div>
            <div class="invalid-feedback">Merci de choisir une date et heure valide</div>
        </div>
        <div class="invalid-feedback-2"><?=$errorsArray['dateHour_error'] ?? ''?></div>
    </div>

    <div class="mb-4">
        <div class="form-outline">
            <select name="idPatients" required>
                <?php
                foreach($allPatients as $patient) {
                    var_dump($id);
                    $state = ($patient->id==$idPatients) ? "selected" : "";
                    echo '<option value="'.$patient->id.'" '.  $state  .'>'.$patient->lastname.' '.$patient->firstname.'</option>';
                } ?>

            </select>
            <div class="valid-feedback">Parfait!</div>
            <div class="invalid-feedback">Merci de choisir une date et heure valide</div>
        </div>
    </div>
   
    <div class="col-12">
        <button class="btn btn-primary" type="submit">Enregistrer le rendez-vous</button>
    </div>
</form>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
        'use strict';

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation');

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach((form) => {
            form.addEventListener('submit', (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>