<?php 
    namespace App\Controllers;

    use App\Models\ProductModel;
    use App\Models\DesignModel;
    use App\Models\LogModel;
    use App\Models\MaterialModel;
    use App\Models\SellingModel;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    
    class Sellings extends BaseController
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
            $date = $this->request->getVar('dates');
            $dates=  $this->request->getVar('dates');
            $date1 = null;
            $date2 = null;
            if (is_null($date)) {
                $penjualan = $this->productModel->penjualan();       
                $data = array(
                    'title' => 'Penjualan',     
                    'sellings' => $penjualan,   
                    'date1' => $date1,
                    'date2' => $date2,  
                );
            } else {
                $date = explode("-",$date);            
                $date1 = date('Y-m-d H:i:s', strtotime($date[0]));
                $date2 = date('Y-m-d H:i:s', strtotime($date[1]));
                $penjualan = $this->productModel->penjualan($date1, $date2);  
                $data = array(
                    'title' => 'Penjualan',     
                    'sellings' => $penjualan,   
                    'date1' => $date[0],
                    'date2' => $date[1],
                    'dates' => $dates,  
                );     
            }
            
            return view('gudang_lovish/penjualan', $data);      
        }

        public function importSelling() {
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
                if ($idx > 0 && !is_null($row[0])) {
                    $modelID = "";
                    $productTypeID = "";
                    $colorID = "";
                    $size = NULL;
                    $hpp = 0;
    
                    $getProductType = $this->productModel->getProductType($row[1]);
                    if (is_null($getProductType)) {
                        $productTypeID = NULL;                    
                    }  else {
                        $productTypeID = $getProductType->id;
                    }                       
    
                    $getModel = $this->designModel->where(['model_name' => $row[2]])->first();                                
                    if (is_null($getModel)) {
                        $model = [
                            'model_name' => $$row[2],                        
                        ];
                        $this->designModel->save($model); 
                        $modelID = $this->designModel->getInsertID();
                    } else {
                        $modelID = $getModel['id'];
                        $hpp = $getModel['hpp'];
                    }
    
                    $getColor = $this->materialModel->getColorByName($row[3]);
                    if (is_null($getColor)) {
                        $colorID = $this->materialModel->saveWarna($row[3]);
                    } else {
                        $colorID = $getColor->id;
                    }
    
                    if (!is_null($row[4])) {
                        $size = strtoupper($row[4]);
                    } else {
                        $size = NULL;
                    }
    
    
                    $this->sellingModel->save([
                        'product_id' => $productTypeID,
                        'model_id' => $modelID,
                        'color_id' => $colorID,                        
                        'qty' => $$row[5],
                        'brand' => $row[6],
                        'size' => $size,
                        'status' => 3
                    ]);     
                    
                    $this->logModel->saveHistoryStok([
                        'model_id' => $modelID,
                        'color_id' => $colorID,                        
                        'qty' => $row[2],
                        'jenis' => 'penjualan'
                    ]);
                                     
                }
            }
            return redirect()->back()->with('create', 'Produk berhasil ditambahkan');
        }

        public function exportPenjualan($date1 = null, $date2 = null) {
            if (is_null($date1)) {
                $penjualan = $this->productModel->penjualan();       
            } else {
                $penjualan = $this->productModel->penjualan($date1, $date2);                       
            }
            $date = date('m-d-Y H.i.s');
        $fileName = "Data Penjualan {$date}.xlsx";  
        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'No');
		$sheet->setCellValue('B1', 'Tanggal');
		$sheet->setCellValue('C1', 'Jenis Produk');
		$sheet->setCellValue('D1', 'Model');
		$sheet->setCellValue('E1', 'Warna');
		$sheet->setCellValue('F1', 'Size');
        $sheet->setCellValue('G1', 'Qty');
        $sheet->setCellValue('H1', 'Brand');
        $i = 2;
        $no = 1;
        foreach($penjualan->getResultObject() as $row) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $row->created_at);
            $sheet->setCellValue('C' . $i, $row->product_name);
            $sheet->setCellValue('D' . $i, $row->model_name);
            $sheet->setCellValue('E' . $i, $row->color);
            $sheet->setCellValue('F' . $i, $row->size);
            $sheet->setCellValue('G' . $i, $row->qty);
            $sheet->setCellValue('H' . $i, $row->brand);
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

        public function updateHPPJual() {            
            $product = $this->request->getVar('product_id');
            $model = $this->request->getVar('model_id');
            $hpp = $this->request->getVar('hpp');
            $size = $this->request->getVar('size');
            $this->productModel->updateHPPJual($product, $model, $size, $hpp);
        }

    }

    

?>