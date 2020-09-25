<?php


namespace App\Jobs;

/*use App\Mails\ImportDeliveryOrderSuccessReport;
use App\Models\DeliveryOrderHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;*/


class SendReportEmailJob
{
    private $currentDate;
    /**
     * Create a new job instance.
     *
     * @param Carbon $currentDate
     */
    /* public function __construct(Carbon $currentDate)
     {
         $this->currentDate = $currentDate;
     }

     /**
      * Execute the job.
      *
      * @return void
      */
    /* public function handle()
    {
        $deliveryOrders = DeliveryOrder::query()
            ->whereBetween('createdAt', [$this->currentDate->hour(0), $this->currentDate->addDay(1)->hour(0)])
            ->get();

        $mail = Mail::to(config('supervision.emails'));
        // pass objects to mail template
        $mail->send(
            new ImportDeliveryOrderSuccessReport([
                'deliveryOrders' => $deliveryOrders
            ])
        );
    }*/


}
