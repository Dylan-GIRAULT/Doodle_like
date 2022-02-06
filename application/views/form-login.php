<div class="task-container columns is-multiline mt-5 mb-5">
    <div class="card column is-4 is-offset-4 mt-5 mb-5">
        <section class="section">
            <h2 class="is-size-2 has-text-centered logo-font">Connexion</h2>
        </section>
        <section class="section">

            <?php if ($invalid): ?>
            <div class="notification is-danger">
                Identifiants invalides !
            </div>
            <?php endif ?>

            <?php echo form_open('compte/connexion'); ?>
                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input name="login" id="login" class="input" type="text" placeholder="Super login">
                        <span class="icon is-small is-left">
                            <i class="fas fa-user"></i>
                        </span>
                    </p>
                </div>
                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input name="password" id="password" class="input" type="password" placeholder="Super mot de passe">
                        <span class="icon is-small is-left">
                            <i class="fas fa-key"></i>
                        </span>
                    </p>
                </div>
                <div class="has-text-centered mt-5">
                    <button type="submit" class="button is-primary has-text-centered logo-font">Se connecter</button>
                </div>
            </form>
        </section>
    </div>
</div>
