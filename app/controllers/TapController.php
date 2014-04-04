<?php

class TapController extends BaseController {

	public function index()
	{
		$data['taps'] = Tap::orderBy('id')->get();

		$this->loadFormViewData($data);

		return View::make('taps.index', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 *
	public function store()
	{
		$tap = new Tap;
		$tap->save();
		$validator = $this->validate();

		return Redirect::action('TapController@index');
	}*/

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$tap = Tap::find($id);
		$this->mapToDomain($tap);
		$tap->save();

		return Response::json(array('success' => true));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$tap = Tap::find($id);
		$tap->delete();
	}

	private function mapToDomain($tap){
		$tap->name       = Input::get('name');
		$tap->batchId 	 = null;
		if( Input::get('batchId') != "" )
			$tap->batchId = Input::get('batchId');
	}

	private function loadFormViewData(&$data){

		$batchList = array( '' => Lang::get('common.NoBeerOnTap') );
		$batches = Batch::GetAllActive();
		foreach($batches as $batch){
			$batchList = array_add($batchList, $batch->id, $batch->Beer->name);
		}
		$data['batchList'] = $batchList;
	}

}
