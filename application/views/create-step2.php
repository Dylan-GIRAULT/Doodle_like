<div class="container">
    <div class="box m-5 p-5">
        <h3 class="is-size-3 has-text-centered logo-font">Ajout des choix</h3>
        <progress class="progress is-primary mt-5" value="1" max="3">2/3</progress>

        <?php if ($is_error): ?>
        <div class="notification is-danger">
            <?= $error_message ?>
        </div>
        <?php endif; ?>

        <?php if (count($options) > 0): ?>
            <?php foreach ($options as $option): ?>
            <div class="box m-3">
                <div class="columns">
                    <div class="column is-size-4">
                        <?= date("Y/m/d - H\hi", $option["unix_timestamp"]) ?>
                    </div>
                    <div class="column has-text-right">
                        <?php echo form_open('sondage/creation'); ?>
                            <input type="number" name="to_delete_timestamp" value="<?= $option["unix_timestamp"] ?>" hidden>
                            <input type="number" name="form_id" value="2" hidden>
                            <button type="submit" class="button"><i class="fas fa-calendar-minus"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
        <div class="notification">
            Merci d'ajouter au moins une option
        </div>
        <?php endif; ?>

        <div class="mt-5"></div>

        <?php echo form_open('sondage/creation'); ?>
            <input type="number" name="form_id" value="3" hidden>
            <div class="field is-grouped">
                <div class="field mr-3">
                    <div class="control">
                      <input name="date" id="date" class="input" type="date" required>
                    </div>
                </div>
                <div class="field mr-3">
                    <div class="control">
                      <input name="temps" id="temps" class="input" type="time" required>
                    </div>
                </div>
                
                <button class="button is-primary" type="submit"><i class="fas fa-calendar-plus mr-3"></i>Ajouter Option</button>
            </div>
        </form>

        <div class="has-text-centered">
            <?php echo form_open('sondage/creation'); ?>
                <input type="number" name="form_id" value="4" hidden>
                <?php if (count($options) > 0): ?>
                <button class="button is-primary" type="submit"><i class="fas fa-angle-double-right mr-3"></i>Etape suivante</button>
                <?php else: ?>
                <button class="button is-primary" disabled><i class="fas fa-angle-double-right mr-3"></i>Etape suivante</button>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
