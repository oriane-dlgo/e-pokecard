<?= $this->extend('layouts/front_magasin') ?>

<?= $this->section('css') ?>
    <link rel="stylesheet" href="<?= base_url('css/pages/profil.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('contenu') ?>

<div class="profil-container">
    
    <div class="trainer-header">
        <h1>VOTRE CARTE DE PROFIL</h1>
        <div class="trainer-id">ID No. <?= esc($user->id) ?></div>
    </div>

    <div class="profil-grid">
        
        <div class="profil-card info-card">
            <div class="card-title">IDENTITÉ</div>
            
            <div class="content-row">
                <div class="avatar-box">
                    <img src="<?= base_url('assets/perso.png') ?>" alt="Avatar">
                </div>

                <div class="info-list">
                    <div class="info-row">
                        <span class="label">PSEUDO:</span>
                        <span class="value"><?= esc($user->login) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">PRENOM NOM:</span>
                        <span class="value"><?= esc($user->prenom . ' ' . $user->nom) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">EMAIL:</span>
                        <span class="value"><?= empty($user->email) ? '---' : esc($user->email) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">ADRESSE:</span>
                        <span class="value"><?= empty($user->adresse) ? '---' : esc($user->adresse) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">BADGES:</span>
                        <span class="value badge-retro"><?= esc($user->role) ?></span>
                    </div>
                </div>
            </div>

            <div class="menu-box">
                <div class="menu-title">OPTIONS</div>
                <a href="<?= base_url('profil/edit') ?>" class="btn-retro btn-edit">MODIFIER LA CARTE</a>
                <a href="<?= base_url('deconnexion') ?>" class="btn-retro btn-logout">SE DÉCONNECTER</a>
            </div>
        </div>

        <div class="profil-card history-card">
            <div class="card-title">DERNIÈRES AVENTURES (COMMANDES)</div>
            
            <?php if (empty($commandes)): ?>
                
                <div class="empty-log">
                    <p>Aucune commandes effectuées</p>
                </div>

            <?php else: ?>

                <div class="history-list">
                    <?php foreach ($commandes as $cmd): ?>
                        <a href="<?= base_url('profil/commande/' . $cmd->id) ?>" style="text-decoration: none;">
                        <div class="history-row" style="display: flex; align-items: center; justify-content: space-between;">
                            
                            <div class="history-info">
                                <div class="history-info-title">
                                    CMD #<?= str_pad($cmd->id, 4, '0', STR_PAD_LEFT) ?>
                                </div>
                                <div class="history-info-sub">
                                    <?= date('d/m/Y', strtotime($cmd->date_creation)) ?> • <?= $cmd->nb_articles ?> Article(s)
                                </div>
                            </div>
                            
                            <div class="history-right" style="display: flex; align-items: center; gap: 15px;">
                                <div class="history-price" style="text-align: right;">
                                    <div class="history-price-val">
                                        <?= number_format($cmd->total, 2) ?> €
                                    </div>
                                    
                                    <?php 
                                        $statusClass = 'status-validee'; // Défaut (vert)
                                        if($cmd->statut == 'attente') $statusClass = 'status-attente'; // Ex: orange
                                        if($cmd->statut == 'annulee') $statusClass = 'status-annulee'; // Ex: rouge
                                    ?>
                                    <div class="history-status <?= $statusClass ?>">
                                        <?= strtoupper($cmd->statut) ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        </a>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>