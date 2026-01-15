<?= $this->extend('layouts/front_magasin') ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url("css/pages/auth.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

    <div class="container">
        <div class="form_area">
            
            <p class="title">MOT DE PASSE OUBLIE</p> 
            <?php if(session()->getFlashdata('msg')):?>
        <div class="alert alert-error">
         <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif;?>

            <?php if(session()->getFlashdata('msg')):?>
                <div style="background: #ffcccc; color: red; border: 2px solid red; padding: 10px; margin-bottom: 15px; font-weight: bold; text-transform: uppercase;">
                     <?= session()->getFlashdata('msg') ?>
                </div>
            <?php endif;?>

            <form action="" method="">
                <div class="group_form">
                    <label class="sub_title" for="username">Email</label>
                    <input type="email" id="email" class="form_style" name="email" required>
                </div>
               
                <div class="action">
                    <button class="submit">ENVOYER</button> <p>Nouveau joueur? <a class="link" href="<?= base_url('inscription') ?>">Inscription</a></p>
                    <p>👉 Se connecter <a class = "link" href="<?= base_url("connexion")?>">Connexion</a></p>
                </div>
            </form>
        
        </div>
    </div>

<?= $this->endSection() ?>