<?php
if(!defined("IN_SB")){echo "You should not be here. Only follow links!";die();}
$errors = 0;
$warnings = 0;

if(isset($_POST['username'], $_POST['password'], $_POST['server'], $_POST['port'], $_POST['database'])) {
    require(ROOT . "../includes/adodb/adodb.inc.php");
    include_once(ROOT . "../includes/adodb/adodb-errorhandler.inc.php");
    $server = "mysqli://" . $_POST['username'] . ":" . $_POST['password'] . "@" . $_POST['server'] . ":" . $_POST['port'] . "/" . $_POST['database'];
    $db = ADONewConnection($server);
    $db->Execute("SET NAMES `utf8`");
    $vars = $db->Execute("SHOW VARIABLES");
    $sql_version = "";
    while(!$vars->EOF)
    {
      if($vars->fields['Variable_name'] == "version")
      {
        $sql_version = $vars->fields['Value'];
        break;
      }
      $vars->MoveNext();
    }
} else {
    $sql_version = "НЕТ СОЕДИНЕНИЯ";
}

// В дальнейшем, в установщик будет интегрироваться мульти-язычность.
// Потому эти переменные заведены под мульти-язычность. Здесь с течением времени, будут вызовы функций "переводчика".
$disabled   = 'Disabled.';
$enabled    = 'Enabled.';
$unknown    = 'N/A';
$yes        = 'Yes';
$no         = 'No';

// ['Папка для демок', 'data/demos', $yes, $unknown, $translations, false],
$gendirdata = function($dirname, $dirpath, $required, $recommended, $display, &$name, $is_warning = false) {
  $data = [
    'required'    => $required,
    'recommended' => $recommended,

    'result'      => is_writable('../' . $dirpath),
    'display'     => $display
  ];

  if ($is_warning)
    $data['is_warning'] = true;

  $name = $dirname . '(' . $dirpath . ')';
  return $data;
};

$requirements = [
  /**
   * О структуре массива
   *
   * Ключи в нём - это названия секций, которые проверяет установщик
   * Ключи в секциях - названия "параметров"
   */
  'PHP Requirements' => [
    'PHP version'  =>  [
      'required'    => '5.5', /**< Значение, которое будет выведено в "Required" */
      'recommended' => '7.0', /**< Значение, которое будет выведено в "Recommended" */

      'result'      => (version_compare(PHP_VERSION, '5.5') != -1), /**< Результат проверки установщиком. Должно быть булевой переменной. GUI на её основе будет выводить нужные стили. */
      /* Так же возможен ключ "is_warning", наличие которого заставляет установщик превратить "ошибку" в "предупреждение", в случае не успешной проверки */

      // Если является массивом, то:
      // - выводит первый ключ, если всё хорошо
      // - выводит второй ключ, если не всё так гладко
      //
      // Если является чем-то иным, то просто выводит, как строку
      'display'     => PHP_VERSION
    ],

    'BCMath extension' => [
      'required'    => $yes,
      'recommended' => $unknown,
      
      'result'      =>  function_exists('bcadd'),
      'display'     => [$yes, $no]
    ],

    'GMP extension / 64bit PHP' => [
      'required'    => $yes,
      'recommended' => $unknown,

      'result'      => (extension_loaded('gmp') || getPhpArchitecture() == 'amd64'),
      'display'     => [$yes, $no]
    ],

    'File uploads' => [
      'required'    => $enabled,
      'recommended' => $unknown,

      'result'      => ini_get("file_uploads"),
      'display'     => [$enabled, $disabled]
    ],

    'XML support' => [
      'required'    => $enabled,
      'recommended' => $unknown,

      'result'      => extension_loaded('xml'),
      'display'     => [$enabled, $disabled]
    ]
  ],

  'MySQL requirements'  => [
    'Server version'  => [
      'required'      => '5.0',
      'recommended'   => '5.5',

      'result'        => (version_compare($sql_version, '5') != -1),
      'display'       => [$yes, $no]
    ]
  ],

  'FS requirements' => [] // это - динамически наполняемый массив. См. ниже.
];

// Наполняем "FS requirements"...
// $gendirdata = function($dirname, $dirpath, $required, $recommended, $display, &$name, $is_warning = false) {
$translations = [$yes, $no];
$fs = [
  ['Demo file',                   'data/demos',       $yes, $unknown, $translations, false],
  ['Theme cache folder',                'data/theme_c',     $yes, $unknown, $translations, false],
  ['MOD icon folder',                'images/games',     $unknown, $yes, $translations, true],
  ['Map image folder',            'images/maps',      $unknown, $yes, $translations, true],
  ['Configuration file',             'data/config.php',  $unknown, $yes, $translations, false],
  ['Game servers metadata cache',  'data/gc',          $unknown, $yes, $translations, true]
];
$req_FS = &$requirements['Требования ФС'];
foreach ($fs as $f) {
  $name = '';
  $data = $gendirdata($f[0], $f[1], $f[2], $f[3], $f[4], $name, $f[5]);

  $req_FS[$name] = $data;
}
?>
<div class="card m-b-0" id="messages-main">
		<div class="ms-menu">
			<div class="ms-block p-10">
				<span class="c-black"><b>Progress</b></span>
			</div>

			<div class="listview lv-user" id="install-progress">
				<div class="lv-item media">
					<div class="lv-avatar bgm-orange pull-left">1</div>
					<div class="media-body">
						<div class="lv-title"><del>Step: License</del></div>
						<div class="lv-small"><i class="zmdi zmdi-timer-off zmdi-hc-fw c-red"></i> <del>Previous Step</del></div>
					</div>
				</div>

				<div class="lv-item media">
					<div class="lv-avatar bgm-orange pull-left">2</div>
					<div class="media-body">
						<div class="lv-title"><del>Step: Database</del></div>
						<div class="lv-small"><i class="zmdi zmdi-timer-off zmdi-hc-fw c-red"></i> <del>Previous Step</del></div>
					</div>
				</div>

				<div class="lv-item media active">
					<div class="lv-avatar bgm-red pull-left">3</div>
					<div class="media-body">
						<div class="lv-title">Step: System requirements</div>
						<div class="lv-small"><i class="zmdi zmdi-badge-check zmdi-hc-fw c-green"></i> Current Step</div>
					</div>
				</div>

				<div class="lv-item media">
					<div class="lv-avatar bgm-orange pull-left">4</div>
					<div class="media-body">
						<div class="lv-title">Step: Creating tables</div>
						<div class="lv-small"><i class="zmdi zmdi-time zmdi-hc-fw c-blue"></i> Next step</div>
					</div>
				</div>

				<div class="lv-item media">
					<div class="lv-avatar bgm-orange pull-left">5</div>
					<div class="media-body">
						<div class="lv-title">Step: Install</div>
						<div class="lv-small"><i class="zmdi zmdi-time zmdi-hc-fw c-blue"></i> Next step</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="ms-body" id="submit-main-full">
			<div class="listview lv-message">
				<div class="lv-header-alt clearfix">
					<div class="lvh-label">
						<span class="c-black">Information</span>
					</div>
				</div>

				<div class="lv-body p-15">
					This page lists all the requirements for running the SourceBans web panel. The system will check them against the current data. This page will also list some guidelines.
				</div>

        <!-- Installer Logic and Checks -->
<?php foreach ($requirements as $name => $data): ?>
				<div class="lv-header-alt clearfix">
					<div class="lvh-label">
						<span class="c-black"><?= $name ?></span>
					</div>
				</div>
				<div class="lv-body p-15">
					<div class="col-sm-12">
						<table class="table table-hover">
							<thead>
								<tr>
									<th width="30%">Setting</th>
									<th>Recommended</th>
									<th>Required</th>
									<th width="30%">Server value</th>
								</tr>
							</thead>
							<tbody>
<?php foreach ($data as $key => $values): ?>
								<tr>
									<td><?= $key ?></td>
									<td><?= $values['recommended'] ?></td>
									<td><?= $values['required'] ?></td>
									<?php 
                    $class = "";
                    $drawable = $values['display'];
										if ($values['result']) {
                      $class = 'success c-white';

                      if (is_array($drawable))
                        $drawable = $drawable[0];
                    } else if (isset($values['is_warning'])) {
                      $class = 'active';
                      $warnings++;

                      if (is_array($drawable))
                        $drawable = $drawable[1];
                    } else {
                      $class = "danger c-white";
                      $errors++;

                      if (is_array($drawable))
                        $drawable = $drawable[1];
                    }
									?><td class="<?= $class ?>"><?= $drawable ?></td>
								</tr>
<?php endforeach; ?>
							</tbody>
						</table>
					</div>
          <?php /** Я без понятия, зачем этот &nbsp; здесь, но, видимо, он какую-то роль играет... */ ?>
          &nbsp;
				</div>
<?php endforeach; ?>
				<div class="lv-body p-15">
					<div class="col-sm-12">
						<?php /* WhiteWolf: This is a hack to make sure the user didn't refresh the page, in the future we should tell them what they did. */
							if(!isset($_POST['username'], $_POST['password'], $_POST['server'], $_POST['database'], $_POST['port'], $_POST['prefix'])) {
						?>
						<form action="index.php?step=2" method="post" name="send" id="send">
							<!-- We don't even include the body here, since the javascript shouldn't let them go forward -->
						</form>
						<form action="index.php?step=2" method="post" name="sendback" id="sendback">
						</form>
						<?php
						}
						else
						{
						?>
						<form action="index.php?step=4" method="post" name="send" id="send">
							<input type="hidden" name="username" value="<?php echo $_POST['username']?>">
							<input type="hidden" name="password" value="<?php echo $_POST['password']?>">
							<input type="hidden" name="server" value="<?php echo $_POST['server']?>">
							<input type="hidden" name="database" value="<?php echo $_POST['database']?>">
							<input type="hidden" name="port" value="<?php echo $_POST['port']?>">
							<input type="hidden" name="prefix" value="<?php echo $_POST['prefix']?>">
							<input type="hidden" name="apikey" value="<?php echo $_POST['apikey']?>">
							<input type="hidden" name="sb-wp-url" value="<?php echo $_POST['sb-wp-url']?>">
						</form>
						<form action="index.php?step=3" method="post" name="sendback" id="sendback">
							<input type="hidden" name="username" value="<?php echo $_POST['username']?>">
							<input type="hidden" name="password" value="<?php echo $_POST['password']?>">
							<input type="hidden" name="server" value="<?php echo $_POST['server']?>">
							<input type="hidden" name="database" value="<?php echo $_POST['database']?>">
							<input type="hidden" name="port" value="<?php echo $_POST['port']?>">
							<input type="hidden" name="prefix" value="<?php echo $_POST['prefix']?>">
							<input type="hidden" name="apikey" value="<?php echo $_POST['apikey']?>">
							<input type="hidden" name="sb-wp-url" value="<?php echo $_POST['sb-wp-url']?>">
						</form>
						<?php
						}
						?>
					</div>
					&nbsp;
					<div class="p-10" align="center">
						<button onclick="next()" class="btn btn-primary waves-effect" id="button" name="button">Next</button>
						<button onclick="$('sendback').submit();" name="button" class="btn btn-info waves-effect" id="button">Recheck</button>
					</div>
					<input type="hidden" name="postd" value="1">
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
setTimeout("<?php if($errors > 0) { echo "ShowBox('Errors', 'There are errors where SourceBans cannot be installed... <br />Fix errors.', 'red', '', true);"; } elseif($warnings > 0) { echo "ShowBox('Warnings', 'There are some warnings. SourceBans will be installed, but some features will not work.', 'red', '', true);"; }?>", 800);
$E('html').onkeydown = function(event){
	var event = new Event(event);
	if (event.key == 'enter' ) next();
};
function next()
{
	var errors = <?php echo $errors?>;
	if(errors > 0)
		ShowBox('Errors', 'There are errors where SourceBans cannot be installed... <br />Read the documentation and fix errors.', 'red', '', true);
	else
		$('send').submit();
}
</script>
