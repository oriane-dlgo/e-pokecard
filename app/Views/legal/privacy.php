<?= $this->extend('layouts/front_magasin') ?>

<?= $this->section('contenu') ?>
<div class="legal-container" style="background: #f4f4f4; padding: 40px; border: 4px solid #111; box-shadow: 10px 10px 0px rgba(0,0,0,0.5); font-family: 'Courier New', Courier, monospace;">
    
    <div class="legal-title" style="font-weight: bold; font-size: 2em; margin-bottom: 20px; border-bottom: 4px solid #111; padding-bottom: 10px;">
        /// PROTECTION DU POKÉDEX (RGPD)
    </div>

    <div class="legal-section" style="margin-bottom: 25px;">
        <h3>1. Quelles baies récoltons-nous ? (Collecte des Données)</h3>
        <p class="legal-text">
            Pour que votre aventure sur <strong>E-POKECARD</strong> se déroule sans accroc, nous collectons les données suivantes lors de votre inscription ou de vos commandes :
            <ul style="list-style-type: '👉 '; padding-left: 20px;">
                <li><strong>Identité :</strong> Nom, prénom, pseudonyme de dresseur.</li>
                <li><strong>Contact :</strong> Adresse email pour les confirmations de commande.</li>
                <li><strong>Logistique :</strong> Adresse postale complète (pour le vol de Dracaufeu Express).</li>
                <li><strong>Technique :</strong> Adresse IP et données de navigation.</li>
            </ul>
            <em>Note : Ces données sont nécessaires au contrat liant le dresseur à l'arène de vente.</em>
        </p>
    </div>

    <div class="legal-section" style="margin-bottom: 25px;">
        <h3>2. Utilisation et Finalités</h3>
        <p class="legal-text">
            Vos données ne sont pas utilisées pour des expériences de laboratoire comme au Manoir Pokémon de Cramois'Île. Elles servent uniquement à :
            <br>- La gestion de votre compte client et de vos captures (commandes).
            <br>- L'envoi d'une newsletter (si vous avez coché la case "PokéMatos").
            <br>- L'amélioration de l'interface de notre boutique.
        </p>
    </div>

    <div class="legal-section" style="margin-bottom: 25px;">
        <h3>3. Sessions et Traceurs</h3>
        <p class="legal-text">
            <br><strong>- Session :</strong> Maintenir votre connexion active entre deux centres Pokémon.
            <br><strong>- Panier :</strong> Se souvenir des cartes que vous avez sélectionnées.
            <br><strong>- Mesures :</strong> Analyser le flux de dresseurs sur le site (via des outils respectueux de la vie privée).
        </p>
    </div>

    <div class="legal-section" style="margin-bottom: 25px;">
        <h3>4. Durée de Stockage</h3>
        <p class="legal-text">
            Vos données ne sont pas éternelles :
            <br>- Les données de compte sont supprimées après <strong>3 ans</strong> d'inactivité.
            <br>- Les données de commandes sont conservées <strong>10 ans</strong> (obligation légale pour la comptabilité).
        </p>
    </div>

    <div class="legal-section" style="margin-bottom: 25px;">
        <h3>5. Sécurité (Bouclier Type Acier)</h3>
        <p class="legal-text">
            Nous mettons en œuvre toutes les mesures de sécurité nécessaires pour protéger vos données contre les intrusions de la Team Rocket : cryptage des mots de passe (hachage), protocole HTTPS et accès restreint à la base de données.
        </p>
    </div>

    <div class="legal-section">
        <h3>6. Vos Droits de Dresseur</h3>
        <p class="legal-text">
            Conformément au RGPD, vous disposez d'un droit d'accès, de rectification, de suppression ("droit à l'oubli") et de portabilité de vos données. 
            Pour exercer ces droits, envoyez un message au Maître de la Ligue à <strong>contact@e-pokecard.com</strong>. Nous répondrons plus vite qu'une attaque Vive-Attaque !
        </p>
    </div>
</div>
<?= $this->endSection() ?>