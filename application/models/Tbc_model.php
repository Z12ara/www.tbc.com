<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tbc_model extends CI_Model {

    // Tabel penyakit
    public function get_all_penyakit() {
    return $this->db->get('penyakit')->result();
}

    public function insert_penyakit($data) {
        return $this->db->insert('penyakit', $data);
    }

    public function update_penyakit($id, $data) {
        $this->db->where('id_penyakit', $id);
        return $this->db->update('penyakit', $data);
    }

    public function delete_penyakit($id) {
        $this->db->where('id_penyakit', $id);
        return $this->db->delete('penyakit');
    }

    // Tabel gejala
    public function get_all_gejala() {
        return $this->db->get('gejala')->result();
    }

    public function insert_gejala($data) {
        return $this->db->insert('gejala', $data);
    }

    public function update_gejala($id, $data) {
        $this->db->where('id_gejala', $id);
        return $this->db->update('gejala', $data);
    }

    public function delete_gejala($id) {
        $this->db->where('id_gejala', $id);
        return $this->db->delete('gejala');
    }

    // Tabel gejala_penyakit
    public function get_all_gejala_penyakit() {
        return $this->db->get('gejala_penyakit')->result();
    }

    public function insert_gejala_penyakit($data) {
        return $this->db->insert('gejala_penyakit', $data);
    }

    public function update_gejala_penyakit($id, $data) {
        $this->db->where('id_relasi', $id);
        return $this->db->update('gejala_penyakit', $data);
    }

    public function delete_gejala_penyakit($id) {
        $this->db->where('id_relasi', $id);
        return $this->db->delete('gejala_penyakit');
    }

    // Tabel hasil_analisis
    public function get_all_hasil() {
        return $this->db->get('hasil_analisis')->result();
    }

    public function insert_hasil($data) {
        return $this->db->insert('hasil_analisis', $data);
    }

    public function update_hasil($id, $data) {
        $this->db->where('id_analisis', $id);
        return $this->db->update('hasil_analisis', $data);
    }

    public function delete_hasil($id) {
        $this->db->where('id_analisis', $id);
        return $this->db->delete('hasil_analisis');
    }
}
