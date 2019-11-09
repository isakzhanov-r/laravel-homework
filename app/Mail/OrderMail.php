<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->to($this->getEmails());
        $this->from(config('mail.from.address'), config('mail.from.name'));
        $this->subject("заказ №({$this->order->id}) завершен");
        $totalSum = $this->getTotalSum();

        return $this->markdown('mail')->with(['order' => $this->order] + compact('totalSum'));
    }

    private function getEmails(): array
    {
        $emails = collect();
        $emails->push($this->order->partner->email);
        $this->order
            ->products
            ->each(function (Product $product) use ($emails) {
                $emails->push($product->vendor->email);
            });

        return $emails->toArray();
    }

    private function getTotalSum()
    {
        return $this->order->products->map(function ($product) {
            return $product->price * $product->pivot->quantity;
        })->sum();
    }
}
