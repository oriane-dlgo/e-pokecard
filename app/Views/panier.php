<?= $this->extend('layouts/base') ?>

<?= $this->section('css') ?>
<style>
    .cart-container { max-width: 1000px; margin: 40px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th { background: #ff3f3f; color: white; padding: 15px; text-align: left; }
    td { padding: 15px; border-bottom: 1px solid #eee; }
    .img-mini { width: 60px; height: 60px; object-fit: contain; }
    .btn-delete { color: red; font-weight: bold; text-decoration: none; }
    .total-box { text-align: right; font-size: 1.5em; font-weight: bold; margin-top: 20px; }
    .actions { display: flex; justify-content: space-between; margin-top: 30px; }
    .btn-primary { background: #3498db; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; }
    .btn-success { background: #2ecc71; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; }
</style>
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
                        <a href="<?= base_url('panier/supprimer/' . $item['produit']['id']) ?>" class="btn-delete">❌ Supprimer</a>
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