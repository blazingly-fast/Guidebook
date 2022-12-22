<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use App\Http\Resources\PlaceResource;
use App\Models\Guidebook;
use App\Models\Place;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlacesController extends Controller
{
	use HttpResponses;
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Guidebook $guidebook)
	{
		return PlaceResource::collection(
			Place::where('guidebook_id', $guidebook->id)->get()
		);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StorePlaceRequest $request)
	{

		$claimsID = Guidebook::where('id', $request->guidebook_id)->pluck('user_id')->first();

		if (Auth::user()->id !== $claimsID) {
			return $this->error('', 'You are not authorized to make this request', 403);
		}

		$request->validated();

		$place = Place::create([
			'guidebook_id' => $request->guidebook_id,
			'title' => $request->title,
			'description' => $request->description
		]);

		return new PlaceResource($place);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$place = Place::whereId($id)->first();

		if ($place == null) {
			return $this->error('', 'place does not exist', 404);
		}
		return new PlaceResource($place);
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
	 * @param  Place  $place
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdatePlaceRequest $request, Place $place)
	{
		$request->validated();

		return $this->isNotAuthorized($place) ? $this->isNotAuthorized($place) : $place->update($request->all());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Place  $place
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Place $place)
	{
		return $this->isNotAuthorized($place) ? $this->isNotAuthorized($place) : $place->delete();
	}

	private function isNotAuthorized($place)
	{
		$claimsID = Guidebook::where('id', $place->guidebook_id)->pluck('user_id')->first();

		if (Auth::user()->id !== $claimsID) {
			return $this->error('', 'You are not authorized to make this request', 403);
		}
	}
}
