<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= esc($product->nom) ?> - Boutique Pokémon</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Ton CSS perso si besoin -->
    <link rel="stylesheet" href="<?= base_url("css/header.css") ?>">
</head>

<body class="bg-light">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <div class="card shadow">
                <div class="row g-0">

                    <!-- Image -->
                    <div class="col-md-5 text-center bg-white p-3">
                        <img 
                            src="<?= base_url('assets/' . esc($product->image_url)) ?>"
                            class="img-fluid rounded"
                            alt="Image <?= esc($product->nom) ?>"
                        >
                    </div>

                    <!-- Infos produit -->
                    <div class="col-md-7">
                        <div class="card-body">

                            <h1 class="card-title"><?= esc($product->nom) ?></h1>

                            <span class="badge bg-primary mb-2">
                                <?= esc($product->type_produit) ?>
                            </span>

                            <?php if (!empty($product->rarete)): ?>
                                <span class="badge bg-warning text-dark">
                                    Rareté : <?= esc($product->rarete) ?>
                                </span>
                            <?php endif; ?>

                            <p class="card-text mt-3">
                                <?= esc($product->description) ?>
                            </p>

                            <h3 class="text-success">
                                <?= esc($product->prix) ?> €
                            </h3>

                            <p>
                                Stock :
                                <?php if ($product->stock > 0): ?>
                                    <span class="text-success fw-bold"><?= esc($product->stock) ?></span>
                                <?php else: ?>
                                    <span class="text-danger fw-bold">Rupture</span>
                                <?php endif; ?>
                            </p>

                            <p>
                                Promotion :
                                <?php if (!empty($product->promotion)): ?>
                                    <span class="badge bg-danger">En promotion</span>
                                <?php else: ?>
                                    <span class="text-muted">Pas de promo</span>
                                <?php endif; ?>
                            </p>

                            <div class="d-flex gap-2 mt-4">
                                <a href="/" class="btn btn-outline-secondary">
                                    ← Retour
                                </a>

                                <?php if ($product->stock > 0): ?>
                                    <button class="btn btn-success">
                                        Ajouter au panier
                                    </button>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
