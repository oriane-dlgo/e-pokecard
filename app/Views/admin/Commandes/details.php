<?= $this->extend('layouts/front_admin') ?>
<?= $this->section('title') ?>COMMANDE #<?= $c->id ?><?= $this->endSection() ?>
<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url('css/admin/forms.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

    <?php if(session()->getFlashdata('msg')): ?>
        <div class="flash-success"><?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>

    <div class="info-row">
        <div class="admin-panel panel-glass info-col">
            <h3 class="panel-title title-white">INFOS CLIENT</h3>
            <p><strong class="text-cyan">NOM :</strong> <?= esc($c->nom) ?></p>
            <p><strong class="text-cyan">EMAIL :</strong> <a href="mailto:<?= esc($c->email) ?>" class="text-white"><?= esc($c->email) ?></a></p>
        </div>

        <div class="admin-panel panel-glass info-col">
            <h3 class="panel-title title-white">RÉSUMÉ FINANCIER</h3>
            <p><strong>TOTAL COMMANDE :</strong> <span class="price-display-large"><?= number_format($c->total, 2) ?>€</span></p>
            
            <div class="mt-15" style="border-top: 1px solid #555; padding-top: 10px;">
                <strong>STATUT ACTUEL :</strong> 
                <?php if(!empty($c->statut)): ?>
                    <span class="status-tag"><?= strtoupper($c->statut) ?></span>
                <?php else: ?>
                    <span class="status-undefined">NON DÉFINI</span>
                <?php endif; ?>
            </div>
            
            <?php if(session()->get('commandes_mementos') && isset(session()->get('commandes_mementos')[$c->id])): ?>
                <div class="mt-15">
                    <a href="<?= base_url('admin/commandes/undo/'.$c->id) ?>" class="btn-undo">
                        ↩ ANNULER DERNIÈRE MODIF
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <h3 class="section-title-large">CONTENU DU PANIER</h3>
    <table class="bios-table mt-15">
        <thead>
            <tr>
                <th style="width: 80px;">IMG</th>
                <th>PRODUIT</th>
                <th>TYPE</th>
                <th>PRIX UNIT.</th>
                <th>QTE</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($lignes as $ligne): ?>
            <tr>
                <td class="text-center">
                    <img src="<?= base_url('assets/produits/'.$ligne->image_url) ?>" class="td-img-medium">
                </td>
                <td style="font-size: 20px;"><?= esc($ligne->nom) ?></td>
                <td class="text-gray"><?= esc($ligne->type_produit) ?></td>
                <td><?= number_format($ligne->prix_unitaire, 2) ?>€</td>
                <td>x <?= $ligne->quantite ?></td>
                <td class="text-yellow text-bold"><?= number_format($ligne->prix_unitaire * $ligne->quantite, 2) ?>€</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="status-update-box">
        <form action="<?= base_url('admin/commandes/updateStatut') ?>" method="post" class="flex-center flex-wrap flex-gap-20">
            <?= csrf_field() ?>
            <input type="hidden" name="id_commande" value="<?= $c->id ?>">
            
            <label class="label-yellow mb-0" style="font-size:24px;">ACTION :</label>
            
            <select name="statut" class="role-select" style="font-size: 20px; padding: 10px; border: 2px solid white;">
                <?php foreach(['validee'=>'VALIDÉE', 'expediee'=>'EXPÉDIÉE', 'terminee'=>'TERMINÉE', 'annulee'=>'ANNULÉE'] as $val => $label): ?>
                    <option value="<?= $val ?>" <?= $c->statut == $val ? 'selected' : '' ?>>
                        DÉFINIR COMME : <?= $label ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn-save" style="width:auto; min-width:auto; padding:10px 30px; font-size:22px; margin:0;">
                METTRE À JOUR
            </button>
        </form>
    </div>
<?= $this->endSection() ?>