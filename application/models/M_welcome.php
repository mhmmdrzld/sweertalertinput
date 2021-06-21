<?php

class M_welcome extends CI_Model
{
    function get_data($nip)
    {
        $query = $this->db->where('nip=', $nip)->get('acpns');
        return $query;
    }
}
