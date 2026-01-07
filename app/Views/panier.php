<?= $this->extend('layouts/base') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url("css/panier.css") ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

<div class="cart-container">
    <h1>Votre Panier</h1>

    <?php if (empty($articles)): ?>
        <p style="text-align: center; font-size: 1.2em; padding: 50px;">
            Votre panier est vide... Comme une Pokéball sans Pokémon. 🕸️
            <br><br>
            <a href="<?= base_url('/') ?>" class="btn-primary">Retourner à la boutique</a>
        </p>
    <?php else: ?>

        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $item): ?>
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <img src="<?= base_url('assets/img/' . $item['produit']['image_url']) ?>" class="img-mini">
                                <?= esc($item['produit']['nom']) ?>
                            </div>
                        </td>
                        <td><?= esc($item['produit']['prix']) ?> €</td>
                        <td>x <?= esc($item['quantite']) ?></td>
                        <td><?= esc($item['total_ligne']) ?> €</td>
                        <td>
                            <a href="<?= base_url('panier/supprimer/' . $item['produit']['id']) ?>" class="btn-delete">❌
                                Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total-box">
            Total à payer : <span style="color: #e74c3c;"><?= $total_global ?> €</span>
        </div>

        <div class="actions">
            <a href="<?= base_url('panier/vider') ?>" style="color: #666;">Vider le panier</a>
            <a href="#" class="btn-success">Valider la commande 🚀</a>
        </div>

    <?php endif; ?>
</div>

<?= $this->endSection() ?>