<div class="container">
    <div class="box m-5 p-5">
        <h3 class="is-size-3 has-text-centered logo-font">Nouveau Sondage</h3>
        <progress class="progress is-primary mt-5" value="0" max="3">1/3</progress>

        <?php if ($is_error): ?>
        <div class="notification is-danger">
            <?= $error_message ?>
        </div>
        <?php endif; ?>

        <?php echo form_open('sondage/creation'); ?>
            <input type="number" name="form_id" value="1" hidden>
            <div class="field">
                <label class="label">Titre</label>
                <div class="control">
                  <input name="titre" id="titre" class="input" type="text" placeholder="Super réunion" maxlength="30" required>
                </div>
                <p class="help has-text-grey-light">30 caractères max</p>
            </div>
            <div class="field">
                <label class="label">Description</label>
                <div class="control">
                    <textarea name="description" id="description" class="textarea" placeholder="Ca serait sympa non ?" maxlength="250" rows="2" required></textarea>
                </div>
                <p class="help has-text-grey-light">250 caractères max</p>
            </div>
            <div class="field">
                <label class="label">Lieu</label>
                <div class="control">
                  <input name="lieu" id="lieu" class="input" type="text" placeholder="Salle 235" maxlength="50" required>
                </div>
                <p class="help has-text-grey-light">50 caractères max</p>
            </div>
            <div class="has-text-centered">
                <button class="button is-primary" type="submit"><i class="fas fa-angle-double-right mr-3"></i>Etape suivante</button>
            </div>
        </form>
    </div>
</div>