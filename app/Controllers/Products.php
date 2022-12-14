<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\DesignModel;
use App\Models\LogModel;
use App\Models\MaterialModel;
use App\Models\SellingModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Products extends BaseController
{                         
    protected $productModel = "";
    protected $designModel = "";
    protected $logModel = "";
    protected $materialModel = "";
    protected $sellingModel = "";

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
        $this->sellingModel = new SellingModel();

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
        $this->logModel->saveHistoryStok([
            'model_id' => $data->id,
            'color_id' => $data->color,
            'qty' => $data->jumlah_setor,   
            'size' => 1,
            'jenis' => 'create',                         
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
        
        $date = date('m-d-Y H:i:s');
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
        
        $date = date('m-d-Y H:i:s');
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
        
        $date = date('m-d-Y H:i:s');
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

    public function exportDataStokProduct($date1= null, $date2 = null) {
        $products = $this->productModel->getAllStockProductLovish();
        $stok = array();
        $penjualan = $this->sellingModel
            ->select('sellings.*')
            ->join('models', 'models.id = sellings.model_id')
            ->join('colors', 'colors.id = sellings.color_id')            
            ->get();   
        if (is_null($date1)) {
            $sisaStok = $this->productModel
                ->select('models.hpp, products.id, products.hpp_jual, products.model_id, products.color_id, products.size, models.jenis as product_name, model_name, color, products.size, product_barcodes.updated_at, stok_masuk, penjualan, stok_retur, pengiriman, (IFNULL(stok_masuk, 0) + IFNULL(stok, 0) + IFNULL(stok_retur, 0) - (IFNULL(penjualan, 0) + IFNULL(pengiriman, 0)) ) as sisa, stok')
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
        } else {
            $sisaStok = $this->productModel
                ->select('models.hpp, products.id, products.hpp_jual, products.model_id, products.color_id, products.size, models.jenis as product_name, model_name, color, products.size, product_barcodes.updated_at, stok_masuk, penjualan, stok_retur, pengiriman, (IFNULL(stok_masuk, 0) + IFNULL(stok, 0) + IFNULL(stok_retur, 0) - (IFNULL(penjualan, 0) + IFNULL(pengiriman, 0)) ) as sisa, stok')
                ->join('models', 'models.id = products.model_id')
                ->join('colors', 'colors.id = products.color_id')
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                ->join('(SELECT id, SUM(qty) as stok FROM products WHERE status= 2 GROUP BY model_id, color_id, size) as a','products.id = a.id', 'left') 
                ->join('(SELECT product_barcodes.product_id, COUNT(product_barcodes.id) as stok_masuk FROM product_barcodes JOIN products ON products.id = product_barcodes.product_id WHERE product_barcodes.status != "0" AND product_barcodes.status != "1" GROUP BY model_id, color_id, size) as m', 'm.product_id = products.id', 'left')
                ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as penjualan FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id WHERE product_logs.status = 3 GROUP BY model_id, color_id, size) as k', 'k.product_id = products.id', 'left')
                ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as stok_retur FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id  WHERE product_logs.status = 4 GROUP BY model_id, color_id, size) as r', 'r.product_id = products.id', 'left')
                ->join('(SELECT product_barcodes.product_id, SUM(product_logs.qty) as pengiriman FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id  WHERE product_logs.status = 5 GROUP BY model_id, color_id, size) as s', 's.product_id = products.id', 'left')
                ->where('product_barcodes.updated_at BETWEEN "'.$date1.'" AND "'.$date2.'"  ')
                ->groupBy('models.id, colors.id, products.size')
                ->get();
        }
        $selling = 0;        
        if ($sisaStok->getNumRows() > 0) {
            foreach ($sisaStok->getResultObject() as $product) {                
                if ($penjualan->getNumRows() > 0) {
                    foreach ($penjualan->getResultObject() as $sell) {                                        
                        if (($sell->model_id == $product->model_id) && ($sell->color_id == $product->color_id) && ($sell->size == $product->size)) {
                            $selling = $selling + $sell->qty;                         
                        }
                    }        
                    $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($product->penjualan + $selling) - $product->pengiriman) ;                                                            
                    array_push($stok, [
                        'id' => $product->id,
                        'model_id' => $product->model_id,
                        'product_name' => $product->product_name,
                        'model_name' => $product->model_name,
                        'color' => $product->color,
                        'size' => $product->size,
                        'stok' => $product->stok,
                        'stok_masuk' => $product->stok_masuk,
                        'penjualan' => $selling + $product->penjualan,
                        'pengiriman' => $product->pengiriman,
                        'stok_retur' => $product->stok_retur,
                        'sisa' => $sisa,
                        'hpp' => $product->hpp,
                        'hpp_jual' => $product->hpp_jual,
                    ]);
                    $selling = 0;
                } else {
                    $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($product->penjualan + $selling) - $product->pengiriman) ;                                                            
                    array_push($stok, [
                        'id' => $product->id,
                        'model_id' => $product->model_id,
                        'product_name' => $product->product_name,
                        'model_name' => $product->model_name,
                        'color' => $product->color,
                        'size' => $product->size,
                        'stok' => $product->stok,
                        'stok_masuk' => $product->stok_masuk,
                        'penjualan' => $product->penjualan,
                        'pengiriman' => $product->pengiriman,
                        'stok_retur' => $product->stok_retur,
                        'sisa' => $sisa,
                        'hpp' => $product->hpp,
                        'hpp_jual' => $product->hpp_jual,
                    ]);
                }
            }
        } else {
            if ($penjualan->getNumRows() > 0) {
                
            }
        }
        $date = date('m-d-Y H:i:s');
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
        
        foreach($stok as $row) {
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
        $date = $this->request->getVar('dates');
        $date1 = null;          
        $date2 = null;
        $productsIn = $this->productModel->getAllProductLovish();        
        if (is_null($date)) {
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
                'vendors' => $vendors,
                'date1' => $date1,
                'date2' => $date2
            );       
        } else {
            $date = explode("-",$date);            
            $date1 = date('Y-m-d H:i:s', strtotime($date[0]));
            $date2 = date('Y-m-d H:i:s', strtotime($date[1]));
            $productsOut = $this->productModel->getAllProductOut($date1, $date2);        
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
                'vendors' => $vendors,
                'date1' => $date1,
                'date2' => $date2
            );
        }
        
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
        $date = $this->request->getVar('dates');
        $dates = $this->request->getVar('dates');
        if (is_null($date)) {
            $models = $this->designModel->getAllModel();
            $colors = $this->materialModel->getAllColors();
            $vendors = $this->productModel->getAllVendorPenjualan();
            $products = $this->productModel->getAllStockProductLovish();
         
            $penjualan = $this->sellingModel
                ->select('sellings.*')
                ->join('models', 'models.id = sellings.model_id')
                ->join('colors', 'colors.id = sellings.color_id')            
                ->get();        
            $stok = array();        
            $sisaStok = $this->productModel
                    ->select('models.hpp, products.id, products.hpp_jual, products.model_id, products.color_id, products.size, models.jenis as product_name, model_name, color, products.size, product_barcodes.updated_at, stok_masuk, penjualan, stok_retur, pengiriman, stok')
                    ->join('models', 'models.id = products.model_id')
                    ->join('colors', 'colors.id = products.color_id')
                    ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as stok FROM history_stok WHERE jenis="sisa_penjualan" AND status = 0 GROUP BY model_id, color_id, size) as a','products.model_id = a.model_id AND a.color_id = products.color_id', 'left') 
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as stok_masuk FROM history_stok WHERE jenis="in" AND status = 0 GROUP BY model_id, color_id, size) as m', 'm.model_id = products.model_id AND m.color_id = products.color_id', 'left')
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as penjualan FROM history_stok WHERE jenis="penjualan" AND status = 0 GROUP BY model_id, color_id, size) as k', 'k.model_id = products.model_id AND k.color_id = products.color_id', 'left')                
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as stok_retur FROM history_stok WHERE jenis="retur" AND status = 0 GROUP BY model_id, color_id, size) as r', 'r.model_id = products.model_id AND r.color_id = products.color_id', 'left')
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as pengiriman FROM history_stok WHERE jenis="pengiriman" AND status = 0 GROUP BY model_id, color_id, size) as s', 's.model_id = products.model_id AND s.color_id = products.color_id', 'left')
                    ->groupBy('models.id, colors.id, products.size')
                    ->get();                
            $selling = 0;             
            $stokIn = $this->productModel
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                ->where('product_barcodes.status', '6')
                ->get();    
            $toIn = 0;
            if ($sisaStok->getNumRows() > 0) {
                foreach ($sisaStok->getResultObject() as $product) {                
                    if ($penjualan->getNumRows() > 0) {                          
                        foreach ($stokIn->getResultObject() as $in) {                                        
                            if (($in->model_id == $product->model_id) && ($in->color_id == $product->color_id) && ($in->size == $product->size)) {
                                $toIn = $toIn + $product->stok;                         
                            }    
                        }
                        $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($product->penjualan + $selling)) ;
                        $sisa_gudang = ($product->stok + $product->stok_masuk + $product->stok_retur - $product->pengiriman) ;                                                            
                        array_push($stok, [
                            'id' => $product->id,
                            'model_id' => $product->model_id,
                            'product_name' => $product->product_name,
                            'model_name' => $product->model_name,
                            'color' => $product->color,
                            'size' => $product->size,
                            'stok' => $product->stok,
                            'stok_masuk' => $product->stok_masuk,
                            'penjualan' => $selling + $product->penjualan,
                            'pengiriman' => $product->pengiriman,
                            'stok_retur' => $product->stok_retur,
                            'sisa' => $sisa,
                            'sisa_gudang' => $sisa_gudang,
                            'hpp' => $product->hpp,
                            'hpp_jual' => $product->hpp_jual,
                        ]);
                        $selling = 0;
                        $toIn = 0;
                    } else {
                        $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($product->penjualan + $selling)) ;
                        $sisa_gudang = ($product->stok + $product->stok_masuk + $product->stok_retur - $product->pengiriman) ;                                                            
                        foreach ($stokIn->getResultObject() as $in) {                                        
                            if (($in->model_id == $product->model_id) && ($in->color_id == $product->color_id) && ($in->size == $product->size)) {
                                $toIn = $toIn + $product->stok;                         
                            }    
                        }
                        array_push($stok, [
                            'id' => $product->id,
                            'model_id' => $product->model_id,
                            'product_name' => $product->product_name,
                            'model_name' => $product->model_name,
                            'color' => $product->color,
                            'size' => $product->size,
                            'stok' => $product->stok,
                            'stok_masuk' => $product->stok_masuk,
                            'penjualan' => $product->penjualan,
                            'pengiriman' => $product->pengiriman,
                            'stok_retur' => $product->stok_retur,
                            'sisa' => $sisa,
                            'sisa_gudang' => $sisa_gudang,
                            'hpp' => $product->hpp,
                            'hpp_jual' => $product->hpp_jual,
                        ]);
                        $toIn = 0;
                    }
                }
            } else {
                if ($penjualan->getNumRows() > 0) {
                    
                }
            }
                    
            $data = array(
                'title' => 'Stock Produk',
                'models' => $models,
                'products' => $stok,
                'colors' => $colors,
                'vendors' => $vendors,
                'date1' => null
            );
        } else {
            $date = explode("-",$date);   
            $date1 = date('Y-m-d 00:00:00', strtotime($date[0]));
            $date2 = date('Y-m-d 00:00:00', strtotime($date[1]));
            $models = $this->designModel->getAllModel();
            $colors = $this->materialModel->getAllColors();
            $vendors = $this->productModel->getAllVendorPenjualan();
            $products = $this->productModel->getAllStockProductLovish();
         
            $penjualan = $this->sellingModel
                ->select('sellings.*')
                ->join('models', 'models.id = sellings.model_id')
                ->join('colors', 'colors.id = sellings.color_id')            
                ->get();        
            $stok = array();        
            $sisaStok = $this->productModel
                    ->select('models.hpp, products.id, products.hpp_jual, products.model_id, products.color_id, products.size, models.jenis as product_name, model_name, color, products.size, product_barcodes.updated_at, stok_masuk, penjualan, stok_retur, pengiriman, (IFNULL(stok_masuk, 0) + IFNULL(stok, 0) + IFNULL(stok_retur, 0) - (IFNULL(penjualan, 0) + IFNULL(pengiriman, 0)) ) as sisa, stok')
                    ->join('models', 'models.id = products.model_id')
                    ->join('colors', 'colors.id = products.color_id')
                    ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                    ->join('(SELECT id, SUM(qty) as stok FROM products WHERE status= 2 GROUP BY model_id, color_id, size) as a','products.id = a.id', 'left') 
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as stok_masuk FROM history_stok WHERE jenis="in" AND (created_at BETWEEN "'.$date1.'" AND "'.$date2.'") GROUP BY model_id, color_id, size) as m', 'm.model_id = products.model_id AND m.color_id = products.color_id', 'left')
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as penjualan FROM history_stok WHERE jenis="penjualan" AND (created_at BETWEEN "'.$date1.'" AND "'.$date2.'") GROUP BY model_id, color_id, size) as k', 'k.model_id = products.model_id AND k.color_id = products.color_id', 'left')                
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as stok_retur FROM history_stok WHERE jenis="retur" AND (created_at BETWEEN "'.$date1.'" AND "'.$date2.'") GROUP BY model_id, color_id, size) as r', 'r.model_id = products.model_id AND r.color_id = products.color_id', 'left')
                    ->join('(SELECT history_stok.model_id, history_stok.color_id, updated_at, SUM(history_stok.qty) as pengiriman FROM history_stok WHERE jenis="pengiriman" AND (created_at BETWEEN "'.$date1.'" AND "'.$date2.'") GROUP BY model_id, color_id, size) as s', 's.model_id = products.model_id AND s.color_id = products.color_id', 'left')
                    ->groupBy('models.id, colors.id, products.size')
                    ->get();
            $selling = 0;             
            $stokIn = $this->productModel
                ->join('product_barcodes', 'product_barcodes.product_id = products.id')
                ->where('product_barcodes.status', '6')
                ->get();    
            $toIn = 0;
            if ($sisaStok->getNumRows() > 0) {
                foreach ($sisaStok->getResultObject() as $product) {                
                    if ($penjualan->getNumRows() > 0) {                          
                        foreach ($stokIn->getResultObject() as $in) {                                        
                            if (($in->model_id == $product->model_id) && ($in->color_id == $product->color_id) && ($in->size == $product->size)) {
                                $toIn = $toIn + $product->stok + 1;                         
                            }    
                        }
                        $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($product->penjualan + $selling)) ;
                        $sisa_gudang = ($product->stok + $product->stok_masuk + $product->stok_retur - $product->pengiriman) ;                                                            
                        array_push($stok, [
                            'id' => $product->id,
                            'model_id' => $product->model_id,
                            'product_name' => $product->product_name,
                            'model_name' => $product->model_name,
                            'color' => $product->color,
                            'size' => $product->size,
                            'stok' => $product->stok,
                            'stok_masuk' => $product->stok_masuk,
                            'penjualan' => $selling + $product->penjualan,
                            'pengiriman' => $product->pengiriman,
                            'stok_retur' => $product->stok_retur,
                            'sisa' => $sisa,
                            'sisa_gudang' => $sisa_gudang,
                            'hpp' => $product->hpp,
                            'hpp_jual' => $product->hpp_jual,
                        ]);
                        $selling = 0;
                        $toIn = 0;
                    } else {
                        $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($product->penjualan + $selling)) ;
                        $sisa_gudang = ($product->stok + $product->stok_masuk + $product->stok_retur - $product->pengiriman) ;                                                            
                        foreach ($stokIn->getResultObject() as $in) {                                        
                            if (($in->model_id == $product->model_id) && ($in->color_id == $product->color_id) && ($in->size == $product->size)) {
                                $toIn = $toIn + $product->stok + 1;                         
                            }    
                        }
                        array_push($stok, [
                            'id' => $product->id,
                            'model_id' => $product->model_id,
                            'product_name' => $product->product_name,
                            'model_name' => $product->model_name,
                            'color' => $product->color,
                            'size' => $product->size,
                            'stok' => $toIn,
                            'stok_masuk' => $product->stok_masuk,
                            'penjualan' => $product->penjualan,
                            'pengiriman' => $product->pengiriman,
                            'stok_retur' => $product->stok_retur,
                            'sisa' => $sisa,
                            'sisa_gudang' => $sisa_gudang,
                            'hpp' => $product->hpp,
                            'hpp_jual' => $product->hpp_jual,
                        ]);
                        $toIn = 0;
                    }
                }
            } else {
                if ($penjualan->getNumRows() > 0) {
                    
                }
            }
                    
            $data = array(
                'title' => 'Stock Produk',
                'models' => $models,
                'products' => $stok,
                'colors' => $colors,
                'vendors' => $vendors,
                'date1' => $dates,
                'date2' => $date2,
            );
        }
        
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
        $penjualan = $this->sellingModel
            ->select('sellings.*')
            ->join('models', 'models.id = sellings.model_id')
            ->join('colors', 'colors.id = sellings.color_id')            
            ->get();        
        $stok = array();  
        $sisaStok = $this->productModel
                ->select('models.hpp, products.id, products.hpp_jual, products.model_id, products.color_id, products.size, models.jenis as product_name, model_name, color, size, product_barcodes.updated_at, scan_in, stok_masuk, penjualan, stok_retur, pengiriman, (IFNULL(stok_masuk, 0) + IFNULL(stok, 0) + IFNULL(stok_retur, 0) - (IFNULL(penjualan, 0) + IFNULL(pengiriman, 0)) ) as sisa, stok')
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
        $selling = 0;
        
        
        if ($sisaStok->getNumRows() > 0) {
            foreach ($sisaStok->getResultObject() as $product) {                
                if ($penjualan->getNumRows() > 0) {
                    foreach ($penjualan->getResultObject() as $sell) {                                        
                        if (($sell->model_id == $product->model_id) && ($sell->color_id == $product->color_id) && ($sell->size == $product->size)) {
                            $selling = $selling + $sell->qty;                         
                        }
                    }        
                    $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($product->penjualan + $selling) - $product->pengiriman) ;                                                            
                    array_push($stok, [
                        'id' => $product->id,
                        'model_id' => $product->model_id,
                        'product_name' => $product->product_name,
                        'model_name' => $product->model_name,
                        'color' => $product->color,
                        'size' => $product->size,
                        'stok' => $product->stok,
                        'stok_masuk' => $product->stok_masuk,
                        'penjualan' => $selling + $product->penjualan,
                        'pengiriman' => $product->pengiriman,
                        'stok_retur' => $product->stok_retur,
                        'sisa' => $sisa,
                        'scan_in' => $product->scan_in,
                        'hpp' => $product->hpp,
                        'hpp_jual' => $product->hpp_jual,
                    ]);
                    $selling = 0;
                } else {
                    $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($product->penjualan + $selling) - $product->pengiriman) ;                                                            
                    array_push($stok, [
                        'id' => $product->id,
                        'model_id' => $product->model_id,
                        'product_name' => $product->product_name,
                        'model_name' => $product->model_name,
                        'color' => $product->color,
                        'size' => $product->size,
                        'stok' => $product->stok,
                        'stok_masuk' => $product->stok_masuk,
                        'penjualan' => $product->penjualan,
                        'pengiriman' => $product->pengiriman,
                        'stok_retur' => $product->stok_retur,
                        'sisa' => $sisa,
                        'scan_in' => $product->scan_in,
                        'hpp' => $product->hpp,
                        'hpp_jual' => $product->hpp_jual,
                    ]);
                }
            }
        } else {
            if ($penjualan->getNumRows() > 0) {
                
            }
        }
        
        $data = array(
            'title' => 'Stock Opname',
            'models' => $models,
            'products' => $stok,
            'colors' => $colors,
            'vendors' => $vendors
        );
        return view('gudang_lovish/stock_opname', $data);    
    }

    public function stokMasukToIn() {
        $this->productModel->setToStokAwal();
    }

    public function exportProductReject($date1 = null, $date2 = null) {
        
        if (is_null($date1)) {
            $products = $this->productModel->getAllProductReject();
        } else {
            $products = $this->productModel->getAllProductReject($date1, $date2);
        }
        $date = date('m-d-Y H:i:s');
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
    
    public function resetSO() {
        $this->productModel->resetSO();
    }

    public function exportSO() {
        $models = $this->designModel->getAllModel();
        $colors = $this->materialModel->getAllColors();
        $vendors = $this->productModel->getAllVendorPenjualan();
        $products = $this->productModel->getAllStockProductLovish();
        $penjualan = $this->sellingModel
            ->select('sellings.*')
            ->join('models', 'models.id = sellings.model_id')
            ->join('colors', 'colors.id = sellings.color_id')            
            ->get();        
        $stok = array();  
        $sisaStok = $this->productModel
                ->select('models.hpp, products.id, products.hpp_jual, products.model_id, products.color_id, products.size, models.jenis as product_name, model_name, color, size, product_barcodes.updated_at, scan_in, stok_masuk, penjualan, stok_retur, pengiriman, (IFNULL(stok_masuk, 0) + IFNULL(stok, 0) + IFNULL(stok_retur, 0) - (IFNULL(penjualan, 0) + IFNULL(pengiriman, 0)) ) as sisa, stok')
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
        $selling = 0;
        
        
        if ($sisaStok->getNumRows() > 0) {
            foreach ($sisaStok->getResultObject() as $product) {                
                if ($penjualan->getNumRows() > 0) {
                    foreach ($penjualan->getResultObject() as $sell) {                                        
                        if (($sell->model_id == $product->model_id) && ($sell->color_id == $product->color_id) && ($sell->size == $product->size)) {
                            $selling = $selling + $sell->qty;                         
                        }
                    }        
                    $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($product->penjualan + $selling) - $product->pengiriman) ;                                                            
                    array_push($stok, [
                        'id' => $product->id,
                        'model_id' => $product->model_id,
                        'product_name' => $product->product_name,
                        'model_name' => $product->model_name,
                        'color' => $product->color,
                        'size' => $product->size,
                        'stok' => $product->stok,
                        'stok_masuk' => $product->stok_masuk,
                        'penjualan' => $selling + $product->penjualan,
                        'pengiriman' => $product->pengiriman,
                        'stok_retur' => $product->stok_retur,
                        'sisa' => $sisa,
                        'scan_in' => $product->scan_in,
                        'hpp' => $product->hpp,
                        'hpp_jual' => $product->hpp_jual,
                    ]);
                    $selling = 0;
                } else {
                    $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($product->penjualan + $selling) - $product->pengiriman) ;                                                            
                    array_push($stok, [
                        'id' => $product->id,
                        'model_id' => $product->model_id,
                        'product_name' => $product->product_name,
                        'model_name' => $product->model_name,
                        'color' => $product->color,
                        'size' => $product->size,
                        'stok' => $product->stok,
                        'stok_masuk' => $product->stok_masuk,
                        'penjualan' => $product->penjualan,
                        'pengiriman' => $product->pengiriman,
                        'stok_retur' => $product->stok_retur,
                        'sisa' => $sisa,
                        'scan_in' => $product->scan_in,
                        'hpp' => $product->hpp,
                        'hpp_jual' => $product->hpp_jual,
                    ]);
                }
            }
        } else {
            if ($penjualan->getNumRows() > 0) {
                
            }
        }
        $date = date('m-d-Y H:i:s');
        $fileName = "Data Stok Opname {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Produk');
		$sheet->setCellValue('C1', 'Sisa Stok');
        $sheet->setCellValue('D1', 'Scan SO');
        $sheet->setCellValue('E1', 'Selisih');
        $i = 2;
        $no = 1;
        foreach($stok as $product) {
            $selisih = $product['sisa'] - $product['scan_in'];
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $product['product_name'].' '.$product['model_name'].' '.$product['color'].' '.$product['size']);
            $sheet->setCellValue('C' . $i, $product['sisa']);            
            $sheet->setCellValue('D' . $i, $product['scan_in'] > 0 ? $product['scan_in'] : '-');
            $sheet->setCellValue('E' . $i, $selisih > 0 ? $selisih : '-');
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

    public function exportRetur() {
        $productsRetur = $this->productModel->productsRetur();
        $date = date('m-d-Y H:i:s');
        $fileName = "Data Produk Retur  {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Tanggal');
		$sheet->setCellValue('C1', 'Produk');
        $sheet->setCellValue('D1', 'Qty');
        $i = 2;
        $no = 1;
        foreach($productsRetur->getResultArray() as $product) {            
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $product['created_at']);            
            $sheet->setCellValue('C' . $i, $product['product_name'].' '.$product['model_name'].' '.$product['color'].' '.$product['size']);
            $sheet->setCellValue('D' . $i, $product['qty']);                        
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

    public function exportProdukMasuk() {
        $productsIn = $this->productModel
            ->select('model_name, jenis as product_name, color, size, COUNT(product_barcodes.id) as stok, products.updated_at')
            ->join('models', 'models.id = products.model_id')
            ->join('colors', 'colors.id = products.color_id')
            ->join('product_barcodes', 'product_barcodes.product_id = products.id')
            ->where('product_barcodes.status', '2')
            ->orWhere('product_barcodes.status', '3')
            ->orWhere('product_barcodes.status', '5')
            
            ->groupBy('product_barcodes.product_id')   
            ->get();
        $date = date('m-d-Y H:i:s');
        $fileName = "Data Produk Retur  {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Produk');
		$sheet->setCellValue('C1', 'Tanggal Masuk');
        $sheet->setCellValue('D1', 'Stok');
        $i = 2;
        $no = 1;
        foreach($productsIn->getResultArray() as $product) {            
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $product['product_name'].' '.$product['model_name'].' '.$product['color'].' '.$product['size']);
            $sheet->setCellValue('C' . $i, $product['updated_at']);                        
            $sheet->setCellValue('D' . $i, $product['stok']);                        
            
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

    public function exportProdukKeluar() {
        $productsExp = $this->productModel
                ->select('products.id, size, models.jenis as product_name, model_name, color, k.updated_at')
                ->join('models', 'models.id = products.model_id')
                ->join('colors', 'colors.id = products.color_id')
                ->join('(SELECT product_barcodes.product_id, product_barcodes.updated_at FROM product_logs JOIN product_barcodes ON product_barcodes.id = product_logs.product_id JOIN products ON products.id = product_barcodes.product_id WHERE product_logs.status = 3 OR product_logs.status = 5) as k', 'k.product_id = products.id')
                ->get();
        $date = date('m-d-Y H:i:s');
        $fileName = "Data Produk Keluar  {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Produk');
		$sheet->setCellValue('C1', 'Tanggal Keluar');
        $sheet->setCellValue('D1', 'Qty');
        $i = 2;
        $no = 1;
        foreach($productsExp->getResultArray() as $product) {            
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $product['product_name'].' '.$product['model_name'].' '.$product['color'].' '.$product['size']);
            $sheet->setCellValue('C' . $i, $product['updated_at']);                        
            $sheet->setCellValue('D' . $i, '1');                        
            
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

    public function exportStokGudang() {
        $sisaStok = $this->productModel
                ->select('models.hpp, products.id, products.hpp_jual, products.model_id, products.color_id, products.size, models.jenis as product_name, model_name, color, products.size, product_barcodes.updated_at, stok_masuk, penjualan, stok_retur, pengiriman, (IFNULL(stok_masuk, 0) + IFNULL(stok, 0) + IFNULL(stok_retur, 0) - (IFNULL(penjualan, 0) + IFNULL(pengiriman, 0)) ) as sisa, stok')
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
        $penjualan = $this->sellingModel
            ->select('sellings.*')
            ->join('models', 'models.id = sellings.model_id')
            ->join('colors', 'colors.id = sellings.color_id')            
            ->get();       
        $stok = array();
        $selling = 0;        
        $totalNilaiBarang = 0;
        $totalNilaiBarangJual = 0;
        
        if ($sisaStok->getNumRows() > 0) {
            foreach ($sisaStok->getResultObject() as $product) {                
                if ($penjualan->getNumRows() > 0) {
                    foreach ($penjualan->getResultObject() as $sell) {                                        
                        if (($sell->model_id == $product->model_id) && ($sell->color_id == $product->color_id) && ($sell->size == $product->size)) {
                            $selling = $selling + $sell->qty;                         
                        }
                    }        
                    $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($product->penjualan + $selling) - $product->pengiriman) ;                                                            
                    array_push($stok, [
                        'id' => $product->id,
                        'model_id' => $product->model_id,
                        'product_name' => $product->product_name,
                        'model_name' => $product->model_name,
                        'color' => $product->color,
                        'size' => $product->size,
                        'stok' => $product->stok,
                        'stok_masuk' => $product->stok_masuk,
                        'penjualan' => $selling + $product->penjualan,
                        'pengiriman' => $product->pengiriman,
                        'stok_retur' => $product->stok_retur,
                        'sisa' => $sisa,
                        'hpp' => $product->hpp,
                        'hpp_jual' => $product->hpp_jual,
                    ]);
                    $selling = 0;
                } else {
                    $sisa = ($product->stok + $product->stok_masuk + $product->stok_retur - ($product->penjualan + $selling) - $product->pengiriman) ;                                                            
                    array_push($stok, [
                        'id' => $product->id,
                        'model_id' => $product->model_id,
                        'product_name' => $product->product_name,
                        'model_name' => $product->model_name,
                        'color' => $product->color,
                        'size' => $product->size,
                        'stok' => $product->stok,
                        'stok_masuk' => $product->stok_masuk,
                        'penjualan' => $product->penjualan,
                        'pengiriman' => $product->pengiriman,
                        'stok_retur' => $product->stok_retur,
                        'sisa' => $sisa,
                        'hpp' => $product->hpp,
                        'hpp_jual' => $product->hpp_jual,
                    ]);
                }                
            }
        } else {
            if ($penjualan->getNumRows() > 0) {
                
            }
        }
        $date = date('m-d-Y H:i:s');
        $fileName = "Data Stok Gudang {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Produk');
		$sheet->setCellValue('C1', 'Sisa Stok');
        $i = 2;
        $no = 1;
        foreach($stok as $product) {            
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $product['product_name'].' '.$product['model_name'].' '.$product['color'].' '.$product['size']);
            $sheet->setCellValue('C' . $i, $product['sisa']);                        

            
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

    public function exportProdukMasukGesit($date1 = null, $date2 = null) {
        if (is_null($date1)) {
            $productsOut = $this->productModel->getAllProductOut();    
        } else {
            $productsOut = $this->productModel->getAllProductOut($date1, $date2);    
        }
        $date = date('m-d-Y H:i:s');
        $fileName = "Data Produk Masuk dari Gesit  {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Produk');
		$sheet->setCellValue('C1', 'Tanggal Masuk');
        $sheet->setCellValue('D1', 'Qty');
        $i = 2;
        $no = 1;
        foreach($productsOut->getResultArray() as $product) {            
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $product['product_name'].' '.$product['model_name'].' '.$product['color']);
            $sheet->setCellValue('C' . $i, $product['created_at']);                        
            $sheet->setCellValue('D' . $i, '1');                        
            
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
