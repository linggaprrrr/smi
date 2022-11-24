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
        $models = $this->designModel->getAllModel();
        $colors = $this->materialModel->getAllColors();
        $products = $this->productModel->getAllProduct();
        $vendors = $this->productModel->getAllVendorPenjualan();
        $penjualan = $this->productModel->penjualan();
        $getStok = $this->productModel->getAllStockProductLovish();
        $stok = array();
        $out = $this->productModel
            ->select('products.*')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->where('product_barcodes.status', '3')
            ->get();
        $selling = 0;        
        if ($getStok->getNumRows() > 0) {
            foreach ($getStok->getResultObject() as $product) {                
                if ($penjualan->getNumRows() > 0 || $out->getNumRows() > 0) {
                    foreach ($penjualan->getResultObject() as $sell) {                
                        if (($sell->model_id == $product->model_id) && ($sell->color_id == $product->color_id) && ($sell->size == $product->size)) {
                            $selling = $selling + $sell->qty;                         
                        }
                    }        
                    foreach($out->getResultObject() as $keluar) {
                        if (($keluar->model_id == $product->model_id) && ($keluar->color_id == $product->color_id) && ($keluar->size == $product->size)) {
                            $selling = $selling + 1;                         
                        }
                    }
                    $sisa = ($product->stok + $product->stok_masuk  + $product->stok_retur - ($selling)) ;                                                            
                    array_push($stok, [
                        'id' => $product->id,
                        'model_id' => $product->model_id,
                        'product_name' => $product->product_name,
                        'model_name' => $product->model_name,
                        'color' => $product->color,
                        'size' => $product->size,
                        'stok' => $product->stok,
                        'stok_masuk' => $product->stok_masuk,
                        'penjualan' => $selling,
                        'stok_retur' => $product->stok_retur,
                        'sisa' => $sisa,
                        'hpp' => $product->hpp,
                        'hpp_jual' => $product->hpp_jual,
                    ]);
                    $selling = 0;
                } else {
                    $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($selling)) ;                                                            
                    array_push($stok, [
                        'id' => $product->id,
                        'model_id' => $product->model_id,
                        'product_name' => $product->product_name,
                        'model_name' => $product->model_name,
                        'color' => $product->color,
                        'size' => $product->size,
                        'stok' => $product->stok,
                        'stok_masuk' => $product->stok_masuk,
                        'penjualan' => $selling,
                        'stok_retur' => $product->stok_retur,
                        'sisa' => $sisa,
                        'hpp' => $product->hpp,
                        'hpp_jual' => $product->hpp_jual,
                    ]);
                }
            }
        }
        
        $data = array(
            'title' => 'Produk',
            'models' => $models,
            'products' => $stok,
            'colors' => $colors,
            'vendors' => $vendors
        );
        return view('admin/products', $data);    
    }
    
    public function createProduct() {
        $id = $this->request->getVar('pola');
        $data = $this->productModel->findPola($id);
        $product = [
            'model_id'  => $data->id,            
            'color_id' => $data->color,
            'user_id' => session()->get('user_id'),
            'hpp_jual' => $data->hpp,
            
            'qty' => $data->jumlah_setor,                
        ];
        $this->productModel->save($product);
        $productId = $this->productModel->insertID();        
        for ($i=0; $i < $data->jumlah_setor; $i++) {
            $temp = $this->productModel->createBarcode($productId);
            $this->productModel->createLog($temp, '0', '2');
        }

        $getProduct = $this->productModel
            ->select('jenis, model_name, color')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->orderBy('products.id', 'desc')
            ->first();
        
        $this->logModel->save([
            'description' => 'Menambahkan produk baru ('.$getProduct['jenis'].' '.$getProduct['model_name'].' '.$getProduct['color'].') sebanyak '.$data->jumlah_setor.'. ',
            'user_id' =>  session()->get('user_id'),
        ]);
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
            ->join('colors', 'colors.id = products.color_id')
            ->first();
        $this->productModel->deleteProductBarcode($productId);
        $this->productModel->where('id', $productId)->delete();
        $this->logModel->save([
            'description' => 'Menghapus data produk ('.$getProduct['jenis'].' '.$getProduct['model_name'].' '.$getProduct['color'].')',
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
            'harga_jahit' => $post['jahit'],
            'hpp' => $post['hpp']
        ];
        $this->designModel->save($model);
        return redirect()->back()->with('create', 'Model berhasil ditambahkan');
    }

    public function updateModel() {
        $post = $this->request->getVar();
        $model = [
            'id' => $post['id'],
            'model_name' => $post['nama_model'],
            'harga_jahit' => $post['jahit'],
            'hpp' => $post['hpp'],
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
        $productsIn = $this->productModel->getAllProductGesit();
        
        $productsOut = $this->productModel->getAllProductOut();
        $models = $this->designModel->getAllModel();
        $colors = $this->materialModel->getAllColors();
        $products = $this->productModel->getAllProduct();
        $vendors = $this->productModel->getAllVendorPenjualan();
        $reject = $this->productModel->rejectedProduct();
        $data = array(
            'title' => 'Produk',
            'productsIn' => $productsIn,
            'productsOut' => $productsOut,
            'models' => $models,
            'products' => $products,
            'colors' => $colors,
            'vendors' => $vendors,
            'rejectedProducts' => $reject
        );
        return view('gudang_gesit/products', $data);    
    }

    public function onChangeProductType() {
        $id = $this->request->getVar('product');
        $type = $this->request->getVar('type');
        $this->productModel->save([
            'id' => $id,
            'product_id' => $type
        ]);
    }

    public function onChangeModelName() {
        $id = $this->request->getVar('product');
        $model = $this->request->getVar('model');
        $this->productModel->save([
            'id' => $id,
            'model_id' => $model
        ]);
    }

    public function onChangeProductQty() {
        $id = $this->request->getVar('product');
        $qty = $this->request->getVar('qty');
        $this->productModel->save([
            'id' => $id,
            'qty' => $qty
        ]);
    }

    public function onChangeProductWeight() {
        $id = $this->request->getVar('product');
        $weight = $this->request->getVar('weight');
        $this->productModel->save([
            'id' => $id,
            'weight' => $weight
        ]);
    }

    public function onChangeProductColor() {
        $id = $this->request->getVar('product');
        $color = $this->request->getVar('color');
        $this->productModel->save([
            'id' => $id,
            'color_id' => $color
        ]);
    }

    public function onChangeProductHPP() {
        $id = $this->request->getVar('product');
        $hpp = $this->request->getVar('hpp');
        $this->productModel->save([
            'id' => $id,
            'price' => $hpp,
            'hpp_jual' => $hpp
        ]);
    }

    public function addProduct() {
        $post = $this->request->getVar();
        $product = [
            'product_id' => $post['nama_produk'],
            'color_id'  => $post['warna'],
            'weight'  => $post['berat'],
            'model_id'  => $post['model'],
            'user_id' => session()->get('user_id'),
            'qty' => $post['qty'],
            'vendor_id' => $post['vendor'],
            'price' => $post['harga']
        ];
        $this->productModel->save($product);
        $productId = $this->productModel->insertID();        
        for ($i=0; $i < $post['qty']; $i++) {
            $temp = $this->productModel->createBarcode($productId);
            $this->productModel->createLog($temp, '0', '2');
        }

        $getProduct = $this->productModel
            ->select('products.id, product_name, model_name, color')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->orderBy('products.id', 'desc')
            ->first();
        
        $this->logModel->save([
            'description' => 'Menambahkan produk baru ('.$getProduct['product_name'].' '.$getProduct['model_name'].' '.$getProduct['color'].') sebanyak '.$post['qty'].'. ',
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
            'user_id' => session()->get('user_id'),
            'qty' => $post['qty'],
            'vendor_id' => $post['vendor'],
            'price' => $post['harga']
        ];
        $this->productModel->save($product);
        $productId = $this->productModel->insertID();
        
        for ($i=0; $i < $post['qty']; $i++) {
            $this->productModel->createBarcode($productId);
        }

        $this->productModel->createLog($productId, $post['qty']);

        $getProduct = $this->productModel
            ->select('products.id, product_name, model_name, color')
            ->join('models', 'models.id = products.model_id')
            ->join('product_types', 'product_types.id = product_id')
            ->join('colors', 'colors.id = products.color_id')
            ->orderBy('products.id', 'desc')
            ->first();
        
        $this->logModel->save([
            'description' => 'Menambahkan produk baru ('.$getProduct['product_name'].' '.$getProduct['model_name'].' '.$getProduct['color'].') sebanyak '.$post['qty'].'. ',
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

    public function exportDataGesit($date1= null, $date2 = null) {
        if (is_null($date1)) {
            $products = $this->productModel->getAllProductInHistory();     
        } else {
            $products = $this->productModel->getAllProductInHistory($date1, $date2);
        }
        
        $date = time();
        $fileName = "Data Produk Gesit {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nama Produk');
		$sheet->setCellValue('C1', 'Model');
		$sheet->setCellValue('D1', 'Warna');
        $sheet->setCellValue('E1', 'Qty');
		$sheet->setCellValue('F1', 'Tanggal Masuk');
        $i = 2;
        $no = 1;
        foreach($products->getResultObject() as $row) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $row->product_name);
            $sheet->setCellValue('C' . $i, $row->model_name);
            $sheet->setCellValue('D' . $i, $row->color);
            $sheet->setCellValue('E' . $i, $row->qty);
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

    public function exportDataPenjualanReject($date1= null, $date2 = null) {
        if (is_null($date1)) {
            $products = $this->productModel->rejectedSold();     
        } else {
            $products = $this->productModel->rejectedSold($date1, $date2);
        }
        
        $date = time();
        $fileName = "Data Penjualan Reject {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Tanggal Reject');
		$sheet->setCellValue('C1', 'Tanggal Jual');
		$sheet->setCellValue('D1', 'Produk');
		$sheet->setCellValue('E1', 'Jenis Reject');
		$sheet->setCellValue('F1', 'Harga jual');
        $i = 2;
        $no = 1;
        foreach($products->getResultObject() as $row) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $row->date);
            $sheet->setCellValue('C' . $i, $row->tanggal_jual);
            $sheet->setCellValue('D' . $i, trim($row->product_name.' '.$row->model_name.' '.$row->color.' '.$row->size));
            $sheet->setCellValue('E' . $i, strtoupper($row->category));
            $sheet->setCellValue('F' . $i, 'Rp '.number_format($row->hpp, 0));
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
        
    public function exportDataLovishIn($date1 = null, $date2 = null) {
        if (is_null($date1)) {
            $products = $this->productModel->getAllProductOut();
        } else {
            $products = $this->productModel->getAllProductOut($date1, $date2);
        }
        
        $date = time();
        $fileName = "Data Produk Masuk Gudang {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Nama Produk');
		$sheet->setCellValue('C1', 'Model');
		$sheet->setCellValue('D1', 'Warna');
		$sheet->setCellValue('E1', 'Harga');
		$sheet->setCellValue('F1', 'Tanggal Masuk');
        $i = 2;
        $no = 1;
        foreach($products->getResultObject() as $row) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $row->product_name);
            $sheet->setCellValue('C' . $i, $row->model_name);
            $sheet->setCellValue('D' . $i, $row->color);
            $sheet->setCellValue('E' . $i, number_format($row->price, 0));
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

    public function exportDataStokProduct() {
        $products = $this->productModel->getAllStockProductLovish();
        $stok = array();
        $penjualan = $this->productModel->penjualan();
        $out = $this->productModel
            ->select('products.*')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->where('product_barcodes.status', '3')
            ->get();
        $sisaStok = $this->productModel
            ->select('models.hpp, products.id, products.hpp_jual, products.model_id, models.jenis as product_name, model_name, color, size, product_barcodes.updated_at, stok_masuk, penjualan, stok_retur, pengiriman, (IFNULL(stok_masuk, 0) + IFNULL(stok, 0) + IFNULL(stok_retur, 0) - (IFNULL(penjualan, 0) + IFNULL(pengiriman, 0)) ) as sisa, stok')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('(SELECT id, SUM(qty) as stok FROM products WHERE status= 2 GROUP BY model_id, color_id, size) as a','products.id = a.id', 'left') 
            ->join('(SELECT product_barcodes.product_id, COUNT(product_barcodes.id) as stok_masuk FROM product_barcodes JOIN products ON products.id = product_barcodes.product_id WHERE product_barcodes.status != "0" AND product_barcodes.status != "1" GROUP BY model_id, color_id, size) as m', 'm.product_id = products.id', 'left')
            ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as penjualan FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id WHERE product_logs.status = 3 GROUP BY model_id, color_id, size) as k', 'k.product_id = products.id', 'left')
            ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as stok_retur FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id  WHERE product_logs.status = 4 GROUP BY model_id, color_id, size) as r', 'r.product_id = products.id', 'left')
            ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as pengiriman FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id  WHERE product_logs.status = 5 GROUP BY model_id, color_id, size) as s', 's.product_id = products.id', 'left')
            ->where('product_barcodes.status <>', '2')
            ->groupBy('models.id, colors.id, products.size')
            ->get();
        $selling = 0;        
        if ($products->getNumRows() > 0) {
            foreach ($products->getResultObject() as $product) {                
                if ($penjualan->getNumRows() > 0 || $out->getNumRows() > 0) {
                    foreach ($penjualan->getResultObject() as $sell) {                
                        if (($sell->model_id == $product->model_id) && ($sell->color_id == $product->color_id) && ($sell->size == $product->size)) {
                            $selling = $selling + $sell->qty;                         
                        }
                    }        
                    foreach($out->getResultObject() as $keluar) {
                        if (($keluar->model_id == $product->model_id) && ($keluar->color_id == $product->color_id) && ($keluar->size == $product->size)) {
                            $selling = $selling + 1;                         
                        }
                    }
                    $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($selling)) ;                                                            
                    array_push($stok, [
                        'id' => $product->id,
                        'model_id' => $product->model_id,
                        'product_name' => $product->product_name,
                        'model_name' => $product->model_name,
                        'color' => $product->color,
                        'size' => $product->size,
                        'stok' => $product->stok,
                        'stok_masuk' => $product->stok_masuk,
                        'penjualan' => $selling,
                        'stok_retur' => $product->stok_retur,
                        'sisa' => $sisa,
                        'hpp' => $product->hpp,
                        'hpp_jual' => $product->hpp_jual,
                    ]);
                    $selling = 0;
                } else {
                    $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($selling)) ;                                                            
                    array_push($stok, [
                        'id' => $product->id,
                        'model_id' => $product->model_id,
                        'product_name' => $product->product_name,
                        'model_name' => $product->model_name,
                        'color' => $product->color,
                        'size' => $product->size,
                        'stok' => $product->stok,
                        'stok_masuk' => $product->stok_masuk,
                        'penjualan' => $selling,
                        'stok_retur' => $product->stok_retur,
                        'sisa' => $sisa,
                        'hpp' => $product->hpp,
                        'hpp_jual' => $product->hpp_jual,
                    ]);
                }
            }
        }
        $date = time();
        $fileName = "Data Stok Produk {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Produk');
		$sheet->setCellValue('C1', 'Stok Awal');
		$sheet->setCellValue('D1', 'Stok Masuk');
        $sheet->setCellValue('E1', 'Stok Retur');
        $sheet->setCellValue('F1', 'Penjualan Langsung');
        $sheet->setCellValue('G1', 'Pengiriman');
        $sheet->setCellValue('H1', 'Sisa Stok');
        $sheet->setCellValue('I1', 'HPP Gesit');
        $sheet->setCellValue('J1', 'HPP Jual');
        $sheet->setCellValue('K1', 'Nilai Barang');
        $sheet->setCellValue('L1', 'Nilai Jual');
        $sheet->setCellValue('M1', 'Margin Tetap');
        $i = 2;
        $no = 1;
        
        foreach($sisaStok->getResultArray() as $row) {
            $prod = $row['product_name'].' '.$row['model_name'].' '.$row['color'].' '.$row['size'];
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $prod);
            $sheet->setCellValue('C' . $i, $row['stok']);
            $sheet->setCellValue('D' . $i, $row['stok_masuk']);
            $sheet->setCellValue('E' . $i, $row['stok_retur']);
            $sheet->setCellValue('F' . $i, $row['penjualan']);
            $sheet->setCellValue('G' . $i, $row['pengiriman']);
            $sheet->setCellValue('H' . $i, $row['sisa']);
            $sheet->setCellValue('I' . $i, $row['hpp']);
            $sheet->setCellValue('J' . $i, $row['hpp_jual']);
            $sheet->setCellValue('K' . $i, $row['hpp'] * $row['sisa']);
            $sheet->setCellValue('L' . $i, $row['hpp_jual'] * $row['sisa']);
            $sheet->setCellValue('M' . $i, ($row['hpp_jual'] * $row['sisa']) - ($row['hpp'] * $row['sisa']));
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

    public function updateHargaJualReject() {
        $id = $this->request->getVar('reject_id');
        $harga = $this->request->getVar('harga');        
        $this->productModel->updateHargaJual($id, $harga);        
    }

    public function getHPP() {
        $id = $this->request->getVar('id');
        $hpp = $this->designModel->find($id);
        echo json_encode($hpp);
    }

    public function gudangReject() {
        $rejectedProducts = $this->productModel->listReject();
        $rejectedSold = $this->productModel->rejectedSold();
        $totalNilaiJual = $this->productModel->totalNilaiJualReject();
        $data = array(
            'title' => 'Produk Reject',
            'rejectedProducts' => $rejectedProducts,
            'rejectedSold' => $rejectedSold,
            'totalNilaiJual' => $totalNilaiJual->total_jual
        );
        return view('gudang_gesit/gudang_reject', $data);    
    }

    // gudang 
    public function gudangProduk() {               
        $productsIn = $this->productModel->getAllProductLovish();        
        $productsOut = $this->productModel->getAllProductOut();        
        $productsExp = $this->productModel->getAllProductExp();        
        $models = $this->designModel->getAllModel();
        $colors = $this->materialModel->getAllColors();
        $products = $this->productModel->getAllProductLovish();
        $types = $this->productModel->getAllProduct();
        $vendors = $this->productModel->getAllVendorPenjualan();
        $data = array(
            'title' => 'Produk',
            'productsIn' => $productsIn,
            'productsOut' => $productsOut,
            'productsExp' => $productsExp,
            'models' => $models,
            'products' => $products,
            'colors' => $colors,
            'types' => $types,
            'vendors' => $vendors
        );
        return view('gudang_lovish/products', $data);       
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
        // dd($data);   
        foreach ($data as $idx => $row) {
            if ($idx > 0) {
                $temp = explode(' ', $row[1]);  
                $modelID = "";
                $productTypeID = "";
                $colorID = "";
                $size = NULL;
                $hpp = 0;
      

                $getModel = $this->designModel->where(['model_name' => $temp[1]])->first();                                
                if (is_null($getModel)) {
                    $model = [
                        'model_name' => $temp[1],                        
                    ];
                    $this->designModel->save($model); 
                    $modelID = $this->designModel->getInsertID();
                } else {
                    $modelID = $getModel['id'];
                    $hpp = $getModel['hpp'];
                }
                
                if (count($temp) == 3) {
                    $color = $temp[2];
                } else if (count($temp) > 3) {
                    $color = $temp[2]. ' '. $temp[3];
                }

                $getColor = $this->materialModel->getColorByName($color);
                if (is_null($getColor)) {
                    $colorID = $this->materialModel->saveWarna($color);
                } else {
                    $colorID = $getColor->id;
                }


                if (strpos($row[1], 'REG') !== false) {
                    $size = "REG";
                } else if (strpos($row[1], 'JUMBO') !== false) {
                    $size = "JUMBO";
                }


                $this->productModel->save([
                    'model_id' => $modelID,
                    'color_id' => $colorID,
                    'user_id' => session()->get('user_id'),
                    'qty' => $row[2],
                    'size' => $size,
                    'price' => $hpp,
                    'status' => 2
                ]);         
                $productId = $this->productModel->insertID();        
                for ($i=0; $i < $row[2]; $i++) {
                    $temp = $this->productModel->createBarcode($productId);
                    $this->productModel->createLog($temp, '0', '2');
                }                       
            }
        }
        return redirect()->back()->with('create', 'Produk berhasil ditambahkan');
    }


    public function gudangLovishStokProduk() {
        $models = $this->designModel->getAllModel();
        $colors = $this->materialModel->getAllColors();
        $vendors = $this->productModel->getAllVendorPenjualan();
        $products = $this->productModel->getAllStockProductLovish();
     
        $penjualan = $this->productModel->penjualan();
        $stok = array();
        $out = $this->productModel
            ->select('products.*, sum(product_logs.qty) as qty')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->join('product_logs', 'product_logs.product_id = product_barcodes.id')
            ->where('product_barcodes.status', '3')
            ->groupBy('model_id, color_id, size')    
            ->get();
        $sisaStok = $this->productModel
                ->select('models.hpp, products.id, products.hpp_jual, products.model_id, models.jenis as product_name, model_name, color, size, product_barcodes.updated_at, stok_masuk, penjualan, stok_retur, pengiriman, (IFNULL(stok_masuk, 0) + IFNULL(stok, 0) + IFNULL(stok_retur, 0) - (IFNULL(penjualan, 0) + IFNULL(pengiriman, 0)) ) as sisa, stok')
                ->join('models', 'models.id = products.model_id')
                ->join('colors', 'colors.id = products.color_id')
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                ->join('(SELECT id, SUM(qty) as stok FROM products WHERE status= 2 GROUP BY model_id, color_id, size) as a','products.id = a.id', 'left') 
                ->join('(SELECT product_barcodes.product_id, COUNT(product_barcodes.id) as stok_masuk FROM product_barcodes JOIN products ON products.id = product_barcodes.product_id WHERE product_barcodes.status != "0" AND product_barcodes.status != "1" GROUP BY model_id, color_id, size) as m', 'm.product_id = products.id', 'left')
                ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as penjualan FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id WHERE product_logs.status = 3 GROUP BY model_id, color_id, size) as k', 'k.product_id = products.id', 'left')
                ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as stok_retur FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id  WHERE product_logs.status = 4 GROUP BY model_id, color_id, size) as r', 'r.product_id = products.id', 'left')
                ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as pengiriman FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id  WHERE product_logs.status = 5 GROUP BY model_id, color_id, size) as s', 's.product_id = products.id', 'left')
                ->groupBy('models.id, colors.id, products.size')
                ->get();
        $selling = 0;        
        if ($products->getNumRows() > 0) {
            foreach ($products->getResultObject() as $product) {                
                if ($penjualan->getNumRows() > 0 || $out->getNumRows() > 0) {
                    foreach ($penjualan->getResultObject() as $sell) {                
                        if (($sell->model_id == $product->model_id) && ($sell->color_id == $product->color_id) && ($sell->size == $product->size)) {
                            $selling = $selling + $sell->qty;                         
                        }
                    }        
                    foreach($out->getResultObject() as $keluar) {
                        if (($keluar->model_id == $product->model_id) && ($keluar->color_id == $product->color_id) && ($keluar->size == $product->size)) {
                            $selling = $selling + 1;                         
                        }
                    }
                    $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($selling) -$product->pengiriman) ;                                                            
                    array_push($stok, [
                        'id' => $product->id,
                        'model_id' => $product->model_id,
                        'product_name' => $product->product_name,
                        'model_name' => $product->model_name,
                        'color' => $product->color,
                        'size' => $product->size,
                        'stok' => $product->stok,
                        'stok_masuk' => $product->stok_masuk,
                        'penjualan' => $selling,
                        'pengiriman' => $product->pengiriman,
                        'stok_retur' => $product->stok_retur,
                        'sisa' => $sisa,
                        'hpp' => $product->hpp,
                        'hpp_jual' => $product->hpp_jual,
                    ]);
                    $selling = 0;
                } else {
                    $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($selling) - $product->pengiriman) ;                                                            
                    array_push($stok, [
                        'id' => $product->id,
                        'model_id' => $product->model_id,
                        'product_name' => $product->product_name,
                        'model_name' => $product->model_name,
                        'color' => $product->color,
                        'size' => $product->size,
                        'stok' => $product->stok,
                        'stok_masuk' => $product->stok_masuk,
                        'penjualan' => $selling,
                        'pengiriman' => $product->pengiriman,
                        'stok_retur' => $product->stok_retur,
                        'sisa' => $sisa,
                        'hpp' => $product->hpp,
                        'hpp_jual' => $product->hpp_jual,
                    ]);
                }
            }
        }
                
        $data = array(
            'title' => 'Produk',
            'models' => $models,
            'products' => $sisaStok,
            'colors' => $colors,
            'vendors' => $vendors
        );
        return view('gudang_lovish/products_stock', $data);    
    }

    public function simpanReject() {
        $id = $this->request->getVar('id');
        $reject = $this->request->getVar('reject');
        
        $check = $this->productModel->findProductReject($id);
        $status = 0;
        
        if ($check->getNumRows() > 0) {
            $status = 1;
            $this->productModel->saveReject($id, $reject);    
        }
        
        echo json_encode($status);
        
    }

    public function jualReject() {
        $id = $this->request->getVar('id');        
        $check = $this->productModel->findProductReject($id);
        $status = 0;
        
        if ($check->getNumRows() > 0) {
            $status = 1;
            $this->productModel->saveJualReject($id);    
        }
        
        echo json_encode($status);
        
    }

    public function rejectIn() {
        $id = $this->request->getVar('id');
        $this->productModel->rejectIn($id);
    }

    public function rejectPermanent() {
        $id = $this->request->getVar('product_id');
        $this->productModel->rejectPermanent($id);
    }
    
    public function stockOpname() {
        $models = $this->designModel->getAllModel();
        $colors = $this->materialModel->getAllColors();
        $vendors = $this->productModel->getAllVendorPenjualan();
        $products = $this->productModel->getAllStockProductLovish();
        $penjualan = $this->productModel->penjualan();
        $sisaStok = $this->productModel
                ->select('models.hpp, products.id, products.hpp_jual, products.model_id, models.jenis as product_name, model_name, color, size, product_barcodes.updated_at, scan_in, stok_masuk, penjualan, stok_retur, pengiriman, (IFNULL(stok_masuk, 0) + IFNULL(stok, 0) + IFNULL(stok_retur, 0) - (IFNULL(penjualan, 0) + IFNULL(pengiriman, 0)) ) as sisa, stok')
                ->join('models', 'models.id = products.model_id')
                ->join('colors', 'colors.id = products.color_id')
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                ->join('(SELECT id, SUM(qty) as stok FROM products WHERE status= 2 GROUP BY model_id, color_id, size) as a','products.id = a.id', 'left') 
                ->join('(SELECT product_barcodes.product_id, COUNT(product_barcodes.id) as stok_masuk FROM product_barcodes JOIN products ON products.id = product_barcodes.product_id WHERE product_barcodes.status != "0" AND product_barcodes.status != "1" GROUP BY model_id, color_id, size) as m', 'm.product_id = products.id', 'left')
                ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as penjualan FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id WHERE product_logs.status = 3 GROUP BY model_id, color_id, size) as k', 'k.product_id = products.id', 'left')
                ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as stok_retur FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id  WHERE product_logs.status = 4 GROUP BY model_id, color_id, size) as r', 'r.product_id = products.id', 'left')
                ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as pengiriman FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id  WHERE product_logs.status = 5 GROUP BY model_id, color_id, size) as s', 's.product_id = products.id', 'left')
                ->join('(SELECT product_barcodes.product_id , COUNT(product_barcodes.product_id) as scan_in FROM products JOIN product_barcodes ON products.id = product_barcodes.product_id JOIN scan_so ON scan_so.product_id = product_barcodes.id GROUP BY model_id, color_id, size) as so', 'so.product_id = products.id', 'left')
                // ->join('(SELECT m.product_id, SUM(m.qty) as scan_in FROM scan_so m JOIN product_barcodes b ON b.id = m.product_id JOIN products as p ON p.id = b.product_id WHERE m.status=1 AND (MONTH(m.created_at) = MONTH(CURRENT_DATE()) AND YEAR(m.created_at) = YEAR(CURRENT_DATE()) ) GROUP BY  p.model_id, p.color_id, p.size) as so', 'product_barcodes.id = so.product_id', 'left')
                ->groupBy('models.id, colors.id, products.size')
                ->get();
        $stok = array();
        $out = $this->productModel
            ->select('products.*')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->where('product_barcodes.status', '3')
            ->get();
        $selling = 0;
        
        
        if ($products->getNumRows() > 0) {
            foreach ($products->getResultObject() as $product) {                
                if ($penjualan->getNumRows() > 0 || $out->getNumRows() > 0) {
                    foreach ($penjualan->getResultObject() as $sell) {                
                        if (($sell->model_id == $product->model_id) && ($sell->color_id == $product->color_id) && ($sell->size == $product->size)) {
                            $selling = $selling + $sell->qty;                         
                        }
                    }       
                    
                    foreach($out->getResultObject() as $keluar) {
                        if (($keluar->model_id == $product->model_id) && ($keluar->color_id == $product->color_id) && ($keluar->size == $product->size)) {
                            $selling = $selling + 1;                         
                        }
                    }
                    $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($selling)) ;                                                            
                    array_push($stok, [
                        'id' => $product->id,
                        'model_id' => $product->model_id,
                        'product_name' => $product->product_name,
                        'model_name' => $product->model_name,
                        'color' => $product->color,
                        'size' => $product->size,
                        'stok' => $product->stok,
                        'scan_in' => $product->scan_in,
                        'stok_masuk' => $product->stok_masuk,
                        'penjualan' => $selling,
                        'stok_retur' => $product->stok_retur,
                        'sisa' => $sisa,
                        'hpp' => $product->hpp,
                        'hpp_jual' => $product->hpp_jual,
                    ]);
                    $selling = 0;
                } else {
                    $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($selling)) ;                                                            
                    array_push($stok, [
                        'id' => $product->id,
                        'model_id' => $product->model_id,
                        'product_name' => $product->product_name,
                        'model_name' => $product->model_name,
                        'scan_in' => $product->scan_in,
                        'color' => $product->color,
                        'size' => $product->size,
                        'stok' => $product->stok,
                        'stok_masuk' => $product->stok_masuk,
                        'penjualan' => $selling,
                        'stok_retur' => $product->stok_retur,
                        'sisa' => $sisa,
                        'hpp' => $product->hpp,
                        'hpp_jual' => $product->hpp_jual,
                    ]);
                }
            }
        }
        
        $data = array(
            'title' => 'Stock Opname',
            'models' => $models,
            'products' => $sisaStok,
            'colors' => $colors,
            'vendors' => $vendors
        );
        return view('gudang_lovish/stock_opname', $data);    
    }

    public function exportProductReject($date1 = null, $date2 = null) {
        
        if (is_null($date1)) {
            $products = $this->productModel->getAllProductReject();
        } else {
            $products = $this->productModel->getAllProductReject($date1, $date2);
        }
        $date = time();
        $fileName = "Data Product Reject {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Tanggal Reject');
		$sheet->setCellValue('C1', 'Produk');
        $sheet->setCellValue('D1', 'Keterangan');
        $i = 2;
        $no = 1;
        foreach($products->getResultObject() as $row) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $row->date);
            $sheet->setCellValue('C' . $i, $row->product_name .' '.$row->model_name.' '.$row->color);            
            $sheet->setCellValue('D' . $i, strtoupper($row->category));
            $i++;
        }
        
        $writer = new Xlsx($spreadsheet);

        $writer->save("file/". $fileName);
        header("Content-Type: application/vnd.ms-excel");

		header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length:' . filesize("file/". $fileName));
		flush();
		readfile("file/". $fileName);
		exit;
    }

}
