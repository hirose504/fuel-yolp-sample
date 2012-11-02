<?php

namespace Yolp;

class Controller_Sample extends \Controller
{
	function action_static($lat = null, $lon = null, $z = null)
	{
		is_null($lat) and $lat = \Input::get('lat', '35.665662327484');
		is_null($lon) and $lon = \Input::get('lon', '139.73091159273');
		is_null($z)   and $z   = \Input::get('z',   '16');

		$response = StaticMap::image(compact('lat', 'lon', 'z'));

		$response->set_header('Content-Type', 'image/png');
		$response->set_header('Content-length', strlen($response->body()));
		return $response;

// 		return \Response::forge(\View::forge('sample/static', compact('response')));
	}

	function action_search($lat = null, $lon = null, $z = null)
	{
		$width = 500;
		$height = 500;

		$query = \Input::get('query', '');

		is_null($lat) and is_null($lat = $this->param('lat')) and $lat = \Input::get('lat', '35.665662327484');
		is_null($lon) and is_null($lon = $this->param('lon')) and $lon = \Input::get('lon', '139.73091159273');
		is_null($z)   and is_null($z   = $this->param('z'))   and $z   = \Input::get('z',   '16');

		$dx = \Input::get('x', ($width/2))  - ($width/2);
		$dy = \Input::get('y', ($height/2)) - ($height/2);

		$xml = StaticMap::xml(compact('lat', 'lon', 'z', 'width', 'height', 'dx', 'dy'));

		list($lon, $lat) = explode(',', $xml->coordinates());

		$bbox  = $xml->bbox();
		$group = 'gid';
		$sort  = 'hybrid';

		$localsearch = LocalSearch::xml(compact('query', 'bbox', 'group', 'sort'));
		$response = $localsearch->body();

		$pins = $localsearch->pins();

		$image = StaticMap::image(array_merge(compact('lat', 'lon', 'z', 'width', 'height'), $pins));

		return \Response::forge(\View::forge('sample/search', compact('response', 'image', 'lat', 'lon', 'z')));
	}

	function action_view($gid = null, $z = null)
	{
		is_null($gid) and is_null($gid = $this->param('gid')) and $gid = \Input::get('gid');
		is_null($z)   and is_null($z   = $this->param('z'))   and $z   = \Input::get('z', '18');

		$group = 'gid';

		$localsearch = LocalSearch::xml(compact('gid', 'group'));
		$response = $localsearch->body();

		$pin = $localsearch->pin('default');

		$image = StaticMap::image(array_merge(compact('z'), $pin));

		return \Response::forge(\View::forge('sample/view', compact('response', 'image')));
	}
}