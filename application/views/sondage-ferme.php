<div class="container">
    <div class="columns">
        <div class="column">
            <nav class="panel m-5">
                <p class="panel-heading">
                    Sondages
                </p>
                <?php foreach ($sondages as $sondage):?>
                    <a class="panel-block" href="<?= base_url("Sondage/Gestion/" . $sondage["clef"]) ?>">
                        <span class="panel-icon">
                            <?php if ($sondage["etat"] == 0): ?>
                            <i class="fas fa-calendar" aria-hidden="true"></i>
                            <?php else: ?>
                            <i class="fas fa-calendar-check" aria-hidden="true"></i>
                            <?php endif; ?>
                        </span>
                        <?= $sondage["titre"] ?>
                    </a>
                <?php endforeach;?>
                <div class="panel-block">
                    <a href="<?= base_url("sondage/creation") ?>" class="button is-link is-outlined is-fullwidth">
                        <i class="fas fa-calendar-plus mr-3"></i> Nouveau
                    </a>
                </div>
            </nav>
        </div>
        <div class="column is-8">
            <div class="card m-5 p-5">
                <h3 class="is-size-3 logo-font has-text-centered"><?= $titre ?></h3>

                <h4 class="is-size-4 logo-font mt-5">Description :</h4>
                <pre><?= $description ?></pre>

                <h4 class="is-size-4 logo-font mt-5">Lieu :</h4>
                <pre><?= $lieu ?></pre>
                
                <div class="table-container mt-5">
                    <table class="table is-fullwidth is-hoverable">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <?php foreach ($options as $option): ?>
                                <th class="has-text-centered"><?= date("Y/m/d - H\hi", $option["unix_timestamp"]) ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($answers	as $answer): ?>
                            <tr>
                                <th><?= $answer["nom"] ?></th>

                                <?php foreach ($answer["reponses"] as $reponse): ?>
                                    <?php if ($reponse == 0): ?>
                                        <th class="has-text-centered"><span class="tag is-dark"><i class="fas fa-times"></i></span></th>
                                    <?php elseif ($reponse == 1): ?>
                                        <th class="has-text-centered"><span class="tag is-warning"><i class="fas fa-check"></i></span></th>
                                    <?php else: ?>
                                        <th class="has-text-centered"><span class="tag is-primary"><i class="fas fa-check-double"></i></span></th>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="columns">
                    <div class="column has-text-left">
                        <h5 class="is-size-5 logo-font mt-5"><i class="fas fa-calendar-check mr-3"></i>Date finale : <span class="tag is-primary is-medium"><?= date("Y/m/d - H\hi", $final) ?></span></h5>
                    </div>
                    <div class="column has-text-right">
                        <?= form_open("gestion/" . $clef) ?>
                            <input name="clefToDelete" type="text" value="<?= $clef ?>" hidden>
                            <h5 class="is-size-5 mt-5"><button type="submit" class="button is-warning"><i class="fas fa-trash"></i></button></h5>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
