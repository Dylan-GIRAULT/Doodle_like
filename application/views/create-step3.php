<div class="container">
    <div class="box m-5 p-5">
        <h3 class="is-size-3 has-text-centered logo-font">Participation</h3>
        <progress class="progress is-primary mt-5" value="2" max="3">2/3</progress>

        <?php if ($is_error): ?>
        <div class="notification is-danger">
            <?= $error_message ?>
        </div>
        <?php endif; ?>

        <?php echo form_open('sondage/creation'); ?>
            <input type="number" name="form_id" value="5" hidden>
            <?php foreach ($options as $option):?>

            <div class="field is-grouped">
                <h5 class="is-size-5 mr-5"><?php echo date("Y/m/d - H\hi", $option["unix_timestamp"]); ?></h5>
                <div class="select">
                    <select id="option-<?php echo $option["unix_timestamp"]; ?>" name="option-<?php echo $option["unix_timestamp"]; ?>" required>
                        <option disabled selected>Merci de choisir une disponibilité</option>
                        <option value="0">Pas disponible</option>
                        <option value="1">Disponible si besoin</option>
                        <option value="2">Disponible</option>
                    </select>
                </div>
            </div>

            <?php endforeach;?>
            
            <button type="submit" class="button is-primary"><i class="fas fa-check mr-3"></i> Participer</button>
        </form>

        <div class="has-text-centered">
            <?php echo form_open('sondage/creation'); ?>
                <input type="number" name="form_id" value="6" hidden>
                <button class="button is-primary" type="submit"><i class="fas fa-angle-double-right mr-3"></i>Etape suivante</button>
            </form>
        </div>
    </div>
</div>
