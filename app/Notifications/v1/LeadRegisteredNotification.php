<?php

namespace App\Notifications\v1;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class LeadRegisteredNotification extends Notification
{
    use Queueable;

    public $lead;
    public $leadType;

    /**
     * Create a new notification instance.
     */
    public function __construct($lead, string $leadType)
    {
        $this->lead = $lead;
        $this->leadType = $leadType;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'lead_type' => $this->leadType,
            'data' => $this->getData()
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            "notification" => $notifiable->notifications()->latest()->first()
        ]);
    }

    protected function getData(): array
    {
        switch ($this->leadType) {
            case 'lead_distributors':
                return [
                    'full_name' => $this->lead->full_name,
                    'dni_or_ruc' => $this->lead->dni_or_ruc,
                    'phone_1' => $this->lead->phone_1,
                    'phone_2' => $this->lead->phone_2,
                    'email' => $this->lead->email,
                    'address' => $this->lead->address,
                    'province' => $this->lead->province,
                    'department' => $this->lead->department,
                    'district' => $this->lead->district,
                    'has_store' => $this->lead->has_store ? 'yes' : 'no',
                    'sells_gas_cylinders' => $this->lead->sells_gas_cylinders ? 'yes' : 'no',
                    'brands_sold' => $this->lead->brands_sold,
                    'selling_time' => $this->lead->selling_time,
                    'monthly_sales' => $this->lead->monthly_sales,
                ];

            case 'lead_work_with_us':
                return [
                    'full_name' => $this->lead->full_name,
                    'dni' => $this->lead->dni,
                    'phone' => $this->lead->phone,
                    'address' => $this->lead->address,
                    'email' => $this->lead->email,
                    'birth_date' => $this->lead->birth_date,
                    'employment_area' => $this->lead->employment->name ?? 'N/A',
                    'cv_path' => $this->lead->cv_path,
                ];

            case 'lead_service_stations':
                return [
                    'full_name' => $this->lead->full_name,
                    'company' => $this->lead->company,
                    'ruc' => $this->lead->ruc,
                    'phone' => $this->lead->phone,
                    'email' => $this->lead->email,
                    'region' => $this->lead->region,
                    'message' => $this->lead->message,
                ];

            default:
                return [
                    'full_name' => $this->lead->full_name,
                    'email' => $this->lead->email,
                    'message' => $this->lead->message,
                ];
        }
    }
}
