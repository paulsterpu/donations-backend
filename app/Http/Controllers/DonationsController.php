<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\DonationOffer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DonationsController extends Controller
{
    private function buildQuery(Request $request, $table) {

        $query =  DB::table($table);

        if ($request->has('expired') && $request->has('available')) {

            if ($request->input('expired') !== $request->input('available')) {
                if ($request->input('expired') === 'false') {
                    $query->where('data_limita', '>', date("Y-m-d"));

                } else {
                    $query->where('data_limita', '<', date("Y-m-d"));
                }

            } else {
                //get all donations, both expired and available by not specifying a where clause
            }
        }

        if ($request->has('fulfilled') && $request->has('unfulfilled')) {

            if ($request->input('fulfilled') !== $request->input('unfulfilled')) {
                $query->where('fulfilled', '=', ($request->input('fulfilled') === 'true' ? 1 : 0));

            } else {
                //get all donations, both fulfilled and unfulfilled by not specifying a where clause
            }
        }

        if ($request->has('order_by') && $request->has('sort_type')) {
            $query->orderBy($request->input('order_by'), $request->input('sort_type'));
        }

        if ($request->has('offset')) {
            $query->offset($request->input('offset'));
        }

        if ($request->has('limit')) {
            $query->limit($request->input('limit'));
        }

        return $query;
    }

    public function getDonations(Request $request) {

        $query = $this->buildQuery($request, $request->input('table'));

        $donation_offers = $query->get();

        return response()->json(
            $donation_offers
        , 200);
    }

    public function getDonationsCount(Request $request) {

        $query = $this->buildQuery($request, $request->input('table'));

        $donations = $query->get();

        return response()->json(
            count($donations)
            , 200);
    }

    public function createDonationOffer(Request $request) {

        $user_id = Auth::user()["id"];

        $donation = new DonationOffer($request->all());

        $donation->data_publicare = date("Y-m-d");
        $donation->user_id = $user_id;
        $donation->fulfilled = false;

        $donation->save();

        return $donation;
    }
}


