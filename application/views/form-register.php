<div class="task-container columns is-multiline mt-5 mb-5">
    <div class="card column is-4 is-offset-4 mt-5 mb-5">
        <section class="section">
            <h2 class="is-size-2 has-text-centered logo-font">Inscription</h2>
        </section>
        <section class="section">

            <?php if ($invalid): ?>
            <div class="notification is-danger">
                <?= $errorMsg ?>
            </div>
            <?php endif ?>

            <?php echo form_open('compte/inscription'); ?>
                <div class="field">
                    <label class="label">Login</label>
                    <p class="control has-icons-left has-icons-right">
                        <input name="login" id="login" class="input" type="text" placeholder="Super login" required>
                        <span class="icon is-small is-left">
                            <i class="fas fa-user"></i>
                        </span>
                    </p>
                </div>
                <div class="field">
                    <label class="label">Prénom</label>
                    <p class="control has-icons-left has-icons-right">
                        <input name="prenom" id="prenom" class="input" type="text" placeholder="Pierre" required>
                        <span class="icon is-small is-left">
                            <i class="fas fa-user-tag"></i>
                        </span>
                    </p>
                </div>
                <div class="field">
                    <label class="label">Nom</label>
                    <p class="control has-icons-left has-icons-right">
                        <input name="nom" id="nom" class="input" type="text" placeholder="Dupont" required>
                        <span class="icon is-small is-left">
                            <i class="fas fa-user-tag"></i>
                        </span>
                    </p>
                </div>
                <div class="field">
                    <label class="label">Email</label>
                    <p class="control has-icons-left has-icons-right">
                        <input name="email" id="email" class="input" type="email" placeholder="p.dupont@gmail.com" required>
                        <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </p>
                </div>
                <div class="field">
                    <label class="label">Mot de passe</label>
                    <p class="control has-icons-left has-icons-right">
                        <input name="password" id="password" class="input" type="password" placeholder="Super mot de passe" required>
                        <span class="icon is-small is-left">
                            <i class="fas fa-key"></i>
                        </span>
                    </p>
                </div>
                <div class="has-text-centered mt-5">
                    <div class="field is-grouped">
                        <p class="control">
                            <button type="submit" class="button is-primary has-text-centered logo-font">Créer un compte</button>
                        </p>
                        <p class="control">
                        <a href="<?= base_url("connexion") ?>" class="button is-outlined is-primary has-text-centered logo-font">Se connecter</a>
                        </p>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
