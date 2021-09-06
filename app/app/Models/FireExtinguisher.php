<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FireExtinguisher extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_site_id', 'equipment_type_id', 'standby_place', 'manufacturing_number', 'manufactured_at',
        'comments', 'q1_check', 'q2_check', 'q3_check', 'q4_check', 'maintenance_date'
    ];

    const MAINTENANCE = 'maintenance';
    const PERIODIC_CHECK = 'periodic_check';

    const UPDATE_ACTION_TYPES = [self::MAINTENANCE, self::PERIODIC_CHECK];

    public function customerSite(): BelongsTo
    {
        return $this->belongsTo(CustomerSite::class);
    }

    public function equipmentType(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class);
    }
}
