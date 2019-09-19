 <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top no-print">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?= $settings->title;?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">

    <ul class="nav navbar-nav">
      <?php foreach ($menu as $parent => $parent_params): ?>

        <?php if (empty($parent_params['children'])): ?>

          <?php $active = ($current_uri==$parent_params['url'] || $ctrler==$parent); ?>
          <li <?php if ($active) echo 'class="active"'; ?>>
            <a href='<?= base_url(); ?><?php echo $parent_params['url']; ?>'>
              <?php echo $parent_params['name']; ?>
            </a>
          </li>

        <?php else: ?>

          <?php $parent_active = ($ctrler==$parent); ?>
          <li class='dropdown <?php if ($parent_active) echo 'active'; ?>'>
            <a data-toggle='dropdown' class='dropdown-toggle' href='#'>
              <?php echo $parent_params['name']; ?> <span class='caret'></span>
            </a>
            <ul role='menu' class='dropdown-menu'>
              <?php foreach ($parent_params['children'] as $name => $url): ?>
                <li><a href='<?= base_url(); ?><?php echo $url; ?>'><?php echo $name; ?></a></li>
              <?php endforeach; ?>
            </ul>
          </li>

        <?php endif; ?>

      <?php endforeach; ?>
    </ul> </div><!--/.nav-collapse -->
      </div>
    </nav>