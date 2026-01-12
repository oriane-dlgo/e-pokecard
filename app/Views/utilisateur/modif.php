<?= $this->extend('layouts/front_magasin') ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url('css/pages/profil.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/pages/auth.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

<div class="profil-container">
    <div class="trainer-header">
        <h1>UPDATE TRAINER CARD</h1>
    </div>

    <div class="form_area" style="background: #e0e0e0; border: 4px solid #111; max-width: 800px; margin: 0 auto;">
        
        <?php if(isset($validation)):?>
            <div style="background: #ffcccc; color: red; border: 2px solid red; padding: 10px; margin-bottom: 15px; font-weight: bold;">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif;?>

        <form action="<?= base_url('profil/update') ?>" method="post">
            
            <div class="group_form">
                <label class="sub_title" style="color:#666">PSEUDO (Locked)</label>
                <input type="text" class="form_style" value="<?= esc($user->login) ?>" disabled style="background:#ccc; cursor:not-allowed;">
            </div>

            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <div class="group_form" style="flex: 1; min-width: 200px;">
                    <label class="sub_title">Prénom</label>
                    <input type="text" name="prenom" class="form_style" value="<?= set_value('prenom', $user->prenom) ?>">
                </div>

                <div class="group_form" style="flex: 1; min-width: 200px;">
                    <label class="sub_title">Nom</label>
                    <input type="text" name="nom" class="form_style" value="<?= set_value('nom', $user->nom) ?>">
                </div>
            </div>

            <div class="group_form">
                <label class="sub_title">Email</label>
                <input type="email" name="email" class="form_style" value="<?= set_value('email', $user->email) ?>">
            </div>

            <div class="group_form">
                <label class="sub_title">Adresse de Livraison</label>
                <textarea name="adresse" class="form_style" rows="3" style="font-family: 'VT323'; font-size: 22px;"><?= set_value('adresse', $user->adresse) ?></textarea>
            </div>

            <div class="action" style="display:flex; gap:20px; justify-content:center; margin-top: 30px;">
                
                <a href="<?= base_url('profil') ?>" class="btn-retro btn-cancel" style="width: auto; padding-left: 30px; padding-right: 30px;">CANCEL</a>
                
                <button class="btn-retro btn-save" style="width: auto; padding-left: 30px; padding-right: 30px; margin-bottom: 10px;">SAVE DATA</button>
            
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>