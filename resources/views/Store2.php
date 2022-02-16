<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

</head>
<script type="text/javascript" src="ajax/Store2.js">
</script>
<style>
    .store-div-nav {
        height: 1000px;
        background-color: blue;
        text-align: center;
    }

    .store-nav {
        color: white;
    }

    .store-main {}

    .store-main-title {
        height: 200px;

        text-align: center;
    }

    .store-main-font-color {
        color: blue;
    }

    .store-main-filter {
        /* background-color: green; */
    }
</style>


<body >
    <div class="row">
        <div class="col-2 store-div-nav ">
            <h3 class="store-nav mt-5">Milk Tea Store</h3>
            <p> <button class="btn mt-5"><a class="store-nav" href="/store1">Store 1</a></button></p>
            <p>
                <button class="btn "><a class="store-nav" href="/store2">Store 2</a></button>
            </p>
            <p><button class="btn store-nav">Store 3</button>
            </p>
            <p><button class="btn store-nav">Store 4</button></p>
        </div>

        <div class="col-10 store-main ">
            <div class="row store-main-title">
                <h2 class="mt-5 store-main-font-color"><? echo $storeName ?> Menu</h2>
            </div>
            <div class="row store-main-filter">
                <div class="row mb-5">
                    <div class="col-2"></div>
                    <div class="col-2"><input type="checkbox" class="btn-check" id="btn-check-2-outlined" autocomplete="on">
                        <label class="btn btn-outline-primary" for="btn-check-2-outlined">Filter</label></div>
                    <div class="col-4 d-flex flex-row-reverse mt-1">Sort by</div>
                    <div class="col-4">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Name</button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/store1/sort-by-name">Name Asc</a>
                                <a class="dropdown-item" href="/store1/sort-by-name-dsc">Name Dsc</a>
                                <a class="dropdown-item" href="/store1/sort-by-price">Price Asc</a>
                                <a class="dropdown-item" href="/store1/sort-by-price-dsc">Price Dsc</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="filter" class="">
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-2 form-check">
                            <input class="form-check-input" type="checkbox" value="" id="milkFoamCheck">
                            <label class="ml-1 form-check-label">
                                Milk foam
                            </label>
                        </div>
                        <br>
                        <div class="col-6 form-check">
                            <input class="form-check-input" type="checkbox" value="" id="whitePearlCheck">
                            <label class="form-check-label">
                                White pearl
                            </label>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-4"></div>
                        <div class="col-2 form-check">
                            <input class="form-check-input" type="checkbox" value="" id="pearlCheck">
                            <label class="form-check-label">
                                Pearl
                            </label>
                        </div>
                        <div class="col-6 form-check">
                            <input class="form-check-input" type="checkbox" value="" id="aloeCheck">
                            <label class="form-check-label">
                                Aloe
                            </label>
                        </div>
                    </div>
                </div>

                <div id="data-1" class="row">
                    <?php
                    foreach ($products as $key => $shopProductData) {
                        ?>

                        <div class="col-3">
                            <div class="card border-primary mb-3 ml-5" style="height: 250px; max-width: 18rem;">
                                <div class="card-header"><? echo $shopProductData['name'] ?></div>
                                <div class="card-body">
                                    <h5 class="card-title">Topping:</h5>
                                    <p class="card-text" style="height: 100px;">
                                        <? foreach ($shopProductData['toppings'] as $key => $topping) {
                                                if ($key !== 0) {
                                                    $filterKey = array_search($topping, array_column($listTopping, 'id'));
                                                    ?>,<? echo $listTopping[$filterKey]['name'];
                                                                } else {
                                                                    $filterKey = array_search($topping, array_column($listTopping, 'id'));
                                                                    echo $listTopping[$filterKey]['name'];
                                                                }
                                                            }

                                                            ?>
                                    </p>
                                    <div class="row">
                                        <div class="col-6">Cost</div>
                                        <div class="col-6 d-flex flex-row-reverse"><? echo $shopProductData['price'] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php

                    }; ?>
                </div>

                <div class="row" id="data-2">

                </div>




            </div>
        </div>
    </div>


</body>


</html>