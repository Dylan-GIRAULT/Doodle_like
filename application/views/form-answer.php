<div class="container">
    <div class="box m-5 p-5">
        <h3 class="is-size-3 has-text-centered logo-font"><?php echo $titre; ?></h3>
        
        <h4 class="is-size-4 logo-font mt-5">Description :</h4>
        <pre><?php echo $description; ?></pre>

        <h4 class="is-size-4 logo-font mt-5">Lieu :</h4>
        <pre><?php echo $lieu; ?></pre>

        <?php if ($is_valid): ?>

        <div class="notification is-primary mt-5">
            Ta participation a été enregistrée !
        </div>

        <?php elseif ($is_error): ?>

        <div class="notification is-warning mt-5">
            Erreur interne lors de l'enregistrement
        </div>

        <?php else: ?>
        
        <h4 class="is-size-4 logo-font mt-5">Ton nom :</h4>
        <?php echo form_open('reponse/' . $clef); ?>
            <div class="field">
                <div class="control">
                  <input name="nom" id="nom" class="input" type="text" placeholder="Billy" required>
                </div>
            </div>

            <h4 class="is-size-4 logo-font mt-5 mb-3">Choix parmi les dates possibles :</h4>

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
            
            <div class="has-text-centered">
                <button type="submit" class="button is-primary"><i class="fas fa-check mr-3"></i> Participer</button>
            </div>
        </form>
        
        <?php endif ?>

    </div>
</div>