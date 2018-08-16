<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>جزئیات فاکتور</title>
    <link rel="stylesheet" href="<?php echo WPF_ASSETS . 'css/normalize.css' ?>">
    <link rel="stylesheet" href="<?php echo WPF_ASSETS . 'css/milligram-rtl.css' ?>">
    <link rel="stylesheet" href="<?php echo WPF_ASSETS . 'css/custom.css' ?>">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="column column-offset-50">
            <div class="wrapper">
                <div class="row_item">
                    <span>مبلغ:</span>
                    <span><?php echo $factor_item->factor_amount ?></span>
                </div>

                <div class="row_item">
                    <span>توضیحات سفارش:</span>
                    <span><?php echo $factor_item->factor_description ?></span>
                </div>

                <div class="row_item">
                    <button type="submit" name="doPayment">پرداخت</button>
                </div>


            </div>
        </div>
    </div>
</div>

</body>
</html>