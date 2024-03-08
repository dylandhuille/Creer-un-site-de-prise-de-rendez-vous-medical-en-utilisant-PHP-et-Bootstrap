<?php if(isset($message)) {?>

    <div class="alert alert-warning" role="alert">
        <?= nl2br($message)?>
    </div>

<?php } else { ?>

    <form action="" method="GET" class="row">
        <div class="form-group col-3">
            <input type="text" name="s" id="s" value="<?=$s?>" class="form-control" placeholder="Qui recherchez-vous?">
        </div>
        <div class="form-group col-9">
            <input type="submit" value="Rechercher" class="btn btn-info">
        </div>

    </form>

    <p class="mt-3 fst-italic">
        Il y a <span class="fw-bold"><?=$nbPatients?> patients</span> dans votre cabinet
    </p>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Prénom</th>
                <th scope="col">Nom</th>
                <th scope="col">Date de naissance</th>
                <th scope="col">Email</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>

            <?php 
        $i=0;
        foreach($response as $patient) {
            $i++;
            ?>
            <tr>
                <th scope="row"><?=$patient->id?></th>
                <td><?=htmlentities($patient->firstname)?></td>
                <td><?=htmlentities($patient->lastname)?></td>
                <td><?=htmlentities($patient->birthdate)?></td>
                <td><a href="mailto:<?=htmlentities($patient->mail)?>"><?=htmlentities($patient->mail)?></a></td>
                <td>
                    <a href="/controllers/display-patientCtrl.php?id=<?=htmlentities($patient->id)?>"><i class="fs-5 fas fa-edit"></i></a>
                    <a href="/controllers/delete-patientCtrl.php?id=<?=$patient->id?>"><i class="fas fa-trash fs-5"></i></a>
                </td>
            </tr>
            <?php } ?>

        </tbody>
    </table>
    <nav aria-label="...">
        <ul class="pagination pagination-lg">
            

            <?php
            for($i=1;$i<=$nbPages;$i++){
                if($i==$currentPage){ ?>    
                <li class="page-item active" aria-current="page">
                    <span class="page-link">
                    <?=$i?> 
                    <span class="visually-hidden">(current)</span>
                    </span>
                </li>
            <?php } else { ?>
            <li class="page-item"><a class="page-link" href="?currentPage=<?=$i?>&s=<?=$s?>"><?=$i?></a></li>
            <?php } 
            }?>
        </ul>
    </nav>
<?php } ?>