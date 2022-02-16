<?php



namespace App\Http\Controllers;

use Faker\Core\Number;
use Illuminate\Http\Request;


class Store2Controller extends Controller
{
    public $storeProductsData;
    public $productsData;
    public $storesData;
    public $storeName;
    public $toppings;
    public $clientProductsData = [];
    public $dataFilter;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $storeProducts = file_get_contents('../app/data/storeProducts.json', true);
        $products = file_get_contents('../app/data/products.json', true);
        $stores = file_get_contents('../app/data/stores.json', true);
        $topping = file_get_contents('../app/data/toppings.json', true);


        $this->storeProductsData = json_decode($storeProducts, true);
        $this->productsData = json_decode($products, true);
        $this->storesData = json_decode($stores, true);
        $this->toppings = json_decode($topping, true);
    }

    public function index()
    {
        $this->getProducts();

        return view('store2', [
            'listTopping' => $this->toppings,
            'products' => $this->clientProductsData,
            'storeName' => $this->storeName,
        ]);
    }

    public function sortByNameAsc()
    {
        $this->getProducts();
        $nameProductsArray = [];
        $dataAfterSort = [];

        foreach ($this->clientProductsData as $product) {
            array_push($nameProductsArray, $product['name']);
        };

        sort($nameProductsArray);

        foreach ($nameProductsArray as $name) {
            foreach ($this->clientProductsData as $product) {
                if ($name == $product['name']) array_push($dataAfterSort, $product);
            }
        }

        $this->clientProductsData = $dataAfterSort;

        return view('store2', [
            'products' => $this->clientProductsData,
            'storeName' => $this->storeName,
        ]);
    }

    public function sortByNameDsc()
    {
        $this->getProducts();
        $nameProductsArray = [];
        $dataAfterSort = [];

        foreach ($this->clientProductsData as $product) {
            array_push($nameProductsArray, $product['name']);
        };

        rsort($nameProductsArray);

        foreach ($nameProductsArray as $name) {
            foreach ($this->clientProductsData as $product) {
                if ($name == $product['name']) array_push($dataAfterSort, $product);
            }
        }

        $this->clientProductsData = $dataAfterSort;

        return view('store2', [
            'products' => $this->clientProductsData,
            'storeName' => $this->storeName,
        ]);
    }

    public function sortByPriceAsc()
    {
        $this->getProducts();
        $priceProductsArray = [];
        $dataAfterSort = [];

        foreach ($this->clientProductsData as $product) {

            array_push($priceProductsArray, (float) $product['price']);
        };

        sort($priceProductsArray);

        foreach ($priceProductsArray as $price) {
            foreach ($this->clientProductsData as $product) {
                if ($price == (float) $product['price']) {
                    array_push($dataAfterSort, $product);
                    break;
                }
            }
        }

        $this->clientProductsData = $dataAfterSort;

        return view('store2', [
            'products' => $this->clientProductsData,
            'storeName' => $this->storeName,
        ]);
    }

    public function sortByPriceDsc()
    {
        $this->getProducts();
        $priceProductsArray = [];
        $dataAfterSort = [];

        foreach ($this->clientProductsData as $product) {
            array_push($priceProductsArray, (float) $product['price']);
        };

        rsort($priceProductsArray);

        foreach ($priceProductsArray as $price) {
            foreach ($this->clientProductsData as $product) {
                if ($price == $product['price'])  if ($price == (float) $product['price']) {
                    array_push($dataAfterSort, $product);
                    break;
                }
            }
        }

        $this->clientProductsData = $dataAfterSort;

        return view('store2', [
            'products' => $this->clientProductsData,
            'storeName' => $this->storeName,
        ]);
    }

    public function getProducts()
    {
        $idStore = 2;
        $storeProductsArray = [];
        $productsId = [];

        // Fetch shopProducts id
        foreach ($this->storeProductsData['shopProducts'] as $shopProduct) {
            if ($shopProduct['shop'] == $idStore)
                array_push($productsId, $shopProduct['product']);
            array_push($storeProductsArray, $shopProduct);
        }

        // Fetch Store Name
        foreach ($this->storesData['stores'] as $store) {
            if ($store['id'] == $idStore) $this->storeName = $store['name'];
        }

        // Fetch Products
        foreach ($this->productsData['products'] as $productData) {
            foreach ($productsId as $productId) {
                if ($productData['id'] == $productId) {
                    array_push($this->clientProductsData, $productData);
                }
            }
        }
    }

    public function clearSession(Request $request)
    {
        $request->session()->flush();
        return 'clear Session';
    }
    public function checkHasOneOrCreate($request)
    {
        if ($request->session()->has($request->keyName)) {
            $request->session()->get($request->keyName);
        } else {
            $request->session()->put($request->keyName, 1);
        }
    }
    public function removeToppingInSession($request)
    {
        $request->session()->forget($request->keyName);
    }
    public function getFilterProducts(Request $request)
    {
        $this->getProducts();

        if ($request->type == 'checked') {
            $this->checkHasOneOrCreate($request);
        };
        if ($request->type == 'unChecked') {
            $this->removeToppingInSession($request);
        };

        $dataHaveStored = count($request->session()->all()) - 2;


        $result = [];
        $testData = [
            'dataHaveStored' => $dataHaveStored,
            'session' => $request->session()->all()
        ];

        foreach ($this->clientProductsData as $productsData) {
            $dataEvalute = 0;
            if ($dataHaveStored == 0) {
                array_push($result, $productsData);
            } else {
                foreach ($productsData['toppings'] as $toppingProductId) {
                    $topping = $this->findToppingById($toppingProductId);
                    if ($request->session()->get($topping['keyName'])) {
                        $dataEvalute++;
                        if ($dataEvalute >= $dataHaveStored) {
                            array_push($result, $productsData);
                        }
                    }
                }
            };
        }


        return [
            'dataFilter' => $result,
            'listToppings' => $this->toppings,
        ];
    }

    public function findToppingById($id)
    {
        $keyHasValueOne = array_search($id, array_column($this->toppings, 'id'));
        return  $this->toppings[$keyHasValueOne];
    }
}
