<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Employe Model Class
 *
 * @package     SYSCMS
 * @subpackage  Models
 * @category    Models
 * @author      Sistiandy Syahbana nugraha <sistiandy.web.id>
 */
class Employe_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('employe.employe_id', $params['id']);
        }

        if (isset($params['employe_nik'])) {
            $this->db->where('employe.employe_nik', $params['employe_nik']);
        }

        if (isset($params['date_start']) AND isset($params['date_end'])) {
            $this->db->where('employe_published_date >=', $params['date_start'] . ' 00:00:00');
            $this->db->where('employe_published_date <=', $params['date_end'] . ' 23:59:59');
        }

        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('employe_id', 'desc');
        }

        $this->db->select('employe.employe_id, employe_nik, employe_name, employe_phone, employe_address,
            employe_divisi, employe_account, employe_unit, employe_bussiness, employe_position, employe_departement, employe_date_register');
        $res = $this->db->get('employe');

        if (isset($params['id']) OR (isset($params['limit']) AND $params['limit'] == 1) OR (isset($params['date']) AND isset($params['member_nip']))) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    // Add and update to database
    function add($data = array()) {

        if (isset($data['employe_id'])) {
            $this->db->set('employe_id', $data['employe_id']);
        }

        if (isset($data['employe_nik'])) {
            $this->db->set('employe_nik', $data['employe_nik']);
        }

        if (isset($data['employe_name'])) {
            $this->db->set('employe_name', $data['employe_name']);
        }

        if (isset($data['employe_phone'])) {
            $this->db->set('employe_phone', $data['employe_phone']);
        }

        if (isset($data['employe_address'])) {
            $this->db->set('employe_address', $data['employe_address']);
        }

        if (isset($data['employe_divisi'])) {
            $this->db->set('employe_divisi', $data['employe_divisi']);
        }

        if (isset($data['employe_position'])) {
            $this->db->set('employe_position', $data['employe_position']);
        }

        if (isset($data['employe_account'])) {
            $this->db->set('employe_account', $data['employe_account']);
        }

        if (isset($data['employe_unit'])) {
            $this->db->set('employe_unit', $data['employe_unit']);
        }

        if (isset($data['employe_bussiness'])) {
            $this->db->set('employe_bussiness', $data['employe_bussiness']);
        }

        if (isset($data['employe_departement'])) {
            $this->db->set('employe_departement', $data['employe_departement']);
        }

        if (isset($data['employe_date_register'])) {
            $this->db->set('employe_date_register', $data['employe_date_register']);
        }

        if (isset($data['employe_id'])) {
            $this->db->where('employe_id', $data['employe_id']);
            $this->db->update('employe');
            $id = $data['employe_id'];
        } else {
            $this->db->insert('employe');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Delete to database
    function delete($id) {
        $this->db->where('employe_id', $id);
        $this->db->delete('employe');
    }

     // Delete all to database
    function delete_all() {
        $this->db->truncate('employe');
    }

    public function is_exist($field, $value)
    {
        $this->db->where($field, $value);        

        return $this->db->count_all_results('employe') > 0 ? TRUE : FALSE;
    }

    public function import_employe($data_excel) {
        $count = 0;

        for ($i = 1; $i < count($data_excel); $i++) {
            if ( ! $this->is_exist('employe_nik', $data_excel[$i]['employe_nik']))
            {
            $data = array(
                'employe_nik' => $data_excel[$i]['employe_nik'],
                'employe_name' => $data_excel[$i]['employe_name'],
                'employe_account' => $data_excel[$i]['employe_account'],
                'employe_address' => $data_excel[$i]['employe_address'],
                'employe_date_register' => $data_excel[$i]['employe_date_register'],
                'employe_position' => $data_excel[$i]['employe_position'],
                'employe_divisi' => $data_excel[$i]['employe_divisi'],
                'employe_departement' => $data_excel[$i]['employe_departement'],
                'employe_unit' => $data_excel[$i]['employe_unit'],
                'employe_bussiness' => $data_excel[$i]['employe_bussiness'],
                'employe_phone' => $data_excel[$i]['employe_phone'],
            );

            $this->db->insert('employe', $data);

            $count++;
        }
    }

        return $count > 0 ? TRUE : FALSE;
    }

}
