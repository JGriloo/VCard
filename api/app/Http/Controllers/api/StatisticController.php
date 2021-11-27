<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\VCard;
use App\Models\Transaction;


class StatisticController extends Controller
{
    public function vcardStats(Vcard $vcard)
    {
        $id = $vcard->phone_number;
        $total = Transaction::where('vcard', '=', $id)->sum('value') ?? 0;
        $max_transaction = Transaction::where('vcard', '=', $id)->max('value') ?? 0;
        $min_transaction = Transaction::where('vcard', '=', $id)->min('value') ?? 0;
        $avg_transaction = Transaction::where('vcard', '=', $id)->avg('value') ?? 0;
        $first = Transaction::where('vcard', '=', $id)->orderBy('datetime','ASC')->first()->datetime ?? 0;
        $last = Transaction::where('vcard', '=', $id)->orderBy('datetime','DESC')->first()->datetime ?? 0;

        $stats = array(
            'total' => $total,
            'max_transaction' => $max_transaction,
            'min_transaction' => $min_transaction,
            'avg_transaction' => $avg_transaction,
            'first' => $first,
            'last' => $last,
        );
        return $stats;
    }

    //Statistic to a specific vcard that only users can use
    public function transactionsPerDate(Request $request)
    {
                // Retrieve any filters
        $from_date = Carbon::parse($request->from_date)
                ->toDateTimeString();
        $to_date = Carbon::parse($request->to_date)
                ->toDateTimeString();
        $vcard = $request->input('vcard');

               // dd($fromDate);
        return Transaction::whereBetween('created_at', [$from_date, $to_date])
        ->where('vcard', '=', $vcard)
        ->where('deleted_at', '=', null)
        ->get();
    }

    //Count and sum all vcard' balances in the whole platform on undeleted vcards
    //Can also count the transactions made with a specific type
    public function adminStats(Request $request)
    {
        $payment_type = $request->input('payment_type');

        $count_vcards = VCard::count('phone_number');
        $sum_balance_vcards = VCard::sum('balance');
        $transactions_per_payment = Transaction::where('payment_type', '=', $payment_type)->count();

        $stats = array(
            'number_of_vcards' => $count_vcards,
            'sum_balances' => $sum_balance_vcards,
            'transactions_per_payment' => $transactions_per_payment,
        );
        dd($stats);
        return $stats;
    }

    //Statistics that onyl the admins can access and can filter by date. Sum and count of all transactions between
    //2 dates
    public function adminStatsPerDate(Request $request)
    {
        $from_date = Carbon::parse($request->from_date)
                ->toDateTimeString();
        $to_date = Carbon::parse($request->to_date)
                ->toDateTimeString();

        $count_transactions = Transaction::whereBetween('date', [$from_date, $to_date])
            ->count();
        $sum_transactions = Transaction::whereBetween('date', [$from_date, $to_date])->sum('value');

        $stats = array(
            'count_transactions' => $count_transactions,
            'sum_transactions' => $sum_transactions,
        );
        dd($stats);
        return $stats;
    }
}