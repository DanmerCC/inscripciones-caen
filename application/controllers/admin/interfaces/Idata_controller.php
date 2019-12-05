<?php
/*
Esta interfaz se implementara
*/
interface Idata_controller
{
	public function index();
	public function dataTable();
	public function save();
	public function update();
	public function edit($data_item_id=-1);
	public function delete();
}
?>
