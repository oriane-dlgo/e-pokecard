<?= $this->extend('layouts/front_magasin') ?>

<?= $this->section('contenu') ?>
<div class="legal-container" style="background: #f4f4f4; padding: 40px; border: 4px solid #111; box-shadow: 10px 10px 0px rgba(0,0,0,0.5); font-family: 'Courier New', Courier, monospace;">
    
    <div class="legal-title" style="font-weight: bold; font-size: 2em; margin-bottom: 20px; border-bottom: 4px solid #111; padding-bottom: 10px;">
        /// IDENTITÉ DU DRESSEUR (MENTIONS LÉGALES)
    </div>

    <div class="legal-section" style="margin-bottom: 25px;">
        <h3>1. Éditeur du Site & Cadre du Projet</h3>
        <p class="legal-text">
            Le site <strong>E-POKECARD</strong> est réalisé dans un cadre strictement <strong>pédagogique</strong>. Il constitue un livrable pour une Situation d'Apprentissage et d'Évaluation (SAE) au sein du département Informatique.<br><br>
            <strong>Équipe de développement :</strong> Nhaël GUILLARD, Clara RENARD, Ryan SEMAOUNE et Oriane DELGADO.<br>
            <strong>Établissement :</strong> IUT de Nantes - Université de Nantes.<br>
            <strong>Adresse :</strong> 3 Rue Maréchal Joffre, 44000 Nantes.<br>
            <strong>Contact :</strong> contact@e-pokecard.com.
        </p>
    </div>

    <div class="legal-section" style="margin-bottom: 25px;">
        <h3>2. Hébergement</h3>
        <p class="legal-text">
            Le site est actuellement hébergé dans un environnement de développement local ou sur les serveurs académiques de l'Université de Nantes.<br>
            <strong>Hébergeur :</strong> Direction de la Logistique et du Numérique (DLN) - Université de Nantes.
        </p>
    </div>

    <div class="legal-section" style="margin-bottom: 25px;">
        <h3>3. Propriété Intellectuelle (Clause de Non-Affiliation)</h3>
        <p class="legal-text">
            <strong>E-POKECARD</strong> est un projet de fan à but non lucratif. 
            Il n'est en aucun cas affilié, approuvé ou soutenu par Nintendo, Game Freak ou The Pokémon Company.<br><br>
            Les noms "Pokémon", les visuels de cartes, et les marques associées sont la propriété exclusive de <strong>© Nintendo, Creatures Inc. et Game Freak Inc.</strong><br>
            Le code source, le design graphique du site et les scripts ont été développés par les étudiants susnommés.
        </p>
    </div>

    <div class="legal-section" style="margin-bottom: 25px;">
        <h3>4. Limitation de Responsabilité</h3>
        <p class="legal-text">
            Ce site étant une <strong>simulation de boutique</strong>, aucun achat réel ne peut être effectué. Les transactions simulées n'entraînent aucun débit bancaire et aucune livraison réelle de cartes ne sera effectuée (même par Dracaufeu). 
            Les auteurs ne sauraient être tenus responsables d'une mauvaise utilisation du site par un tiers.
        </p>
    </div>

    <div class="legal-section">
        <h3>5. Données et Cookies</h3>
        <p class="legal-text">
            Dans le cadre de ce projet, les données collectées (comptes utilisateurs fictifs, paniers) sont stockées temporairement à des fins de démonstration technique et ne font l'objet d'aucun traitement commercial ou revente. Conformément au RGPD, ces données peuvent être supprimées sur simple demande auprès de l'équipe étudiante.
        </p>
    </div>

</div>
<?= $this->endSection() ?>