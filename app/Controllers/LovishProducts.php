<?php

namespace App\Controllers;

use App\Models\LovishProductModel;
use App\Models\DesignModel;
use App\Models\LogModel;
use App\Models\MaterialModel;
use App\Models\ProductModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LovishProducts extends BaseController
{ 
    protected $productModel = "";
    protected $productLovishModel = "";
    protected $designModel = "";
    protected $logModel = "";
    protected $materialModel = "";

    public function __construct() { 
        $userId = session()->get('user_id');
        if (is_null($userId)) {            
            header('Location: '.base_url('/'));
            exit(); 
        }
        $this->productModel = new ProductModel();
        $this->productLovishModel = new LovishProductModel();
        $this->designModel = new DesignModel();
        $this->logModel = new LogModel();
        $this->materialModel = new MaterialModel();
    }

    public function gudangLovishProduk() {
        $productsIn = $this->productLovishModel->getAllProductLovish();        
        $productsOut = $this->productLovishModel->getAllProductOut();        
        $productsExp = $this->productModel->getAllProductExp();        
        $models = $this->designModel->getAllModel();
        $colors = $this->materialModel->getAllColors();
        $products = $this->productModel->getAllProduct();
        $vendors = $this->productModel->getAllVendorPenjualan();
        $data = array(
            'title' => 'Produk',
            'productsIn' => $productsIn,
            'productsOut' => $productsOut,
            'productsExp' => $productsExp,
            'models' => $models,
            'products' => $products,
            'colors' => $colors,
            'vendors' => $vendors
        );
        return view('gudang_lovish/products', $data);    
    }

    public function gudangLovishStokProduk() {
        $models = $this->designModel->getAllModel();
        $colors = $this->materialModel->getAllColors();
        $products = $this->productModel->getAllProduct();
        $vendors = $this->productModel->getAllVendorPenjualan();
        $products = $this->productLovishModel->getAllStockProductLovish();
        
        $data = array(
            'title' => 'Produk',
            'models' => $models,
            'products' => $products,
            'colors' => $colors,
            'vendors' => $vendors
        );
        return view('gudang_lovish/products_stock', $data);    
    }

    public function addProductLovish() {
        $post = $this->request->getVar();
        $product = [
            'product_id' => $post['nama_produk'],
            'color_id'  => $post['warna'],
            'weight'  => $post['berat'],
            'model_id'  => $post['model'],
            'user_id' => session()->get('user_id'),
            'qty' => $post['qty'],
            'vendor_id' => $post['vendor'],
            'price' => $post['harga'],
            'status' => '2'
        ];
        $this->productLovishModel->save($product);
        $getProduct = $this->productLovishModel
            ->select('lovish_products.id, product_name, model_name, color')
            ->join('models', 'models.id = lovish_products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = lovish_products.color_id')
            ->orderBy('lovish_products.id', 'desc')
            ->first();
        
        $this->logModel->save([
            'description' => 'Menambahkan produk baru ('.$getProduct['product_name'].' '.$getProduct['model_name'].' '.$getProduct['color'].') sebanyak '.$post['qty'].'. ',
            'user_id' =>  session()->get('user_id'),
        ]);
        return redirect()->back()->with('create', 'Produk berhasil ditambahkan');
    }

    public function importProduct() {
        $file = $this->request->getFile('file');        
        $ext = $file->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file);
        $data = $spreadsheet->getActiveSheet()->toArray();        
        foreach ($data as $idx => $row) {
            if ($idx > 0) {
                $temp = explode(' ', $row[1]);  
                $modelID = "";
                $productTypeID = "";
                $colorID = "";

                $getProductType = $this->productModel->getProductType($temp[0]);
                if (is_null($getProductType)) {
                    $productTypeID = $this->productModel->saveProductType($temp[0]);                    
                }  else {
                    $productTypeID = $getProductType->id;
                }                       

                $getModel = $this->designModel->where(['model_name' => $temp[1]])->first();                                
                if (is_null($getModel)) {
                    $model = [
                        'model_name' => $temp[1],
                        'hpp' => $row[2]
                    ];
                    $this->designModel->save($model); 
                    $modelID = $this->designModel->getInsertID();
                } else {
                    $modelID = $getModel['id'];
                    $this->designModel->save([
                        'id' => $modelID,
                        'hpp' => $row[2]
                    ]);                     
                }
                
                if (count($temp) == 3) {
                    $color = $temp[2];
                } else if (count($temp) == 4) {
                    $color = $temp[2]. ' '. $temp[3];
                } else {
                    $color = $temp[2]. ' '. $temp[3]. ' '. $temp[4];
                }

                $getColor = $this->materialModel->getColorByName($color);
                if (is_null($getColor)) {
                    $colorID = $this->materialModel->saveWarna($color);
                } else {
                    $colorID = $getColor->id;
                }
                $this->productLovishModel->save([
                    'product_id' => $productTypeID,
                    'model_id' => $modelID,
                    'color_id' => $colorID,
                    'user_id' => session()->get('user_id'),
                    'qty' => $row[3]
                ]);                                
            }
        }
        return redirect()->back()->with('create', 'Produk berhasil ditambahkan');
    }

    public function updateProductDetail() {
        $post = $this->request->getVar();
        $product = [
            'id' => $post['id'],
            'product_id' => $post['nama_produk'],
            'color_id'  => $post['warna'],
            'weight'  => $post['berat'],
            'model_id'  => $post['model'],
            'user_id' => session()->get('user_id'),
        ];
        $this->productModel->save($product);
        $getProduct = $this->productModel
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->where('products.id',  $post['id'])
            ->first();
        $this->logModel->save([
            'description' => 'Mengubah produk baru ('.$getProduct['product_name'].' '.$getProduct['model_name'].' '.$getProduct['color'].')',
            'user_id' =>  session()->get('user_id'),
        ]);
        return redirect()->back()->with('create', 'Produk berhasil ditambahkan');
    }

    public function deleteProductDetail() {
        $productId = $this->request->getVar('product_id');
        $getProduct = $this->productLovishModel
            ->join('models', 'models.id = lovish_products.model_id')
            ->join('product_types', 'product_types.id = lovish_products.product_id')
            ->join('colors', 'colors.id = lovish_products.color_id')
            ->first();
        $this->logModel->save([
            'description' => 'Menghapus data produk ('.$getProduct['product_name'].' '.$getProduct['model_name'].' '.$getProduct['color'].')',
            'user_id' =>  session()->get('user_id'),
        ]);
        $this->productLovishModel->where('id', $productId)->delete();
    }

    public function onChangeProductType() {
        $id = $this->request->getVar('product');
        $type = $this->request->getVar('type');
        $this->productLovishModel->save([
            'id' => $id,
            'product_id' => $type
        ]);
    }

    public function onChangeModelName() {
        $id = $this->request->getVar('product');
        $model = $this->request->getVar('model');
        $this->productLovishModel->save([
            'id' => $id,
            'model_id' => $model
        ]);
    }

    public function onChangeProductQty() {
        $id = $this->request->getVar('product');
        $qty = $this->request->getVar('qty');
        $this->productLovishModel->save([
            'id' => $id,
            'qty' => $qty
        ]);
    }

    public function onChangeProductWeight() {
        $id = $this->request->getVar('product');
        $weight = $this->request->getVar('weight');
        $this->productLovishModel->save([
            'id' => $id,
            'weight' => $weight
        ]);
    }

    public function onChangeProductColor() {
        $id = $this->request->getVar('product');
        $color = $this->request->getVar('color');
        $this->productLovishModel->save([
            'id' => $id,
            'color_id' => $color
        ]);
    }

    public function onChangeProductHPP() {
        $id = $this->request->getVar('product');
        $hpp = $this->request->getVar('hpp');
        $this->productLovishModel->save([
            'id' => $id,
            'price' => $hpp
        ]);
    }

    public function getHPP() {
        $id = $this->request->getVar('id');
        $hpp = $this->designModel->find($id);
        echo json_encode($hpp);
    }

}