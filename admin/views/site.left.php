<? /*
  Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"
  Tip 2: you can also add an image using data-image tag
  Example: <div class="sidebar" data-color="rose" data-background-color="black" data-image="../assets/img/sidebar-1.jpg">
*/ ?>
<div class="sidebar" data-color="green" data-background-color="white">
    <div class="logo">
        <!--<a href="<?/*= $websiteURL */?>" class="simple-text logo-mini">P</a>-->
        <!--<a href="<?/*= $websiteURL */?>" class="simple-text logo-normal">Platform</a>-->
        <a href="<?= $websiteURL ?>" class="text-center logo-normal">
            <img src="/public/<?= ASSETS_PATH ?>/images/<?= settingsGet('admin-logo') ?>?v=<?= settingsGet('version-admin-logo') ?>" height="52" class="p-1" />
        </a>
    </div>
    <div class="sidebar-wrapper">
        <? if($languages && 0) : ?>
            <div class="user">
                <div class="languages">
                    <? foreach($languages AS $lang => $langName) : ?>
                        <a  rel="tooltip"
                            title="<?= $langName ?>"
                            href="<?= getLangUrl() . '&lang=' . $lang ?>"
                            class="<?= getLang() == $lang ? 'on' : '' ?>">
                            <img src="/public/admin/images/<?= $lang ?>.png" alt="<?= $langName ?>" />
                        </a>
                    <? endforeach; ?>
                </div>
            </div>
        <? endif; ?>
        <ul class="nav" id="sidebarNav">
            <li class="nav-item <?= getPage() != 'home' ? '' : 'active' ?>">
                <a class="nav-link" href="<?= $websiteURL ?>">
                    <i class="material-icons">dashboard</i>
                    <p> Home </p>
                </a>
            </li>
            <? foreach($adminMenuRes AS $i => $row) : ?>
                <? if(!$row['hidden']) : ?>
                    <?
                        // Check if nav is open or active
                        $p = getPage();
                        if (substr(getPage(), -5) == '.edit') {
                            $p = substr(getPage(), 0, -5);
                        }

                        $isExpanded = in_array($row['id'], $activeMenu);
                        $isActive = array_key_exists($p, ($row['pages'] ?: array()));
                    ?>
                    <li class="nav-item active">
                        <a  class="nav-link"
                            data-toggle="collapse"
                            data-id="<?= $row['id'] ?>"
                            href="#<?= $row['id'] ?>"
                            <?= $isExpanded || $isActive ? 'aria-expanded="true"' : '' ?>>
                            <i class="material-icons"><?= $row['icon'] ?></i>
                            <p> <?= $row['cat'] ?>
                                <b class="caret"></b>
                            </p>
                        </a>
                        <? if ($row['pages']) : ?>
                        <div class="collapse <?= $isExpanded || $isActive ? 'show' : '' ?>" id="<?= $row['id'] ?>">
                            <ul class="nav">
                                <? foreach($row['pages'] AS $p => $name) : $p = htmlspecialchars_decode($p); ?>
                                    <li class="nav-item <?= (getPage() == $p || getPage() == $p . '.edit' || $_SERVER['QUERY_STRING'] == 'page=' . $p) ? 'active' : '' ?>">
                                        <a class="nav-link" href="index.php?page=<?= $p ?>">
                                            <span class="sidebar-mini"> <?= substr($name, 0, 1) ?> </span>
                                            <span class="sidebar-normal"> <?= $name ?> </span>
                                        </a>
                                    </li>
                                <? endforeach; ?>
                            </ul>
                        </div>
                        <? endif; ?>
                    </li>
                <? endif ?>
            <? endforeach ?>
            <li class="nav-item"><br /><br /></li>
        </ul>
    </div>
</div>