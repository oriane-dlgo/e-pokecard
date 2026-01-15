<?php $pager->setSurroundCount(0); ?>

<div class="retro-pagination">
    
    <?php if ($pager->hasPrevious()) : ?>
        <a href="<?= $pager->getPrevious() ?>" class="btn-pagin btn-prev">
            &lt; PRECEDENT
        </a>
    <?php else : ?>
        <span class="btn-pagin btn-disabled">&lt; PRECEDENT</span>
    <?php endif ?>

    <div class="pagin-info">
        <span class="pagin-label">PAGE</span>
        <span class="pagin-current"><?= $pager->getCurrentPageNumber() ?></span>
        <span class="pagin-sep">/</span>
        <span class="pagin-total"><?= $pager->getPageCount() ?></span>
    </div>

    <?php if ($pager->hasNext()) : ?>
        <a href="<?= $pager->getNext() ?>" class="btn-pagin btn-next">
            SUIVANT &gt;
        </a>
    <?php else : ?>
        <span class="btn-pagin btn-disabled">SUIVANT &gt;</span>
    <?php endif ?>
    
</div>