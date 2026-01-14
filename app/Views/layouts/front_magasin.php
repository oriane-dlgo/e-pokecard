<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png"  href="<?= base_url('assets/pokeball.png') ?>">

    <link rel="stylesheet" href="<?= base_url("css/retro/base.css") ?>">
    <link rel="stylesheet" href="<?= base_url("css/retro/layout.css") ?>">
    <link rel="stylesheet" href="<?= base_url("css/retro/components.css") ?>">
    <link rel="stylesheet" href="<?= base_url("css/retro/responsive.css") ?>">
    <?= $this->renderSection('css') ?>
    <title>E-POKECARD</title>

</head>
<body>

<div class="game-container"> 
    
    <header>
        <?php if (session()->get('isLoggedIn') && session()->get('user_role') === 'admin'): ?>
            <a href="<?= base_url('admin/dashboard') ?>" class="admin-access-btn" title="Zone Administrateur">
                <img src="<?= base_url('assets/utilisateur_icone.png') ?>" alt="Admin">
                <span>SYSTEME ADMIN</span>
            </a>
        <?php endif; ?>

        <div class="logo">
            <h1><img src="<?= base_url("assets/pokeball.png")?>" 
            style="width:80px; vertical-align:middle;"> E-POKECARD</h1>
        </div>
    </header>

    <nav class="nav-bar">
        <div class="nav-links">
            <a href="<?= base_url('/')?>" class="btn-home">
                <img src="<?= base_url('assets/pokeball.png') ?>" alt="Home" style="width:20px; margin-right:8px; vertical-align:middle; filter: grayscale(100%) brightness(200%);">    
                ACCUEIL</a>
            <a href="<?= base_url('recherche?type=carte') ?>">CARTES</a>
            <a href="<?= base_url('recherche?type=booster') ?>">BOOSTERS</a>
            <a href="<?= base_url('recherche?type=coffret') ?>">COFFRETS</a>
            <a href="<?= base_url('recherche?type=display') ?>">DISPLAYS</a>
            <a href="<?= base_url('recherche?type=ETB') ?>">ETB</a>
            <a href="<?= base_url('recherche?type=accessoire') ?>">ACCESSOIRES</a>
            <a href="<?= base_url('recherche?q=&all_promos=1&tri=') ?>" class="prom">
                PROMOTIONS             
            </a>   
        </div>

        <form action="<?= base_url('recherche') ?>" method="get" class="nav-search-form">
            <input type="text" name="q" placeholder="RECHERCHER..." class="retro-input">
            <button type="submit" class="retro-search-btn">GO</button>
        </form>

        <div class="nav-icons">
             <?php if (session()->get('isLoggedIn')): ?>
                <a href="<?= base_url('profil') ?>" title="Mon Espace">
                    <img src="<?= base_url("assets/utilisateur_icone.png")?>" alt="Profil">
                </a>
                <div style="display:flex; align-items:center; gap:10px; margin-right:10px;">
                    <span style="color:white; font-size:18px; font-weight:bold; text-transform:uppercase;">
                        <?= esc(session()->get('user_name')) ?>
                    </span>
                    <a href="<?= base_url('deconnexion') ?>" title="Quitter la partie" class="btn-quit">OFF</a>
                </div>
             <?php else: ?>
                <a href="<?= base_url('connexion')?>" title="Se connecter">
                    <img src="<?= base_url("assets/utilisateur_icone.png")?>" alt="Connexion">
                </a>
             <?php endif; ?>
            
             <?php 
                $panierSession = session()->get('panier');
                $totalArticles = 0;
                if (!empty($panierSession) && is_array($panierSession)) {
                    foreach($panierSession as $qty) {
                        $totalArticles += (is_numeric($qty) ? $qty : 1);
                    }
                }
             ?>
             <a href="<?= base_url('panier')?>" title="Mon Panier" class="cart-icon-wrapper">
                <img src="<?= base_url("assets/panier_icone.png")?>" alt="Panier">
                
                <?php if($totalArticles > 0): ?>
                    <span class="cart-badge"><?= $totalArticles ?></span>
                <?php endif; ?>
             </a>
        </div>
    </nav>

    <div class="marquee-container">
        <div class="marquee-content">
            *** PROMOTIONS EN COURS POUR LE DEBUT D'ANNÉE 2026 !!! -10% SUR CERTAINS PRODUITS ! ---- PROFITEZ AUSSI DES NOUVEAUTÉS ***
        </div>
    </div>
    
    <img src="<?= base_url("assets/dracaufeuX.png") ?>" class="bg-dracaufeuX" alt="Background Dragon">
    <img src="<?= base_url("assets/dracaufeuY.png") ?>" class="bg-dracaufeuY" alt="Background Dragon">

    <main>
        <?= $this->renderSection('contenu') ?>
    </main>

    

    <footer class="retro-footer">
        <div class="footer-decoration"></div>
        <div class="footer-content">
            <div class="footer-col">
                <h4>POKÉ-TRADER '85</h4>
                <p>Le meilleur du TCG en 8-bits.</p>
                <p>© 1985 - 2025 Nintendo/Creatures Inc./GAME FREAK inc.</p>
            </div>
            <div class="footer-col">
                <h4>LIENS UTILES</h4>
                <a href="<?= base_url('cgv') ?>">Conditions Générales (CGV)</a>
                <a href="<?= base_url('mentions-legales') ?>">Mentions Légales</a>
                <a href="<?= base_url('confidentialite') ?>">Confidentialité (RGPD)</a>
                <a href="#">Livraison</a>
                <a href="#">Contact</a>
            </div>
            <div class="footer-col">
                <h4>NOUS RETROUVER</h4>
                <p>3615 POKEMON</p>
                <div class="socials">
                    <a href="#">FB</a> <a href="#">TW</a> <a href="#">IG</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            ABONNEZ VOUS A LA NEWSLETTER POUR DES BONUS !!
        </div>
    </footer>

</div> 
</body>
</html>