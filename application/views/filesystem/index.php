<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('assets/plugins/elFinder/css/elfinder.min.css'); ?>">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('assets/plugins/elFinder/themes/Material/css/theme.css'); ?>">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('assets/plugins/elFinder/themes/Material/css/theme-light.css'); ?>">
<script src="<?php echo base_url('assets/plugins/elFinder/js/elfinder.min.js'); ?>"></script>
<script type="text/javascript" charset="utf-8">
  $().ready(function() {
    window.setTimeout(function() {
      var _locale = 'en_GB';
      var elf = $('#elfinder').elfinder({
        lang: 'en_GB',
        url: '<?php echo base_url('Filemanagers/elfinder_init'); ?>', // connector URL (REQUIRED)
        height: 700,
        uiOptions: {
          toolbar: [
            ['back', 'forward'],
            ['mkdir', 'mkfile', 'upload'],
            ['open', 'download', 'getfile'],
            ['info'],
            ['quicklook'],
            ['copy', 'cut', 'paste'],
            ['rm'],
            ['duplicate', 'rename', 'edit', 'resize'],
            ['extract', 'archive'],
            ['search'],
            ['view'],
          ],
        }
      }).elfinder('instance');
    }, 200);
  });
</script>
<!-- Header Layout Content -->
<div class="mdk-header-layout__content mdk-header-layout__content--fullbleed mdk-header-layout__content--scrollable page">
  <div class="container-fluid page__container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>My
        <small>Files</small>
      </h1>
    </section>
    <!-- Main content -->
    <div class="card">
      <div class="row">
        <div class="col-lg-12">
          <?php if (in_array('viewFileManager', $user_permission)) : ?>
            <div id="elfinder"></div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- // END header-layout__content -->
</div>
<!-- // END header-layout -->
</div>
<!-- // END drawer-layout__content -->

<script type="text/javascript">
  $(document).ready(function() {
    $("#FilemanagerNav").addClass('active');
  });
</script>