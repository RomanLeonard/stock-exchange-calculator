<?php

if (isset($_POST) && !empty($_POST)) {
    $orderValue = isset($_POST['order_value']) && !empty($_POST['order_value']) ? $_POST['order_value'] : 0;
    $buyCommission = isset($_POST['buy_commission']) && !empty($_POST['buy_commission']) ? $_POST['buy_commission'] : 0;
    $sellCommission = isset($_POST['sell_commission']) && !empty($_POST['sell_commission']) ? $_POST['sell_commission'] : 0;
    $initialStockPrice = isset($_POST['initial_stock_price']) && !empty($_POST['initial_stock_price']) ? $_POST['initial_stock_price'] : 0;
    $sellingStockPrice = isset($_POST['selling_stock_price']) && !empty($_POST['selling_stock_price']) ? $_POST['selling_stock_price'] : 0;

    # get number of shares
    $shares = ($orderValue - $buyCommission) / $initialStockPrice;

    # get profit/loss
    $profit = ($sellingStockPrice - $initialStockPrice) * $shares - $buyCommission - $sellCommission;

    # calculate total
    $total = $orderValue + $profit;

    # format number for user interface convenience
    $result = [
        'feeling' => $profit > 0 ? true : false,
        'profit' => number_format((float)$profit, 6, '.', ''),
        'shares' => number_format((float)$shares, 6, '.', ''),
        'total' => number_format((float)$total, 2, '.', ''),
    ];
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="./assets/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/favicon-16x16.png">
    <link rel="manifest" href="./assets/site.webmanifest">
    <link rel="mask-icon" href="./assets/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <title>Stock Exchange Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <style>
        .bg-success-moderate{
            background-color: rgba(25, 135, 84, 0.3);
        }
        .bg-warning-moderate{
            background-color: rgba(255, 193, 7, 0.3);
        }
        .result-font{
            font-weight: bold; 
            -webkit-font-smoothing: antialiased; 
            -moz-osx-font-smoothing: grayscale;
        }
    </style>

</head>

<body>

    <div class="container mt-5">
        <div class="row">
            
            <?php if (isset($result) && !empty($result)): ?>
            <div class="col-12 col-xl-6 mx-auto mb-4">
                <div class="alert p-4 <?= $result['feeling'] ? 'alert-success' : 'alert-warning' ?> ">
                    <h5 class="card-title">P/L Result:</h5>
                    <div class="wrapper mt-4">
                        <div class="row">
                            <div class="col-6">You invested: <b><?= $orderValue ?></b></div>
                            <div class="col-6">Your shares: <b><?= $result['shares'] ?></b></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <?= $result['feeling'] ? 'Profit: ' : 'Loss: ' ?>
                                <?= $result['profit'] ?>
                            </div>
                            <div class="col-12 mt-3 p-2">
                                <div class="p-2 alert result-font <?= $result['feeling'] ? 'bg-success-moderate' : 'bg-warning-moderate' ?>">
                                    TOTAL: <?= $result['total'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="col-12"></div>

            <div class="col-12 col-xl-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Stock Exchange Calculator</h5>
                        <p class="card-text pt-2">This calculator works in a single currency. If you bought a stock in USD ($) and want to get your P/L also in USD, please fill all inputs in one currency (ex.: USD).</p>
                        <p class="card-text"><span style="color: red;">*</span>Suited for Revolut investments.</p>
                        <div class="wrapper mt-5">
                            <form action="" method="post" class="row g-3">
                                <div class="row">
                                    <div class="col-12 col-xl-6">
                                        <!-- order value -->
                                        <div class="mb-3">
                                            <label class="form-lable" id="order-value">Initial order value</label>
                                            <input name="order_value" required type="text" class="form-control" placeholder="100" aria-describedby="order-value" <?= $orderValue ? "value='$orderValue'" : '' ?> >
                                        </div>
                                        <!-- ./order value -->
                                        <!-- buy commission -->
                                        <div class="mb-3">
                                            <label class="form-lable" id="buy-commission">Buy commission</label>
                                            <input name="buy_commission" type="text" class="form-control" placeholder="1.09" aria-describedby="buy-commission" <?= isset($buyCommission) ? "value='$buyCommission'" : '' ?> >
                                        </div>
                                        <!-- ./buy commission -->
                                        <!-- sell commission -->
                                        <div class="mb-3">
                                            <label class="form-lable" id="sell-commission">Sell commission</label>
                                            <input name="sell_commission" type="text" class="form-control" placeholder="1.09" aria-describedby="sell-commission" <?= isset($sellCommission) ? "value='$sellCommission'" : '' ?> >
                                        </div>
                                        <!-- ./sell commission -->
                                    </div>
                                    <div class="col-12 col-xl-6">
                                        <!-- initial stock price -->
                                        <div class="mb-3">
                                            <label class="form-lable" id="initial-stock-price">Initial stock price</label>
                                            <input name="initial_stock_price" required type="text" class="form-control" placeholder="100" aria-describedby="initial-stock-price" <?= $initialStockPrice ? "value='$initialStockPrice'" : '' ?> >
                                        </div>
                                        <!-- ./initial stock price -->
                                        <!-- selling stock price -->
                                        <div class="mb-3">
                                            <label class="form-lable" id="selling-stock-price">Selling stock price</label>
                                            <input name="selling_stock_price" required type="text" class="form-control" placeholder="200" aria-describedby="selling-stock-price" <?= $sellingStockPrice ? "value='$sellingStockPrice'" : '' ?> >
                                        </div>
                                        <!-- ./selling stock price -->
                                    </div>
                                    <div class="col-12 mt-2">
                                        <button class="btn btn-success" type="submit">Calculate P/L</button>
                                    </div>
                                    <div class="col-12 mt-5">
                                        <p style="font-size: 0.9rem; margin-bottom: 0"><span style="color: crimson">P/L</span> (definition for this use case): Profit/Loss (Profit and Loss)</p>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12"></div>

            <div class="col-12 col-xl-6 mt-5 mx-auto">
                <div class="alert alert-primary">
                    <p>This application was developed by <a target="_blank" href="https://leonardroman.netlify.app/">Leonard Roman</a> and it is a personal tool to estimate winnings or losses for stock exchange investments.</p>
                    <p>This application IS NOT a professional tool, and this estimate or the algorithm used to calculate it may not be correct.</p>
                    <p>You can freely use it as you wish.</p>
                    <p><a href="https://github.com/RomanLeonard/stock-exchange-calculator" target="_blank">GitHub Link</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>
