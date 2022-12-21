<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuidebookRequest;
use App\Http\Requests\UpdateGuidebookRequest;
use App\Http\Resources\GuidebookResource;
use App\Models\Guidebook;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuidebookController extends Controller
{
	use HttpResponses;
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return GuidebookResource::collection(
			Guidebook::all()
		);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreGuidebookRequest $request)
	{
		$request->validated();

		$guidebook = Guidebook::create([
			'user_id' => Auth::user()->id,
			'title' => $request->title,
			'description' => $request->description
		]);

		return new GuidebookResource($guidebook);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$guidebook = Guidebook::whereId($id)->first();

		return new GuidebookResource($guidebook);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateGuidebookRequest $request, Guidebook $guidebook)
	{
		if (Auth::user()->id !== $guidebook->user_id) {
			return $this->error('', 'You are not authorized to make this request', 403);
		}

		$request->validated();

		$guidebook->update($request->all());

		return new GuidebookResource($guidebook);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Guidebook $guidebook)
	{
		return $this->isNotAuthorized($guidebook) ? $this->isNotAuthorized($guidebook) : $guidebook->delete();
	}

	private function isNotAuthorized($guidebook)
	{
		if (Auth::user()->id !== $guidebook->user_id) {
			return $this->error('', 'You are not authorized to make this request', 403);
		}
	}
}