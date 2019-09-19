<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?= base_url(); ?>panel" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><?= $settings->title_small; ?></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?= $settings->title?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown">
              <a class="btn tip" title="<?= lang('language') ?>" data-placement="bottom" data-toggle="dropdown"
                 href="#">
                  <img src="<?= base_url('assets/images/langs/' . $settings->language . '.png'); ?>" alt="">
              </a>
              <ul class="dropdown-menu pull-right">
                  <?php $scanned_lang_dir = array_map(function ($path) {
                      return basename($path);
                  }, glob(APPPATH . 'language/*', GLOB_ONLYDIR));
                  foreach ($scanned_lang_dir as $entry) { ?>
                      <li>
                          <a href="<?= site_url('panel/dashboard/language/' . $entry); ?>">
                              <img src="<?= base_url(); ?>assets/images/langs/<?= $entry; ?>.png" class="language-img"> 
                              &nbsp;&nbsp;<?= ucwords($entry); ?>
                          </a>
                      </li>
                  <?php } ?>
                <li class="divider"></li>
                <li>
                    <a href="<?= site_url('panel/dashboard/toggle_rtl') ?>">
                        <i class="fa fa-align-<?=$settings->toggle_rtl ? 'right' : 'left';?>"></i>
                        <?= lang('toggle_alignment') ?>
                    </a>
                </li>
              </ul>

          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= base_url();?>assets/uploads/no_image.png" class="user-image" alt="User Image">
          
              <span class="hidden-xs"><?= $user->first_name . " " . $user->last_name; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= base_url();?>assets/uploads/no_image.png" class="img-circle" alt="User Image">

                <p>
                  <?= $user->first_name . " " . $user->last_name; ?>
                  <small>Member since <?= date('M Y', $user->created_on);?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="<?= base_url(); ?>panel/auth/change_password">Password</a>
                  </div>
                  <!-- <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div> -->
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?= base_url();?>panel/auth/edit_user/<?= $user->id ?>" class="btn btn-default btn-flat">Edit Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('panel/auth/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
         
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= base_url();?>assets/uploads/no_image.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= $user->first_name . " " . $user->last_name; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        
          
  <?php foreach ($menu as $parent => $parent_params): ?>

    <?php if ( (array_key_exists($parent_params['url'], $page_auth) && $page_auth[$parent_params['url']] == 1 ) || !array_key_exists($parent_params['url'], $page_auth) ): ?>

      <?php if ( empty($parent_params['children']) ): ?>

        <?php $active = ($current_uri==$parent_params['url'] || $ctrler==$parent); ?>
        <li class='<?php if ($active) echo 'active'; ?>'>
          <a href='<?= base_url(); ?>panel/<?php echo $parent_params['url']; ?>'>
            <i class='<?php echo $parent_params['icon']; ?>'></i> <span><?php echo $parent_params['name']; ?></span>
          </a>
        </li>

      <?php else: ?>

        <?php $parent_active = ($ctrler==$parent); ?>
        <li class='treeview <?php if ($parent_active) echo 'active'; ?>'>
          <a href='#'>
            <i class='<?php echo $parent_params['icon']; ?>'></i> <span><?php echo $parent_params['name']; ?></span> <i class='fa fa-angle-left pull-right'></i>
          </a>
          <ul class='treeview-menu'>
              <?php foreach ($parent_params['children'] as $name => $url): ?>
              <?php if ( (array_key_exists($url, $page_auth) && $page_auth[$url] == 1 ) || !array_key_exists($url, $page_auth) ): ?>
              <?php $child_active = ($current_uri==$url); ?>
              <li <?php if ($child_active) echo 'class="active"'; ?>>
                <a href='<?= base_url(); ?>panel/<?php echo $url; ?>'><i class='fa fa-circle-o'></i> <span><?php echo $name; ?></span></a>
              </li>
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </li>

      <?php endif; ?>
  
    <?php endif; ?>

  <?php endforeach; ?>
  
  <?php if ( !empty($useful_links) ): ?>
    <li class="header">USEFUL LINKS</li>
    <?php foreach ($useful_links as $link): ?>
      <?php if ($this->ion_auth->in_group($link['auth']) ): ?>
      <li>
        <a href="<?php echo starts_with($link['url'], 'http') ? $link['url'] : base_url($link['url']); ?>" target='<?php echo $link['target']; ?>'>
          <i class="fa fa-circle-o <?php echo $link['color']; ?>"></i> <?php echo $link['name']; ?>
        </a>
      </li>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php endif; ?>
  </ul>
  
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="content-wrapper">
  <!-- Content Header (Page header) -->
   
         <!-- Main content -->
    <section class="content">
        <?php if (isset($_SESSION['message'])) { ?>
      <div class="alert alert-success">
          <button data-dismiss="alert" class="close" type="button">×</button>
          <?= $_SESSION['message']; ?>
      </div>
  <?php } ?>
  <?php if (isset($_SESSION['error'])) { ?>
      <div class="alert alert-danger">
          <button data-dismiss="alert" class="close" type="button">×</button>
          <?= ($_SESSION['error']); ?>
      </div>
  <?php } ?>
  <?php if (isset($_SESSION['warning'])) { ?>
      <div class="alert alert-warning">
          <button data-dismiss="alert" class="close" type="button">×</button>
          <?= ($_SESSION['warning']); ?>
      </div>
  <?php } ?>


