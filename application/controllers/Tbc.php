<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tbc extends CI_Controller {

    public function __construct() {
    parent::__construct();
    $this->load->model('Tbc_model'); // PENTING: singular!
    $this->load->helper('url');
    }

    public function index() {
        $data['penyakit'] = $this->Tbc_model->get_all_penyakit();
        $data['gejala'] = $this->Tbc_model->get_all_gejala();
        $data['gejala_penyakit'] = $this->Tbc_model->get_all_gejala_penyakit();
        $data['hasil'] = $this->Tbc_model->get_all_hasil();

        $this->load->view('tbc_view', $data);
    }

    // CRUD Penyakit
    public function tambah_penyakit() {
        $data = [
            'nama_penyakit' => $this->input->post('nama'),
            'probabilitas_prior' => $this->input->post('prob')
        ];
        $this->Tbc_model->insert_penyakit($data);
        redirect('tbc');
    }

    public function edit_penyakit($id) {
        $data = [
            'nama_penyakit' => $this->input->post('nama'),
            'probabilitas_prior' => $this->input->post('prob')
        ];
        $this->Tbc_model->update_penyakit($id, $data);
        redirect('tbc');
    }
    public function edit_penyakit_form($id) {
    $data['penyakit'] = $this->Tbc_model->get_all_penyakit();
    $data['gejala'] = $this->Tbc_model->get_all_gejala();
    $data['gejala_penyakit'] = $this->Tbc_model->get_all_gejala_penyakit();
    $data['hasil'] = $this->Tbc_model->get_all_hasil();
    $data['edit'] = $this->db->get_where('penyakit', ['id_penyakit' => $id])->row();

    $this->load->view('tbc_view', $data);
}


    public function hapus_penyakit($id) {
        $this->Tbc_model->delete_penyakit($id);
        redirect('tbc');
    }

    // CRUD Gejala-Penyakit
public function tambah_relasi() {
    $data = [
        'id_penyakit' => $this->input->post('id_penyakit'),
        'id_gejala' => $this->input->post('id_gejala'),
        'probabilitas_if_penyakit' => $this->input->post('p_true'),
        'probabilitas_if_tidak_penyakit' => $this->input->post('p_false')
    ];
    $this->Tbc_model->insert_gejala_penyakit($data);
    redirect('tbc');
}

public function edit_relasi($id) {
    $data = [
        'id_penyakit' => $this->input->post('id_penyakit'),
        'id_gejala' => $this->input->post('id_gejala'),
        'probabilitas_if_penyakit' => $this->input->post('p_true'),
        'probabilitas_if_tidak_penyakit' => $this->input->post('p_false')
    ];
    $this->Tbc_model->update_gejala_penyakit($id, $data);
    redirect('tbc');
}

public function hapus_relasi($id) {
    $this->Tbc_model->delete_gejala_penyakit($id);
    redirect('tbc');
}

public function edit_relasi_form($id) {
    $data['penyakit'] = $this->Tbc_model->get_all_penyakit();
    $data['gejala'] = $this->Tbc_model->get_all_gejala();
    $data['gejala_penyakit'] = $this->Tbc_model->get_all_gejala_penyakit();
    $data['hasil'] = $this->Tbc_model->get_all_hasil();
    $data['edit_relasi'] = $this->db->get_where('gejala_penyakit', ['id_relasi' => $id])->row();

    $this->load->view('tbc_view', $data);
}
    // CRUD Hasil Analisis
public function tambah_hasil() {
    $data = [
        'id_penyakit' => $this->input->post('id_penyakit'),
        'id_gejala' => $this->input->post('id_gejala'),
        'probabilitas_total_gejala' => $this->input->post('total'),
        'probabilitas_posterior' => $this->input->post('posterior')
    ];
    $this->Tbc_model->insert_hasil($data);
    redirect('tbc');
}

public function edit_hasil($id) {
    $data = [
        'id_penyakit' => $this->input->post('id_penyakit'),
        'id_gejala' => $this->input->post('id_gejala'),
        'probabilitas_total_gejala' => $this->input->post('total'),
        'probabilitas_posterior' => $this->input->post('posterior')
    ];
    $this->Tbc_model->update_hasil($id, $data);
    redirect('tbc');
}

public function hapus_hasil($id) {
    $this->Tbc_model->delete_hasil($id);
    redirect('tbc');
}

public function edit_hasil_form($id) {
    $data['penyakit'] = $this->Tbc_model->get_all_penyakit();
    $data['gejala'] = $this->Tbc_model->get_all_gejala();
    $data['gejala_penyakit'] = $this->Tbc_model->get_all_gejala_penyakit();
    $data['hasil'] = $this->Tbc_model->get_all_hasil();
    $data['edit_hasil'] = $this->db->get_where('hasil_analisis', ['id_analisis' => $id])->row();

    $this->load->view('tbc_view', $data);
}

public function diagnosa() {
    $gejala_terpilih = $this->input->post('gejala_id');

    if (!$gejala_terpilih) {
        $data['gejala'] = $this->Tbc_model->get_all_gejala();
        $this->load->view('diagnosa_view', $data);
        return;
    }

    $penyakit = $this->Tbc_model->get_all_penyakit();
    $gejala_penyakit = $this->Tbc_model->get_all_gejala_penyakit();

    if (!$penyakit || !is_array($penyakit)) {
        $data['gejala'] = $this->Tbc_model->get_all_gejala();
        $data['error'] = "Data penyakit tidak tersedia.";
        $this->load->view('diagnosa_view', $data);
        return;
    }

    $hasil = [];

    foreach ($penyakit as $p) {
        $p_tbc = $p->probabilitas_prior;
        $p_not = 1 - $p_tbc;

        $p_gejala_given_tbc = 1;
        $p_gejala_given_not = 1;

        foreach ($gejala_terpilih as $idg) {
            foreach ($gejala_penyakit as $relasi) {
                if ($relasi->id_penyakit == $p->id_penyakit && $relasi->id_gejala == $idg) {
                    $p_gejala_given_tbc *= $relasi->probabilitas_if_penyakit;
                    $p_gejala_given_not *= $relasi->probabilitas_if_tidak_penyakit;
                }
            }
        }

        $p_evidence = ($p_gejala_given_tbc * $p_tbc) + ($p_gejala_given_not * $p_not);
        $posterior = $p_evidence != 0 ? ($p_gejala_given_tbc * $p_tbc) / $p_evidence : 0;

        $hasil[] = [
            'penyakit' => $p->nama_penyakit,
            'probabilitas' => $posterior
        ];
    }

    usort($hasil, function ($a, $b) {
        return $b['probabilitas'] <=> $a['probabilitas'];
    });

    $data['gejala'] = $this->Tbc_model->get_all_gejala();
    $data['hasil'] = $hasil[0];

    $this->load->view('diagnosa_view', $data);
}

public function tambah_gejala() {
    $data = [
        'nama_gejala' => $this->input->post('nama_gejala')
    ];
    $this->Tbc_model->insert_gejala($data);
    redirect('tbc/diagnosa');
}
}
