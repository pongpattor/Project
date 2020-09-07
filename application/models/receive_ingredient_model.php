<?php
defined('BASEPATH') or exit('No direct script access allowed');

class receive_ingredient_model extends CI_Model
{
    public function fetchReceive(){
        $sql = "SELECT * FROM receive_ingredient ORDER BY RECEIVE_INGREDIENT_ID DESC";
        return $this->db->query($sql)->result();
    }

    public function maxIdReceiveIngredien(){
        $sql = "SELECT MAX(RECEIVE_INGREDIENT_ID) as ID FROM receive_ingredient";
        $result   = $this->db->query($sql)->result();
        foreach($result as $row){
            return $row->ID;
        }
    }
}