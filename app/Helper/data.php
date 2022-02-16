if (!function_exists('getDataJson')) {
function getDataJson()
{
$storeProducts = file_get_contents('../app/data/storeProducts.json', true);
$products = file_get_contents('../app/data/products.json', true);
$stores = file_get_contents('../app/data/stores.json', true);
$storeProductsData = json_decode($storeProducts, true);
$productsData = json_decode($products, true);;
$storesData = json_decode($stores, true);;

return [
    'storeProductsData' => $storeProductsData
    'productsData' => $productsData,
    'storesData' => $storesData,
    ]};
}
}