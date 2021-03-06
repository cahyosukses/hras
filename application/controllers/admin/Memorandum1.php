<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Memorandum1 controllers class
 * 
 * @package     HRA CMS
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Achyar Anshorie
 */
class Memorandum1 extends CI_Controller {

    public function __construct() {
        parent::__construct(TRUE);
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('Memorandum1_model', 'Activity_log_model', 'Employe_model', 'Memorandum2_model', 'Setting_model'));
        $this->load->helper('string');
    }

    // Memorandum view in list
    public function index($offset = NULL) {
        $this->load->library('pagination');

        // Apply Filter
        // Get $_GET variable
        $q = $this->input->get(NULL, TRUE);

        $data['q'] = $q;
        $params = array();

        // Employe Nik
        if (isset($q['n']) && !empty($q['n']) && $q['n'] != '') {
            $params['memorandum_employe_nik'] = $q['n'];
        }

        $params['present'] = 0;
        $paramsPage = $params;
        $params['limit'] = 10;
        $params['offset'] = $offset;


        $data['memorandum'] = $this->Memorandum1_model->get($params);
        $data['memorandum2'] = $this->Memorandum2_model->get();
        $config['base_url'] = site_url('admin/memorandum1/index');
        $config['total_rows'] = count($this->Memorandum1_model->get($paramsPage));
        $this->pagination->initialize($config);

        $data['title'] = 'Surat Panggilan 1';
        $data['main'] = 'admin/memorandum1/memorandum_list';
        $this->load->view('admin/layout', $data);
    }    

    function detail($id = NULL) {
        if ($this->Memorandum1_model->get(array('id' => $id)) == NULL) {
            redirect('admin/memorandum1');
        }
        $data['memorandum'] = $this->Memorandum1_model->get(array('id' => $id));
        $data['memorandum2'] = $this->Memorandum2_model->get(array('memorandum1_id' => $id));
        $data['title'] = 'Surat Panggilan 1';
        $data['main'] = 'admin/memorandum1/memorandum_view';
        $this->load->view('admin/layout', $data);
    }

    // Add Memorandum and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');
        if ($this->input->post('from_finished')) {
            $this->form_validation->set_rules('memorandum_finished_desc', 'Keterangan', 'trim|required|xss_clean');
        } else {
            $this->form_validation->set_rules('memorandum_absent_date', 'Tanggal Mangkir', 'trim|required|xss_clean');
            $this->form_validation->set_rules('memorandum_date_sent', 'Tanggal Kirim', 'trim|required|xss_clean');
            $this->form_validation->set_rules('memorandum_call_date', 'Tanggal Panggilan', 'trim|required|xss_clean');
        }
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {

            if ($this->input->post('memorandum_id')) {
                $params['memorandum_id'] = $this->input->post('memorandum_id');
            } else {
                $lastnumber = $this->Memorandum1_model->get(array('limit' => 1, 'order_by' => 'memorandum_id'));
                $num = $lastnumber['memorandum_number'];
                $params['memorandum_number'] = sprintf('%04d', $num + 01);
                $params['memorandum_input_date'] = date('Y-m-d H:i:s');
            }

            $params['memorandum_finished_desc'] = $this->input->post('memorandum_finished_desc');
            $params['memorandum_email_date'] = $this->input->post('memorandum_email_date');
            $params['memorandum_absent_date'] = $this->input->post('memorandum_absent_date');
            $params['memorandum_date_sent'] = $this->input->post('memorandum_date_sent');
            $params['memorandum_call_date'] = $this->input->post('memorandum_call_date');
            $params['memorandum_employe_nik'] = $this->input->post('employe_nik');
            $params['memorandum_employe_name'] = $this->input->post('employe_name');
            $params['memorandum_employe_position'] = $this->input->post('employe_position');
            $params['memorandum_employe_address'] = $this->input->post('employe_address');
            $params['memorandum_employe_phone'] = $this->input->post('employe_phone');
            $params['user_id'] = $this->session->userdata('user_id');
            $params['memorandum_last_update'] = date('Y-m-d H:i:s');
            $status = $this->Memorandum1_model->add($params);


            // activity log
            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id'),
                    'log_module' => 'Surat Panggilan 1',
                    'log_action' => $data['operation'],
                    'log_info' => 'ID:' . $status . ';Title:NULL'
                    )
                );
            if ($this->input->post('from_finished')) {
                $this->session->set_flashdata('success', ' Surat Panggilan Selesai');
                redirect('admin/memorandum');
            } else {
                $this->session->set_flashdata('success', $data['operation'] . ' Surat Panggilan berhasil');
                redirect('admin/memorandum1');
            }
        } else {
            if ($this->input->post('memorandum_id')) {
                redirect('admin/memorandum/edit/' . $this->input->post('memorandum_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                $data['memorandum'] = $this->Memorandum1_model->get(array('id' => $id));
            }
            $data['employe'] = $this->Employe_model->get();
            $data['title'] = $data['operation'] . ' Surat Panggilan 1';
            $data['main'] = 'admin/memorandum1/memorandum_add';
            $this->load->view('admin/layout', $data);
        }
    }

    // Delete Memorandum
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Memorandum1_model->delete($this->input->post('del_id'));
            // activity log
            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id'),
                    'log_module' => 'Surat Panggilan 1',
                    'log_action' => 'Hapus',
                    'log_info' => 'ID:' . $this->input->post('del_id') . ';Title:' . $this->input->post('del_name')
                    )
                );
            $this->session->set_flashdata('success', 'Hapus Surat Panggilan berhasil');
            redirect('admin/memorandum1');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/memorandum1/edit/' . $id);
        }
    }

    function multiple() {
        $action = $this->input->post('action');
        if ($action == "delete") {
            $delete = $this->input->post('msg');
            for ($i = 0; $i < count($delete); $i++) {
                $this->Memorandum1_model->delete($delete[$i]);
            }
        } elseif ($action == "printPdf") {
            $this->load->helper(array('dompdf'));
            $this->load->helper(array('tanggal'));
            $memo = $this->input->post('msg');
            for ($i = 0; $i < count($memo); $i++) {
                $print[] = $memo[$i];
            }
            $data['setting_address'] = $this->Setting_model->get(array('id' => 2));
            $data['setting_pic'] = $this->Setting_model->get(array('id' => 4));
            $data['setting_employe_name'] = $this->Setting_model->get(array('id' => 6));
            $data['setting_employe_position'] = $this->Setting_model->get(array('id' => 7)); 
            $data['setting_city'] = $this->Setting_model->get(array('id' => 3));
            $data['memorandum'] = $this->Memorandum1_model->get(array('multiple_id' => $print));

            $html = $this->load->view('admin/memorandum1/memorandum_multiple_pdf', $data, true);
            $data = pdf_create($html, '$paper', TRUE);
        }
        elseif ($action == "printEnvl") {
            $this->load->helper(array('dompdf'));
            $this->load->helper(array('tanggal'));
            $memo = $this->input->post('msg');
            for ($i = 0; $i < count($memo); $i++) {
                $print[] = $memo[$i];
            }
            $data['memorandum'] = $this->Memorandum1_model->get(array('multiple_id' => $print));

            $html = $this->load->view('admin/memorandum1/memorandum_multi_envelope', $data, true);
            $data = pdf_create($html, '$paper', TRUE);
        }
        redirect('admin/memorandum1');
    }

    function printPdf($id = NULL) { 
        $this->load->helper(array('dompdf'));
        $this->load->helper(array('tanggal'));
        if ($id == NULL)
            redirect('admin/memorandum1');

        $data['setting_address'] = $this->Setting_model->get(array('id' => 2));
        $data['setting_pic'] = $this->Setting_model->get(array('id' => 4));
        $data['setting_employe_name'] = $this->Setting_model->get(array('id' => 6));
        $data['setting_employe_position'] = $this->Setting_model->get(array('id' => 7)); 
        $data['setting_city'] = $this->Setting_model->get(array('id' => 3));

        $data['memorandum'] = $this->Memorandum1_model->get(array('id' => $id));

        $html = $this->load->view('admin/memorandum1/memorandum_pdf', $data, true);
        $data = pdf_create($html, '$paper', TRUE);
    }

    function printEnvl($id = NULL) {
        $this->load->helper(array('dompdf'));
        $this->load->helper(array('tanggal'));
        if ($id == NULL)
            redirect('admin/memorandum1');

        $data['memorandum'] = $this->Memorandum1_model->get(array('id' => $id));

        $html = $this->load->view('admin/memorandum1/memorandum_envelope', $data, true);
        $data = pdf_create($html, '', TRUE, 'A4', TRUE);
    }

    function present($id = NULL) {
        $this->Memorandum1_model->add(array('memorandum_id' => $id, 'memorandum_is_present' => 1));
        $this->session->set_flashdata('success', 'Sunting Surat Panggilan berhasil');
        redirect('admin/memorandum1');
    }

}

/* End of file memorandum.php */
/* Location: ./application/controllers/admin/memorandum.php */
