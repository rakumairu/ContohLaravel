<?php

namespace App\Http\Controllers;

use App\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    private $column_order_province = array('code', 'description', null); 
    private $column_search_province = array('code', 'description'); 
    private $order_province = array('code' => 'asc');

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $tab_active = 'province';
        return view('province.index', compact('tab_active'));
    }
    
    // AJAX Request
    /**
     * Read
     */
    public function api_province_list(Request $request)
    {
        $request = $request->all();
        
        $list = $this->get_province_query($request);
        $data = array();
        $no = $request['start'];
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $val->code; 
            $row[] = $val->description; 
            $row[] = '<button class="btn btn-sm btn-primary" alt="Edit" onclick="edit_default('."'".$val->code."'".')"><i class="far fa-edit" aria-hidden="true"></i>Edit</button> 
            <button class="btn btn-sm btn-danger" alt="Hapus" onclick="show_delete('."'".$val->code."','".$val->description."'".')"><i class="fas fa-trash" aria-hidden="true"></i> Delete</button>';
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $request['draw'],
            "recordsTotal" =>$this->count_province_all(),
            "recordsFiltered" => $this->count_province_filtered($request),
            "data" => $data,
            'list' => $list
        );
        //output to json format
        echo json_encode($output);
    }

    public function _get_province_query($request)
    {
        $i = 0;

        $provinceOptions = Province::selectRaw('*');

        if($request['search']['value']) {
            foreach($this->column_search_province as $item) {
                if($i == 0) {
                    $rawhere = '( LOWER ( CAST ( ' . $item . ' AS TEXT ) ) LIKE' . "%" . strtolower($request['search']['value']) . "%";
                } else {
                    $rawhere .= 'OR LOWER ( CAST ( ' . $item . ' AS TEXT ) ) LIKE' . "%" . strtolower($request['search']['value']) . "%";
                }

                $i = 1;
            }
            $rawhere .= ')';
        }

        if(isset($rawhere)) {
            $provinceOptions->whereRaw($rawhere);
        }

        if(isset($request['order'])) // here order processing
        {
            $provinceOptions->orderBy($this->column_order_province[$request['order']['0']['column']], $request['order']['0']['dir']);
        } 
        else if(isset($this->order_province))
        {
            $order = $this->order_province;
            $provinceOptions->orderBy(key($order), $order[key($order)]);
        }

        return $provinceOptions;
    }

    public function get_province_query($request)
    {
        $provinceOptions = $this->_get_province_query($request);
        if($request['length'] != -1)
        $provinceOptions->skip($request['start'])->take($request['length']);
        return $provinceOptions->get();
    }

    public function count_province_filtered($request){
        $provinceOptions = $this->_get_province_query($request);
        return $provinceOptions->count();
    }

    public function count_province_all()
    {
        return Province::count();
    }

    /**
     * Create
     */
    public function api_save_province(Request $request){
        $code = $request->input('code');
		$description = $request->input('description');

        if (Province::create([
            'code' => $code,
            'description' => $description,
        ])) {
            $return = array(
				'status' => 'true',
				'message' => 'Berhasil Menyimpan',
				'alert' => 'success'
			);
        } else {
            $return = array(
				'status' => 'false',
				'message' => 'Gagal Menyimpan',
				'alert' => 'error'
            );
        }
		echo json_encode($return);
    }

    /**
     * Update
     */
    public function api_get_province(Request $request)
    {
        $code = $request->code;
        $result = Province::find($code);

		if ($result) {
			$return = array(
					'status' => 'true',
					'datas' => $result
				);
		}else{
			$return = array(
					'status' => 'false',
					'messsage' => 'Data Tidak ditemukan'
				);
		}
		echo json_encode($return);
    }

    public function api_update_province(Request $request){
        $code = $request->input('code');
        $description = $request->input('description');
        
        if (Province::where('code', $code)->update([
            'code'=> $code,
            'description' => $description,
        ])) {
            $return = array(
                'status' => 'true',
                'message' => 'Berhasil Update'
            );
        } else {
            $return = array(
                'status' => 'false',
                'message' => 'Gagal Update'
            );
        }
		echo json_encode($return);
    }
    
    /**
     * Delete
     */
    public function api_delete_province(Request $request){
        $code = $request->idhapus;
        
        if (Province::findOrFail($code)->delete()) {
            $return = array(
                'status' => 'true',
                'message' => 'Berhasil Hapus'
            );
        } else {
            $return = array(
                'status' => 'false',
                'message' => 'Gagal Hapus'
            );
        }
		echo json_encode($return);
	}
}
