<!-- Affichage d'un message d'erreur personnalisé -->
<?php if(isset($message)) {?>

    <div class="alert alert-warning" role="alert">
        <?= nl2br($message)?>
    </div>

<?php }  else { ?>
<!-- -------------------------------------------- -->

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Heure</th>
                <th scope="col">Nom Prénom</th>
                <th scope="col">Phone</th>
                <th scope="col" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>

            <?php 
        $i=0;
        foreach($appointments as $appointment) {
            $i++;
            ?>
            <tr>
                <th scope="row"><?=$i?></th>
                <td><?=date('d.m.Y', strtotime($appointment->dateHour))?></td>
                <td><?=date('H:i', strtotime($appointment->dateHour))?></td>
                <td><?=htmlentities($appointment->lastname)?> <?=htmlentities($appointment->firstname)?></td>
                <td><?=htmlentities($appointment->phone)?></td>
                <td class="text-center">
                    <a href="/controllers/edit-appointmentCtrl.php?id=<?=$appointment->id?>"><i class="fas fa-edit fs-5"></i></a>
                    <a href="/controllers/delete-appointmentCtrl.php?id=<?=$appointment->id?>"><i class="fas fa-trash fs-5"></i></a>
                </td>
            </tr>
            <?php } ?>

        </tbody>
    </table>

<?php } ?>