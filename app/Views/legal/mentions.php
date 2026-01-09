<?= $this->extend('layouts/base_retro') ?>

<?= $this->section('contenu') ?>
<div class="legal-container" style="background: #f4f4f4; padding: 40px; border: 4px solid #111; box-shadow: 10px 10px 0px rgba(0,0,0,0.5);">
    
    <div class="legal-title">/// IDENTITÉ DU DRESSEUR (MENTIONS LÉGALES)</div>

    <div class="legal-section">
        <h3>1. Éditeur du Site</h3>
        <p class="legal-text">
            Le site <strong>E-POKECARD '85</strong> est un projet étudiant à but pédagogique (SAE).<br>
            <strong>Responsable de la publication :</strong> [TON NOM]<br>
            <strong>Adresse :</strong> IUT de Nantes<br>
            <strong>Email :</strong> contact@e-pokecard85.com
        </p>
    </div>

    <div class="legal-section">
        <h3>2. Hébergement</h3>
        <p class="legal-text">
            Le site est hébergé par :<br>
            <strong>Nom de l'hébergeur :</strong> Localhost / Université de Nantes<br>
            <strong>Adresse :</strong> Serveur de l'IUT
        </p>
    </div>

    <div class="legal-section">
        <h3>3. Propriété Intellectuelle & Copyright</h3>
        <p class="legal-text">
            Ce site est un hommage non-officiel.<br>
            Pokémon, les noms des personnages et les images de cartes sont des marques déposées de <strong>Nintendo, Creatures Inc. et Game Freak Inc.</strong><br>
            Aucune violation de droit d'auteur n'est souhaitée. Les images sont utilisées à des fins de démonstration technique uniquement.
        </p>
    </div>
</div>
<?= $this->endSection() ?>