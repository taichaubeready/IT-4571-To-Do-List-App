<?php
/** @var yii\web\View $this */
/** @var string $content */
use app\assets\AppAsset;

AppAsset::register($this);
?>


<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo 'Nhat Tai - ToDoList Application' ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <!-- Header -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" x-data="{ header: 'Header' }">
                <h1 class="text-red-600" x-text="header">

                </h1>
            </div>
        </div>
    </div>

    <br>

    <!-- Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1>
                    <?php echo $content ?>
                </h1>
            </div>
        </div>
    </div>

    <br>

    <!-- Footer -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" x-data="{ footer: 'Footer' }">
                <h1 class="text-red-600" x-text="footer">

                </h1>
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
</body>

</html>

<?php $this->endPage() ?>