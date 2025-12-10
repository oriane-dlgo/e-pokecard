<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Boutique Pokémon</title>
    <style>
        .carte { border: 1px solid #ddd; padding: 10px; margin: 10px; display: inline-block; width: 200px; text-align: center; }
        .prix { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <h1>Bienvenue dans la boutique !</h1>

    <div class="catalogue">
        <?php if (!empty($lesProduits) && is_array($lesProduits)): ?>
            
            <?php foreach ($lesProduits as $produit): ?>
                <div class="carte">
                    <h3><?= esc($produit->nom) ?></h3>
                    <p><?= esc($produit->type_produit) ?></p>
                    
                    <?php if($produit->type_produit == 'carte'): ?>
                        <p>Rareté : <?= esc($produit->rarete) ?></p>
                    <?php endif; ?>

                    <p class="prix"><?= esc($produit->prix) ?> €</p>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <p>Aucun produit Pokémon trouvé.</p>
        <?php endif; ?>
    </div>

</body>
</html>