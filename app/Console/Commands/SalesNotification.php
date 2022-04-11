<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Payment;
use Carbon\Carbon;

class SalesNotification extends Command
{
	protected $signature = 'command:salesSend';
	protected $description = 'その日に売上をスラックに通知する';

	public function __construct()
	{
		parent::__construct();
	}

	public function handle()
	{
		$today = Carbon::today();
		$payments = Payment::whereDate('created_at', $today)->whereNull('refunded_at')->get();
		$sales = 0;
		foreach ($payments as $payment) {
			$sales+= $payment->total;
		}
		$payment = new Payment();
		$payment->sendSales($sales);
    }
}
