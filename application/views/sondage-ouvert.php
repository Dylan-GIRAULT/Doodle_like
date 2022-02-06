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

                <h4 class="is-size-4 logo-font mt-5">Lien :</h4>
                <pre>https://dwarves.iut-fbleau.fr/~toutain/wim/projet/reponse/<?= $clef ?></pre>

                <div class="table-container mt-5">
                    <table class="table is-fullwidth is-hoverable">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <?php foreach ($options as $option): ?>
                                    <?php if (isset($bigger)): ?>
                                        <?php if (in_array($option["unix_timestamp"], $bigger)): ?>
                                            <th class="has-text-centered has-text-primary"><?= date("Y/m/d - H\hi", $option["unix_timestamp"]) ?></th>
                                        <?php else: ?>
                                            <th class="has-text-centered"><?= date("Y/m/d - H\hi", $option["unix_timestamp"]) ?></th>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <th class="has-text-centered"><?= date("Y/m/d - H\hi", $option["unix_timestamp"]) ?></th>
                                    <?php endif; ?>
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
                <?php if (isset($bigger)): ?>
                    <h5 class="is-size-5 logo-font mt-5">
                    <?php if (count($bigger) > 0): ?>
                        Date(s) potentielle(s) :
                        <?php foreach ($bigger as $big): ?>
                            <span class="tag is-primary is-medium ml-3"><?= date("Y/m/d - H\hi", $big) ?></span>
                        <?php endforeach; ?>

                    <?php else: ?>
                        Aucune date idéale trouvée
                    <?php endif; ?>
                    </h5>
                <?php else: ?>
                    <h5 class="is-size-5 logo-font mt-5">Aucune date idéale trouvée</h5>
                <?php endif; ?>
                <h5 class="is-size-5 logo-font mt-5">Fermer le sondage :</h5>
                <?= form_open("gestion/" . $clef) ?>
                    <div class="field is-grouped">
                        <div class="control">
                            <div class="select">
                                <select name="result" required>
                                    <option disabled selected>Choisir date finale</option>
                                    <?php foreach($options as $option): ?>
                                        <?php if (isset($bigger)): ?>
                                            <?php if (in_array($option["unix_timestamp"], $bigger)): ?>
                                                <option value="<?= $option["unix_timestamp"] ?>">[Idéal] - <?= date("Y/m/d - H\hi", $option["unix_timestamp"]) ?></option>
                                            <?php else: ?>
                                                <option value="<?= $option["unix_timestamp"] ?>"><?= date("Y/m/d - H\hi", $option["unix_timestamp"]) ?></option>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <option value="<?= $option["unix_timestamp"] ?>"><?= date("Y/m/d - H\hi", $option["unix_timestamp"]) ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="control">
                            <button type="submit" class="button is-primary"><i class="fas fa-calendar-check mr-3"></i> Fermer le sondage</button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
