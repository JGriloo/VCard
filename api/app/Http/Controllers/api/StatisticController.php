<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VCard;
use App\Models\Transaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Doctrine\DBAL\TransactionIsolationLevel;

class StatisticController extends Controller
{
    public function vcardStats(Vcard $vcard)
    {
        $id = $vcard->phone_number;
        $total = Transaction::where('vcard', '=', $id)->where('type', 'D')->sum('value') ?? 0;
        $max_transaction = Transaction::where('vcard', '=', $id)->max('value') ?? 0;
        $min_transaction = Transaction::where('vcard', '=', $id)->min('value') ?? 0;
        $avg_transaction = Transaction::where('vcard', '=', $id)->avg('value') ?? 0;
        $first = Transaction::where('vcard', '=', $id)->orderBy('datetime','ASC')->first()->datetime ?? 0;
        $last = Transaction::where('vcard', '=', $id)->orderBy('datetime','DESC')->first()->datetime ?? 0;
        $times_mbway = Transaction::where('vcard', '=', $id)->where('payment_type', 'MBWAY')->count();
        $times_vcard = Transaction::where('vcard', '=', $id)->where('payment_type', 'VCARD')->count();
        $times_paypal = Transaction::where('vcard', '=', $id)->where('payment_type', 'PAYPAL')->count();
        $times_mb = Transaction::where('vcard', '=', $id)->where('payment_type', 'MB')->count();
        $times_visa = Transaction::where('vcard', '=', $id)->where('payment_type', 'VISA')->count();
        $times_iban = Transaction::where('vcard', '=', $id)->where('payment_type', 'IBAN')->count();

        $stats = array(
            'total' => $total,
            'max_transaction' => $max_transaction,
            'min_transaction' => $min_transaction,
            'avg_transaction' => $avg_transaction,
            'first' => $first,
            'last' => $last,
            'times_mbway' => $times_mbway,
            'times_vcard' => $times_vcard,
            'times_paypal' => $times_paypal,
            'times_mb' => $times_mb,
            'times_visa' => $times_visa,
            'times_iban' => $times_iban
        );
        return $stats;
    }

    //Count and sum all vcard' balances in the whole platform on undeleted vcards
    //Can also count the transactions made with a specific type
    public function adminStats(Request $request)
    {
        $payment_type = $request->input('payment_type');

        $count_vcards = VCard::count('phone_number');
        $count_transactions = Transaction::count('id');
        $sum_balance_vcards = VCard::sum('balance');
        $average_transaction = (Transaction::where('type', 'D')->sum('value')) / $count_transactions;
        $transactions_per_payment = Transaction::where('payment_type', '=', $payment_type)->count();

        $stats = array(
            'total_vcards' => $count_vcards,
            'total_transactions' => $count_transactions,
            'sum_balances' => $sum_balance_vcards,
            'average_transaction' => $average_transaction,
            'transactions_per_payment' => $transactions_per_payment,
        );
        return $stats;
    }
}