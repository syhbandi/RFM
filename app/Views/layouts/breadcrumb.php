<div class="row mb-2 mb-xl-3">
  <div class="col-auto d-none d-sm-block">
    <h3><?= isset($title) ? $title : 'Dashboard' ?></h3>
  </div>

  <div class="col-auto ml-auto text-right mt-n1">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
        <?php if (isset($title)) : ?>
          <li class="breadcrumb-item"><a href="/<?= service('uri')->getSegment(1) . '/' . service('uri')->getSegment(2) ?>"><?= $title ?></a></li>
        <?php endif; ?>
        <?php if (isset($subtitle)) : ?>
          <li class="breadcrumb-item active" aria-current="page"><?= $subtitle ?></li>
        <?php endif; ?>
      </ol>
    </nav>
  </div>
</div>