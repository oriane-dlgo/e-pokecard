<?= $this->extend('layouts/front_magasin') ?>

<?= $this->section('contenu') ?>
<div class="legal-container" style="background: #f4f4f4; padding: 40px; border: 4px solid #111; box-shadow: 10px 10px 0px rgba(0,0,0,0.5);">
<div class="legal-title">/// PROTECTION DU POKÉDEX (RGPD)</div>

    <div class="legal-section">
        <h3>1. Collecte des Données</h3>
        <p class="legal-text">
            Nous collectons les informations suivantes pour le bon traitement de vos commandes :
            Nom, Prénom, Adresse de livraison, Adresse email.
            Ces données sont stockées dans notre base de données sécurisée (Team Rocket Proof).
        </p>
    </div>

    <div class="legal-section">
        <h3>2. Cookies</h3>
        <p class="legal-text">
            Nous utilisons des cookies pour :
            <br>- Maintenir votre session active (ne pas vous déconnecter en plein combat).
            <br>- Sauvegarder votre panier.
            <br>Nous ne revendons PAS vos données à la Sylphe Co.
        </p>
    </div>

    <div class="legal-section">
        <h3>3. Vos Droits</h3>
        <p class="legal-text">
            Vous pouvez demander à tout moment l'accès, la modification ou la suppression de vos données personnelles en contactant l'Administrateur via votre Espace Dresseur.
        </p>
    </div>
</div>
<?= $this->endSection() ?>