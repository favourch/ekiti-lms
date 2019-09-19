<?php 
Class Settings_model extends CI_Model
{
    public function getFineValue()
    {
        $q = $this->db->query('SELECT fine FROM settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    } 
    public function getSettings()
    {
        $q = $this->db->query('SELECT * FROM settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    } 
    public function getSmsSettings()
    {
        $q = $this->db->query('SELECT * FROM sms_settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    } 
    public function updateSmsSettings($data)
    {
        $q = $this->db->update('sms_settings', $data);
        if ($q) {
            return TRUE;
        }
        return FALSE;
    } 
    public function updateSettings($data)
    {
        $q = $this->db->update('settings', $data);
      	if ($q) {
      		return TRUE;
      	}
        return FALSE;
    } 
    public function getGroupPermissions($id)
    {
        $q = $this->db->get_where('permissions', array('group_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
  
}
?>