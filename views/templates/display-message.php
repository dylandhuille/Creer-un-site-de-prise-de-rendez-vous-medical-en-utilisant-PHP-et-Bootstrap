<!-- Affichage d'un message d'erreur personnalisé -->
<?php if(isset($message)) {?>
    
    <div class="alert alert-warning" role="alert">
        <?= nl2br($message)?>
    </div>

<?php } ?>
<!-- -------------------------------------------- -->
