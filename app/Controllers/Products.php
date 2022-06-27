<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\DesignModel;
use App\Models\LogModel;
use App\Models\MaterialModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Products extends BaseController
{
    protected $productModel = "";
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
        $this->designModel = new DesignModel();
        $this->logModel = new LogModel();
        $this->materialModel = new MaterialModel();

    }
    
    public function index() {
        $productsIn = $this->productModel->getAllProductIn();
        $productsOut = $this->productModel->getAllProductOut();
        $productsExp = $this->productModel->getAllProductExp();
        $models = $this->designModel->getAllModel();
        $colors = $this->materialModel->getAllColors();
        $products = $this->productModel->getAllProduct();
        $data = array(
            'title' => 'Produk & Model',
            'productsIn' => $productsIn,
            'productsOut' => $productsOut,
            'productsExp' => $productsExp,
            'models' => $models,
            'products' => $products,
            'colors' => $colors
        );
        return view('admin/products', $data);    
    }
    
    public function getProductDetail() {
        $productId = $this->request->getVar('product_id');
        $product = $this->productModel->find($productId);
        echo json_encode($product);
    }

    public function getProduct() {
        $productId = $this->request->getVar('product_id');
        $product = $this->productModel->getProduct($productId);
        echo json_encode($product[0]);
    }
    
    public function saveProduct() {
        $product = $this->request->getVar('nama_produk');
        $this->productModel->saveProductType($product);
        
    }

    public function updateProduct() {
        $post = $this->request->getVar();
        $this->productModel->updateProductType($post['id'], $post['nama_produk']);
        return redirect()->back()->with('update', 'Produk berhasil ditambahkan');
    }

    public function deleteProduct() {
        $productId = $this->request->getVar('product_id');
        $this->productModel->deleteProduct($productId);
    }

    public function deleteProductDetail() {
        $productId = $this->request->getVar('product_id');
        $getProduct = $this->productModel
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = products.product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->first();
        $this->logModel->save([
            'description' => 'Menghapus data produk ('.$getProduct['product_name'].' '.$getProduct['model_name'].' '.$getProduct['color'].')',
            'user_id' =>  session()->get('user_id'),
        ]);
        $this->productModel->where('id', $productId)->delete();
    }

    public function getModel() {
        $modelId = $this->request->getVar('model_id');
        $model = $this->designModel->find($modelId);
        echo json_encode($model);
    } 

    public function saveModel() {
        $post = $this->request->getVar();
        $model = [
            'model_name' => $post['nama_model'],
        ];
        $this->designModel->save($model);
        return redirect()->back()->with('create', 'Model berhasil ditambahkan');
    }

    public function updateModel() {
        $post = $this->request->getVar();
        $model = [
            'id' => $post['id'],
            'model_name' => $post['nama_model'],
        ];
        $this->designModel->save($model);
        return redirect()->back()->with('update', 'Model berhasil ditambahkan');
    }

    public function deleteModelDetail() {
        $modelId = $this->request->getVar('model_id');
        $this->designModel->where('id', $modelId)->delete();
        return redirect()->back()->with('delete', 'Model berhasil dihapus');
    }

    public function deleteModel() {
        $modelId = $this->request->getVar('model_id');
        $this->designModel->where('id', $modelId)->delete();
        return redirect()->back()->with('delete', 'Model berhasil dihapus');
    }

    public function exportDataProductIn() {
        $productsIn = $this->productModel->getAllProductIn();
        $data = array(
            'title' => 'Produk & Model',
            'productsIn' => $productsIn
        );
        return view('admin/export/produk_keluar_gesit', $data);  
    }

    public function exportDataProductOut() {
        $productsOut = $this->productModel->getAllProductOut();
        $data = array(
            'title' => 'Produk & Model',
            'productsOut' => $productsOut,
        );
        return view('admin/export/produk_masuk_lovish', $data);  
    }

    // Gesit
    public function gudangGesitProduk() {
        $productsIn = $this->productModel->getAllProductIn();
        $productsOut = $this->productModel->getAllProductOut();
        $productsExp = $this->productModel->getAllProductExp();
        $models = $this->designModel->getAllModel();
        $colors = $this->materialModel->getAllColors();
        $products = $this->productModel->getAllProduct();
       
        $data = array(
            'title' => 'Produk',
            'productsIn' => $productsIn,
            'productsOut' => $productsOut,
            'productsExp' => $productsExp,
            'models' => $models,
            'products' => $products,
            'colors' => $colors,
        );
        return view('gudang_gesit/products', $data);    
    }

    // Lovish
    public function gudangLovishProduk() {
        $productsOut = $this->productModel->getAllProductOut();
        $productsExp = $this->productModel->getAllProductExp();
        $models = $this->designModel->getAllModel();
        $colors = $this->materialModel->getAllColors();
        $products = $this->productModel->getAllProduct();
        $data = array(
            'title' => 'Produk',
            'productsOut' => $productsOut,
            'productsExp' => $productsExp,
            'models' => $models,
            'products' => $products,
            'colors' => $colors,
        );
        return view('gudang_lovish/products', $data);    
    }

    public function addProduct() {
        $post = $this->request->getVar();
        $product = [
            'product_id' => $post['nama_produk'],
            'color_id'  => $post['warna'],
            'weight'  => $post['berat'],
            'model_id'  => $post['model'],
            'user_id' => session()->get('user_id'),
        ];
        $this->productModel->save($product);
        $getProduct = $this->productModel
            ->select('products.id, product_name, model_name, color')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->orderBy('products.id', 'desc')
            ->first();
        $this->productModel->setProductIn($getProduct['id'], session()->get('user_id'));
        $this->logModel->save([
            'description' => 'Menambahkan produk baru ('.$getProduct['product_name'].' '.$getProduct['model_name'].' '.$getProduct['color'].')',
            'user_id' =>  session()->get('user_id'),
        ]);
        return redirect()->back()->with('create', 'Produk berhasil ditambahkan');
    }

    public function addProductLovish() {
        $post = $this->request->getVar();
        $product = [
            'product_id' => $post['nama_produk'],
            'color_id'  => $post['warna'],
            'weight'  => $post['berat'],
            'model_id'  => $post['model'],
            'qty' => $post['qty'],
            'status' => '2',
            'user_id' => session()->get('user_id'),
        ];
        $this->productModel->save($product);
        
        $getProduct = $this->productModel
            ->select('products.id, product_name, model_name, color')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->orderBy('products.id', 'desc')
            ->first();
        $this->productModel->setProductIn($getProduct['id'], session()->get('user_id'));
        $this->logModel->save([
            'description' => 'Menambahkan produk baru ('.$getProduct['product_name'].' '.$getProduct['model_name'].' '.$getProduct['color'].')',
            'user_id' =>  session()->get('user_id'),
        ]);
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

    public function exportDataGesit() {
        $products = $this->productModel->getAllProductIn();
        $date = date("Y-m-d H:i:s");
        $fileName = "Data Produk Gesit {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nama Produk');
		$sheet->setCellValue('C1', 'Model');
		$sheet->setCellValue('D1', 'Warna');
		$sheet->setCellValue('E1', 'Berat (gr)');
		$sheet->setCellValue('F1', 'Tanggal Masuk');
        $i = 2;
        $no = 1;
        foreach($products->getResultObject() as $row) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $row->product_name);
            $sheet->setCellValue('C' . $i, $row->model_name);
            $sheet->setCellValue('D' . $i, $row->color);
            $sheet->setCellValue('E' . $i, number_format($row->weight, 2));
            $sheet->setCellValue('F' . $i, $row->created_at);
            $i++;
        }
        
        $writer = new Xlsx($spreadsheet);

        $writer->save($fileName);
        header("Content-Type: application/vnd.ms-excel");

		header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length:' . filesize($fileName));
		flush();
		readfile($fileName);
		exit;
    }

    public function exportDataLovishIn() {
        $products = $this->productModel->getAllProductOut();
        $date = date("Y-m-d H:i:s");
        $fileName = "Data Produk Masuk Lovish {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nama Produk');
		$sheet->setCellValue('C1', 'Model');
		$sheet->setCellValue('D1', 'Warna');
		$sheet->setCellValue('E1', 'Berat (gr)');
		$sheet->setCellValue('F1', 'Tanggal Masuk');
        $i = 2;
        $no = 1;
        foreach($products->getResultObject() as $row) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $row->product_name);
            $sheet->setCellValue('C' . $i, $row->model_name);
            $sheet->setCellValue('D' . $i, $row->color);
            $sheet->setCellValue('E' . $i, number_format($row->weight, 2));
            $sheet->setCellValue('F' . $i, $row->created_at);
            $i++;
        }
        
        $writer = new Xlsx($spreadsheet);

        $writer->save($fileName);
        header("Content-Type: application/vnd.ms-excel");

		header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length:' . filesize($fileName));
		flush();
		readfile($fileName);
		exit;
    }

}
