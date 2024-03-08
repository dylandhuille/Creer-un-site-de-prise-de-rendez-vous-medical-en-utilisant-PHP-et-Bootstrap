<!-- Affichage d'un message d'erreur personnalisé -->
<?php if(isset($message)) {?>
    
    <div class="alert alert-warning" role="alert">
        <?= nl2br($message)?>
    </div>

<?php } ?>
<!-- -------------------------------------------- -->

<form class="row g-3 needs-validation" novalidate method="POST">


    <h2>Ajouter le patient</h2>

    <input type="hidden" value="<?= $id ?? '' ?>" class="form-control" id="id" name="id" />

    <div class="mb-4">
        <div class="form-outline">
            <input type="text" value="<?= $lastname ?? '' ?>" class="form-control" id="lastname" required name="lastname" pattern="[A-Za-z-éèêëàâäôöûüç' ]+" />
            <label for="lastname" class="form-label">Nom</label>
            <div class="valid-feedback">Parfait!</div>
            <div class="invalid-feedback">Merci de choisir un nom valide.</div>
        </div>
        <div class="invalid-feedback-2"><?=$errorsArray['lastname_error'] ?? ''?></div>
    </div>
    <div class="mb-4">
        <div class="form-outline">
            <input type="text" value="<?= $firstname ?? '' ?>" class="form-control" id="firstname" required name="firstname"  pattern="[A-Za-z-éèêëàâäôöûüç' ]+" />
            <label for="firstname" class="form-label">Prénom</label>
            <div class="valid-feedback">Parfait!</div>
            <div class="invalid-feedback">Merci de choisir un prénom valide.</div>
        </div>
        <div class="invalid-feedback-2"><?=$errorsArray['firstname_error'] ?? ''?></div>
    </div>
    <div class="mb-4">
        <div class="input-group form-outline">
            <span class="input-group-text" id="inputGroupPrepend">@</span>
            <input type="email" value="<?= $mail ?? '' ?>" class="form-control" id="mail" name="mail" aria-describedby="inputGroupPrepend"
                required />
            <label for="mail" class="form-label">Email</label>
            <div class="valid-feedback">Parfait!</div>
            <div class="invalid-feedback">Merci de choisir un email valide.</div>
        </div>
        <div class="invalid-feedback-2"><?=$errorsArray['mail_error'] ?? ''?></div>
    </div>
    <div class="mb-4">
        <div class="form-outline">
            <input type="date" value="<?= $birthdate ?? '' ?>" class="form-control" id="birthdate" name="birthdate" required />
            <div class="valid-feedback">Parfait!</div>
            <div class="invalid-feedback">Merci de choisir une date de naissance valide.</div>
        </div>
        <div class="invalid-feedback-2"><?=$errorsArray['birthdate_error'] ?? ''?></div>
    </div>
    <div class="mb-4">
        <div class="form-outline">
            <input type="phone" value="<?= $phone ?? '' ?>" class="form-control" id="phone" name="phone" pattern="(01|02|03|04|05|06|07|08|09)[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}[ \.\-]?[0-9]{2}" />
            <label for="phone" class="form-label">Téléphone</label>
            <div class="valid-feedback">Parfait!</div>
            <div class="invalid-feedback">Merci de choisir un numéro de téléphone valide.</div>
        </div>
        <div class="invalid-feedback-2"><?=$errorsArray['phone_error'] ?? ''?></div>
    </div>

    <h2>Ajouter le rendez-vous</h2>

    <div class="mb-4">
        <div class="form-outline">
            <input type="datetime-local" value="<?= $dateHour ?? '' ?>" class="form-control" id="dateHour" name="dateHour" required />
            <div class="valid-feedback">Parfait!</div>
            <div class="invalid-feedback">Merci de choisir une date et heure valide</div>
        </div>
        <div class="invalid-feedback-2"><?=$errorsArray['dateHour_error'] ?? ''?></div>
    </div>
   
    <div class="col-12">
        <button class="btn btn-primary" type="submit">Enregistrer le patient et le rendez-vous</button>
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