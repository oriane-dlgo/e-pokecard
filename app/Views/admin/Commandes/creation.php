<?= $this->extend('layouts/front_admin') ?>

<?= $this->section('title') ?>
    ADMIN - AJOUT COMMANDE
<?= $this->endSection() ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url('css/admin/forms.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

<div class="bios-container">
    
    <div class="admin-header">
        <h1>NOUVELLE COMMANDE
        <a href="<?= base_url('admin/commandes') ?>" class="btn-back">✖ ANNULER</a>
        </h1>
    </div>

    <?php if(session()->getFlashdata('error')):?>
        <div class="alert alert-error">
             <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif;?>

    <div class="info-box" style="text-align:center; color: #aaa; margin-bottom: 20px;">
        <span style="color:yellow;">⚠ ATTENTION :</span> Création manuelle. 
        Cette action génère une commande globale sans lier de produits spécifiques (utile pour régularisation ou commande hors-stock).
    </div>

    <form action="<?= base_url('admin/commandes/save') ?>" method="post">
        
        <div class="admin-grid admin-grid-single">
            <div class="data-column">
                
                <h3 class="column-title title-cyan">DÉTAILS DE LA FACTURATION</h3>

                <div class="form-group promo-box">
                    <label>CLIENT / UTILISATEUR</label>
                    <select name="id_user" required style="font-size: 20px;">
                        <option value="">-- CHOISIR UN CLIENT --</option>
                        <?php foreach($users as $u): ?>
                            <?php 
                                $uid = is_object($u) ? $u->id : $u['id'];
                                $unom = is_object($u) ? $u->nom : $u['nom'];
                                $uprenom = is_object($u) ? $u->prenom : $u['prenom'];
                                $uemail = is_object($u) ? $u->email : $u['email'];
                            ?>
                            <option value="<?= $uid ?>">
                                #<?= $uid ?> - <?= esc(strtoupper($unom . ' ' . $uprenom)) ?> (<?= esc($uemail) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>DATE DE CRÉATION</label>
                        <input type="text" value="<?= date('d/m/Y H:i') ?>" disabled class="input-disabled">
                        <small style="color:#777;">*Automatique</small>
                    </div>

                    <div class="form-group">
                        <label>MONTANT TOTAL ($)</label>
                        <input type="number" name="total" step="0.01" min="0" required placeholder="0.00" class="input-total">
                    </div>
                </div>

                <div class="form-group">
                    <label>STATUT INITIAL</label>
                    <input type="text" value="VALIDÉE (Par défaut)" disabled class="input-status-valid">
                </div>

            </div>
        </div>

        <div class="btn-save-wrapper">
            <button type="submit" class="btn-save">✚ CRÉER LA COMMANDE</button>
        </div>

    </form>
</div>

<?= $this->endSection() ?>