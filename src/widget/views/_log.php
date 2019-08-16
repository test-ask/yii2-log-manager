<?php

$bg = [
    1 => 'danger',
    2 => 'warning',
    4 => 'info',
];
?>

<!-- Navbar Right Menu -->
<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
        <!-- Messages: style can be found in dropdown.less-->
        <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>
            </a>
            <ul class="dropdown-menu">
                <?php foreach ($logs as $log) : ?>
                    <li>
                        <!-- inner menu: contains the actual data -->
                        <ul class="menu">
                            <li><!-- start message -->
                                <a href="#" class="bg-<?= $bg[$log['level']] ?>">
                                    <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <?= $log['message'] ?>
                                    </div>

                                    <div class="pull-right">
                                        <small>
                                            <i class="fa fa-clock-o"></i> <?= $log['updated_at'] ?>
                                        </small>
                                    </div>
                                    <div class="pull-left">
                                        <p>Count: <?= $log['count']; ?></p>
                                    </div>

                                </a>
                            </li><!-- end message -->
                        </ul>
                    </li>
                <?php endforeach; ?>

                <li class="footer"><a href="<?= \yii\helpers\Url::to(['/log-manager']); ?>">See All Events</a></li>
            </ul>
        </li>

    </ul>
</div>
