<?php 

class Perolehan_kursi extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin')
        {
            redirect('admin/auth');
        }
    }
     
    public function index()
    {
        $data = [
            'title'     => 'Perolehan Kursi',
            'aktif'     => 'perolehan_kursi',
            'periode'   => $this->Perolehan_kursi_model->getDataPeriode()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('perolehan_kursi/periode',$data);
		$this->load->view('templates/footer');
    }

    public function kabupaten($id_periode)
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'         => 'Perolehan Kursi',
            'aktif'         => 'perolehan_kursi',
            'wilayah'       => $this->Perolehan_kursi_model->getDataWilayahKabupaten()->result(),
            'wilayahById'   => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $id_periode = $this->uri->segment(3);
        $this->session->set_userdata('id_periode', $id_periode);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('perolehan_kursi/kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function detailPerolehanKursiKabupaten($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'         => 'Perolehan Kursi',
            'aktif'         => 'perolehan_kursi',
            'wilayah'       => $this->Perolehan_kursi_model->getDataPerolehanKursiByIdKabPeriode($id_periode,$id_kab)->result_array(),
            'wilayahKab'    => $this->Perolehan_kursi_model->getDataWilayahKabupatenById($id_kab)->result_array(),
            'periode'       => $this->Perolehan_kursi_model->getDataPeriodeById($id_periode)->result_array(),
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('perolehan_kursi/detailPerolehanKursiKabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function tambahPerolehanKursi_proses()
    {
        $id_kab = $this->session->userdata('id_kab');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->detailPerolehanKursiKabupaten($id_kab);
        }
        else
        {
            $this->Perolehan_kursi_model->tambahPerolehanKursi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('perolehan_kursi/detailPerolehanKursiKabupaten/'.$this->session->userdata('id_kab'));
        }
    }

    public function editPerolehanKursi($id_perolehan_kursi)
    {
        $data = [
            'title'         => 'Perolehan Kursi',
            'aktif'         => 'perolehan_kursi',
            'data'          => $this->Perolehan_kursi_model->getDataPerolehanKursiById($id_perolehan_kursi)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('perolehan_kursi/editPerolehanKursiKabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function editPerolehanKursi_proses($id_perolehan_kursi)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editPerolehanKursi($id_perolehan_kursi);
        }
        else
        {
            $this->Perolehan_kursi_model->editPerolehanKursi($id_perolehan_kursi);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('perolehan_kursi/detailPerolehanKursiKabupaten/'.$this->session->userdata('id_kab'));
        }
    }

    public function hapusPerolehanKursi($id_perolehan_kursi)
    {
        $this->db->where('id_perolehan_kursi',$id_perolehan_kursi);
        $this->db->delete('tb_perolehan_kursi');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Dihapus.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        redirect('perolehan_kursi/detailPerolehanKursiKabupaten/'.$this->session->userdata('id_kab'));
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_partai', 'Nama Partai', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Nama Partai wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('jumlah_kursi', 'Jumlah Kursi', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Jumlah Kursi wajib diisi'
        ]);
    }
}