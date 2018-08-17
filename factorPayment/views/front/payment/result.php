<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>نتیجه پرداخت</title>
    <link rel="stylesheet" href="<?php echo WPF_ASSETS . 'css/normalize.css' ?>">
    <link rel="stylesheet" href="<?php echo WPF_ASSETS . 'css/milligram-rtl.css' ?>">
    <link rel="stylesheet" href="<?php echo WPF_ASSETS . 'css/custom.css' ?>">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="column column-50 column-offset-25">
            <div class="wrapper">
                <?php if ($verify_result): ?>
                    <p>پرداخت شما با موفقیت انجام شد.</p>
                    <p>کد پیگیری : <?php echo $trace_number; ?></p>
                    <p>مبلغ پرداخت شده :<?php echo wpf_format_amount($payment_item->payment_amount) ?></p>
                <?php else: ?>
                    <p>پرداخت شما ناموفق بود.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
