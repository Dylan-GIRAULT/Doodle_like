<div class="container">
    <div class="columns">
        <div class="column">
            <nav class="panel m-5">
                <p class="panel-heading">
                    Sondages
                </p>
                <?php if (count($sondages) > 0): ?>
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
                <?php else: ?>
                <a class="panel-block has-text-centered">
                    Aucun sondage ...
                </a>
                <?php endif; ?>
                <div class="panel-block">
                    <a href="<?= base_url("sondage/creation") ?>" class="button is-link is-outlined is-fullwidth">
                        <i class="fas fa-calendar-plus mr-3"></i> Nouveau
                    </a>
                </div>
            </nav>
        </div>
        <div class="column is-8">
            <div class="card m-5 p-5">
                <div class="notification">
                    Merci de choisir un sondage
                </div>
            </div>
        </div>
    </div>
</div>
