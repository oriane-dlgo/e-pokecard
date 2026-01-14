<?= $this->extend('layouts/front_magasin') ?> 
<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url("css/pages/auth.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

<div class="container">
    <div class="form_area">
        <p class="title">NOUVEAU JOUEUR</p> <?php if(isset($validation)):?>
            <div style="background: #ffcccc; color: red; border: 2px solid red; padding: 10px; margin-bottom: 15px; font-weight: bold; text-align: left;">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif;?>

        <form action="<?= base_url('inscription/register') ?>" method="post">
            
            <div class="group_form">
                <label class="sub_title" for="login">Pseudo</label>
                <input type="text" name="login" id="login" class="form_style" value="<?= set_value('login') ?>">
            </div>

            <div style="display: flex; gap: 15px;">
                <div class="group_form" style="flex: 1;">
                    <label class="sub_title" for="prenom">Prénom</label>
                    <input type="text" name="prenom" id="prenom" class="form_style" value="<?= set_value('prenom') ?>">
                </div>

                <div class="group_form" style="flex: 1;">
                    <label class="sub_title" for="nom">Nom</label>
                    <input type="text" name="nom" id="nom" class="form_style" value="<?= set_value('nom') ?>">
                </div>
            </div>

            <div class="group_form">
                <label class="sub_title" for="email">Email</label>
                <input type="email" name="email" id="email" class="form_style" value="<?= set_value('email') ?>">
            </div>

            <div class="group_form">
                <label class="sub_title" for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="form_style">
            </div>

            <div class="group_form">
                <label class="sub_title" for="password">Confirmer le mot de passe</label>
                <input type="password" name="verify_password" id="verify_password" class="form_style">
            </div>

            <div class="action">
                <p>
                    <input type="checkbox" name="cgu" id="cgu" value="1">
                    <label for="cgu" class="label_cgu"> J'accepte les<a class="link" href="<?= base_url('cgu') ?>"> Conditions Générales d'Utilisation</a></label>
                </p>    
            </div>

            <div class="action">
                <button class="submit">Valider</button>
                <p>Déjà un compte ? <a class="link" href="<?= base_url('connexion') ?>">Retour au Login</a></p>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>