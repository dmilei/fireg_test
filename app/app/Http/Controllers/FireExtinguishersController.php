<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFireExtinguisherRequest;
use App\Http\Requests\UpdateFireExtinguisher;
use App\Models\FireExtinguisher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class FireExtinguishersController extends Controller
{
    /**
     * Return list of FireExtinguishers.
     *
     */
    public function index()
    {
        $response = FireExtinguisher::all()->load(['customerSite', 'equipmentType']);

        return response()->json($response, JsonResponse::HTTP_OK);
    }

    /**
     * Store a new FireExtinguisher.
     *
     * @param  StoreFireExtinguisherRequest  $request
     */
    public function store(StoreFireExtinguisherRequest $request)
    {
        $response[0] = FireExtinguisher::create($request->except(['replicas']));

        if ($request->input('replicas') >= 2) {
            for ($i = 1; $i < $request->input('replicas'); $i++) {
                $response[$i] = $response[0]->replicate();
                $response[$i]->save();
            }
        }

        return response()->json($response, JsonResponse::HTTP_OK);
    }

    /**
     * Update the specified FireExtinguisher in storage.
     *
     * @param  UpdateFireExtinguisher $request
     * @param  FireExtinguisher  $fireExtinguisher
     */
    public function update(UpdateFireExtinguisher $request, FireExtinguisher  $fireExtinguisher)
    {
        if ($request->input('action_type') === FireExtinguisher::MAINTENANCE) {
            $fireExtinguisher->update(['maintenance_date' => $request->input('date')]);
        } elseif ($request->input('action_type') === FireExtinguisher::PERIODIC_CHECK) {
            $quarter = Carbon::createFromFormat('Y-m-d', $request->input('date'))->quarter;
            $fireExtinguisher->update(["q{$quarter}_check" => $request->input('date')]);
        }

        if ($request->input('comments')) {
            $fireExtinguisher->update(['comments' => $request->input('comments')]);
        }

        return response()->json($fireExtinguisher, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified FireExtinguisher from storage.
     *
     * @param  FireExtinguisher  $fireExtinguisher
     */
    public function destroy(FireExtinguisher  $fireExtinguisher)
    {
        $fireExtinguisher->delete();

        return response()->json([], JsonResponse::HTTP_OK);
    }
}
