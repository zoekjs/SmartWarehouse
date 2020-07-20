<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PurchaseOrder;
use Illuminate\Support\Facades\Mail;
use App\Mail\RememberOCPayment;


class RememberPaymentOC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remember:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remember the payment of pending oc';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       //$orders = \DB::table('purchase_order')->where('id_payment_status', 0)->where('id_status', 3)->get();
       $order = new PurchaseOrder();
       $orders = $order->getAprovedPOrders();
       if(count($orders) > 0){
        Mail::to('felipe@email.cl')->send(new RememberOCPayment($orders));
        Mail::to('javier@email.cl')->send(new RememberOCPayment($orders));
       }
       
    }
}
